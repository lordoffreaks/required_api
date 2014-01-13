<?php

/**
 * @file
 * Contains \Drupal\required_api_test\Tests\RequiredApiTest.
 */

namespace Drupal\required_api_test\Tests;

use Drupal\Component\Utility\String;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Language\Language;
use Drupal\required_api_test\Tests\RequiredApiTestBase;

/**
 * Tests the functionality of the 'Manage fields' screen.
 */
class RequiredApiTest extends RequiredApiTestBase {
  public static function getInfo() {
    return array(
      'name' => 'Required API',
      'description' => 'Test the required api base behavior.',
      'group' => 'Required API',
    );
  }

  function setUp() {
    parent::setUp();

    // Create random field name.
    $this->field_label = $this->randomName(8);
    $this->field_name_input =  strtolower($this->randomName(8));
    $this->field_name = 'field_'. $this->field_name_input;

    // Create Basic page and Article node types.
    $this->drupalCreateContentType(array('type' => 'page', 'name' => 'Basic page'));
    $this->drupalCreateContentType(array('type' => 'article', 'name' => 'Article'));

    // Create a vocabulary named "Tags".
    $vocabulary = entity_create('taxonomy_vocabulary', array(
      'name' => 'Tags',
      'vid' => 'tags',
      'langcode' => Language::LANGCODE_NOT_SPECIFIED,
    ));
    $vocabulary->save();

    $field = array(
      'name' => 'field_' . $vocabulary->id(),
      'entity_type' => 'node',
      'type' => 'taxonomy_term_reference',
    );
    entity_create('field_entity', $field)->save();

    $instance = array(
      'field_name' => 'field_' . $vocabulary->id(),
      'entity_type' => 'node',
      'label' => 'Tags',
      'bundle' => 'article',
    );
    entity_create('field_instance', $instance)->save();

    entity_get_form_display('node', 'article', 'default')
      ->setComponent('field_' . $vocabulary->id())
      ->save();
  }

  /**
   * Tests that default value is correctly validated and saved.
   */
  function testDefaultValue() {
    // Create a test field and instance.
    $field_name = 'test';
    entity_create('field_entity', array(
      'name' => $field_name,
      'entity_type' => 'node',
      'type' => 'test_field'
    ))->save();
    $instance = entity_create('field_instance', array(
      'field_name' => $field_name,
      'entity_type' => 'node',
      'bundle' => $this->type,
    ));
    $instance->save();

    $form_display = entity_get_form_display('node', $this->type, 'default');

    $form_display->setComponent($field_name)
      ->save();

    $definitions = $form_display->get('pluginManager')->getRequiredManager()->getDefinitions();

    $this->assertEqual(array(), $definitions, 'no definitions');
    $this->verbose("<pre>Definitions: " . print_r($definitions , 1). "</pre>");

    //$pluginManager = $form_display->get('pluginManager');
    //$this->verbose("<pre>pluginManager methods: " . print_r(get_class_methods($pluginManager) , 1). "</pre>");

    //$this->verbose("<pre>Form Display methods: " . print_r(get_class_methods($form_display) , 1). "</pre>");
    //$this->verbose("<pre>Form Display: " . print_r($form_display , 1). "</pre>");

    $admin_path = 'admin/structure/types/manage/' . $this->type . '/fields/' . $instance->id();
    $element_id = "edit-default-value-input-$field_name-0-value";
    $element_name = "default_value_input[{$field_name}][0][value]";
    $this->drupalGet($admin_path);
    $this->assertFieldById($element_id, '', 'The default value widget was empty.');

    // Check that invalid default values are rejected.
    $edit = array($element_name => '-1');
    $this->drupalPostForm($admin_path, $edit, t('Save settings'));
    $this->assertText("$field_name does not accept the value -1", 'Form vaildation failed.');

    // Check that the default value is saved.
    $edit = array($element_name => '1');
    $this->drupalPostForm($admin_path, $edit, t('Save settings'));
    $this->assertText("Saved $field_name configuration", 'The form was successfully submitted.');
    field_info_cache_clear();
    $instance = field_info_instance('node', $field_name, $this->type);
    $this->assertEqual($instance->default_value, array(array('value' => 1)), 'The default value was correctly saved.');

    // Check that the default value shows up in the form
    $this->drupalGet($admin_path);
    $this->assertFieldById($element_id, '1', 'The default value widget was displayed with the correct value.');

    // Check that the default value can be emptied.
    $edit = array($element_name => '');
    $this->drupalPostForm(NULL, $edit, t('Save settings'));
    $this->assertText("Saved $field_name configuration", 'The form was successfully submitted.');
    field_info_cache_clear();
    $instance = field_info_instance('node', $field_name, $this->type);
    $this->assertEqual($instance->default_value, NULL, 'The default value was correctly saved.');

    // Check that the default widget is used when the field is hidden.
    entity_get_form_display($instance->entity_type, $instance->bundle, 'default')
      ->removeComponent($field_name)->save();
    $this->drupalGet($admin_path);
    $this->assertFieldById($element_id, '', 'The default value widget was displayed when field is hidden.');
  }
}

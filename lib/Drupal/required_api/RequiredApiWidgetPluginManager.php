<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredApiWidgetPluginManager.
 */

namespace Drupal\required_api;

use Drupal\Component\Plugin\Factory\DefaultFactory;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Field\WidgetPluginManager;;
use Drupal\required_api\RequiredPluginBag;

/**
 * Plugin type manager for field widgets.
 */
class RequiredApiWidgetPluginManager extends WidgetPluginManager {

  /**
   * The method manager.
   *
   * @var \Drupal\Core\Field\RequiredApiMethodsPluginManager
   */

  /**
   * The plugin bag that holds the required plugin for the widgets.
   *
   * @var \Drupal\Component\Plugin\DefaultSinglePluginBag
   */
  protected $requiredPluginBag;

  /**
   * Sets the required manager.
   *
   * @param \Drupal\required_api\RequiredManager
   *   The required manager to set.
   */
  public function setRequiredManager(RequiredManager $requiredManager) {

    $instance_ids = array_keys($requiredManager->getDefinitions());
    $configuration = array();

    $pluginBag = new RequiredPluginBag($requiredManager, $instance_ids, $configuration);

    $this->requiredPluginBag = $pluginBag;

  }

  /**
   * Overrides PluginManagerBase::getInstance().
   *
   * @param array $options
   *   An array with the following key/value pairs:
   *   - field_definition: (FieldDefinitionInterface) The field definition.
   *   - form_mode: (string) The form mode.
   *   - prepare: (bool, optional) Whether default values should get merged in
   *     the 'configuration' array. Defaults to TRUE.
   *   - configuration: (array) the configuration for the widget. The
   *     following key value pairs are allowed, and are all optional if
   *     'prepare' is TRUE:
   *     - type: (string) The widget to use. Defaults to the
   *       'default_widget' for the field type. The default widget will also be
   *       used if the requested widget is not available.
   *     - settings: (array) Settings specific to the widget. Each setting
   *       defaults to the default value specified in the widget definition.
   *
   * @return \Drupal\Core\Field\WidgetInterface
   *   A Widget object.
   */
  public function getInstance(array $options) {

    $field = $options['field_definition'];

    if(isset($options['account'])){
      $account = $options['account'];
    } else {
      $account = \Drupal::currentUser();
    }

    // Work out here the required property
    $required = $this->getRequiredPlugin($field)->isRequired($field, $account);

    // Set the required property
    $options['field_definition']->required = $required;

    return parent::getInstance($options);

  }

  public function getRequiredPlugin(FieldInstance $field_definition){

    $options = array(
      'plugin_id' => 'required_by_role',
      'field_definition' => $field_definition,
    );

    $this->requiredPluginBag->setConfiguration($options);

    return $this->requiredPluginBag->get($options['plugin_id']);
  }

}

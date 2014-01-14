<?php
/**
 * @file
 * Contains \Drupal\required_api\Plugin\Required\RequiredBase.
 */

namespace Drupal\required_api\Plugin\Required;

use Drupal\Core\Plugin\PluginBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\required_api\Plugin\RequiredPluginInterface;


abstract class RequiredBase extends PluginBase implements RequiredPluginInterface {

  /**
   * Return a form element to use in form_field_ui_field_instance_edit_form.
   *
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field
   *   A field instance.
   *
   * @return array
   *   Form element to configure the required property.
   */
  public function formElement(FieldDefinitionInterface $field) {

    $element = $this->requiredFormElement($field);

    return $element + array(
      '#prefix' => '<div id="required-ajax-wrapper">',
      '#suffix' => '</div>',
    );
  }

  /**
   * Helper method to get the label.
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Required method to get the configuration.
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * Required method to set the configuration.
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = $configuration;
    return $this;
  }

  /**
   * Required method to set the default configuration.
   */
  public function defaultConfiguration() {
    return array();
  }
}

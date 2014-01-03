<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredApiWidgetPluginManager.
 */

namespace Drupal\required_api;

use Drupal\Core\Field\WidgetPluginManager;
use Drupal\required_api\RequiredManager;

/**
 * Plugin type manager for field widgets.
 */
class RequiredApiWidgetPluginManager extends WidgetPluginManager {

  /**
   * The required plugin manager.
   *
   * @var \Drupal\required_api\RequiredManager
   */
  protected $requiredManager;

  /**
   * Sets the required manager.
   *
   * @param \Drupal\required_api\RequiredManager $manager
   *   The required manager to set.
   */
  public function setRequiredManager(RequiredManager $manager) {
    $this->requiredManager = $manager;
  }

  /**
   * Overrides WidgetPluginManager::getInstance().
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
    $options['account'] += \Drupal::currentUser();

    $plugin = $this->requiredManager->getInstance($options);

    // Work out here the required property.
    $required = $plugin->isRequired($field, $options['account']);

    // Set the required property.
    $options['field_definition']->required = $required;

    return parent::getInstance($options);
  }

}

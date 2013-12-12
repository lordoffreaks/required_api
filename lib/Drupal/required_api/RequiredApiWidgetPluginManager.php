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

/**
 * Plugin type manager for field widgets.
 */
class RequiredApiWidgetPluginManager extends WidgetPluginManager {

  /**
   * The required api manager.
   *
   * @var \Drupal\required_api\RequiredManager
   */
  protected $requiredApiManager;

  /**
   * Collection of required plugins.
   *
   * @var array
   */
  protected $requiredPlugins;


  /**
   * The method manager.
   *
   * @var \Drupal\Core\Field\RequiredApiMethodsPluginManager
   */

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, LanguageManager $language_manager, FieldTypePluginManager $field_type_manager) {

    parent::__construct($namespaces, $cache_backend, $module_handler, $language_manager, $field_type_manager);

    $this->requiredApiManager = \Drupal::service('plugin.manager.required_api.required');
    $this->requiredPlugins = $this->requiredApiManager->getDefinitions();

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

    // Work out here the required property
    $account = \Drupal::currentUser();
    $required_plugin = $this->get_required_plugin($options['field_definition']);

    $is_required = $required_plugin->isRequired($options['field_definition'], $account, array());

    $options['field_definition']->required = $is_required;

    return parent::getInstance($options);

  }

  public function get_required_plugin(FieldInstance $field_definition){

    $options = array(
      'plugin_id' => 'required_by_role',
      'field_definition' => $field_definition,
    );

    return $this->requiredApiManager->getInstance($options);
  }

}

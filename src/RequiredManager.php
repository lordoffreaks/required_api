<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredManager.
 */

namespace Drupal\required_api;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Field\FieldDefinitionInterface;

/**
 * Manages required by role plugins.
 */
class RequiredManager extends DefaultPluginManager {

  /**
   * DefaultPluginManager overriden.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {

    parent::__construct('Plugin/Required', $namespaces, $module_handler, 'Drupal\required_api\Annotation\Required');
    $this->setCacheBackend($cache_backend, 'required_api_required_plugins');

  }

  /**
   * Overrides PluginManagerBase::getInstance().
   */
  public function getInstance(array $options) {

    if (isset($options['plugin_id'])) {
      $plugin_id = $options['plugin_id'];
    }
    else {
      $plugin_id = $this->getPluginId($options['field_definition']);
    }

    $plugin = $this->createInstance($plugin_id, $options);

    return $plugin;
  }

  /**
   * Gets the plugin_id for this field definition, fallback to system default.
   *
   * @param \Drupal\field\FieldDefinitionInterface $field
   *   A field instance.
   *
   * @return string
   *   The plugin id.
   */
  public function getPluginId(FieldDefinitionInterface $field) {

    $plugin_id = $field->getSetting('required_plugin');

    if (!$plugin_id) {
      $plugin_id = $this->getDefaultPluginId();
    }

    return $plugin_id;
  }

  /**
   * Gets the default plugin_id for the system.
   *
   * @return string
   *   The plugin id.
   */
  public function getDefaultPluginId() {
    return \Drupal::config('required_api.plugins')->get('default_plugin');
  }

  /**
   * Provides the defintions ids.
   */
  public function getDefinitionsIds() {
    return array_keys($this->getDefinitions());
  }

  /**
   * Provides the defintions as options just to inject to a select element.
   */
  public function getDefinitionsAsOptions() {

    $definitions = $this->getDefinitions();
    $plugins = array();

    foreach ($definitions as $plugin_id => $definition) {
      $plugins[$plugin_id] = $definition['label'];
    }

    return $plugins;
  }

}

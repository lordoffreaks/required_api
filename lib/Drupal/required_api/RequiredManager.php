<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredApiManager.
 */

namespace Drupal\required_api;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages required by role plugins.
 */
class RequiredManager extends DefaultPluginManager {

  /**
   * DefaultPluginManager overriden.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {

    parent::__construct('Plugin/Required', $namespaces, 'Drupal\required_api\Annotation\Required');

    $this->alterInfo($module_handler, 'required_api_required_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'required_api_required_plugins');

  }

  /**
   * Overrides PluginManagerBase::getInstance().
   */
  public function getInstance(array $options) {

    $plugin_id = $this->getPluginId($options['field_definition']);
    return $this->createInstance($plugin_id, $options);
  }

  /**
   * Gets the plugin_id for this field definition, fallback to system default.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   A field instance.
   *
   * @return string
   *   The plugin id.
   */
  public function getPluginId(FieldInstance $field) {

    $plugin_id = $field->getSetting('required_plugin');

    if (!$plugin_id) {
      $plugin_id = \Drupal::config('required_api.plugins')->get('default_plugin');
    }

    return $plugin_id;
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

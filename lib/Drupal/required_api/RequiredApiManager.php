<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredApiManager.
 */

namespace Drupal\required_api;

use Drupal\Component\Plugin\Factory\DefaultFactory;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages required by role plugins.
 */
class RequiredApiManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {

    parent::__construct('Plugin/RequiredApi', $namespaces, 'Drupal\required_api\Annotation\RequiredApi');

    $this->alterInfo($module_handler, 'required_api_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'required_api_plugins');

  }

  /**
   * Overrides PluginManagerBase::getInstance().
   *
   */
  public function getInstance(array $options) {

    dsm($this->mapper, 'mapper');
    dsm($this->factory, 'factory');

    $plugin_id = $options['plugin_id'];

    return $this->createInstance($plugin_id, $options);
  }

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    $plugin_definition = $this->getDefinition($plugin_id);

    dsm($plugin_definition, 'plugin_definition');
    dsm($plugin_id, 'plugin_id');

    $plugin_class = DefaultFactory::getPluginClass($plugin_id, $plugin_definition);

    // If the plugin provides a factory method, pass the container to it.
    if (is_subclass_of($plugin_class, 'Drupal\Core\Plugin\ContainerFactoryPluginInterface')) {
      return $plugin_class::create(\Drupal::getContainer(), $configuration, $plugin_id, $plugin_definition);
    }

    dsm($plugin_class, 'plugin_class');

    return new $plugin_class($plugin_id, $plugin_definition, $configuration['field_definition'], $configuration['settings']);
  }

}
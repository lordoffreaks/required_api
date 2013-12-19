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
use \Drupal\Component\Plugin\DefaultSinglePluginBag;

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

    $plugin_id = $options['plugin_id'];
    return $this->createInstance($plugin_id, $options);
  }

}

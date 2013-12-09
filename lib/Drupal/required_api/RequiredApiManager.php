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
class RequiredApiManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {

    parent::__construct('Plugin/RequiredApi', $namespaces, 'Drupal\required_api\Annotation\RequiredApi');

    $this->alterInfo($module_handler, 'required_api_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'required_api_plugins');

  }

}

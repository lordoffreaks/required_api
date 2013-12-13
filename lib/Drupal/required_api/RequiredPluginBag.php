<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredPluginBag.
 */

namespace Drupal\required_api;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Component\Plugin\DefaultSinglePluginBag;

/**
 * Provides a collection of block plugins.
 */
class RequiredPluginBag extends DefaultSinglePluginBag {

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\block\BlockPluginInterface
   */
  public function setConfiguration($configuration) {
    $this->configuration = $configuration;
    return $this;
  }

}

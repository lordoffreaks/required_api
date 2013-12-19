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
   * Helper method to set the configuration when it´s invoked.
   *
   * @param array $configuration
   *   The configuration for the current field.
   *
   * @return \Drupal\required_api\RequiredPluginBag
   *   An instance of the required plugin bag.
   */
  public function setConfiguration($configuration) {
    $this->configuration = $configuration;
    return $this;
  }

}

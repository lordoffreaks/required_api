<?php
/**
 * @file
 * Contains \Drupal\required_api\Plugin\Required\RequiredBase.
 */

namespace Drupal\required_api\Plugin\Required;

use Drupal\Core\Plugin\PluginBase;
use Drupal\required_api\Plugin\RequiredPluginInterface;


abstract class RequiredBase extends PluginBase implements RequiredPluginInterface {

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
    return array();
  }

  /**
   * Required method to set the configuration.
   */
  public function setConfiguration(array $configuration) {
    return $this;
  }

  /**
   * Required method to set the default configuration.
   */
  public function defaultConfiguration() {
    return array();
  }

}

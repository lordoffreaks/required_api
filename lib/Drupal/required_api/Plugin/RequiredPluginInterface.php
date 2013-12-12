<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredPluginInterface.
 */

namespace Drupal\required_api\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\field\Entity\FieldInstance;

/**
 * Defines the interface for image effects.
 */
interface RequiredPluginInterface extends PluginInspectionInterface, ConfigurablePluginInterface {

  /**
   * Determines wether a field is required or not.
   *
   * @param array $context
   *   An array of contexts provided by the implementation.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   An image file object.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function isRequired(FieldInstance $field, $account);

}

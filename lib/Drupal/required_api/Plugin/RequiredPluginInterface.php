<?php

/**
 * @file
 * Contains \Drupal\required_api\RequiredPluginInterface.
 */

namespace Drupal\required_api\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\field\Entity\FieldInstance;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the interface for image effects.
 */
interface RequiredPluginInterface extends PluginInspectionInterface, ConfigurablePluginInterface {

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   A field instance.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   A field instance.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function isRequired(FieldInstance $field, AccountInterface $account);

  /**
   * Return a form element to use in form_field_ui_field_instance_edit_form.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   A field instance.
   *
   * @return array
   *   Form element to configure the required property.
   */
  public function requiredFormElement(FieldInstance $field);

}

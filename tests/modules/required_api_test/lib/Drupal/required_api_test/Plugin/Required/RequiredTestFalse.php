<?php
/**
 * @file
 * Contains \Drupal\required_api_test\Plugin\Required\RequiredTestFalse.
 */

namespace Drupal\required_api_test\Plugin\Required;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Session\AccountInterface;
use Drupal\field\Entity\FieldInstance;
use Drupal\required_api\Annotation\Required;
use Drupal\required_api\Plugin\Required\RequiredBase;

/**
 *
 * @Required(
 *   id = "required_false",
 *   label = @Translation("Required FALSE"),
 *   description = @Translation("Required FALSE for testing.")
 * )
 */
class RequiredTestFalse extends RequiredBase {

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   A field instance object.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function isRequired(FieldInstance $field, AccountInterface $account) {
    return FALSE;
  }

  /**
   * Determines wether a field is required or not.
   *
   * @param \Drupal\field\Entity\FieldInstance $field
   *   A field instance object.
   *
   * @return bool
   *   TRUE on required. FALSE otherwise.
   */
  public function requiredFormElement(FieldInstance $field) {

    $element = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Required field'),
      '#default_value' => FALSE,
      '#weight' => -5,
    );

    return $element;
  }

}

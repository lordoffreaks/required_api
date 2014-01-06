<?php
/**
 * @file
 * Contains \Drupal\required_api\Plugin\Required\RequiredDefault.
 */

namespace Drupal\required_api\Plugin\Required;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Session\AccountInterface;
use Drupal\field\Entity\FieldInstance;
use Drupal\required_api\Annotation\Required;
use Drupal\required_api\Plugin\Required\RequiredBase;

/**
 *
 * @Required(
 *   id = "default",
 *   label = @Translation("Core"),
 *   description = @Translation("Required based on core implementation.")
 * )
 */
class RequiredDefault extends RequiredBase {

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
    return $field->isRequired();
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
      '#default_value' => $field->isRequired(),
      '#weight' => -5,
    );

    return $element;
  }

}

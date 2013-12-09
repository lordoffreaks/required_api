<?php

/**
 * @file
 * Contains \Drupal\required_api\Annotation\Required.
 */

namespace Drupal\required_api\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an field required api annotation object.
 *
 * @see hook_required_api_info_alter()
 *
 * @Annotation
 */
class Required extends RequiredApi {

  public $type = 'Required';

}

<?php

/**
 * @file
 * Contains \Drupal\required_api\Annotation\RequiredApi.
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
class RequiredApi extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The type api.
   *
   */
  public $type;

  /**
   * The human-readable name of the api.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * A brief description of the api.
   *
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation (optional)
   */
  public $description = '';

}

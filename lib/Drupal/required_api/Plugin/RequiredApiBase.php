<?php

/**
 * @file
 * Contains \Drupal\required_api\Plugin\RequiredApiBase.
 */

namespace Drupal\required_api\Plugin;

use Drupal\Core\Plugin\PluginBase;

/**
 * Provides a base class for required_api.
 */
abstract class RequiredApiBase extends PluginBase {

  /**
   * The image effect ID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The weight of the image effect.
   *
   * @var int|string
   */
  protected $weight = '';

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

}

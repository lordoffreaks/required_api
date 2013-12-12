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
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return array(
      'uuid' => $this->getUuid(),
      'id' => $this->getPluginId(),
      'weight' => $this->getWeight(),
      'data' => $this->configuration,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $configuration += array(
      'data' => array(),
      'uuid' => '',
      'weight' => '',
    );
    $this->configuration = $configuration['data'] + $this->defaultConfiguration();
    $this->uuid = $configuration['uuid'];
    $this->weight = $configuration['weight'];
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array();
  }

}

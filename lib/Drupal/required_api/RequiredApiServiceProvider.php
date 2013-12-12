<?php
/**
* @file
* Contains Drupal\required_api\RequiredApiServiceProvider
*/
namespace Drupal\required_api;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
* Modifies the widget manager service.
*/
class RequiredApiServiceProvider extends ServiceProviderBase {
  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Overrides plugin.manager.field.widget class to provide required api.
    $definition = $container->getDefinition('plugin.manager.field.widget');
    $definition->setClass('Drupal\required_api\RequiredApiWidgetPluginManager');
  }
}

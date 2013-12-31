<?php

/**
 * @file
 * Contains \Drupal\required_api\Form\RequiredDefaultPluginForm.
 */

namespace Drupal\required_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\Context\ContextInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure default required stratety for this site.
 */
class RequiredDefaultPluginForm extends ConfigFormBase {

  /**
   * Required method to provide the form_id.
   */
  public function getFormId() {
    return 'required_default_plugin';
  }

  /**
   * Required method to provide the actual form.
   */
  public function buildForm(array $form, array &$form_state) {

    $definitions = \Drupal::service('plugin.manager.required_api.required')->getDefinitions();
    $plugins = array();

    foreach ($definitions as $plugin_id => $definition) {
      $plugins[$plugin_id] = $definition['label'];
    }

    $config = $this->configFactory->get('required_api.plugins');
    $plugin = $config->get('default_plugin');

    $form['default_plugin'] = array(
      '#title' => t('Default required strategy'),
      '#type' => 'radios',
      '#options' => $plugins,
      '#default_value' => $plugin,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit function for the form.
   */
  public function submitForm(array &$form, array &$form_state) {

    $this->configFactory->get('required_api.plugins')
      ->set('default_plugin', $form_state['values']['default_plugin'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}

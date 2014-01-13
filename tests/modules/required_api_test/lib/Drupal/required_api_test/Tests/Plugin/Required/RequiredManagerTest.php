<?php

/**
 * @file
 * Contains \Drupal\required_api_test\Tests\Plugin\Required\RequiredManagerTest.
 */

namespace Drupal\required_api_test\Tests\Plugin\Required;

use Drupal\Core\Language\Language;
use Drupal\required_api\RequiredManager;
use Drupal\Tests\UnitTestCase;

/**
 * Tests the breadcrumb manager.
 *
 * @group Drupal
 * @group Required API
 */
class RequiredManagerTest extends UnitTestCase {

  /**
   * The tested required manager.
   *
   * @var \Drupal\required_api\RequiredManager
   */
  protected $requiredManager;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {

    parent::setUp();

    $namespaces = new \ArrayObject(array());

    $cache_backend = $this->getMockBuilder('Drupal\Core\Cache\MemoryBackend')
      ->disableOriginalConstructor()
      ->getMock();

    $language = new Language(array('id' => 'en'));
    $language_manager = $this->getMock('Drupal\Core\Language\LanguageManager');

    $language_manager->expects($this->once())
      ->method('getLanguage')
      ->with(Language::TYPE_INTERFACE)
      ->will($this->returnValue($language));

    $module_handler = $this->getMock('Drupal\Core\Extension\ModuleHandlerInterface');

    $this->requiredManager = new RequiredManager($namespaces, $cache_backend, $language_manager, $module_handler);
  }

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Required manager',
      'description' => 'Tests the required manager.',
      'group' => 'Required API'
    );
  }

  /**
   * Tests creating a Required Manager instance.
   */
  public function testCreateManagerInstance() {

    $is_object = is_object($this->requiredManager);
    $is_instance_of_required_manager = $this->requiredManager instanceof RequiredManager;

    $this->assertTrue($is_object, 'The requiredManager property is an object');
    $this->assertTrue($is_instance_of_required_manager, 'The requiredManager is instance of RequiredManager');

  }

}
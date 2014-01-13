<?php

/**
 * @file
 * Contains \Drupal\required_api_test\Tests\RequiredApiTestBase.
 */

namespace Drupal\required_api_test\Tests;

use Drupal\field_ui\Tests\FieldUiTestBase;

/**
 * Provides common functionality for the Field UI test classes.
 */
abstract class RequiredApiTestBase extends FieldUiTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('node', 'field_ui', 'field_test', 'required_api', 'required_api_test');

  function setUp() {
    parent::setUp();

    // Create test user.
    $admin_user = $this->drupalCreateUser(array('access content', 'administer content types', 'administer node fields', 'administer node form display', 'administer node display', 'administer users', 'administer account settings', 'administer user display', 'bypass node access', 'administer required settings'));
    $this->drupalLogin($admin_user);
  }
}

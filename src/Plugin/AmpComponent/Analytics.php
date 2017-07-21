<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Analytics AMP component.
 *
 * @AmpComponent(
 *   id = "amp-analytics",
 *   name = @Translation("Analytics"),
 *   default = true,
 *   regexp = {}
 * )
 */
class Analytics extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
  }

}

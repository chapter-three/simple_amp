<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Analytics AMP component.
 *
 * @AmpComponent(
 *   id = "amp-analytics",
 *   name = @Translation("Analytics"),
 *   description = @Translation("Enables JS to capture analytics data from an AMP document"),
 *   regexp = {}
 * )
 */
class Analytics extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    if (\Drupal::moduleHandler()->moduleExists('google_analytics') || \Drupal::moduleHandler()->moduleExists('google_tag')) {
      $ga = \Drupal::config('google_analytics.settings')->get('account');
      $gtm = \Drupal::config('google_tag.settings')->get('container_id');
      if (!empty($ga) || !empty($gtm)) {
        return '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
      }
    }
  }

}

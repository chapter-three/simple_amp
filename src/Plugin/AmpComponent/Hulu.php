<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Hulu AMP component.
 *
 * @AmpComponent(
 *   id = "amp-hulu",
 *   name = @Translation("Hulu"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-hulu.*><\/amp\-hulu>/isU",
 *   }
 * )
 */
class Hulu extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-hulu" src="https://cdn.ampproject.org/v0/amp-hulu-0.1.js"></script>';
  }

}

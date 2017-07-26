<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Twitter AMP component.
 *
 * @AmpComponent(
 *   id = "amp-twitter",
 *   name = @Translation("Twitter"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-twitter.*><\/amp\-twitter>/isU",
 *   }
 * )
 */
class Twitter extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>';
  }

}

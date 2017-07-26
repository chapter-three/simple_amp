<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Instagram AMP component.
 *
 * @AmpComponent(
 *   id = "amp-instagram",
 *   name = @Translation("Instagram"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-instagram.*><\/amp\-instagram>/isU",
 *   }
 * )
 */
class Instagram extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>';
  }

}

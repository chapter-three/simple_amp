<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Facebook AMP component.
 *
 * @AmpComponent(
 *   id = "amp-facebook",
 *   name = @Translation("Facebook"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-facebook.*><\/amp\-facebook>/isU",
 *   }
 * )
 */
class Facebook extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>';
  }

}

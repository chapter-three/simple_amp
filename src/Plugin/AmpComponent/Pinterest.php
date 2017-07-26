<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Pinterest AMP component.
 *
 * @AmpComponent(
 *   id = "amp-pinterest",
 *   name = @Translation("Pinterest"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-pinterest.*><\/amp\-pinterest>/isU",
 *   }
 * )
 */
class Pinterest extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-pinterest" src="https://cdn.ampproject.org/v0/amp-pinterest-0.1.js"></script>';
  }

}

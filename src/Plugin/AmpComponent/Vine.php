<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Vine AMP component.
 *
 * @AmpComponent(
 *   id = "amp-vine",
 *   name = @Translation("Vine"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-vine.*><\/amp\-vine>/isU",
 *   }
 * )
 */
class Vine extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-vine" src="https://cdn.ampproject.org/v0/amp-vine-0.1.js"></script>';
  }

}

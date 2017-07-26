<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Iframe AMP component.
 *
 * @AmpComponent(
 *   id = "amp-iframe",
 *   name = @Translation("Iframe"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-iframe.*><\/amp\-iframe>/isU",
 *   }
 * )
 */
class Iframe extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>';
  }

}

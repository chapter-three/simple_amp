<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Vimeo AMP component.
 *
 * @AmpComponent(
 *   id = "amp-vimeo",
 *   name = @Translation("Vimeo"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-vimeo.*><\/amp\-vimeo>/isU",
 *   }
 * )
 */
class Vimeo extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>';
  }

}

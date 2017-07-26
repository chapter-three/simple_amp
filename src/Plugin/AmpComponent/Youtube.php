<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Youtube AMP component.
 *
 * @AmpComponent(
 *   id = "amp-youtube",
 *   name = @Translation("YouTube"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-youtube.*><\/amp\-youtube>/isU",
 *   }
 * )
 */
class Youtube extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>';
  }

}

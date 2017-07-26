<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Audio AMP component.
 *
 * @AmpComponent(
 *   id = "amp-audio",
 *   name = @Translation("Audio"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-audio.*><\/amp\-audio>/isU",
 *   }
 * )
 */
class Audio extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>';
  }

}

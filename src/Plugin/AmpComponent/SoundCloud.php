<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * SoundCloud AMP component.
 *
 * @AmpComponent(
 *   id = "amp-soundcloud",
 *   name = @Translation("SoundCloud"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-soundcloud.*><\/amp\-soundcloud>/isU",
 *   }
 * )
 */
class SoundCloud extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-soundcloud" src="https://cdn.ampproject.org/v0/amp-soundcloud-0.1.js"></script>';
  }

}

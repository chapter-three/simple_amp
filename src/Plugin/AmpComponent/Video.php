<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Video AMP component.
 *
 * @AmpComponent(
 *   id = "amp-video",
 *   name = @Translation("Video"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-video.*><\/amp\-video>/isU",
 *   }
 * )
 */
class Video extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>';
  }

}

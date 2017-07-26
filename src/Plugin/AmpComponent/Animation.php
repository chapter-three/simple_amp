<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Animation AMP component.
 *
 * @AmpComponent(
 *   id = "amp-anim",
 *   name = @Translation("Animation"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-anim.*><\/amp\-anim>/isU",
 *   }
 * )
 */
class Animation extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-anim" src="https://cdn.ampproject.org/v0/amp-anim-0.1.js"></script>';
  }

}

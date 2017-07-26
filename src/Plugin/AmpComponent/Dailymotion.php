<?php

namespace Drupal\simple_amp\Plugin\AmpComponent;

use Drupal\simple_amp\AmpComponentBase;

/**
 * Dailymotion AMP component.
 *
 * @AmpComponent(
 *   id = "amp-dailymotion",
 *   name = @Translation("Dailymotion"),
 *   default = false,
 *   regexp = {
 *     "/<amp\-dailymotion.*><\/amp\-dailymotion>/isU",
 *   }
 * )
 */
class Dailymotion extends AmpComponentBase {

  /**
   * {@inheritdoc}
   */
  public function getElement() {
    return '<script async custom-element="amp-dailymotion" src="https://cdn.ampproject.org/v0/amp-dailymotion-0.1.js"></script>';
  }

}

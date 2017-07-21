<?php

namespace Drupal\simple_amp;

use Drupal\Component\Plugin\PluginBase;

class AmpComponentBase extends PluginBase implements AmpComponentInterface {

  /**
   * Get plugin name.
   */
  public function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * Get plugin regexp.
   */
  public function getRegexp() {
    return $this->pluginDefinition['regexp'];
  }

  /**
   * Check if component loaded by default.
   */
  public function isDefault() {
    return !empty($this->pluginDefinition['default']);
  }

  /**
   * AMP component Javascript.
   */
  public function getElement() {
    // Return javascript tag.
  }

}

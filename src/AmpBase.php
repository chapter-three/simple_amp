<?php

namespace Drupal\simple_amp;

use Lullabot\AMP\AMP;
use Drupal\Core\Url;

/**
 * Parse content and detect if there is any JS should be added
 */
class AmpBase {

  protected $entity;
  protected $view_mode;
  protected $content;
  protected $html;

  protected $component_manager;
  protected $metadata_manager;

  // Default and absolutely must scripts.
  protected $scripts = [
    '<script async src="https://cdn.ampproject.org/v0.js"></script>',
  ];

  public function __construct() {
    $this->component_manager = \Drupal::service('plugin.manager.simple_amp_component');
    $this->metadata_manager = \Drupal::service('plugin.manager.simple_amp_metadata');
  }

  public function setEntity($entity) {
    $this->entity = $entity;
    return $this;
  }

  public function getEntity() {
    return $this->entity;
  }

  public function getScripts() {
    return join("\n", $this->scripts);
  }

  public function getCanonicalUrl() {
    $options = ['absolute' => TRUE];
    $url = Url::fromRoute('entity.node.canonical', ['node' => $this->getEntity()->id()], $options);
    return $url->toString();
  }

  public function getContent() {
    return $this->content;
  }

  public function getViewMode() {
    return \Drupal::config('simple_amp.settings')->get($this->getEntity()->bundle() . '_view_mode');
  }

  public function isAmpEnabled() {
    return (bool) \Drupal::config('simple_amp.settings')->get($this->getEntity()->bundle() . '_enable');
  }

  public function getGoogleAnalytics() {
    return \Drupal::config('google_analytics.settings')->get('account');
  }

  public function getMetadata() {
    $entity = $this->getEntity();
    $manager = $this->metadata_manager;
    $plugins = $manager->getDefinitions();
    foreach ($plugins as $id => $plugin) {
      $plugin = $manager->createInstance($plugin['id']);
      $entity_types = $plugin->getEntityTypes($entity);
      if (in_array($entity->bundle(), $entity_types)) {
        $metadata = $plugin->getMetadata($entity);
        return json_encode($metadata);
      }
    }
  }

  public function parse() {
    $amp = new AMP();
    $amp->loadHtml($this->renderEntityViewMode());
    $this->content = $amp->convertToAmpHtml();
    $this->detect();
    return $this;
  }

  protected function renderEntityViewMode() {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($this->getEntity()->getEntityTypeId());
    $node = $view_builder->view($this->getEntity(), $this->getViewMode(), $langcode);
    $html = \Drupal::service('renderer')->render($node);
    return $this->html = $html->__toString();
  }

  protected function detect() {
    $manager = $this->component_manager;
    $plugins = $manager->getDefinitions();

    // Find component.
    foreach ($plugins as $id => $plugin) {
      $plugin = $manager->createInstance($plugin['id']);

      $regexp = $plugin->getRegexp();

      if ($plugin->isDefault()) {
        if ($element = $plugin->getElement()) {
          $this->scripts[] = $element;
        }
      }

      $component = [];
      if (!is_array($regexp)) {
        $component['regexp'][] = $regexp;
      }
      else {
        $component['regexp'] = $regexp;
      }

      // Try all regular expressions.
      foreach ($component['regexp'] as $delta => $regexp) {
        if (preg_match($regexp, $this->html, $matches)) {
          if ($element = $plugin->getElement()) {
            $this->scripts[] = $element;
          }
        }
      }

    }

  }

}

<?php

namespace Drupal\simple_amp;

use Lullabot\AMP\AMP;
use Drupal\Core\Url;
use Drupal\simple_amp\Metadata\Metadata;
use Drupal\simple_amp\Metadata\Author;
use Drupal\simple_amp\Metadata\Publisher;
use Drupal\simple_amp\Metadata\Image;

/**
 * Parse content and detect if there is any JS should be added
 */
class AmpBase {

  protected $entity;
  protected $view_mode;
  protected $content;

  // Default and absolutely must scripts.
  protected $scripts = [
    '<script async src="https://cdn.ampproject.org/v0.js"></script>',
    '<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>',
    '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>',
    '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>',
    '<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>',
  ];

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
    $metadata = new Metadata();
    $author = (new Author())
      ->setName('Test Author');
    $logo = (new Image())
      ->setUrl('http://url-to-image')
      ->setWidth(400)
      ->setHeight(300);
    $publisher = (new Publisher())
      ->setName('MyWebsite.com')
      ->setLogo($logo);
    $image = (new Image())
      ->setUrl('http://url-to-image')
      ->setWidth(400)
      ->setHeight(300);
    $metadata
      ->setDatePublished($entity->getCreatedTime())
      ->setDateModified($entity->getChangedTime())
      ->setDescription('test')
      ->setAuthor($author)
      ->setPublisher($publisher)
      ->setImage($image);
    return json_encode($metadata->build());
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
    return $html->__toString();
  }

  protected function detect() {
    // @TODO: detect if there is any need to add extra JS to support
    // additional elements.
    $content = $this->getContent();
  }

}

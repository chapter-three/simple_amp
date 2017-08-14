<?php

namespace Drupal\simple_amp\RouteProcessor;

use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\Core\RouteProcessor\OutboundRouteProcessorInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\Routing\Route;

class AmpRouteProcessor implements OutboundRouteProcessorInterface {

  /**
   * An alias manager for looking up the system path.
   *
   * @var \Drupal\Core\Path\AliasManagerInterface
   */
  protected $aliasManager;

  /**
   * Constructs a PathProcessorAlias object.
   *
   * @param \Drupal\Core\Path\AliasManagerInterface $alias_manager
   *   An alias manager for looking up the system path.
   */
  public function __construct(AliasManagerInterface $alias_manager) {
    $this->aliasManager = $alias_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function processOutbound($route_name, Route $route, array &$parameters, BubbleableMetadata $bubbleable_metadata = NULL ) {
    if ($route_name !== 'simple_amp.amp') {
      return;
    }

    $nid = $parameters['entity'];

    if (is_numeric($nid)) {
      $node = Node::load($nid);
      if ($alias = $this->aliasManager->getAliasByPath('/node/' . $node->id())) {
        $path = $alias;
      }
      else {
        $path = \Drupal::service('pathauto.alias_cleaner')->cleanString($node->getTitle());
      }
      $parameters['entity'] = '/amp' . $path;
    }
  }

}

# Simple AMP integration Drupal 8 module

Module requires `composer require lullabot/amp` [https://github.com/Lullabot/amp-library](https://github.com/Lullabot/amp-library)

The module is extendable, there are two components: AmpComponent and AmpMetadata.

Read blog post about this module: [How to implement simple AMP support in Drupal 8](https://www.chapterthree.com/blog/how-implement-simple-amp-support-drupal-8)

## AMPComponent

1. All plugins stored in src/Plugin/AmpComponent/* currently the module doesn't support all available AMP components, but can be easily extended from your own module.

Here is example:

The key variables here are:

- name - plugin name
- default - true/false (when set to TRUE plugin will include javascript from getElement() method to HTML header.
- regexp - array of regular expressions to match in HTML body.

```
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
 *     "/youtube\.com\/watch\?v=([a-z0-9\-_]+)/i",
 *     "/youtube\.com\/embed\/([a-z0-9\-_]+)/i",
 *     "/youtu.be\/([a-z0-9\-_]+)/i",
 *     "/youtube\.com\/v\/([a-z0-9\-_]+)/i",
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
```

## AmpMetadata

1. All plugins stored in src/Plugin/AmpMetadata/* provide Metadata for specific entity.

Here is example:

The key variables here are:

- entity_types - array of entity type names. This will tell the module to generate AMP Metadata for entity types specified in this variable.

```
<?php

namespace Drupal\simple_amp\Plugin\AmpMetadata;

use Drupal\simple_amp\AmpMetadataBase;
use Drupal\simple_amp\Metadata\Metadata;
use Drupal\simple_amp\Metadata\Author;
use Drupal\simple_amp\Metadata\Publisher;
use Drupal\simple_amp\Metadata\Image;

/**
 * Example AMP metadata component.
 *
 * @AmpMetadata(
 *   id = "default",
 *   entity_types = {
 *     "example_article"
 *   }
 * )
 */
class ExampleEntity extends AmpMetadataBase {

  /**
   * {@inheritdoc}
   */
  public function getMetadata($entity) {
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
    return $metadata->build();
  }

}
```



## Theming

1. Modify template in `simple_amp/templates/amp.html.twig` to match your design 
2. You may also have custom template per content type: `amp--node.html.twig` or `amp--node--article.html.twig`

Module developed by [Minnur Yunusov](https://www.minnur.com) at [Chapter Three](https://www.chapterthree.com)
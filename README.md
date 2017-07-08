# Simple AMP integration Drupal 8 module

Module requires `composer require lullabot/amp` [https://github.com/Lullabot/amp-library](https://github.com/Lullabot/amp-library)

This module is just a starter module, you would need to override some code in this module.

1. `Drupal\simple_amp\AmpBase::getMetadata` set proper variables to display publisher name, logo, image etc..
2. Modify template in `simple_amp/templates/amp.html.twig` to match your design needs.
3. You may also have custom template per content type: `amp--node.html.twig` or `amp--node--article.html.twig`

Module developed by [Minnur Yunusov](https://www.minnur.com) at [Chapter Three](https://www.chapterthree.com)
<?php

namespace Drupal\simple_amp;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Processes the inbound path using path alias lookups.
 * Original code for this is in https://www.drupal.org/project/subpathauto module.
 */
class AmpPathProcessor implements InboundPathProcessorInterface, OutboundPathProcessorInterface {

  protected $pathProcessor;
  protected $languageManager;
  protected $configFactory;
  protected $pathValidator;
  protected $recursiveCall;
  protected $maxDepth = 1;

  /**
   * Builds PathProcessor object.
   */
  public function __construct(InboundPathProcessorInterface $path_processor, LanguageManagerInterface $language_manager, ConfigFactoryInterface $config_factory) {
    $this->pathProcessor = $path_processor;
    $this->languageManager = $language_manager;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function processInbound($path, Request $request) {
    $request_path = $this->getPath($request->getPathInfo());

    if (!$this->startsWith($request_path, '/node/') && !$this->endsWith($request_path, '/amp')) {
      return $path;
    }

    if ($request_path !== $path || $this->recursiveCall) {
      return $path;
    }

    $original_path = $path;
    $max_depth = $this->maxDepth;
    $subpath = [];
    $i = 0;
    while (($path_array = explode('/', ltrim($path, '/'))) && ($max_depth === 0 || $i < $max_depth)) {
      $i++;
      $subpath[] = array_pop($path_array);
      if (empty($path_array)) {
        break;
      }
      $path = '/' . implode('/', $path_array);
      $processed_path = $this->pathProcessor->processInbound($path, $request);
      if ($processed_path !== $path) {
        $path = $processed_path . '/' . implode('/', array_reverse($subpath));
        $valid_path = $this->isValidPath($path);
        if ($valid_path) {
          return $path;
        }
        break;
      }
    }
    return $original_path;
  }

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleableMetadata = NULL) {
    if (isset($options['absolute']) && $options['absolute']) {
      return $path;
    }

    if (is_null($request)) {
      return $path;
    }

    $request_path = $this->getPath($request->getPathInfo());

    if (!$this->startsWith($request_path, '/node/') && !$this->endsWith($path, '/amp')) {
      return $path;
    }

    $original_path = $path;
    $subpath = [];
    $max_depth = $this->maxDepth;
    $i = 0;
    while (($path_array = explode('/', ltrim($path, '/'))) && ($max_depth === 0 || $i < $max_depth)) {
      $i++;
      $subpath[] = array_pop($path_array);
      if (empty($path_array)) {
        break;
      }
      $path = '/' . implode('/', $path_array);
      $processed_path = $this->pathProcessor->processOutbound($path, $options, $request);
      if ($processed_path !== $path) {
        $path = $processed_path . '/' . implode('/', array_reverse($subpath));
        return $path;
      }
    }
    return $original_path;
  }

  /**
   * Helper function to handle multilingual paths.
   */
  protected function getPath($path_info) {
    $language_prefix = '/' . $this->languageManager->getCurrentLanguage(LanguageInterface::TYPE_URL)->getId() . '/';

    if (substr($path_info, 0, strlen($language_prefix)) == $language_prefix) {
      $path_info = '/' . substr($path_info, strlen($language_prefix));
    }
    return $path_info;
  }

  /**
   * Tests if path is valid.
   */
  protected function isValidPath($path) {
    $this->recursiveCall = TRUE;
    $is_valid = (bool) $this->getPathValidator()->getUrlIfValidWithoutAccessCheck($path);
    $this->recursiveCall = FALSE;
    return $is_valid;
  }

  /**
   * Gets the path validator.
   */
  protected function getPathValidator() {
    if (!$this->pathValidator) {
      $this->setPathValidator(\Drupal::service('path.validator'));
    }
    return $this->pathValidator;
  }

  /**
   * Sets the path validator.
   */
  public function setPathValidator(PathValidatorInterface $path_validator) {
    $this->pathValidator = $path_validator;
    return $this;
  }

  /**
   * Check if URL starts with
   */
  public function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
  }

  /**
   * Check if URL ends with
   */
  public function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
      return TRUE;
    }
    return (substr($haystack, -$length) === $needle);
  }

}


<?php

namespace Drupal\vactory_frequent_searches\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetFrequentSearchesController
 *
 * @package Drupal\vactory_jsonapi\Controller
 */
class GetFrequentSearchesController extends ControllerBase {

  /**
   * Display the frequent searches.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function index(Request $request) {
    $search_index = $request->query->get('index');
    $limit = $request->query->get('limit');
    $keywords = [];
    if (empty($search_index)) {
      $keywords = \Drupal::service('vactory_frequent_searches.frequent_searches_controller')
        ->fetchKeywordsWithResultsFromDatabase($limit);
    }
    else{
      $keywords = \Drupal::service('vactory_frequent_searches.frequent_searches_controller')
        ->fetchKeywordsWithResultsFromDatabaseBySearchIndex($search_index, $limit);
    }
    $count = count($keywords);
    return new JsonResponse([
      'keywords' => $keywords,
      'count' => $count,
      'status' => 200
    ]);
  }

}
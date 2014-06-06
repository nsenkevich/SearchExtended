<?php

namespace Search\Controller;

use Search\View\View;
use Search\Service\SearchService;
use Search\View\Json;
use Search\Service\SearchExtended;

class SearchController {

  /**
   * @var SearchService
   */
  private $searchService;

  /**
   * @param SearchService $searchService
   */
  public function __construct(SearchService $searchService)
  {
    $this->searchService = $searchService;
  }

  public function IndexAction()
  {
    if ($this->isAjax()) {
      $q = $this->getPost('q');
      $a = $this->getPost('auto');

      //check query
      if (!strip_tags($q)) {
        $jsonView = new Json();
        $jsonView->render();
      }

      // get data
      $this->searchService->getSearchExtended()->setQ($q);
      $this->searchService->getSearchExtended()->setSearch_availability(SearchExtended::SEARCH_AVAILABILITY_IPLAYER);
      //var_dump($this->searchService->getSearchExtended()->generateUrl());exit;
      $data = $this->searchService->getResponce();
      $data = json_decode($data);

      if (!$data) {
        $jsonView = new Json();
        $jsonView->render();
      }

      //dispalay brand/episodes
      if ($a == 1) {
        $list = $this->searchService->getBrands($data, $q);
      } else {
        $list = $this->searchService->getEpisodes($data, $q);
      }

      $jsonView = new Json($list);
      $jsonView->render();
    }

    $view = new View('index.html');
    $view->render();
  }

  public function isAjax()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return TRUE;
    }
    return FALSE;
  }

  public function getPost($var)
  {
    if (isset($_POST[$var])) {
      return $_POST[$var];
    }
    return FALSE;
  }

}

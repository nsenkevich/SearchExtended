<?php

namespace Search\Service;

use UrlGenerate;

class SearchExtendedResponce {

  /**
   * @var UrlGenerate 
   */
  private $search;

  /**
   * @param UrlGenerate $search
   */
  public function __construct(UrlGenerate $search)
  {
    $this->search = $search;
  }

  public function getData()
  {
    $url = $this->search->generateUrl();
    $data = file_get_contents($url);

    if ($data == FALSE) {
      return FALSE;
    }

    return $data;
  }

}

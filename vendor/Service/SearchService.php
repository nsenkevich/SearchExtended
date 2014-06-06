<?php

namespace Search\Service;

use Search\Service\SearchExtended;
use Search\Service\SearchExtendedResponce;

class SearchService {

  const TYPE_EPISODE = 'episode';
  const TYPE_BRAND = 'brand';

  /**
   * @var SearchExtended
   */
  private $searchExtended;

  /**
   * @param SearchExtended $searchExtended
   */
  public function __construct(SearchExtended $searchExtended)
  {
    $this->searchExtended = $searchExtended;
  }

  /**
   * @return SearchExtended
   */
  public function getSearchExtended()
  {
    return $this->searchExtended;
  }

  /**
   * @return Json
   */
  public function getResponce()
  {
    $responce = new SearchExtendedResponce($this->searchExtended);
    return $responce->getData();
  }

  /**
   * @param stdClass $obj
   * @param string $q
   * @return string
   */
  public function getBrands($obj, $q)
  {
    $newList = array();
    if (empty($obj->blocklist)) {
      return array();
    }

    foreach ($obj->blocklist as $block) {
      if ($this->hasBrand($block, $q)) {
        $newList[]['title'] = 'brands ' . $block->brand_title;
      }
    }
    return $newList;
  }

  /**
   * 
   * @param stdClass $obj
   * @param string $q
   * @return array
   */
  public function getEpisodes($obj, $q)
  {
    $newList = array();
    if (empty($obj->blocklist)) {
      return array();
    }

    foreach ($obj->blocklist as $block) {
      if ($this->hasBrand($block, $q) && $this->hasEpisode($block)) {
        $newList[]['title'] = 'episodes ' . $block->complete_title;
      }
    }
    return $newList;
  }

  /**
   * @param stdClass $block
   * @param string $brand
   * @return boolean
   */
  public function hasBrand($block, $brand)
  {
    $pos = strpos(strtolower($block->brand_title), strtolower(trim($brand)));
    if ($pos === FALSE) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * @param stdClass $block
   * @return boolean
   */
  public function hasEpisode($block)
  {
    if ($block->type == self::TYPE_EPISODE) {
      return TRUE;
    }
    return FALSE;
  }

}

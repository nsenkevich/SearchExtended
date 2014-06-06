<?php

namespace Search\Service;

use UrlGenerate;

class SearchExtended implements UrlGenerate {

  const LOCAL_RADIO_INCLUDE = 'include';
  const LOCAL_RADIO_EXCLUDE = 'exclude';
  const LOCAL_RADIO_EXCLUSIVE = 'exclusive';
  const SEARCH_AVAILABILITY_IPLAYER = 'iplayer';
  const SEARCH_AVAILABILITY_ANY = 'any';
  const SEARCH_AVAILABILITY_DISCOVERABLE = 'discoverable';
  const SEARCH_AVAILABILITY_ONDEMAND = 'ondemand';
  const SEARCH_AVAILABILITY_SIMULCAST = 'simulcast';
  const SEARCH_AVAILABILITY_COMINGUP = 'comingup';
  const SERVICE_TYPE_TV = 'tv';
  const SERVICE_TYPE_RADIO = 'radio';
  const COMING_SOON_WITHIN_MAX = 168;
  const MAX_TLEOS_MAX = 4;
  const FORMAT_JSON = 'json';
  const FORMAT_XML = 'xml';
  const BBC_SEARCH_URL = 'http://www.bbc.co.uk/iplayer/ion/searchextended/';

  public static $search_availability_list = array(
      self::SEARCH_AVAILABILITY_IPLAYER,
      self::SEARCH_AVAILABILITY_ANY,
      self::SEARCH_AVAILABILITY_DISCOVERABLE,
      self::SEARCH_AVAILABILITY_ONDEMAND,
      self::SEARCH_AVAILABILITY_SIMULCAST,
      self::SEARCH_AVAILABILITY_COMINGUP);
  public static $local_radio_list = array(
      self::LOCAL_RADIO_INCLUDE,
      self::LOCAL_RADIO_EXCLUDE,
      self::LOCAL_RADIO_EXCLUSIVE);
  public static $service_type_list = array(
      self::SERVICE_TYPE_TV,
      self::SERVICE_TYPE_RADIO);

  /**
   * category to restrict search on 
   * @var string 
   */
  private $category;

  /**
   * a number 0..9+. Value in hours 
   * @var int 
   */
  private $coming_soon_within;

  /**
   * accepted values are include|exclude|exclusive 
   * @var string 
   */
  private $local_radio = self::LOCAL_RADIO_EXCLUDE;

  /**
   * A valid masterbrand on which to filter results. 
   * @var string 
   */
  private $masterbrand;

  /**
   * maximum tleo results to return ( 0 ..4 )
   * @var int
   */
  private $max_tleos = 0;

  /**
   * string must be [a­zA­Z­]+ 
   * @var string 
   */
  private $media_set;

  /**
   * Validation  minimum value: 1 
   * the page to return. Only digits allowed 
   * @var int 
   */
  private $page = 1;

  /**
   * Validation  minimum value: 1 
   * maximum number to return per results page. Only digits allowed
   * @var int 
   */
  private $perpage = 10;

  /**
   * string of characters 
   * @var string 
   */
  private $q;

  /**
   * accepted values are iplayer|any|discoverable|ondemand|simulcast|comingup
   * @var string 
   */
  private $search_availability;

  /**
   * accepted values are tv|radio
   * @var string 
   */
  private $service_type;

  /**
   * boolean value. either 1 or 0 
   * @var bool 
   */
  private $signed = FALSE;

  /**
   * @var string
   */
  private $format = self::FORMAT_JSON;

  /**
   * @param string $search_availability
   */
  public function __construct($search_availability)
  {
    $this->setSearch_availability($search_availability);
  }

  public function setCategory($category)
  {
    $this->category = $category;
  }

  public function setComing_soon_within($coming_soon_within)
  {
    if ($coming_soon_within > self::COMING_SOON_WITHIN_MAX) {
      return FALSE;
    }

    $this->coming_soon_within = $coming_soon_within;
  }

  public function setLocal_radio($local_radio)
  {
    if (!in_array($local_radio, self::$local_radio_list)) {
      return FALSE;
    }

    $this->local_radio = $local_radio;
  }

  public function setMasterbrand($masterbrand)
  {
    $this->masterbrand = $masterbrand;
  }

  public function setMax_tleos($max_tleos)
  {
    if ($max_tleos > self::MAX_TLEOS_MAX) {
      return FALSE;
    }

    $this->max_tleos = $max_tleos;
  }

  public function setMedia_set($media_set)
  {
    if (preg_match("/^[a-zA-Z0-9]+$/", $media_set) != 1) {
      return FALSE;
    }
    $this->media_set = $media_set;
  }

  public function setPage($page)
  {
    if (!is_int($page)) {
      return FALSE;
    }

    $this->page = $page;
  }

  public function setPerpage($perpage)
  {
    if (!is_int($perpage)) {
      return FALSE;
    }

    $this->perpage = $perpage;
  }

  public function setQ($q)
  {
    $this->q = $q;
  }

  public function setSearch_availability($search_availability)
  {
    if (!in_array($search_availability, self::$search_availability_list)) {
      return FALSE;
    }

    $this->search_availability = $search_availability;
  }

  public function setService_type($service_type)
  {
    if (!in_array($service_type, self::$service_type_list)) {
      return FALSE;
    }
    $this->service_type = $service_type;
  }

  public function setSigned($signed)
  {
    if (!is_bool($signed)) {
      return FALSE;
    }
    $this->signed = $signed;
  }

  public function getComing_soon_within()
  {
    return $this->coming_soon_within;
  }

  public function getLocal_radio()
  {
    return $this->local_radio;
  }

  public function getMasterbrand()
  {
    return $this->masterbrand;
  }

  public function getMax_tleos()
  {
    return $this->max_tleos;
  }

  public function getMedia_set()
  {
    return $this->media_set;
  }

  public function getPage()
  {
    return $this->page;
  }

  public function getPerpage()
  {
    return $this->perpage;
  }

  public function getQ()
  {
    return $this->q;
  }

  public function getSearch_availability()
  {
    return $this->search_availability;
  }

  public function getService_type()
  {
    return $this->service_type;
  }

  public function getSigned()
  {
    return $this->signed;
  }

  public function getCategory()
  {
    return $this->category;
  }

  public function getFormat()
  {
    return $this->format;
  }

  public function setFormat($format)
  {
    $this->format = $format;
  }

  public function generateUrl()
  {
    $url = self::BBC_SEARCH_URL;
    $properties = get_object_vars($this);
    foreach ($properties as $prName => $prValue) {
      if ($prValue) {
        $url .= $prName . '/' . $prValue . '/';
      }
    }

    return $url;
  }

}

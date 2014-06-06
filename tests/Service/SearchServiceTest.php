<?php

namespace Test\Search\Services;

use Search\Service\SearchService;
use Search\Service\SearchExtended;

class SearchServiceTest extends PHPUnit_Framework_TestCase {

  /**
   * @var SearchService
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    $this->object = new SearchService(new SearchExtended(SearchExtended::SEARCH_AVAILABILITY_ANY));
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
    
  }

  /**
   * @covers Search\Service\SearchService::getBrands
   * @todo   Implement testGetBrands().
   */
  public function testGetBrands()
  {
    $obj = new \stdClass();
    $obj->blocklist = array();
    $this->assertEquals($this->object->getBrands($obj, 'bob'), array());


    $block = new \stdClass();
    $block->type = SearchService::TYPE_EPISODE;

    $obj->blocklist = array($block);
    $result = $this->object->getBrands($obj, 'bob');
    $this->assertEquals($result, array('title' => 'brands ' . $block->brand_title));
  }

  /**
   * @covers Search\Service\SearchService::getEpisodes
   * @todo   Implement testGetEpisodes().
   */
  public function testGetEpisodes()
  {
    $obj = new \stdClass();
    $obj->blocklist = array();
    $this->assertEquals($this->object->getEpisodes($obj, 'bob'), array());

    $block = new \stdClass();
    $block->type = SearchService::TYPE_EPISODE;
    $block->brand_title = 'bob the builder tra ta ta';

    $obj->blocklist = array($block);
    $result = $this->object->getEpisodes($obj, 'bob');
    $this->assertEquals($result, array('title' => 'episodes ' . $block->complete_title));
  }

  /**
   * @covers Search\Service\SearchService::hasEpisode
   * @todo   Implement testHasEpisode().
   */
  public function testHasEpisode()
  {
    $block = new \stdClass();

    $block->type = SearchService::TYPE_EPISODE;
    $this->assertTrue($this->object->hasEpisode($block));

    $block->type = SearchService::TYPE_BRAND;
    $this->assertFalse($this->object->hasEpisode($block));
  }

  /**
   * @covers Search\Service\SearchService::hasBrand
   * @todo   Implement testHasBrand().
   */
  public function testHasBrand()
  {
    $block = new \stdClass();
    $block->brand_title = 'bob the builder tra ta ta';
    $this->assertTrue($this->object->hasBrand($block, 'bob the builder'));
    $this->assertFalse($this->object->hasBrand($block, 'tom'));
  }

}

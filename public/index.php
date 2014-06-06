<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Search\Service\SearchService;
use Search\Controller\SearchController;
use Search\Service\SearchExtended;

$searchService = new SearchService(new SearchExtended(SearchExtended::SEARCH_AVAILABILITY_ANY));
$controller = new SearchController($searchService);
$controller->IndexAction();







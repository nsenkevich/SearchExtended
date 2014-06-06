SearchExtended
==============
All code writen in php without using any frameworks and libraries.

Search Implementation
Search\Service\SearchExtended -- validate arguments generate url base on provided arguments.
Search\Service\SearchExtendedResponce -- generate response data.
Search\Service\SearchService -- contain all business logic for search.

Simple mvc
Search\Controller\SearchController 
Search\View\Json - ajax json response.
Search\View\View  http response.

public/search.js - js which call ajax and manage ajax response
public/index.html - html which display search

Todo
Cover more with tests.
Implement xml/json converter to real objects insted using stdClass in Search\Service\SearchExtendedResponce.


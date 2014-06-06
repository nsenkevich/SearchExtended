<?php

namespace Search\View;

use Search\View\ViewInterface;

class View implements ViewInterface {

  /**
   * @var string
   */
  private $path;

  /**
   * @var mixed
   */
  private $variable;

  /**
   * @param string $path
   * @param mixed $variable
   */
  function __construct($path = NULL, $variable = NULL)
  {
    $this->path = $path;
    $this->variable = $variable;
  }

  /**
   * @param string $path
   */
  public function setTemplate($path)
  {
    $this->path = $path;
  }

  /**
   * @param mixed $variable
   */
  public function setVariable($variable)
  {
    $this->variable = $variable;
  }

  public function render()
  {
    include (__DIR__ . '/' . $this->path);
  }

  public function getVariable()
  {
    return $this->variable;
  }

}

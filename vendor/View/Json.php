<?php

namespace Search\View;

use Search\View\ViewInterface;

class Json implements ViewInterface {

  /**
   * @var mixed
   */
  private $variable = array();

  /**
   * @param mixed $variable
   */
  public function __construct(array $variable = NULL)
  {
    $this->variable = $variable;
  }

  /**
   * @param mixed $variable
   */
  public function setVariables(array $variable)
  {
    $this->variable = $variable;
  }

  public function render()
  {
    echo json_encode($this->variable);
    exit;
  }

}

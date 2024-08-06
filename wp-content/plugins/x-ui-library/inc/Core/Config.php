<?php

namespace X_UI\Core;


use X_UI\Core\Tokens\Grid;

class Config {

  public static function get_grid_breakpoints_keys() {
    $gridInstance = Grid::getInstance();
    $breakpoints = $gridInstance->getMeta('breakpoints');
    return array_keys($breakpoints);
  }
  public static function get_grid_breakpoints() {
    $gridInstance = Grid::getInstance();
    $breakpoints = $gridInstance->getMeta('breakpoints');
    return array_keys($breakpoints);
  }
}

<?php

class render extends Blackbird {

  public static $render_controller;
  public static $render_action;
  public static $render_yield;
  public static $render_class;
  public static $render_yieldtext;

  function __construct($class, $controller, $action) {
    self::$render_class       = $class;
    self::$render_controller  = $controller;
    self::$render_action      = $action;
  }

  public static function start($content = "") {
    $file = explode("/", $_SERVER['SCRIPT_NAME']);
    
    $file = $file[count($file)-1];

    foreach(get_object_vars(self::$render_class) as $key => $value) {
      $$key = $value;		
    }

    #define view path based on controller and action
    $view_path = view.self::$controller."/".self::$action.".".$_GET['format'].".php";

    self::$render_yield = $view_path;
    self::$render_yieldtext = $content;

    $layout = file_exists(get_include_path().view.'layouts/'.self::$render_controller.".".$_GET['format'].".php") ? 
      view.'layouts/'.self::$render_controller.".".$_GET['format'].".php" : 
      view.'layouts/'.parent::$layout;

    $yield = self::$render_yield;
    $yieldtext = self::$render_yieldtext;
    
    require_once($layout);
  }
}

?>
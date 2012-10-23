<?php

class router extends Blackbird {

  static $paths = array();

  public static function add($routes) {
    self::$paths = $routes;
  }

  public static function get($uri) {

    $url = explode('/', substr($uri, 1));
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $route_found = false;
    
    # Loop through each route
    foreach(self::$paths as $path => $matches) {

      # If a route has already been found, stop looking
      if($route_found) break;

      # Strip / from the match if its there
      if(substr($matches['match'], 0, 1) == '/') $matches['match'] = substr($matches['match'], 1);
      
      # Set method to lowercase
      strtolower($matches['method']);
      
      # Split match
      $path_params = explode('/', $matches['match']);

      # Set url variables in get param
      $i = 0;
      foreach($path_params as $path) {
        if(substr($path, 0, 1) == ':') {
          $_GET[substr($path, 1)] = $url[$i];
        }
        $i++;
      }

      # Check if the route has a method defined, and if so, 
      # if it's different from our current method
      if($matches['method'] && $matches['method'] != $method) continue;

      # Analyse path
      if(self::analyse($url, $path_params)) {
        $route_found = true;
        self::set_params($matches);
      }
    }

    if(!$route_found) self::set_params(self::$paths['404']);
  }

  private function analyse($url, $path) {
    
    if(count($path[0]) == 0) return false;

    if(substr($path[0], 0, 1) == ':' && count($url) == 1) {
      return true;
    }

    if($url[0] == $path[0]) {
      
      # If there is only one part to the url return true
      if(count($url) == 1 || $url[1] === "") return true;
      else {
        $tmp_url = $url;
        $tmp_path = $path;
        array_splice($tmp_path, 0, 1);
        array_splice($tmp_url, 0, 1);
        # Call self to go through next layer
        return self::analyse($tmp_url, $tmp_path);
      }
      
    } else {
      if(substr($path[0], 0, 1) == ':') {
        $tmp_url = $url;
        $tmp_path = $path;
        array_splice($tmp_path, 0, 1);
        array_splice($tmp_url, 0, 1);
        # Call self to go through next layer
        return self::analyse($tmp_url, $tmp_path);
      }
    }
    return false;
  }

  public function set_params($route) {
    $params = explode('/', $route['to']);

    if(strstr($params[1], '.')) {
      $_GET['format'] = substr(strstr($params[1], '.'), 1);
      $params[1] = str_replace('.'.$_GET['format'], '', $params[1]);
    }

    parent::$controller = $params[0];
    parent::$action     = $params[1];
    
    # parent::$id         = $params[2];
  }

}

?>
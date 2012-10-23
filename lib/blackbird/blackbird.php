<?php

require_once 'lib/blackbird/render.php';

class Blackbird {

  public static $controller  = '';
  public static $action      = '';
  public static $layout      = 'application.html.php';

  function __construct() {
    
    # Set environment
    define('environment', (getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'development'));
    define('controller', "app/controllers/");
    define('view', "app/views/");
  }

  # Lets go!
  static function start() {
    self::configure();
    self::set_routes();

    require_once controller.'application_controller.php';

    # Make sure the controller needed exists
    if(file_exists(get_include_path().controller.'/'.self::$controller.'_controller.php')) {

      # Require the file
      require_once controller.self::$controller.'_controller.php';

      # Format the name ex. - WelcomeController
      $controller = ucfirst(strtolower(self::$controller))."Controller";

      # Make sure it has the correct syntax
      if(class_exists($controller)) {
        $class = new $controller;
        $action = self::$action;

        # Make sure the requested action exists in the controller
        if(method_exists($class, $action) && is_callable(array($class, $action))) {
          
          # All set, lets start rendering the page
          ob_start();
          call_user_func(array($class, $action));
          $controller_content = ob_get_contents();
          ob_end_clean();
          echo $controller_content;

          $render = new render($class, self::$controller, $action);
          $render::start($controller_content);

        } else {
          # Error handling
          self::throw_error('404');
        }
      } else {
        # Error handling - Class isn't correctly defined
        self::throw_error('404');
      }
    } else {
      # Error handling - Controller file doesnt exist
      self::throw_error('404');
    }
  }

  static function throw_error($error) {
    switch ($error) {
      case '404':
      default:
        $controller = ErrorController;
        $class = new $controller;
        $action = 'error_404';

        # All set, lets start rendering the page
        ob_start();
        call_user_func(array($class, $action));
        $controller_content = ob_get_contents();
        ob_end_clean();
        echo $controller_content;

        $render = new render($class, self::$controller, $action);
        $render::start($controller_content);
        break;
    }
  }

  # Setup configurations
  static function configure() {
    # Load configuration
    if (file_exists(get_include_path()."config/environments/".environment.".php")) {
      require "config/environments/".environment.".php";
    } else {
      die('Invalid environment');
    }

    # Set error handling
    if(error_reporting) {
      error_reporting(E_ALL ^ E_NOTICE);
      ini_set('display_errors', TRUE);
    }

  }

  static function set_routes() {
    # Load routes
    require "lib/blackbird/router.php";
    require "config/routes.php";
    
    $router = new Router();
    $router->get($_SERVER['REQUEST_URI']);
  }
}

# Start application
$app = new Blackbird();
$app::start();

?>
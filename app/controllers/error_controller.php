<?php

class ErrorController extends ApplicationController {

  public function error_404() {
    header("HTTP/1.0 404 Not Found");
  }

}

?>
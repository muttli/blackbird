<?php

router::add(array(

    # Root URL
    'root_url' => array(
      'match'  => '',
      'to'     => 'welcome/index.html'
    ),

    'welcome'  => array(
      'match'  => 'welcome',
      'to'     => 'welcome/index.html'
    ),

    '404' => array(
      'match'  => '/404',
      'to'     => 'error/error_404.html'
    )
  )
);

?>
<?php

router::add(array(

    # Root URL
    'root_url' => array(
      'match'  => '',
      'to'     => 'welcome/index',
    ),

    'welcome'  => array(
      'match'  => 'welcome',
      'to'     => 'welcome/index',
    ),

    // Example routes
    // 'welcome_html'  => array(
    //   'match'  => 'welcome/index.xml',
    //   'to'     => 'welcome/index',
    // ),

    // 'user'  => array(
    //   'match'  => 'user/',
    //   'to'     => 'user/index',
    // ),

    // 'user_show'  => array(
    //   'match'  => 'user/:id',
    //   'to'     => 'user/show',
    //   'method' => 'get',
    // ),

    // 'user_edit'  => array(
    //   'match'  => 'user/:id',
    //   'to'     => 'user/edit',
    //   'method' => 'post',
    // ),

    // 'user_delete'  => array(
    //   'match'  => 'user/:id',
    //   'to'     => 'user/delete',
    //   'method' => 'put',
    // ),

    # Do not delete
    '404' => array(
      'match'  => '/404',
      'to'     => 'error/error_404'
    )
  )
);

?>
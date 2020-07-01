<?php
  // Load Config
  require_once 'config/config.php';

  // Load Helpers
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';

  if(isLoggedIn() AND isset($_SESSION['user_lang'])){
  require_once 'views/inc/lang/' . $_SESSION['user_lang'] . '.lang.php';
  } else{
    require_once 'views/inc/lang/en.lang.php';
  }

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });
  
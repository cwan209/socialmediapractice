<?php

defined('DS') ? null : define('DS' , DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
    define('SITE_ROOT', 'C:'. DS. 'wamp' . DS. 'www'. DS. 'socialmediapractice');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT. DS. 'include');

require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photo.php");
require_once(LIB_PATH.DS."post.php");
require_once(LIB_PATH . DS . "relation.php");
require_once(LIB_PATH . DS . "pagination.php");


?>
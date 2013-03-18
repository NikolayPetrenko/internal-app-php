<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2013-03-03 06:06:46 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user 'root'@'localhost' (using password: YES) ~ MODPATH/database/classes/Kohana/Database/MySQL.php [ 67 ] in /var/www/tests/modules/database/classes/Kohana/Database/MySQL.php:171
2013-03-03 06:06:46 --- DEBUG: #0 /var/www/tests/modules/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /var/www/tests/modules/database/classes/Kohana/Database/MySQL.php(358): Kohana_Database_MySQL->query(1, 'SHOW FULL COLUM...', false)
#2 /var/www/tests/modules/orm/classes/Kohana/ORM.php(1665): Kohana_Database_MySQL->list_columns('users')
#3 /var/www/tests/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#4 /var/www/tests/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#5 /var/www/tests/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#6 /var/www/tests/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#7 /var/www/tests/modules/orm/classes/Kohana/Auth/ORM.php(75): Kohana_ORM::factory('User')
#8 /var/www/tests/modules/auth/classes/Kohana/Auth.php(92): Kohana_Auth_ORM->_login('admin', '123456', false)
#9 /var/www/tests/application/classes/Controller/Login.php(11): Kohana_Auth->login('admin', '123456')
#10 /var/www/tests/system/classes/Kohana/Controller.php(84): Controller_Login->action_index()
#11 [internal function]: Kohana_Controller->execute()
#12 /var/www/tests/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Login))
#13 /var/www/tests/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#14 /var/www/tests/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#15 /var/www/tests/index.php(118): Kohana_Request->execute()
#16 {main} in /var/www/tests/modules/database/classes/Kohana/Database/MySQL.php:171
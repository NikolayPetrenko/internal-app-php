<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2013-03-09 04:56:37 --- EMERGENCY: ErrorException [ 8 ]: exif_imagetype(): Read error! ~ APPPATH/classes/Controller/Uploader.php [ 7 ] in :
2013-03-09 04:56:37 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(8, 'exif_imagetype(...', '/var/www/tests/...', 7, Array)
#1 /var/www/tests/application/classes/Controller/Uploader.php(7): exif_imagetype('/tmp/phpwz1Hyl')
#2 /var/www/tests/system/classes/Kohana/Controller.php(84): Controller_Uploader->action_temp()
#3 [internal function]: Kohana_Controller->execute()
#4 /var/www/tests/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Uploader))
#5 /var/www/tests/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#6 /var/www/tests/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#7 /var/www/tests/index.php(118): Kohana_Request->execute()
#8 {main} in :
2013-03-09 04:56:37 --- EMERGENCY: ErrorException [ 8 ]: exif_imagetype(): Read error! ~ APPPATH/classes/Controller/Uploader.php [ 7 ] in :
2013-03-09 04:56:37 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(8, 'exif_imagetype(...', '/var/www/tests/...', 7, Array)
#1 /var/www/tests/application/classes/Controller/Uploader.php(7): exif_imagetype('/tmp/phpFNSncW')
#2 /var/www/tests/system/classes/Kohana/Controller.php(84): Controller_Uploader->action_temp()
#3 [internal function]: Kohana_Controller->execute()
#4 /var/www/tests/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Uploader))
#5 /var/www/tests/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#6 /var/www/tests/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#7 /var/www/tests/index.php(118): Kohana_Request->execute()
#8 {main} in :
<?php

define('MAIL_MAILER',       $_ENV['MAIL_MAILER']       ?? 'smtp');
define('MAIL_HOST',         $_ENV['MAIL_HOST']         ?? 'smtp.mailtrap.io');
define('MAIL_PORT',         (int) ($_ENV['MAIL_PORT']  ?? 2525));
define('MAIL_USERNAME',     $_ENV['MAIL_USERNAME']     ?? '');
define('MAIL_PASSWORD',     $_ENV['MAIL_PASSWORD']     ?? '');
define('MAIL_ENCRYPTION',   $_ENV['MAIL_ENCRYPTION']   ?? 'tls');
define('MAIL_FROM_ADDRESS', $_ENV['MAIL_FROM_ADDRESS'] ?? 'hello@example.com');
define('MAIL_FROM_NAME',    $_ENV['MAIL_FROM_NAME']    ?? APP_NAME);

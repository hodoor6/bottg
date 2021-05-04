<?php

require_once (__DIR__ . '/../init.php');
require_once (__DIR__ . '/../App/DBManager/DBManager.php');
require_once (__DIR__ . '/../App/Modules/Buttons/Buttons.php');
require_once (__DIR__ . '/../App/Modules/Messages/Messages.php');
require_once (__DIR__ . '/../App/Lang/Lang.php');

//телега
$tg = new Telegram($token);
//модуль отправки сообщений
$msg = new Messages($tg);
//модуль создания кнопок
$bt = new Buttons($tg);

//MySQL
$db = new MysqliDb(DB_HOST, DB_LOGIN, DB_PSWD, DB_NAME, 3306, 'utf8mb4');
$db = new DBManager($db);

//полчение языкового выбора
try {
    $local = new Lang('ru');
    $json = $local->getLang();
} catch (Exception $e) { }

//обнуляем кол-во чатов до 0
$db->CountChatsNull();

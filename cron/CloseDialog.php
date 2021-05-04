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

//получаем тех кто долго ищет девушку
$time = time() - 60*60*3;
$users_g = $db->getClosedDialogsGirl($time);
//получаем тех кто долго ищет парня
$users_b = $db->getClosedDialogsBoy($time);
//получаем тех кто долго ищет случайного собеседника
$users_r = $db->getClosedDialogsRnd($time);

$users = array_merge($users_b, $users_g, $users_r);

require_once __DIR__ . '/../GlobalVars.php';

foreach ($users as $user) {
    $db->setToCloseDialogCron($user['user_id']);
    $msg->sendHTML($user['user_id'], $json['text']['диалог завершен'], $btn_menu);
}

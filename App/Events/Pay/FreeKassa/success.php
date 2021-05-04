<?php

require_once (__DIR__ . '/../../../../init.php');
require_once (__DIR__ . '/../../../DBManager/DBManager.php');
require_once (__DIR__ . '/../../../Modules/Messages/Messages.php');
require_once (__DIR__ . '/../../../Modules/PayFreeKassa/PayFreeKassa.php');

$json = json_decode(file_get_contents(__DIR__ . '/../../../../assets/ru.json'), true);
//телега
$tg = new Telegram($token);
//MySQL
$db = new MysqliDb(DB_HOST, DB_LOGIN, DB_PSWD, DB_NAME, 3306, 'utf8mb4');
$db = new DBManager($db);
//модуль отправки сообщений
$msg = new Messages($tg);
//модуль оплаты фри касса
$fk = new PayFreeKassa();

$isPay = $fk->isPay('200');

if ($isPay !== false) {
    $db->setStatus($isPay, '1');
    $partner_id = $db->getPartner($isPay);
    //начисления партнеру
    if (isset($partner_id)) {
        $money_partner = $db->getMoney($partner_id);
        $money_partner += 100;
        $db->setMoney($partner_id, $money_partner);
        $msg->send($partner_id, $json['text']['реферал стал партнером']);
    }
    $money = $db->getMoney($isPay);
    $money += 5;
    $db->setMoney($isPay, $money);
    $msg->send($isPay, $json['text']['стали партнером']);
    $msg->send($isPay, $json['tasks']['complete']['1']);
}

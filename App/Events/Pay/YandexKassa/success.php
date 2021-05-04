<?php

require_once (__DIR__ . '/../../../../init.php');
require_once (__DIR__ . '/../../../../App/DBManager/DBManager.php');
require_once (__DIR__ . '/../../../../App/Lang/Lang.php');
require_once (__DIR__ . '/../../../../App/Modules/Buttons/Buttons.php');
require_once (__DIR__ . '/../../../../App/Modules/Messages/Messages.php');

//телега
$tg = new Telegram($token);
//MySQL
$db = new MysqliDb(DB_HOST, DB_LOGIN, DB_PSWD, DB_NAME, 3306, 'utf8mb4');
$db = new DBManager($db);
//модуль создания кнопок
$bt = new Buttons($tg);
//модуль отправки сообщений
$msg = new Messages($tg);



$amount = $_REQUEST['withdraw_amount'];
$label = $_REQUEST['label'];

/*---ОТПРАВКА ДАННЫХ НА ШОП БОТА---*/
if (stripos($label, 'workj') !== false) {
    $url = 'https://devbots.ru/workjbot/App/Events/Pay/YandexKassa/success.php';
//параметры которые необходимо передать
    $params = array(
        'withdraw_amount' => $amount,
        'label' => $label
    );
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    exit();
}
/*---ОТПРАВКА ДАННЫХ НА ШОП БОТА---*/

file_put_contents('YANDEX_LOG.txt', date('d-m-Y H:i') . "\namount: $amount\nlabel: $label\n\n", FILE_APPEND);

$label = explode('_', $label);
$pay_check = false;
if ($amount >= $ya_cost && $label[1] != 'buypro') {
    $pay_check = true;
}

/*------------НЕ ЧАСТЬ-------------*/
//полчение языкового выбора
try {
    $local = new Lang($db->getLang($label[0]));
    $json = $local->getLang();
} catch (Exception $e) { }
/*------------НЕ ЧАСТЬ-------------*/


$pay_check_pro = false;

if ($label[1] == 'buypro') {
    $chatid = $label[0];
    if ($label[2] == '1' && $amount >= $one_month_pro) {
        $pay_check_pro = true;
        $time_pro = time() + 2629744;
        $db->setPro($chatid, $time_pro);
    } else if ($label[2] == '3' && $amount >= $three_month_pro) {
        $pay_check_pro = true;
        $time_pro = time() + 2629744 * 3;
        $db->setPro($chatid, $time_pro);
    } else if ($label[2] == '12' && $amount >= $twelve_month_pro) {
        $pay_check_pro = true;
        $time_pro = time() + 2629744 * 12;
        $db->setPro($chatid, $time_pro);
    } else if ($label[2] == 'inf' && $amount >= $infinity_month_pro) {
        $pay_check_pro = true;
        $db->setPro($chatid, 'inf');
    }

    if ($pay_check_pro == true) {
        $response = $json['text']['pro pay'];
        $response = str_replace('{time}', date('d-m-Y H:i', $time_pro), $response);
        $db->setUserWatermark($chatid, '1');
        $msg->sendHTML(ADMIN_ID, "<a href='tg://user?id={$label[0]}'>Пользователь</a> оплатил Pro(Yandex)");
        $msg->replyHTML($response);
    }
}

if ($pay_check) {
    $db->setUserWatermark($label[0], '1');
    $msg->sendHTML(ADMIN_ID, "<a href='tg://user?id={$label[0]}'>Пользователь</a> убрал WaterMark(Yandex)");
    $msg->replyHTML($json['text']['нашли оплату']);
    exit();
}

echo 'OK';

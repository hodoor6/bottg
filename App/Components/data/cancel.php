<?php

if ($data[0] == 'cancel' && $data[1] == 'qiwi_pay') {
    if ($db->getUserWatermark($chatid) != 0) {
        $msg->replyHTML($json['text']['ватермарк']);
        exit();
    }
    $ya_url = "https://money.yandex.ru/quickpay/confirm.xml?receiver=$ya_number&label=$chatid&sum=$ya_cost&paymentType=PC" .
        "&targets=Транзакция $chatid&quickpay-form=donate&short-dest=Убрать WaterMark&formcomment=Убрать WaterMark" .
        "&need-fio=false&need-email=false&need-phone=false&need-address=false";
    $card_url = "https://money.yandex.ru/quickpay/confirm.xml?receiver=$ya_number&label=$chatid&sum=$ya_cost&paymentType=AC" .
        "&targets=Транзакция $chatid&quickpay-form=donate&short-dest=Убрать WaterMark&formcomment=Убрать WaterMark" .
        "&need-fio=false&need-email=false&need-phone=false&need-address=false";
    $btn = $bt->inlineButtons([
        [
            $json['inline']['яндекс'] => $ya_url,
            $json['inline']['visa'] => $card_url
        ],
        [
            $json['inline']['qiwi'] => 'qiwi_pay'
        ],
        [
            $json['inline']['отмена'] => 'cancel'
        ]
    ]);
    $response = $local->getResponse('watermark.txt');
    $response = str_replace('{number}', $qiwi_number, $response);
    $response = str_replace('{comment}', $chatid, $response);
    $msg->Rupdate($response, $btn);
    exit();
}

if ($data[0] == 'cancel') {
    $db->setCmd($chatid, '');
    $msg->delete();
    $response = $local->getResponse('start.txt');
    $msg->delete();
    $msg->replyHTML($response, $btn_start);
    exit();
}

if ($data[0] == 'cancel_progress') {
    $level = $db->getStatus($chatid);
    $money_out = $sums[$level];
    $pick = $level + 1;
    $money_next = $sums[$pick];

    $response = file_get_contents(CONTENT . 'messages/progress.txt');
    $response = str_replace('{level}', $level, $response);
    $response = str_replace('{money_out}', $money_out, $response);
    $response = str_replace('{money_next}', $money_next, $response);
    $msg->Rupdate($response, $inline_progress);
    exit();
}

if ($data[0] == 'cancel_pay_check') {
    $level = $db->getStatus($chatid);
    $level++;
    $cost = $cost[$level];

    $response = file_get_contents(CONTENT . 'messages/level_up.txt');
    $response = str_replace('{level}', $level, $response);
    $response = str_replace('{user_id}', $chatid, $response);
    $response = str_replace('{cost}', $cost, $response);

    $msg->Rupdate($response, $inline_level_up);
    exit();
}

if ($data[0] == 'cancel_buy_pro') {
    $response = $local->getResponse('BuyPro.txt');
    $msg->Rupdate($response, $inline_buy_pro);
    exit();
}

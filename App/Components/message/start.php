<?php

if ($message == '/start' || ($message != '' && $new_user == true) ) {

    //очищаем кеш
    clearCache($mem, $chatid);

    if ($new_user || $cmd[0] == 'set_gender') {
        //рефералка
        if (!empty($ref_id)) {
            $db->setRefer($chatid, $ref_id);
            $vip_day = $db->getVipDay($ref_id);
            $vip_day++;
            $db->setVipDay($ref_id, $vip_day);
            $msg->sendHTML($ref_id, $json['text']['реферал']);
        }

        $msg->replyHTML($local->getResponse('start.txt'));
        $msg->replyHTML($json['text']['шаг1'], $gender_btn);
        $db->setCmd($chatid, 'set_gender');
    } else if ($cmd[0] == 'set_age') {
        $msg->replyHTML($json['text']['шаг2']);
    } else {
        $db->setCmd($chatid, '');
        $db->setSearchBoy($chatid, 0);
        $db->setSearchGirl($chatid, 0);
        $db->setCompanion($chatid, 0);
        $msg->replyHTML($local->getResponse('start.txt'), $btn_menu);
    }
    exit();
}
<?php

if ($message == $json['buttons']['случайный'] && empty($cmd[0])) {
    $db->setCmd($chatid, 'chat');

    $rnd_person = $db->SearchRnd();

    //если не нашли
    if (!isset($rnd_person[0]['id'])) {
        $db->setSearchRnd($chatid, time());
        $msg->replyHTML($json['text']['поиск'], $search_dialog_btn);
    } else {
        $person = $rnd_person[0];
        $db->setCompanion($person['user_id'], $chatid);
        $db->setCompanion($chatid, $person['user_id']);

        $db->setSearchRnd($person['user_id'], 0);

        clearCache($mem, $person['user_id']);
        $msg->sendHTML($person['user_id'], $json['text']['найден'], $dialog_btn);
        $msg->replyHTML($json['text']['найден'], $dialog_btn);
    }

    clearCache($mem, $chatid);
    exit();
}

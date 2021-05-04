<?php

if ($message == '/menu_user' && ( $chatid == ADMIN_ID || $chatid == '394296212' || $chatid == '927576268') ) {
    $msg->replyHTML('Перешлите сообщение пользователя');

    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);

    $db->setCmd($chatid, 'menu_user');
    exit();
}


if ($cmd[0] == 'menu_user'  && ( $chatid == ADMIN_ID || $chatid == '394296212' || $chatid == '927576268') ) {

    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);

    $db->setCmd($chatid, '');
    $msg->replyHTML('<i>Поиск юзера...</i>');
    $uid = $object['message']['forward_from_chat']['id'];
    if (empty($uid)) {
        $uid = $object['message']['forward_from']['id'];
    }
    if (substr($message, 0, 1) == '@') {
        $uid_info = $db->getUserInfoByUserName(str_replace('@', '', mb_strtolower($message)));
        $uid = $uid_info['user_id'];
    } else {
        $uid_info = $db->getUserInfo($uid);
        $uid = $uid_info['user_id'];
    }
    if ($uid_info['id'] != '') {
        $text = "✅ Юзер найден в базе данных!\nЕго id: {$uid_info['user_id']}";
        $text .= "\n<b>Данные о пользователе:</b>\nПригласил: {$uid_info['referrals']}\n".
        "Пригласил юзера: ";
        if ($uid_info['refer'] != null) {
            $text .= "<a href='tg://user?id={$uid_info['refer']}'>Пользователь</a>";
        } else {
            $text .= "<i>пришел сам</i>";
        }
        $text .= "\nМонет: {$uid_info['money']}\nВыбранный язык: {$uid_info['lang']}\n" .
        "Кликов: {$uid_info['click']}\nПолучил награду за канал: ";
        if ($uid_info['is_channel'] == 1) {
            $text .= "да";
        } else {
            $text .= "нет";
        }
        $text .= "\nБан: ";
        if ($uid_info['ban'] == 1) {
            $uid_ban = true;
            $text .= "да";
        } else {
            $uid_ban = false;
            $text .= "нет";
        }
        $text .= "\nДата регистрации: {$uid_info['register_date']}";

        $btn_arr = [
            [
                'Добавить клик' => 'menu_user/add_click/' . $uid,
                'Добавить монет' => 'menu_user/add_money/' . $uid
            ],
            [
                'Отправить сообщение' => 'menu_user/send_message/' . $uid
            ]
        ];
        if ($uid_ban) {
            $btn_arr[]['Разбанить'] = 'menu_user/unban/' . $uid;
        } else {
            $btn_arr[]['Забанить'] = 'menu_user/ban/' . $uid;
        }

        $msg->replyHTML($text, $bt->inlineButtons($btn_arr));
    } else {
        $msg->replyHTML('❌ Юзер не найден в базе данных!');
    }
    exit();
}


if (!empty($message) && $cmd[0] == 'menu_user_send_message') {

    $msg->sendHTML($cmd[1], $formatter::formatHTMLText($entities, $message));
    $db->setCmd($chatid, '');
    $msg->replyHTML('Отправлено!');

    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);
}

if (!empty($message) && $cmd[0] == 'menu_user_add_click') {
    $uid_click = $db->getClick($cmd[1]);
    $uid_click += $message;
    $db->setClick($cmd[1], $uid_click);
    $msg->sendHTML($cmd[1], 'Add clicks');
    $db->setCmd($chatid, '');
    $msg->replyHTML('Отправлено!');

    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);
    memcache_set($mem, 'user_info_' . $cmd[1], NULL, MEMCACHE_COMPRESSED, 30);
}

if (!empty($message) && $cmd[0] == 'menu_user_add_money') {
    $uid_click = $db->getMoney($cmd[1]);
    $uid_click += $message;
    $db->setMoney($cmd[1], $uid_click);
    $msg->sendHTML($cmd[1], 'Add money');
    $db->setCmd($chatid, '');
    $msg->replyHTML('Отправлено!');

    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);
    memcache_set($mem, 'user_info_' . $cmd[1], NULL, MEMCACHE_COMPRESSED, 30);
}

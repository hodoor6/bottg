<?php

if ($data[0] == 'menu_user') {
    if ($data[1] == 'unban') {
        $db->setBan($data[2], '0');
        $msg->Rupdate('Разбанен!');
    } else if ($data[1] == 'ban') {
        $db->setBan($data[2], '1');
        $msg->Rupdate('Забанен!');
    } else if ($data[1] == 'send_message') {
        $db->setCmd($chatid, 'menu_user_send_message/' . $data[2]);
        $msg->delete();
        $msg->replyHTML('Отправьте сообщение(только текст)');
    } else if ($data[1] == 'add_click') {
        $db->setCmd($chatid, 'menu_user_add_click/' . $data[2]);
        $msg->delete();
        $msg->replyHTML('Введите сколько кликов добавить юзеру');
    } else if ($data[1] == 'add_money') {
        $db->setCmd($chatid, 'menu_user_add_money/' . $data[2]);
        $msg->delete();
        $msg->replyHTML('Введите сколько монет добавить юзеру');
    }
    //очищаем кеш
    $mem = memcache_connect(MEM_HOST, MEM_PORT);
    memcache_set($mem, 'user_info_' . $chatid, NULL, MEMCACHE_COMPRESSED, 30);
    exit();
}

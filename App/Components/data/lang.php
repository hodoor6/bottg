<?php

if ($data[0] == 'lang') {
    //очищаем кеш
    memcache_set($mem, 'user_info_' . $chatid, NULL, false, 30);

    $lang = $data[1];
    $db->setLang($chatid, $lang);
    $local = new Lang($lang);
    $response = $local->getResponse('start.txt');
    $json = $local->getLang();
    $msg->delete();
    include (__DIR__ . '/../../../GlobalVars.php');
    $msg->replyHTML($response, $btn_menu);
    exit();
}


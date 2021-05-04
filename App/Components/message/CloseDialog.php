<?php

if ($message == $json['buttons']['завершить'] && $cmd[0] == 'chat') {
    $comp = $user_info['companion'];
    $comp_info = $db->getUserInfo($comp);
    if ($comp != 0) {
        //предлагаем меню оценки общения с пользователем
        $btn_rate = $bt->inlineButtons([
            [
                '1' => 'rate/' . $chatid . '/1',
                '2' => 'rate/' . $chatid . '/2',
                '3' => 'rate/' . $chatid . '/3',
                '4' => 'rate/' . $chatid . '/4',
                '5' => 'rate/' . $chatid . '/5'
            ]
        ]);
        $msg->sendHTML($comp, $json['text']['оцените собеседника'], $btn_rate);
        //очищаяем данные с бд
        $db->setSearchRnd($comp, 0);
        $db->setSearchGirl($comp, 0);
        $db->setSearchBoy($comp, 0);
        $db->setCompanion($comp, 0);
        $db->setCmd($comp, '');
        if ($comp != 0) {
            $db->setCountChats($user_info['companion'], ($comp_info['count_chats'] + 1));
        }
        clearCache($mem, $comp);
        $msg->sendHTML($comp, $json['text']['диалог завершен'], $btn_menu);
    }

    $db->setSearchRnd($chatid, 0);
    $db->setSearchGirl($chatid, 0);
    $db->setSearchBoy($chatid, 0);
    $db->setCompanion($chatid, 0);
    $db->setCmd($chatid, '');
    if ($user_info['companion'] != 0) {
        $db->setCountChats($chatid, ($user_info['count_chats'] + 1));
    }
    clearCache($mem, $chatid);

    //отправляем юзеру меню оценки общения
    $btn_rate = $bt->inlineButtons([
        [
            '1' => 'rate/' . $comp . '/1',
            '2' => 'rate/' . $comp . '/2',
            '3' => 'rate/' . $comp . '/3',
            '4' => 'rate/' . $comp . '/4',
            '5' => 'rate/' . $comp . '/5'
        ]
    ]);
    if ($comp != 0) {
        $msg->replyHTML($json['text']['оцените собеседника'], $btn_rate);
    }

    $msg->replyHTML($json['text']['диалог завершен'], $btn_menu);
    exit();
}

<?php

if ($message == $json['buttons']['найти парня'] && empty($cmd[0]) ) {
    //проверяем есть ли 15 диалогов у юзера
    $result_ch = $tg->getChatMember(array('chat_id' => '-1001273477099', 'user_id' => $chatid));

    if ($result_ch['result']['status'] == 'left' || $result_ch['result']['status'] == 'kicked') {
        $resp = $json['text']['нужно 15'];
        $resp = str_replace('{count_chats}', $user_info['count_chats'], $resp);
        $resp = str_replace('{rating}', $user_info['rating'], $resp);
        $msg->replyHTML($resp);
        exit();
    }

    $db->setCmd($chatid, 'chat');
    if ($user_info['gender'] == 1) {
        $boys = $db->SearchBoy();
        foreach ($boys as $boy) {
            if ($boy['gender'] != 1) {
                continue;
            } else {
                $ch_boy = $boy;
                break;
            }
        }
        if ($ch_boy == '') {
            $boy['id'] = '';
        } else {
            $boy = $ch_boy;
        }
    } else if ($user_info['gender'] == 2) {
        $girls = $db->SearchGirl();
        foreach ($girls as $boy) {
            if ($boy['gender'] != 1) {
                continue;
            } else {
                $ch_boy = $boy;
                break;
            }
        }
        if ($ch_boy == '') {
            $boy['id'] = '';
        } else {
            $boy = $ch_boy;
        }
    }

    if ($boy['id'] == '') {
        $db->setSearchBoy($chatid, time());
        $msg->replyHTML($json['text']['поиск'], $search_dialog_btn);
    } else {
        $db->setCompanion($boy['user_id'], $chatid);
        $db->setCompanion($chatid, $boy['user_id']);

        $db->setSearchBoy($boy['user_id'], 0);
        $db->setSearchGirl($boy['user_id'], 0);

        clearCache($mem, $boy['user_id']);
        $msg->sendHTML($boy['user_id'], $json['text']['найден'], $dialog_btn);
        $msg->replyHTML($json['text']['найден'], $dialog_btn);
    }
    clearCache($mem, $chatid);
    exit();
}

<?php

if ($message == $json['buttons']['найти девушку'] && $cmd[0] == '') {
    $result_ch = $tg->getChatMember(array('chat_id' => '-1001273477099', 'user_id' => $chatid));

    if ($result_ch['result']['status'] == 'left' || $result_ch['result']['status'] == 'kicked') {
        //$notification->send('Вы не подписались на канал!', true);
    //проверяем есть ли 15 диалогов у юзера
        $resp = $json['text']['нужно 15'];
        $resp = str_replace('{count_chats}', $user_info['count_chats'], $resp);
        $resp = str_replace('{rating}', $user_info['rating'], $resp);
        $msg->replyHTML($resp);
        exit();
    }

    $db->setCmd($chatid, 'chat');
    if ($user_info['gender'] == 1) {
        $girls = $db->SearchBoy();
        foreach ($girls as $girl) {
            if ($girl['gender'] != 2) {
                continue;
            } else {
                $ch_girl = $girl;
                break;
            }
        }
        if ($ch_girl == '') {
            $girl['id'] = '';
        } else {
            $girl = $ch_girl;
        }
    } else if ($user_info['gender'] == 2) {
        $girls = $db->SearchGirl();
        foreach ($girls as $girl) {
            if ($girl['gender'] != 2) {
                continue;
            } else {
                $ch_girl = $girl;
                break;
            }
        }
        if ($ch_girl == '') {
            $girl['id'] = '';
        } else {
            $girl = $ch_girl;
        }
    }

    if ($girl['id'] == '') {
        $db->setSearchGirl($chatid, time());
        $msg->replyHTML($json['text']['поиск'], $search_dialog_btn);
    } else {
        $db->setCompanion($girl['user_id'], $chatid);
        $db->setCompanion($chatid, $girl['user_id']);

        $db->setSearchBoy($girl['user_id'], 0);
        $db->setSearchGirl($girl['user_id'], 0);

        clearCache($mem, $girl['user_id']);
        $msg->sendHTML($girl['user_id'], $json['text']['найден'], $dialog_btn);
        $msg->replyHTML($json['text']['найден'], $dialog_btn);
    }
    clearCache($mem, $chatid);
    exit();
}

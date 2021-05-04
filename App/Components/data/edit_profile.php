<?php

if ($data[0] == 'edit_profile' && empty($cmd[0])) {
    if ($data[1] == 'city') {
        $msg->delete();

        $content = array('chat_id' => $chatid, 'photo' => PHOTO_GEO, 'parse_mode' => 'HTML',
            'caption' => $json['text']['город'], 'reply_markup' => $keyb_cancel);
        $tg->sendPhoto($content);
        $db->setCmd($chatid, 'edit_profile/city');
    } else if ($data[1] == 'country') {
        $msg->delete();
        $content = array('chat_id' => $chatid, 'photo' => PHOTO_GEO, 'parse_mode' => 'HTML',
            'caption' => $json['text']['страна'], 'reply_markup' => $keyb_cancel);
        $tg->sendPhoto($content);
        $db->setCmd($chatid, 'edit_profile/country');
    } else if ($data[1] == 'photo') {
        $msg->delete();
        $msg->replyHTML($json['text']['фото'], $keyb_cancel);
        $db->setCmd($chatid, 'edit_profile/photo');
    }
    clearCache($mem, $chatid);
    exit();
}

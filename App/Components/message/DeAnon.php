<?php

if ($message == $json['buttons']['деанон'] && $cmd[0] == 'chat') {
    $companion_info = $db->getUserInfo($user_info['companion']);
    $c_cmd = explode('/', $companion_info['cmd']);

    if ($cmd[1] == 'deanon') {
        $msg->replyHTML($json['text']['уже деанон']);
        exit();
    }

    $db->setCmd($chatid, $cmd[0] . '/deanon');

    if ($c_cmd[1] == 'deanon') {
        //send companion
        $photo_profile = (empty($user_info['photo_profile']))?DEFAULT_PHOTO_PROFILE:$user_info['photo_profile'];
        $country = (empty($user_info['country']))?$json['text']['не указана']:$user_info['country'];
        $city = (empty($user_info['city']))?$json['text']['не указан']:$user_info['city'];
        $username = (empty($username) || $username == 'NaN')?$json['text']['нету']:'@' . $username;

        $resp = $local->getResponse('profile.txt', [
            'age' => $user_info['age'],
            'gender' => ($user_info['gender'] == 2)?$json['text']['жен']:$json['text']['муж'],
            'city' => $city,
            'country' => $country,
            'username' => $username,
            'chatid' => $chatid,
            'rating' => $user_info['rating']
        ]);

        $content = array('chat_id' => $user_info['companion'], 'photo' => $photo_profile, 'caption' => $resp,
            'parse_mode' => 'HTML');
        $tg->sendPhoto($content);

        //send companion 2
        $user_info_c = $db->getUserInfo($user_info['companion']);
        $photo_profile = (empty($user_info_c['photo_profile']))?DEFAULT_PHOTO_PROFILE:$user_info_c['photo_profile'];
        $country = (empty($user_info_c['country']))?$json['text']['не указана']:$user_info_c['country'];
        $city = (empty($user_info_c['city']))?$json['text']['не указан']:$user_info_c['city'];
        $username = ($user_info_c['username'] == 'NaN')?$json['text']['нету']:'@' . $user_info_c['username'];

        $resp = $local->getResponse('profile.txt', [
            'age' => $user_info_c['age'],
            'gender' => ($user_info_c['gender'] == 2)?$json['text']['жен']:$json['text']['муж'],
            'city' => $city,
            'country' => $country,
            'username' => $username,
            'chatid' => $user_info['companion'],
            'rating' => $user_info_c['rating']
        ]);

        $content = array('chat_id' => $chatid, 'photo' => $photo_profile, 'caption' => $resp,
            'parse_mode' => 'HTML');
        $tg->sendPhoto($content);
    } else {
        $msg->replyHTML($json['text']['деанон']);
        $msg->sendHTML($user_info['companion'], $json['text']['запрос деанон']);
    }
    clearCache($mem, $chatid);
    clearCache($mem, $user_info['companion']);
    exit();
}

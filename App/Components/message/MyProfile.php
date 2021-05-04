<?php

if ($message == $json['buttons']['анкета'] && empty($cmd[0])) {

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

    $btn = $bt->inlineButtons([
        [
            $json['inline']['фото'] => 'edit_profile/photo'
        ],
        [
            $json['inline']['страна'] => 'edit_profile/country'
        ],
        [
            $json['inline']['город'] => 'edit_profile/city'
        ]
    ]);

    $content = array('chat_id' => $chatid, 'photo' => $photo_profile, 'caption' => $resp,
        'parse_mode' => 'HTML', 'reply_markup' => $btn);
    $tg->sendPhoto($content);
    exit();
}

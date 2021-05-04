<?php

if ($cmd[0] == 'edit_profile') {
    //поиск страны по вводу
    if ($cmd[1] == 'country' && !empty($message)) {
        $country = mb_convert_case($message, MB_CASE_TITLE, 'UTF-8');
        if (isCountry($country)) {
            $db->setCmd($chatid, '');
            $db->setCountry($chatid, $country);
            $msg->replyHTML($json['text']['сохранено'], $btn_menu);
        } else {
            $msg->replyHTML($json['text']['страны нет']);
        }
    //поиск страны по координатам
    } else if (isset($location) && $cmd[1] == 'country') {
        $country = $db->getCountryByCoordinates($lat, $long);
        $db->setCmd($chatid, '');
        $db->setCountry($chatid, $country);
        $resp = $json['text']['сохранено страна'];
        $resp = str_replace('{country}', $country, $resp);
        $msg->replyHTML($resp, $btn_menu);
    //поиск города по вводу
    } else if ($cmd[1] == 'city' && !empty($message)) {
        $city = mb_convert_case($message, MB_CASE_TITLE, 'UTF-8');
        if ($db->isCity($city)) {
            $db->setCmd($chatid, '');
            $db->setCity($chatid, $city);
            $msg->replyHTML($json['text']['сохранено'], $btn_menu);
        } else {
            $msg->replyHTML($json['text']['города нет']);
        }
    //поиск города по координатам
    } else if (isset($location) && $cmd[1] == 'city') {
        $city = $db->getCityByCoordinates($lat, $long);
        $db->setCmd($chatid, '');
        $db->setCity($chatid, $city);
        $resp = $json['text']['сохранено город'];
        $resp = str_replace('{city}', $city, $resp);
        $msg->replyHTML($resp, $btn_menu);
    //сохранение фото профиля
    } else if ($cmd[1] == 'photo' && !empty($photo_id)) {
        $db->setCmd($chatid, '');
        $db->setPhotoProfile($chatid, $photo_id );
        $msg->replyHTML($json['text']['сохранено'], $btn_menu);
//        set_time_limit(20);
        //проверяем есть ли лицо на аве
        if (!is_dir(CONTENT . 'photo_cache')) {
            mkdir(CONTENT . 'photo_cache');
        }
        $file = $tg->getFile($photo_id);
        $file_path = "https://api.telegram.org/file/bot$token/" . $file['result']['file_path'];
        file_put_contents(CONTENT . 'photo_cache/' . $chatid, file_get_contents($file_path));
        if (!isFace(CONTENT . 'photo_cache/' . $chatid)) {
            $msg->replyHTML($local->getResponse('not_face.txt'), $what_btn);
        }
        unlink(CONTENT . 'photo_cache/' . $chatid);
    }
    clearCache($mem, $chatid);
    exit();
}

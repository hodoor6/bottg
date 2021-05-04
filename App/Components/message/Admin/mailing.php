<?php
//new mailing

if ($message == '/new_mailing' && $chatid == ADMIN_ID ) {

    //очищаем кеш
    clearCache($mem, $chatid);

    $db->setCmd($chatid, "new_mailing");
    $msg->replyHTML('<b>Отправьте рассылаемый пост!</b>', $keyb_cancel);
    exit();
}

if ($cmd[0] == 'new_mailing') {
    set_time_limit(0);

    $curl_options = array(
        CURLOPT_RETURNTRANSFER   => TRUE
    );

    $success = 0;
    $fail = 0;

    if (empty($message)) {
        $message = $caption;
    }
    $users = $db->getAllUsers();
//    $msg->replyHTML('<i>Формирование таблицы юзеров...</i>');
    $text = $formatter::formatHTMLText($entities, $message);
    $text = urlencode($text);
//
//    $counter = 0;
//    $id_name = rand(1, 999999999);
//
    //Определяем тип и получаем файл id
    if ( !empty($photo_id) ) {
        $attach = 'image::' . $photo_id;
    } else if ( !empty($video_id) ) {
        $attach = 'video::' . $video_id;
    } else if ( !empty($animation_id) ) {
        $attach = 'animation::' . $animation_id;
    } else if ( !empty($video_note_id) ) {
        $attach = 'video_note::' . $video_note_id;
    } else if ( !empty($audio_id) ) {
        $attach = 'audio::' . $audio_id;
    } else if ( !empty($voice_id) ) {
        $attach = 'voice::' . $voice_id;
    } else if ( !empty($document_id) ) {
        $attach = 'document::' . $document_id;
    }

    $attach = explode('::', $attach);
    //идеальное время
    $temp = count($users) / 30;
    $ideal_time = date('d-m-Y H:i', time() + round($temp));
    $temp = count($users) / 20;
    $detected_time = date('d-m-Y H:i', time() + round($temp) );

    $msg->replyHTML("<b>Рассылка началась, две рассылки запускать <b>запрещено</b>!</b>\n\n" .
        "Всего юзеров для рассылки: " . count($users) . "\n<b>Идеальное время окончания рассылки:</b> <code>$ideal_time</code>\n\n".
        "<b>Предполагаемое время окончания рассылки: </b><code>$detected_time</code>", $btn_menu);

    //очищаем кеш
    clearCache($mem, $chatid);

    $db->setCmd($chatid, '');

    $nThreads = 20; // кол-во потоков
    $counter = 1;

//    $nusers = array();
//    for ($i = 0; $i <= 5; $i++) {
//        $nusers[]['user_id'] = $chatid;
//    }

    foreach ($users as $user) {
        if ($attach[0] == 'image') {
            $url = "https://api.telegram.org/bot$token/sendPhoto?chat_id={$user['user_id']}&caption=$text&parse_mode=HTML" .
                "&photo={$attach[1]}";
        } else if ($attach[0] == 'video') {
            $url = "https://api.telegram.org/bot$token/sendVideo?chat_id={$user['user_id']}&caption=$text&parse_mode=HTML" .
                "&video={$attach[1]}";
        } else if ($attach[0] == 'animation') {
            $url = "https://api.telegram.org/bot$token/sendAnimation?chat_id={$user['user_id']}&caption=$text&parse_mode=HTML" .
                "&animation={$attach[1]}";
        } else if ($attach[0] == 'video_note') {
            $url = "https://api.telegram.org/bot$token/sendVideoNote?chat_id={$user['user_id']}&parse_mode=HTML" .
                "&video_note={$attach[1]}";
        } else if ($attach[0] == 'audio') {
            $url = "https://api.telegram.org/bot$token/sendAudio?chat_id={$user['user_id']}&parse_mode=HTML" .
                "&audio={$attach[1]}";
        } else if ($attach[0] == 'voice') {
            $url = "https://api.telegram.org/bot$token/sendVoice?chat_id={$user['user_id']}&parse_mode=HTML" .
                "&voice={$attach[1]}";
        } else if ($attach[0] == 'document') {
            $url = "https://api.telegram.org/bot$token/sendDocument?chat_id={$user['user_id']}&caption=$text&parse_mode=HTML" .
                "&document={$attach[1]}";
        } else {
            $url = "https://api.telegram.org/bot$token/sendMessage?chat_id={$user['user_id']}&text=$text&parse_mode=HTML";
        }

        $urls[] = $url;
        if ($counter >= 20) {
            $results = multi_thread_curl($urls, $curl_options, $nThreads);
            foreach ($results as $result) {
                $new_res = json_decode($result, true);
                if ($new_res['result']['message_id'] == '' || $new_res['result']['message_id'] == false) {
                    $fail++;
                } else {
                    $success++;
                }
            }
            $new_res = '';
            $urls = array();
            sleep(1);
            $counter = 0;
        }
        $counter++;
    }

    $results = multi_thread_curl($urls, $curl_options, $nThreads);

    foreach ($results as $result) {
        $new_res = json_decode($result, true);
        if ($new_res['result']['message_id'] == '' || $new_res['result']['message_id'] == false) {
            $fail++;
        } else {
            $success++;
        }
    }

    $text = urlencode("Рассылка окончена!\n\n<b>Отправлено: </b>$success\n<b>Ошибка: </b>$fail");

    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id={$chatid}&text=$text&parse_mode=HTML";
    $urls = array($url);
    $results = multi_thread_curl($urls, $curl_options, $nThreads);

//    $msg->replyHTML("Рассылка окончена!\n\n<b>Отправлено: </b>$success\n<b>Ошибка: </b>$fail");

    exit();
}
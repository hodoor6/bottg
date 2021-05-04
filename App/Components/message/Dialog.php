<?php

if ($cmd[0] == 'chat' && $user_info['companion'] != 0) {
    $text = $message;
    if (empty($message)) {
        $text = $caption;
    }

    //проверяем правильность раскладки юзера
    /*$text_checker = new \LangCorrect\LangCorrect();
    $text_new = $text_checker->parse($text, 1|2);

    if ($text != $text_new) {
        $dialog_btn = $bt->inlineButtons([
            [
                $json['inline']['раскладка'] => 'different_layout'
            ]
        ]);
    }*/

    $text = $formatter::formatHTMLText($entities, $text);

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
    } else if (!empty($sticker_id) ) {
        $attach = 'sticker::' . $sticker_id;
    }

    $attach = explode('::', $attach);
    $user['user_id'] = $user_info['companion'];

    if ($attach[0] == 'image') {
        $content = array('chat_id' => $user_info['companion'], 'photo' => $attach[1], 'caption' => $text,
            'reply_markup' => $dialog_btn, 'parse_mode' => 'HTML');
        $tg->sendPhoto($content);
    } else if ($attach[0] == 'video') {
        $content = array('chat_id' => $user_info['companion'], 'video' => $attach[1], 'caption' => $text,
            'reply_markup' => $dialog_btn, 'parse_mode' => 'HTML');
        $tg->sendVideo($content);
    } else if ($attach[0] == 'animation') {
        $content = array('chat_id' => $user_info['companion'], 'animation' => $attach[1], 'caption' => $text,
            'reply_markup' => $dialog_btn, 'parse_mode' => 'HTML');
        $tg->sendAnimation($content);
    } else if ($attach[0] == 'video_note') {
        $content = array('chat_id' => $user_info['companion'], 'video_note' => $attach[1], 'reply_markup' => $dialog_btn);
        $tg->sendVideoNote($content);
    } else if ($attach[0] == 'audio') {
        $content = array('chat_id' => $user_info['companion'], 'audio' => $attach[1], 'caption' => $text,
            'reply_markup' => $dialog_btn, 'parse_mode' => 'HTML');
        $tg->sendAudio($content);
    } else if ($attach[0] == 'voice') {
        $content = array('chat_id' => $user_info['companion'], 'voice' => $attach[1], 'reply_markup' => $dialog_btn);
        $tg->sendVoice($content);
    } else if ($attach[0] == 'document') {
        $content = array('chat_id' => $user_info['companion'], 'document' => $attach[1], 'caption' => $text,
            'reply_markup' => $dialog_btn, 'parse_mode' => 'HTML');
        $tg->sendDocument($content);
    } else if ($attach[0] == 'sticker') {
        $content = array('chat_id' => $user_info['companion'], 'sticker' => $attach[1], 'reply_markup' => $dialog_btn,
            'parse_mode' => 'HTML');
        $tg->sendSticker($content);
    } else {
        $msg->sendHTML($user_info['companion'], $text, $dialog_btn);
    }

    exit();
}

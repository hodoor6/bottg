<?php

$gender_btn = $bt->inlineButtons([
    [
        $json['inline']['парень'] => 'set_gender/boy'
    ],
    [
        $json['inline']['девушка'] => 'set_gender/girl'
    ]
]);

$btn_menu = $bt->keyButtons([
    [
        $json['buttons']['случайный'] => ''
    ],
    [
        $json['buttons']['найти парня'] => '',
        $json['buttons']['найти девушку'] => ''
    ],
    [
        $json['buttons']['статистика'] => '',
        $json['buttons']['анкета'] => ''
    ],
    [
        $json['buttons']['правила'] => ''
    ]
]);

$search_dialog_btn = $bt->keyButtons([
    [
        $json['buttons']['завершить'] => ''
    ]
]);

$btn_invite = $bt->inlineButtons([
    [
        $json['inline']['пригласить'] => 'https://t.me/share/url?url=https://t.me/RuGenChatBot?start=' . $chatid . '&text=Зацени'
    ]
]);

$dialog_btn = $bt->keyButtons([
    [
        $json['buttons']['деанон'] => ''
    ],
    [
        $json['buttons']['завершить'] => ''
    ]
]);

$what_btn = $bt->inlineButtons([
    [
        $json['inline']['почему'] => 'profile_photo_what'
    ]
]);

$keyb_cancel = $bt->keyButtons([
    [
        $json['buttons']['отмена'] => ''
    ]
]);
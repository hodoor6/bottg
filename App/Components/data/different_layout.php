<?php

if ($data[0] == 'different_layout') {
    $message = $object['callback_query']['message']['text'];
    //проверяем правильность раскладки юзера
    $text_checker = new \LangCorrect\LangCorrect();
    $message = $text_checker->parse($message, 1|2);
    $msg->Rupdate($message);
    exit();
}

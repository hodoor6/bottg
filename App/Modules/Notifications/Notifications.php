<?php

class Notifications
{
    private $tg;
    private $callback_query_id;

    public function __construct(Telegram $tg)
    {
        $this->tg = $tg;
        $this->callback_query_id = $tg->Callback_ID();
    }

    public function send($text, $alert = false)
    {
        $tg = $this->tg;
        $cqi = $this->callback_query_id;
        $content = array('callback_query_id' => $cqi, 'text' => $text, 'cache' => '5', 'show_alert' => $alert );
        $tg->answerCallbackQuery($content);
    }
}
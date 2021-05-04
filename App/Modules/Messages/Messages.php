<?php

class Messages
{
    private $tg;

    public function __construct(Telegram $tg)
    {
        $this->tg = $tg;
    }

    public function send($chat_id, $message, $keyboard = '')
    {
        $tg = $this->tg;
        if (isset($message)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard);
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message);
        }
        $tg->sendMessage($content);
    }

    public function sendHTML($chat_id, $message, $keyboard = '')
    {
        $tg = $this->tg;
        if (isset($keyboard)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard,
                'parse_mode' => 'HTML');
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'parse_mode' => 'HTML');
        }
        return $tg->sendMessage($content)['result']['message_id'];
    }

    public function reply($message, $keyboard = '')
    {
        $tg = $this->tg;
        $chat_id = $tg->ChatID();
        if (isset($message)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard);
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message);
        }
        $tg->sendMessage($content);
    }

    public function replyHTML($message, $keyboard = '')
    {
        $tg = $this->tg;
        $chat_id = $tg->ChatID();
        if (isset($keyboard)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard,
                'parse_mode' => 'HTML');
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'parse_mode' => 'HTML');
        }
        return $tg->sendMessage($content)['result']['message_id'];
    }

    public function Rupdate($message, $keyboard = '')
    {
        $tg = $this->tg;
        $chat_id = $tg->ChatID();
        $message_id = $tg->MessageID();
        if (isset($message)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard,
                'parse_mode' => 'HTML', 'message_id' => $message_id, 'disable_web_page_preview' => true);
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'parse_mode', 'message_id' => $message_id);
        }
        $tg->editMessageText($content);
    }

    public function update($message_id, $message, $keyboard = '')
    {
        $tg = $this->tg;
        $chat_id = $tg->ChatID();
        if (isset($keyboard)) {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $keyboard,
                'parse_mode' => 'HTML', 'message_id' => $message_id, 'disable_web_page_preview' => true);
        } else {
            $content = array('chat_id' => $chat_id, 'text' => $message, 'parse_mode', 'message_id' => $message_id,
                'parse_mode' => 'HTML');
        }
        return $tg->editMessageText($content)['result']['message_id'];
    }


    public function delete($chat_id = '', $message_id = '')
    {
        $tg = $this->tg;
        if (empty($chat_id)) {
            $chat_id = $tg->ChatID();
        }
        if (empty($message_id)) {
            $message_id = $tg->MessageID();
        }
        $content = array('chat_id' => $chat_id, 'message_id' => $message_id);
        $tg->deleteMessage($content);
    }

}
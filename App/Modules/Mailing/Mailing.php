<?php

class Mailing
{
    private $tg;
    private $counter = 0;

    public function __construct(Telegram $tg)
    {
        $this->tg = $tg;
    }

    public function listMailing($users, $text)
    {
        $tg = $this->tg;
        if (!is_array($users)) {
            return false;
        }
        foreach ($users as $user) {
            static $counter = 0;
            $content = array('chat_id' => $user['user_id'], 'text' => $text, 'parse_mode' => 'HTML');
            if ($counter >= 20) {
                sleep(1);
                $counter = 0;
            }
            $tg->sendMessage($content);
            $counter++;
        }
        return true;
    }

    public function nowMailing($user, $text)
    {
        $tg = $this->tg;
        $counter = $this->counter;
        $content = array('chat_id' => $user, 'text' => $text);
        if ($counter >= 20) {
            sleep(1);
            $this->counter = 0;
        }
        $id = $tg->sendMessage($content);
        $this->counter++;
        $id = (isset($id))?$id:false;
        return $id;
    }

}
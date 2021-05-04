<?php

class Webhook
{

    private $tg;
    public $path = (__DIR__ . '/../../../cache');

    public function __construct(Telegram $tg)
    {
        $path = $this->path;
        if (!is_dir($path)) {
            mkdir($path);
        }
        $this->tg = $tg;
    }

    public function setWebhook($url)
    {
        $tg = $this->tg;
        $path = $this->path;
        $cache = file_get_contents($path . '/webhook.frm');
        if ($cache == '1') {
            return true;
        } else {
            $tg->setWebhook($url);
            file_put_contents($path . '/webhook.frm', '1');
            return true;
        }
    }

    public function setWebhookDynamic($line, $url)
    {
        $tg = $this->tg;
        $path = $this->path;
        $line--;
        $bot = file(__DIR__ . '/../../../bot.php');
        unset($bot[$line]);
        file_put_contents(__DIR__ . '/../../../bot.php', '');
        foreach ($bot as $line) {
            file_put_contents(__DIR__ . '/../../../bot.php', $line, FILE_APPEND);
        }
        $tg->setWebhook($url);
        file_put_contents($path . '/webhook.frm', '1');
        return true;
    }

}
<?php

class Buttons
{
    private $tg;

    public function __construct(Telegram $tg)
    {
        $this->tg = $tg;
    }

    public function inlineButtons(array $buttons)
    {
        $tg = $this->tg;
        $btns = array();
        foreach ($buttons as $button) {
            static $row = 0;
            foreach ($button as $name => $val) {
                if (stripos($val, 'http') !== false || stripos($val, 'https') !== false) {
                    $btns[$row][] = $tg->buildInlineKeyboardButton($name, $val);
                } else {
                    $btns[$row][] = $tg->buildInlineKeyboardButton($name, '', $val);
                }
            }
            $row++;
        }
        $keyb = $tg->buildInlineKeyBoard($btns);
        $row = 0;
        return $keyb;
    }

    public function keyButtons(array $buttons)
    {
        $tg = $this->tg;
        $btns = array();
        foreach ($buttons as $button) {
            static $row = 0;
            foreach ($button as $name => $val) {
                $btns[$row][] = $tg->buildKeyboardButton($name);
            }
            $row++;
        }
        $keyb = $tg->buildKeyBoard($btns, false, true);
        $row = 0;
        return $keyb;
    }

}
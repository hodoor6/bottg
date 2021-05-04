<?php

class Lang
{
    private $lang;

    public function __construct($lang)
    {
        if ($lang == '') $lang = 'ru';
        $this->lang = $lang;
    }

    public function getLang()
    {
        $lang = $this->lang;
        $json = file_get_contents(CONTENT . '/' . $lang . '.json');
        $json = json_decode($json, true);
        return $json;
    }

    public function getResponse($file, array $replace = [])
    {
        $lang = $this->lang;
        $response = file_get_contents(CONTENT . '/messages/' . $lang . '/' . $file);
        if ($replace != []) {
            $response = $this->replace($response, $replace);
        }
        return $response;
    }

    private function replace($text, array $replace)
    {
        foreach ($replace as $k=>$v) {
            $text = str_replace("{" . $k . "}", $v, $text);
        }
        return $text;
    }
}
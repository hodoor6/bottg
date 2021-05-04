<?php

require_once __DIR__ . '/LogicFormatter.php';

class Formatter extends LogicFormatter
{

    public function __construct()
    {
    }

    static function formatHTMLText($entities, $message, $offset_msg = 0)
    {
        $counter = 0;
        $counter -= $offset_msg;
        $max_count = count($entities);
        for ($i = 0; $i < $max_count; $i++) {
            $value = $entities[$i];
            static $cnt = 0;
            // ITALIC
            if ($value['type'] == 'italic') {
                $offset = $value['offset'] + $counter;
                $length = $value['length'];
                $p2 = '<i>'; //символ
                $p3 = '</i>'; //символ
                $message = self::mb_substr($message,0, $offset).$p2.self::mb_substr($message,$offset,$length).$p3.self::mb_substr($message,($offset + $length));

                $entities = self::updateEntityOffset($entities, $value['offset'], $i);

                $counter += 7;
            }
            // BOLD
            if ($value['type'] == 'bold') {
                $offset = $value['offset'] + $counter;
                $length = $value['length'];
                $p2 = '<b>'; //символ
                $p3 = '</b>'; //символ
                $message = self::mb_substr($message,0,$offset).$p2.self::mb_substr($message,$offset,$length).$p3.self::mb_substr($message,($offset + $length));

                $entities = self::updateEntityOffset($entities, $value['offset'], $i);

                $counter += 7;
            }
            // UNDERLINE
            if ($value['type'] == 'underline') {
                $offset = $value['offset'] + $counter;
                $length = $value['length'];
                $p2 = '<u>'; //символ
                $p3 = '</u>'; //символ
                $message = self::mb_substr($message,0,$offset).$p2.self::mb_substr($message,$offset,$length).$p3.self::mb_substr($message,($offset + $length));

                $entities = self::updateEntityOffset($entities, $value['offset'], $i);

                $counter += 7;
            }
            // STRIKETHROUGH
            if ($value['type'] == 'strikethrough') {
                $offset = $value['offset'] + $counter;
                $length = $value['length'];
                $p2 = '<s>'; //символ
                $p3 = '</s>'; //символ
                $message = self::mb_substr($message,0,$offset).$p2.self::mb_substr($message,$offset,$length).$p3.self::mb_substr($message,($offset + $length));

                $entities = self::updateEntityOffset($entities, $value['offset'], $i);

                $counter += 7;
            }
            // CODE
            if ($value['type'] == 'code') {
                $offset = $value['offset'] + $counter;
                $length = $value['length'];
                $p2 = '<code>'; //символ
                $p3 = '</code>'; //символ
                $message = self::mb_substr($message,0,$offset).$p2.self::mb_substr($message,$offset,$length).$p3.self::mb_substr($message,($offset + $length));

                $entities = self::updateEntityOffset($entities, $value['offset'], $i);

                $counter += 13;
            }
            // URL LINK
            if ($value['type'] == 'text_link') {
                $offset = $value['offset'];
                $length = $value['length'];
                $url = $value['url'];
                $offset = $offset + $counter;
                $p2 = '<a href="'; //символ
                $p3 = '">'; //символ
                $p4 = '</a>'; //символ
                $del = self::mb_substr($message, $offset, $length);
                $link = $p2 . $url . $p3 . $del . $p4;
                $message = self::mb_substr($message, 0, $offset).$link.self::mb_substr($message, ($offset + $length));

                $link_c = mb_strlen($link,'UTF-8');
                $del_c = mb_strlen($del,'UTF-8');

                $sum = $link_c - $del_c;

                //$counter2 = $counter2 + $length;
                $counter = $counter + $sum;
            }
            $cnt++;
        }
        return $message;
    }


}
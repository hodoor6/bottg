<?php

require_once __DIR__ . '/Formatter.php';

class LogicFormatter
{
    public function __construct()
    {
    }

    protected static function mb_strlen($text)
    {
        $length = 0;
        $textlength = strlen($text);
        for ($x = 0; $x < $textlength; $x++) {
            $char = ord($text[$x]);
            if (($char & 0xC0) != 0x80) {
                $length += 1 + ($char >= 0xf0);
            }
        }

        return $length;
    }

    protected static function mb_substr($text, $offset, $length = null)
    {
        $mb_text_length = self::mb_strlen($text);
        if ($offset < 0) {
            $offset = $mb_text_length + $offset;
        }
        if ($length < 0) {
            $length = ($mb_text_length - $offset) + $length;
        } elseif ($length === null) {
            $length = $mb_text_length - $offset;
        }
        $new_text = '';
        $current_offset = 0;
        $current_length = 0;
        $text_length = strlen($text);
        for ($x = 0; $x < $text_length; $x++) {
            $char = ord($text[$x]);
            if (($char & 0xC0) != 0x80) {
                $current_offset += 1 + ($char >= 0xf0);
                if ($current_offset > $offset) {
                    $current_length += 1 + ($char >= 0xf0);
                }
            }
            if ($current_offset > $offset) {
                if ($current_length <= $length) {
                    $new_text .= $text[$x];
                }
            }
        }

        return $new_text;
    }

    protected static function updateEntityOffset($entities, $offset, $i)
    {
        for ($jj = 0; $jj < count($entities); $jj++) {
            $val = $entities[$jj];
            if ($jj <= $i) continue;
            if ($offset == $val['offset'] ) {
                $type = $val['type'];
                if ($type == 'italic' || $type == 'bold' || $type == 'underline' || $type == 'strikethrough') {
                    $entities[$jj]['offset'] -= 4;
                } else if ($type == 'code') {
                    $entities[$jj]['offset'] -= 7;
                }
            }
        }
        return $entities;
    }
}
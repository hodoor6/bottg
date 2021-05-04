<?php

class Query
{

    private $tg;

    public function __construct(Telegram $tg)
    {
        $this->tg = $tg;
    }

    public function sendText($query_id, $title, $text, $keyboard = '', $description = '', $thumb = '', $w = 150, $h = 150)
    {
        $tg = $this->tg;

        $results = array(
            array(
                'type' => 'article',
                'title' =>  $title,
                'id' => rand(1, 9999999),
                'description' => $description,
                'input_message_content' => array(
                    'message_text' => $text,
                    'parse_mode' => 'HTML'
                )
            )
        );

        if (!empty($keyboard)) {
            $results[0]['reply_markup'] = $keyboard;
        }

        //image
//        if (!empty($thumb)) {
//            $results[0]['thumb_url'] = $thumb;
//            $results[0]['thumb_width'] = $w;
//            $results[0]['thumb_height'] = $h;
//        }

        $results = json_encode($results);
        $content = array('inline_query_id' => $query_id, 'results' => $results, 'cache_time' => 0, 'is_personal' => true);
        return $tg->answerInlineQuery($content);
    }

    public function sendImage($query_id, $photo, $caption = '', $keyboard = '')
    {
        $tg = $this->tg;

        $results = array(
            array(
                'type' => 'photo',
                'id' => rand(1, 9999999),
                'parse_mode' => 'HTML',
                'photo_url' => $photo,
                'thumb_url' => $photo,
                'caption' => $caption

            )
        );

        if (!empty($keyboard)) {
            $results[0]['reply_markup'] = $keyboard;
        }

        $results = json_encode($results);
        $content = array('inline_query_id' => $query_id, 'results' => $results);
        return $tg->answerInlineQuery($content);
    }

}
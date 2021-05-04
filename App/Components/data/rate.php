<?php

if ($data[0] == 'rate') {
    $rate = $db->getRating($data[1]);
    if ($rate == 0) {
        $db->setRating($data[1], $data[2]);
    } else {
        $rate = ($rate + $data[2]) / 2;
        $db->setRating($data[1], $rate);
    }
    clearCache($mem, $data[1]);
    $msg->Rupdate($json['text']['спасибо за оценку']);
    exit();
}

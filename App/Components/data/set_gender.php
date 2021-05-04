<?php

if ($data[0] == 'set_gender' && $cmd[0] == 'set_gender') {
    if ($data[1] == 'boy') {
        $gender = 1;
    } else {
        $gender = 2;
    }
    $db->setCmd($chatid, 'set_age');
    $db->setGender($chatid, $gender);
    clearCache($mem, $chatid);

    $msg->Rupdate($json['text']['шаг2']);
    exit();
}

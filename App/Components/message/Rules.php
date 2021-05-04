<?php

if ($message == $json['buttons']['правила'] && empty($cmd[0])) {
    $msg->replyHTML($local->getResponse('rules.txt'));
    exit();
}

<?php

namespace App\Security;


class Security
{
    private $date_msg;
    private $user_id;

    public function __construct(\Telegram $tg)
    {
        $tg_date = $tg->Date();
        if (empty($tg_date)) {
            $object = $tg->getData();
            $tg_date = $object['callback_query']['message']['date'];
        }
        $this->date_msg = $tg_date;
        $this->user_id = $tg->UserID();
    }

    // true = okey || false = flood
    public function FloodControlMemCached()
    {
        $date_msg = $this->date_msg;
        $user_id = $this->user_id;

        if (empty($user_id) || empty($date_msg)) {
            return true;
        }

        $mem = memcache_connect(MEM_HOST, MEM_PORT);
        $mem_date = memcache_get($mem, $user_id);
        $mem_date2 = memcache_get($mem, $user_id . '2');
        $block_users = memcache_get($mem, 'block_users');

        $block_users_arr = explode('|', $block_users);
        if (in_array($user_id, $block_users_arr)) {
            return false;
        }

        if ($mem_date == $date_msg && $mem_date2 == $date_msg) {
            $block_users .= "|$user_id";
            memcache_set($mem, 'block_users', $block_users, MEMCACHE_COMPRESSED, 5); //на сколько банить спамера
            return false;
        }

        if (empty($mem_date2) && !empty($mem_date)) {
            memcache_set($mem, $user_id . '2', $date_msg, MEMCACHE_COMPRESSED, 1);
        }

        if (empty($mem_date)) {
            memcache_set($mem, $user_id, $date_msg, MEMCACHE_COMPRESSED, 2);
        }

        return true;
    }

}
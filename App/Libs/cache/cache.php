<?php

function clearCache($mem, $chatid)
{
    memcache_set($mem, 'user_info_' . $chatid, NULL, false, 30);
}

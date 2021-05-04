<?php

require_once __DIR__ . '/MySQLi/MysqliDb.php';
require_once __DIR__ . '/TelegramAPI/Telegram.php';
require_once __DIR__ . '/TelegramAPI/TelegramErrorLogger.php';
require_once __DIR__ . '/config.php';
//Include Libs
require_once __DIR__ . '/App/Libs/Functions/functions.php';
require_once __DIR__ . '/App/Libs/cache/cache.php';
require_once __DIR__ . '/App/Libs/FaceDetector/FaceDetector.php';
require_once __DIR__ . '/App/Libs/MultiThreadCurl/MultiCurlThread.php';

require_once __DIR__ . '/App/Libs/TextLangCorrect/Util/ReflectionTypeHint.php';
require_once __DIR__ . '/App/Libs/TextLangCorrect/LangCorrect.php';
require_once __DIR__ . '/App/Libs/TextLangCorrect/Util/UTF8.php';

//init MemCache
$mem = memcache_connect(MEM_HOST, MEM_PORT);


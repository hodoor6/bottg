<?php

$token = ''; //токен полученный в бот фазер
$url = '/bot/bot.php'; // путь к файлу bot.php
$dom_assets = '/bot/assets/'; // путь к папке assets
$dom_cache = '/bot/cache/'; // путь к папке cache

const ADMIN_ID = '1384735398';

//id фото в телеграм боте
const DEFAULT_PHOTO_PROFILE = 'AgACAgIAAxkBAAMwYAII7a0nyyTl-Yd4lHMtPvOoOoYAAk6wMRsNhxBIfKqXQIkQfvBQ3RCeLgADAQADAgADeAAD4YgAAh4E';

//id фото в телеграм боте которое опказывает отправку геолокации
const PHOTO_GEO = 'AgACAgIAAxkBAAMzYAIJCvXZuM_4itf6AAFm95E17cyNAAJ0sDEbDYcQSA4_AAHFhjkWa1RVYJouAAMBAAMCAAN4AAMkdgMAAR4E';

//MySQL
const DB_HOST = ''; //хост БД
const DB_LOGIN = ''; //логин
const DB_PSWD = ''; //пароль
const DB_NAME = ''; // имя таблицы

const CONTENT = __DIR__ . '/assets/'; //это не трогать

//насройки MemCached
const MEM_HOST = 'unix:///memcache/socket';
const MEM_PORT = 0;
<?php
/**
 * В данном файле хранятся настройки окружения, данные для соединения с базой данных и "глобальные" переменные.
 * ЗАПРЕЩЕНО добавлять функции, логику и переменные, которые относятся только к текущему проекту.
 */

// Вывод ошибок
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///                                               БАЗА ДАННЫХ
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Соединение с базой данных
// (хост, пользователь СУБД, пароль пользователя СУБД, имя базы данных)
$_DB_HOST_ = 'localhost';
$_DB_USER_ = 'root';
$_DB_PASS_ = '';
$_DB_NAME_ = 'mht.test';


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///                                                  СЕССИЯ
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
ini_set('session.gc_maxlifetime', 10800);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_start();


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///                                                IP КЛИЕНТА
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$client = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote = @$_SERVER['REMOTE_ADDR'];

if (filter_var($client, FILTER_VALIDATE_IP)) {
    $_IP_ = $client;
} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $_IP_ = $forward;
} else {
    $_IP_ = $remote;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///                                       ВСПОМОГАТЕЛЬНЫЕ ПЕРЕМЕННЫЕ
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Текущее время
$_TMR_ = time();

// Максимальное значение Cargo
$_CARGO_MAX_ = 52000;

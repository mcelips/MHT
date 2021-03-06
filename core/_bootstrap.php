<?php
/**
 * Основной файл программы, который вызывается во всех остальных файлах.
 *
 * Подключаем файл с конфигурационными данными.
 * Устанавливаем соединение с базой данных.
 * Подключаем все необходимые файлы (вывод ошибок, вспомогательные функции...)
 *
 * Разрешено подключать файлы проекта, которые содержат дополнительную логику и/или расширение функционала для проекта.
 */

// Подключаем конфигурационный файл
include '_config.php';

// Проверяем хеш в сессии.
// Используется для проверки авторизации пользователя.
$_SES_ = $_SESSION['ses'] ?? "";

// Устанавливаем соединение с базой данных
$connection = mysqli_connect($_DB_HOST, $_DB_USER_, $_DB_PASS_, $_DB_NAME_) or die("Error connect BD");
mysqli_query($connection, "set names utf8");

// Подключаем вывод ошибок
include '_errors.php';

// Подключаем вспомогательные функции
include '_helpers.php';

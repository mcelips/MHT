<?php

// Подключаем конфигурационный файл
include '_config.php';

// Проверяем сессию, чтобы... (зачем???)
$_SES_ = $_SESSION['ses'] ?? "";

// Если сессия не найдена, выкидываем ошибку
if (true === empty($_SES_)) { getError(0); }

// Устанавливаем соединение с базой данных
$connection = mysqli_connect($_DB_HOST, $_DB_USER_, $_DB_PASS_, $_DB_NAME_) or die("Error connect BD");
mysqli_query($connection, "set names utf8");

// Подключаем вывод ошибок
include '_errors.php';

// Подключаем вспомогательные функции
include "_helpers.php";

<?php
/**
 * В данном файле находится функция вывода ошибок по коду.
 * После получения ошибки вызывается die() с выводом сообщения в JSON.
 * 
 * Так как массив со списком ошибок только один, то он также присутствует в данном файле. 
 */

$errors = [
    0  => "Your session has expired or has been changed. Re-enter the game.",
    1  => "Ship don't find.",
    2  => "There is not enough space on the ship. Free the cargo on the ship.",
    3  => "There is not enough space on the base. Free the cargo on the base.",
    4  => "There is not enough space on the plot. Free the cargo on the plot.",
    5  => "Wrong login-password.",
    6  => "Done. You can log in.",
    7  => "This login already exists.",
    8  => "This e-mail already exists.",
    9  => "Base don't find.",
    10 => "You do not have rights for this sector.",
    11 => "You are not a sector owner.",
    12 => "Plot don't find.",
    13 => "You do not have unloading rights in this sector",
    14 => "You do not have rights in this sector",
    15 => "Please wait 5 seconds",
    16 => "There are no objects nearby to scan",
    17 => "Plot don't find.",
    18 => "Such a building has already been built",
    19 => "Building don't find.",
    20 => "Not enough resources",
    21 => "It costs 1,200 SG to rent a planet. You don't have enough funds.",
    22 => "You cannot rent more than 1 plot from the owner of D.I.O. and I.O.",
    23 => "You need to build a Mini Miner",
    24 => "Resources are exhausted",
    25 => "You need to build a Power plant",
    26 => "You don't have so many resources"

];

/**
 * Выводим ошибку в формате JSON и завершаем выполнение скрипта.
 * Также дополнительно закрываем все соединения с базой данных.
 *
 * @param int $code Код ошибки.
 */
function getError(int $code)
{
    // Получаем массив ошибок
    global $errors;
    global $connection;

    // Закрываем соединение с базой данных
    @mysqli_close($connection);

    // Проверяем наличие необходимой ошибки в массиве. Если не найдено, выводим "Server error."
    $error = $errors[$code] ?? "Server error.";

    // Выводим сообщение и прекращаем выполнение скрипта
    die('{"error":{"message":"' . $error . '","title":"Warning!"}}');
}

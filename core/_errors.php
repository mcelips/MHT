<?php
/**
 * В данном файле находится функция вывода ошибок по коду.
 * После получения ошибки вызывается die() с выводом сообщения в JSON.
 *
 * Так как массив со списком ошибок только один, то он также присутствует в данном файле.
 */

$errors = [
    0  => "Your session has been expired or changed. Re-enter the game.",
    1  => "The Ship wasn't found.",
    2  => "There isn't enough space in the Ship. You need to unload the cargo from the Ship.",
    3  => "There isn't enough space on the Base. You need to unload the cargo from the Base.",
    4  => "There isn't enough space on the Plot. You need to unload the cargo from the Plot.",
    5  => "Wrong login or password.",
    6  => "Done. You can log in now.",
    7  => "This login already exists.",
    8  => "This e-mail already exists.",
    9  => "Base wasn't found.",
    10 => "You don't have rights for this sector.",
    11 => "You aren't a sector owner.", // (?) You aren't the owner of this sector.
    12 => "Plot wasn't found.",
    13 => "You don't have unloading rights in this sector.", // (?) You don't have permission to unload in this sector.
    14 => "You don't have rights in this sector.",
    15 => "Please wait 5 seconds.",
    16 => "There are no objects nearby to scan.", // (?) There are no objects to scan nearby.
    17 => "The Plot wasn't found.",
    18 => "Such a Building has already been built.", // (?) This Building has already been built.
    19 => "The Building wasn't found",
    20 => "Not enough resources.",
    21 => "It costs 1,200 SG to rent a planet. You don't have enough funds.",
    22 => "You can't rent more than 1 plot from the owner of D.I.O. and I.O.",
    23 => "You need to build a Mini Miner.",
    24 => "The resources have been exhausted.",
    25 => "You need to build a Power plant.",
    26 => "You don't have so many resources." // (?) You don't have enough resources.

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

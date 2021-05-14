<?php
/**
 * Вспомогательные функции.
 * В данном файле собраны те функции, которые необходимы в каждом проекте и являются обязательным минимумом.
 */

/**
 * Генератор хеша сессии
 *
 * @return string
 */
function generate_ses(): string
{
    $arr = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v',
            'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    $pass = "";
    for ($i = 0; $i < 20; $i++) {
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}

/**
 * Округляем значения типа float до двух знаков после запятой.
 *
 * @param array $array Массив с данными типа float.
 *
 * @return array
 */
function check_floats(array $array): array
{
    $array_res = [];
    foreach ($array as $k => $v) {
        if ($v != 0) {
            $array_res[$k] = round($v, 2);
        }
    }
    return $array_res;
}
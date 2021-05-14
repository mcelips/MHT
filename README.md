# Заметки по коду

* Составить правила написания кода (для PHP и др.) для того, чтобы стиль у всех программистов был одинаковый, что
  упростит чтение и понимание кода, а также поиск возможных ошибок.

### Комментарии

* В начале каждого файла добавлять комментарий, в котором указывать:
    * краткое описание, что делает данный скрипт;
    * если возвращаются данные, то указать какие именно и в каком формате.
* Внутри скрипта комментировать более подробно о том, что именно выполняется в коде.

### Именование переменных и не только

#### Переменные

* Понятное именование переменных. Например, при получении данных из таблицы `users` переменную с результатом
  называть `$result_users` или `$users`.
* Если нет возможно назвать переменную так, чтобы легко было понять что она несет в себе, необходимо добавлять
  комментарий с объяснением для чего эта переменная введена и что она в себе хранит.
* Переменные, которые объявляются один раз в конфигурационном файле и далее вызываются в остальных скриптах, предлагаю
  именовать, например, `$_SES_` (вместо `$ses`) или `$_TMR_` (вместо `$tmr`). Анализируя код, натолкнулся на
  формулу `$newT = $tmr - $tmr2;`. Переменная `$tmr2` объявлялась выше и бралась из базы
  данных `$tmr2 = $row_sector['tmr'];`, а вот `$tmr` я долго искал в коде файла, но так и не нашел. Только поиском
  удалось найти в конфигурационном файле и вспомнить какую функцию она выполняет. Новый программист может тратить очень
  много времени на то, чтобы понять, откуда берутся "неизвестные" переменные.
* Как исключение, подключение к базе данных можно оставить как `$connection`, не переименовывая в `$_CONNECTION_`.

#### Файлы

* К имени файлов, которые относятся к базовому функционалу, добавлять в начало нижнее подчеркивание. Это позволит легко
  находить "базовые файлы" для отладки, расширения функционала и переноса в другой проект. Примеры именования
  файлов: `_config.php`, `_errors.php` и т.д. Также можно добавить подчеркивание в конце файла: `_config_.php`, однако
  это, на мой взгляд, является излишним.
* В начало имени файлов самого проекта запрещается добавлять какие-либо символы. Имя файла всегда должно начинаться с
  буквы в нижнем регистре.
* Запрещается использовать в имени файлов стиль CamelCase или смешивать стили. Слова необходимо разделять нижним
  подчеркиванием. Например, `getAllShips.php` или `get_allShips` - неверно, `get_all_ships.php` - верно.

### Рекомендации по написанию условий

* Если в условиях после `else` вызывается ошибка `getError($num)`, то стоит изначально проверять на ошибки, а потом
  писать основной функционал. Пример условия: `if (/*...условие...*/) { /*...код...*/ } else { getError($num); }`. Более
  подробный пример приведен в разделе «Предложение по обработке ошибок для условий».

### Работа с базой данных

* Если не планируется переходить на другую СУБД, то <u>использовать PDO нет смысла</u>.
* В функцию `getError($num)` добавить закрытие соединения с базой данных `mysqli_close($connection);`. В конце всех
  файлов соединение с базой данных закрывается, НО в функции `getError($num)` вызывается `die()` и выполнение скрипта
  сразу прекращается, а так как функция `getError($num)` может быть вызвана в любом месте, то ранее открытые соединения
  с базой данных не закрываются.
* Для добавления данных в базу данных написать отдельную функцию `db_insert(string $table, array $data) {}`.
* Для обновления данных в базе данных написать отдельную функцию `db_update(string $table, array $data, $where) {}`.
* Для удаления данных из базы данных написать отдельную функцию `db_delete(string $table, $where) {}`.

### Массив ошибок

#### Плюсы:

* Легко масштабируется, достаточно добавить элемент в конец.
* Для получения сообщения достаточно передать код ошибки (ключ элемента).

#### Минусы

* При большом количестве элементов (20 и больше) сложно быстро определить код нужной ошибки. При увеличении количества
  ошибок будет сложнее определить код ошибки.
* Ошибки записаны в случайном порядке. То есть, системные ошибки, ошибки работы с данными и пользователями не
  сгруппированны, а записаны в разных местах.

#### Решение проблем

_Для решения проблемы быстрого определения кода ошибки можно явно добавить ключи массива:_

```php
// Текущий вариант
$errors = [
    "Your session has expired or has been changed. Re-enter the game.",
    "Ship don't find.",
    "There is not enough space on the ship. Free the cargo on the ship.",
    /* ... */
];

// Предлагаемый вариант:
$errors = [
    0 => "Your session has expired or has been changed. Re-enter the game.",
    1 => "Ship don't find.",
    2 => "There is not enough space on the ship. Free the cargo on the ship.",
    /* ... */
];
```

### Новые функции

* Можно не использовать конструктор запросов для формирования запроса в базу данных, но при этом упростить написание
  запросов в базу данных. Пример приведен в разделе 
  [«Предложение по оптимизации кода обработки запросов в базу данных»](#предложение-по-обработке-ошибок-для-условий).
* Получение данных из массива `$_POST` вынести в отдельную функцию. Пример функции в разделе 
  [«Функция получения данных из массива $_POST»](#функция-получения-данных-из-массива-_post).
* Проверку сессии на пустоту `if ($ses == "") { getError(0); }` можно вынести из основного файла в функцию проверки
  авторизации пользователя. Так как данная проверка нужна только в тех файлах, где проверяется авторизован пользователь
  или нет, то логичным шагом будет функционал проверки пользователя вынести в отдельную функцию, где также проверять
  существование сессии. Следующим шагом будет вызов функции проверки авторизации во всех требуемых файлах. Пример
  функции в разделе [«Проверка авторизации пользователя по сессии»](#проверка-авторизации-пользователя-по-сессии).

---

## Предложение по обработке ошибок для условий

Как было сказано ранее, предлагается выводить ошибку сразу, а не писать конструкцию:

```php
if(/*...условие...*/){ /* ...какой-то_код... */ }else{ getError(/*...номер_ошибки...*/); }
```

_Пример текущей реализации:_

```php
///запрос на клиента
$prov = "SELECT * FROM `users` WHERE `id` = '$id'";
$res = mysqli_query($connection,$prov);
$numberkk = mysqli_num_rows($res);

if($numberkk != "0"){ 
    while ($row = mysqli_fetch_array($res)) {/*...*/}    
    /* ...какой-то_код... */ }
else{ 
    getError(0); 
}
```

Можно и, на мой взгляд, нужно заменить на:

```php
///запрос на клиента
$prov = "SELECT * FROM `users` WHERE `id` = '$id'";
$res = mysqli_query($connection,$prov);
$numberkk = mysqli_num_rows($res);

// Если ничего не найдено, то мы сразу прерываем выполнение скрипта
if($numberkk == "0") { getError(0); } 

// Продолжаем выполнение скрипта, так как ошибок нет
while ($row = mysqli_fetch_array($res)) {/*...*/}  
/* ...какой-то_код... */
```

_Примечание: в некоторых случаях проверка ошибок реализована в таком варианте, как предлагаю. Однако такого кода мало._

---

## Предложение по оптимизации кода обработки запросов в базу данных

_Пример текущей реализации:_

```php
///запрос на клиента
$prov = "SELECT * FROM `users` WHERE `id` = '$id'";
$res = mysqli_query($connection, $prov);
$numberkk = mysqli_num_rows($res);

if ($numberkk != "0") {
    while ($row = mysqli_fetch_array($res)) {
        $id = $row['uid'];
    }
}
```

Весь код обработчика запроса можно вынести в отдельную функцию:

```php
// ***Название функции не очень информативно, можно придумать лучше
/**
 * Обработка SQL запроса
 * @param string $query Строка запроса.
 * @return false|array Ассоциативный массив
 */
function db_get(string $query)
{
    global $connection;

    // Проверяем, что пришла строка
    // ***можно выводить ошибку
    if (false === is_string($query)) { return false; }

    // Удаляем лишние пробелы на концах строки запроса
    $query = trim($query);

    // Проверка на пустой запрос
    // ***можно выводить ошибку
    if (true === empty($query)) { return false; }

    // Обрабатываем запрос
    $result = mysqli_query($connection, $query);

    // Ошибка при выполнении запроса.
    // ***Заметка: вместо возврата FALSE лучше выбросить ошибку.
    if (false === $result) { return false; }

    // Если найдено 0 строк
    // ***Заметка: вместо возврата FALSE лучше выбросить ошибку.
    if (0 == (int)mysqli_num_rows($result)) { return false; }

    // Возвращаем результат в виде ассоциативного массива
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
```

В итоге запрос у нас будет выглядеть так:

```php
///запрос на клиента
$query = "SELECT * FROM `users` WHERE `id` = '$id'";
$result = db_get($query);

if ($result) {
    foreach ($result as $row) {
        $id = $row['uid'];
    }
}

// ИЛИ более короткий вариант вариант
$query = "SELECT * FROM `users` WHERE id = '$id'";

if ($result = db_get($query)) {
    foreach ($result as $row) {
        $id = $row['uid'];
    }
}

```

---

# Функция получения данных из массива $_POST

```php
/**
 * Получаем данные из массива $_POST по ключу и возвращаем подготовленные для SQL запроса данные.
 * @param integer|string $key Ключ данных в массиве $_POST. 
 * @return false|string
 */
function from_post($key)
{
    global $connection;

    // Если пришел пустой ключ
    if (true === empty($key)) { return false; }

    // Если в массиве $_POST не существует такого ключа
    if (false === isset($_POST[$key])) { return false; }

    // Возвращаем подготовленные для SQL запроса данные
    return $connection->real_escape_string($_POST[$key]);
}
```

_Пример текущей реализации:_

```php
$sid = $connection->real_escape_string($_POST['sid']);
```

Пример с использованием функции `from_post($key)`:

```php
$sid = from_post('sid');
```

---

# Проверка авторизации пользователя по сессии

Так как проверка пользователя по хешу вызывается в нескольких файлах, то данный кусок кода можно вынести в отдельную
функцию.

_Пример текущей реализации:_

```php
///запрос на клиента
$prov = "SELECT * FROM `users` WHERE `session` = '$ses'";
$res = mysqli_query($connection,$prov);
$numberkk = mysqli_num_rows($res);

if($numberkk != "0"){ /* ...какой-то_код... */ }else{ getError(0); }
```

Можно обернуть в функцию, в которой производить проверку. Если пользователь найден, то возвращаем полученный массив
данных, в ином случае выкидываем ошибку getError(0):

```php
/**
* Получаем данные пользователя по хешу. Если сессия не найдена вызывается функция getError(0).
* @return array Данные найденного пользователя.
*/
function get_user_data($ses)
{
    global $connection;

    // Если сессия не найдена, выкидываем ошибку
    if (true === empty($ses)) { getError(0); }
    
    // Запрос данных пользователя
    $query = "SELECT * FROM `users` WHERE `session` = '$ses' LIMIT 1";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result);
    
    // Пользователь найден
    if ($num_rows != "0") { return $result; }

    // Сессия истекла
    getError(0);
}

// ИЛИ при внедрении функции db_get(/*query*/)

function get_user($ses)
{
    global $connection;
    global $_SES_;

    // Если сессия не найдена, выкидываем ошибку
    if (true === empty($_SES_)) { getError(0); }
    
    // Запрос данных пользователя
    $query = "SELECT * FROM `users` WHERE `session` = '$_SES_' LIMIT 1";
    $result = db_get($query);
    
    // Сессия истекла
    if (false === $result) { getError(0); }
    
    // Возвращаем полученные данные
    // Так как мы знаем, что будет только 1 пользователь, то возвращаем результат с ключом 0
    return $result[0];
}
```

<?php

require_once('simplevk-master/autoload.php'); // БЛИБЛИОТЕКИ
require './vendor/autoload.php';// БЛИБЛИОТЕКИ
require_once('vk_api.php'); 

error_reporting(E_ERROR | E_WARNING);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', './log/bot_error.log');

function log_error($message) {
    static $logged_messages = [];

    if (!in_array($message, $logged_messages)) {
        error_log($message);
        $logged_messages[] = $message;
    }
}

// Использование:
try {
    // Ваш код, который может генерировать ошибки
} catch (Exception $e) {
    log_error($e->getMessage());
}


// use Krugozor\Database\Mysql\Mysql as Mysql; // КЛАССЫ ДЛЯ РАБОТЫ С БД
use DigitalStar\vk_api\vk_api; // Основной класс
use DigitalStar\vk_api\Message; // Конструктор сообщений
use DigitalStar\vk_api\VkApiException; // Обработка ошибок

$vk_key = '..........'; // Длинный ключ сообщества, который мы получим чуть позже
$confirm = '........'; // СТРОКА которую должен вернуть сервер
$v = '5.103'; // Версия API, последняя на сегодняшнее число, оставлять таким если на новых работать в будущем не будет


$vk = vk_api::create($vk_key, $v)->setConfirm($confirm);
$my_msg = new Message($vk);
$data = json_decode(file_get_contents('php://input')); //Получает и декодирует JSON пришедший из ВК

$vk->sendOK();
//$vk->debug();

// ТУТ УЖЕ БУДЕМ ПИСАТЬ КОД //

// Переменные для удобной работы в будущем
$id = $data->object->message->from_id; // ИД того кто написал
$peer_id = $data->object->message->peer_id; // Только для бесед (ид беседы)

$time = time();
$cmd = explode(" ", mb_strtolower($data->object->message->text)); // Команды
$message = $data->object->message->text; // Сообщение полученное ботом
$new_ids = current($data->object->message->fwd_messages)->from_id ?? $data->object->message->reply_message->from_id; // ИД того чье сообщение переслали
$userinfo = $vk->userInfo($id);
$bonus = $vk->buttonText('⏰ Бонус!', 'green', ['command' => 'bonus']);
$clic = $vk->buttonText('🔱 Клик!', 'red', ['command' => 'clic']);
$help = $vk->buttonText('👤 Помощь!', 'blue', ['command' => 'help']);
$ras = $vk->buttonText( '✌ Рассылка!', 'blue', ['command' => 'ras']);
$sql = new sql();
// Закончили с переменными
$date = date('j-n-Y');


if ($id < 0){exit();} // ПРОВЕРЯЕМ что сообщение прислал юзер а не сообщество

if ($data->type == 'message_new') {
    if (isset($data->object->message->payload)) {  //получаем payload
        $payload = json_decode($data->object->message->payload, True); // Декодируем кнопки в массив
    } else {
        $payload = null; // Если пришел пустой массив кнопок, то присваеваем кнопке NULL
    }
    $payload = $payload['command'];

    $id_reg_check = $db->query('SELECT vk_id FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['vk_id']; // Пытаемся получить пользователя который написал сообщение боту
    if (!$id_reg_check and $id > 0) { // Если вдруг запрос вернул NULL (0) это FALSE, то используя знак ! перед переменной, все начинаем работать наоборот, FALSE становится TRUE
        // Так же мы проверяем что $id больше нуля, что бы не отвечать другим ботам, но лучше в самом верху добавить такую проверку что бы не делать лашних обращений к БД!
        $db->query("INSERT INTO users (vk_id, nick, status, time) VALUES (?i, '?s', ?i, ?i)", $id, "$userinfo[first_name] $userinfo[last_name]", 0, $time);
        $db->query("UPDATE users SET times = FROM_UNIXTIME(" . time() . ") WHERE vk_id = $id");

        $vk->sendButton($peer_id, "Приветствую  тебя, @id$id ($userinfo[first_name] $userinfo[last_name]),вы автоматичесекий соглашаетесь с договором \n https://vk.com/topic-184241709_49216517 \nТакже чтобы купить реальную валюту\n нужно обменять монеты в рубли: Аукцион.", [[$help, $bonus, $clic]]);
    }

// $vk->sendMessage($peer_id, "Разработка Vk ботов\n @cx_studio");



if ($message == 'стат') { 
    if($sql->Admin($db, $id) == false){
        return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
    }
    
    $result = $db->query("SELECT SUM(rub) as total_rub FROM users")->fetch_assoc()['total_rub'];

$result1 = $db->query("SELECT SUM(balance) as total_balance FROM users")->fetch_assoc()['total_balance'];

$result2 = $db->query("SELECT SUM(ferma_plata) as total_ferma_plata FROM users")->fetch_assoc()['total_ferma_plata'];

$result3 = $db->query("SELECT SUM(buss_plata) as total_buss_plata FROM users")->fetch_assoc()['total_buss_plata'];

$result4 = $db->query("SELECT SUM(ban) as total_ban FROM users")->fetch_assoc()['total_ban'];

$result5 = $db->query("SELECT SUM(vip) as total_vip FROM users")->fetch_assoc()['total_vip'];

$result6 = $db->query("SELECT SUM(admin) as total_admin FROM users")->fetch_assoc()['total_admin'];

    
$base = $db->query("SELECT COUNT(*) FROM users")->fetch_assoc()['COUNT(*)'];

$sitata = $db->query("SELECT COUNT(*) FROM sitata")->fetch_assoc()['COUNT(*)'];



    $vk->sendMessage($id, "Пользователей: $base \n Цитат: $sitata \n Вся сумма rub: $result \n Вся сумма в боте накопилось: $result1 монеток \n Общее сумма заработка от фермы: $result2 монеток \n Общий доход бизнеса: $result3 монет \n Забаненных: $result4 \n Виперов: $result5 \n Админов: $result6 "); 
}

if (mb_strtolower($message) == '!тест') {
    
    $message1 = '<b><font color="blue">' . $id . ' (Пользователь) нарушил тихий режим, он был наказан.</font></b>';
$vk->sendMessage($peer_id, $message1);

    
}

	if (mb_strtolower($message) == '!бот') {
    // Проверяем, является ли диалог беседой
    if ($peer_id > 2000000000) {
        if ($sql->Bot($db, $id)) {
            return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы.");
        }
        // Получаем список участников беседы
        $members = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id])['items'];

        $is_admin = false;
        foreach ($members as $member) {
            if ($member['member_id'] == $id && $member['is_admin']) {
                $is_admin = true;
                break;
            }
        }

        // Если пользователь является администратором, то выполняем нужные действия
        if ($is_admin) {
            $keyboard = [[]];
            	
		$start = microtime(true);
		$time1 = microtime(true) - $start;
        $vk->sendButton($peer_id, "&#9203; Мой ответ: задержки $time1 сек. \n &#9888; Беседа $peer_id \n  &#128204; Ваш id: $id \n $time" , [[$help, $bonus, $clic, $ras]] );
        } else {
            $vk->sendMessage($peer_id, "Вы не являетесь администратором");
        }
    } else if ($peer_id > 0) {
        if ($sql->Bot($db, $id)) {
            return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы.");
        }
        $keyboard = [[]];
            $vk->sendButton($peer_id, "&#9203; Мой ответ: задержки $time1 сек. \n &#9888; Беседа $peer_id \n  &#128204; Ваш id: $id \n $time" , [[$help, $bonus, $clic, $ras]]  );
    } else {
        $vk->sendMessage($peer_id, "Команда доступна только в беседах или переписках.");
    }
}



if (mb_strtolower($message) == 'кнопки') {
    // Проверяем, является ли диалог беседой
    if ($peer_id > 2000000000) {
        if ($sql->Bot($db, $id)) {
            return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы.");
        }
        // Получаем список участников беседы
        $members = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id])['items'];

        $is_admin = false;
        foreach ($members as $member) {
            if ($member['member_id'] == $id && $member['is_admin']) {
                $is_admin = true;
                break;
            }
        }

        // Если пользователь является администратором, то выполняем нужные действия
        if ($is_admin) {
            $keyboard = [[]];
            $vk->sendMessage($peer_id, "Кнопки скрыты, снова вызвать их, отправьте !бот $is_admin", $keyboard);
        } else {
            $vk->sendMessage($peer_id, "Вы не являетесь администратором");
        }
    } else if ($peer_id > 0) {
        if ($sql->Bot($db, $id)) {
            return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы.");
        }
        $keyboard = [[]];
        $vk->sendMessage($peer_id, "Кнопки скрыты, снова вызвать их, отправьте !бот", $keyboard);
    } else {
        $vk->sendMessage($peer_id, "Команда доступна только в беседах или переписках.");
    }
}




if(mb_strtolower($message) == 'магазин'){ 
     if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

     
     $nick = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['nick'];
    $vk->sendMessage($peer_id,"@id$id($nick), разделы магазина:\n\n &#128665;Транспорты:\n\n&#128663;Машина\n &#128741;Яхта\n\n&#127960;Недвижимость:\n\n&#127968; Дом\n\n&#128204;Остальное\n\n&#128012;Питомец\n&#128421;Компьютер\n &#11088;Ферма\n&#128188;Бизнес\n\n Для покупки используйте (категория) (номер) Например: Дом 1,\nЧтобы узнать какие есть возможные Дома напишите Дом.");
}

if(mb_strtolower($message) == 'ферма'){ 
    if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

    
    $vk->sendMessage($peer_id," В разработке");
}


if(mb_substr($message,0,6) == 'Репорт'){
	
	if($sql->isBanCmd($db, $id) == true){
				return $vk->sendMessage($peer_id, "$userError Вы заблокированы в Robert\n Чтобы узнать подробнее напиши в !репорт");
			}
		
		
		$param1 = mb_substr($message,7);
		if($param1==''){
			return $vk->sendMessage($peer_id,"$userError я не могу отослать пустое сообщение");
		}
		$profiles = $id;
		foreach($profiles as $p){
			$send = "@id$id($userName $userSurName)";
			$vk->sendMessage($p, "Внимание, заявка на баг!\nПрислали из беседы: $peer_id\nПрислал: $send\n\nТекст: $param1");
		}
		return $vk->sendMessage($peer_id, "$userSuc успешно отправлено на обработку!");
		$db->query("INSERT INTO vav (vk_id, text) VALUES ($id, $param1)");
	}

   if ($cmd[0] == 'машина') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM mashin");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM mashin WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Машина не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT mashin FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['mashin'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть это Машина');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM mashin WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET mashin = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили машину за ' . $exta32 . ' монет');
            }
        }
    }
}
}


if (mb_substr($message, 0, 10) == 'Ограбление') {
    if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

    
    $param1 = mb_substr($message, 11);
    if ($param1 == '') {
        return $vk->sendMessage($peer_id, "Не указано число.");
    }
    if (!is_numeric($param1)) {
        return $vk->sendMessage($peer_id, "Введите число после слова 'Ограбление'.");
    }
    $number = rand(1, 200);
    if ($param1 == $number) {
        // выполнение определенного кода, если пользователь угадал число
        return $vk->sendMessage($peer_id, "Вы угадали число $number! Выполняю определенный код...");
    } else {
        // сообщение об ошибке, если пользователь не угадал число
        return $vk->sendMessage($peer_id, "К сожалению, выпало число $number, а не $param1. Вы не угадали.");
    }
}

 if ($cmd[0] == 'компьютер') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM computer");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM computer WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Компьютер не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT computer FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['computer'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть это Компьютер');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM computer WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET computer = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили Компьютер за ' . $exta32 . ' монет');
            }
        }
    }
}
}



 if ($cmd[0] == 'дом') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM home");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM home WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Дом не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT home FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['home'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть это Дом');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM home WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET home = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили Дом за ' . $exta32 . ' монет');
            }
        }
    }
}
}




 if ($cmd[0] == 'яхта') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM exta");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM exta WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Яхта не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT exta FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['exta'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть это Яхта');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM exta WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET exta = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили Яхту за ' . $exta32 . ' монет');
            }
        }
    }
}
}


 if ($cmd[0] == 'одежда') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM odes");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM odes WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Одежда не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT odes FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['odes'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть эта Одежда');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM odes WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET odes = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили Одежду за ' . $exta32 . ' монет');
            }
        }
    }
}
}


 if ($cmd[0] == 'питомец') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

 $odes5 = $db->query("SELECT id, name, shop FROM pitomith");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['id']}, {$row['name']}, Цена {$row['shop']} Монеток\n";
        }

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 11) {
        $vk->sendMessage($peer_id, $result);
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM pitomith WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Питомец не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT pitom FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['pitom'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть это питомец');
            } else if ($balance < $buss['plata']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM pitomith WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET pitom = ?i WHERE vk_id = ?i', $shop, $id);
                $vk->sendMessage($peer_id, 'Вы купили питомца за ' . $exta32 . ' монет');
            }
        }
    }
}
}





if(mb_strtolower($message) == 'баланс'){ 
if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}


$balance = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['balance'];
$bank = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['bank'];

  $vk->sendMessage($peer_id, " Ваша баланс: $balance монет 	&#128305; \n У вас в банке: $bank &#128176; ");


}

if(mb_strtolower($message) == 'топ'){ 
if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

			
			$is_admins = $db->query("SELECT * FROM users WHERE balance != 0 ORDER BY balance DESC LIMIT 5"); // Получаем данные из колонки vk_id
			while ($row = $is_admins->fetch_assoc()) { // Запускаем цикл
				$i++;
				$s = $vk->request("users.get", ["user_ids" => $row['vk_id']]);
				$ss = $s[0]['first_name']; 
				$sss = $s[0]['last_name']; 
				$sss = mb_substr($sss,0,1);
				$rei = $row['balance'];
				$is_adminss .= "&#12935$i; $ss $sss ( 	&#128305; $rei )\n";
			//$is_adminss .= $row['reiting']. " - запись с бд\n";
			}
			$qq = $is_adminss;
			if($qq == ''){
				$qq = 'Нет таких :(';
			}
			$vk->sendMessage($peer_id, "Самые популярные люди\n $qq");
		}
    
if(mb_strtolower($message) == 'профиль'){ 
    if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

    
    $nick = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['nick'];
     $pitom1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['pitom']; // Питомец
     $pitom2 = $db->query("SELECT * FROM pitomith WHERE id = $pitom1")->fetch_assoc()['name']; // ПИТОМЕЦ
     
      $com1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['computer']; // PC
     $com2 = $db->query("SELECT * FROM computer WHERE id = $com1")->fetch_assoc()['name']; // PC
     
      $home1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['home']; // HOME
     $home2 = $db->query("SELECT * FROM home WHERE id = $home1")->fetch_assoc()['name']; // HOME
     
      $exta1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['exta']; // EXTA
     $exta2 = $db->query("SELECT * FROM exta WHERE id = $exta1")->fetch_assoc()['name']; // EXTA
     
      
      $mashin1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['mashin']; //машина
     $mashin2 = $db->query("SELECT * FROM mashin WHERE id = $mashin1")->fetch_assoc()['name']; // машина
     
     $odes1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['odes']; //машина
     $odes2 = $db->query("SELECT * FROM odes WHERE id = $odes1")->fetch_assoc()['name']; // машина
     
      $buss1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss']; //машина
     $buss2 = $db->query("SELECT * FROM buss WHERE id = $buss1")->fetch_assoc()['name']; // машина
     
      $ferma1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['ferma']; //машина
     $ferma2 = $db->query("SELECT * FROM ferma WHERE id = $ferma1")->fetch_assoc()['name']; // машина
     
     
    $ids1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['id'];
    $balance1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['balance'];
    $bank = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['bank'];
     $times1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['times'];


$rub = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['rub'];

    $vk->sendMessage($peer_id, "@id$id($nick), твой профиль: \n &#128270; ID: $ids1\n&#128176; Монет: $balance1\n&#128179; В банке: $bank \n &#128184;	Рублей: $rub ₽ \n &#128084; Одежда: $odes2\n\n&#128477; Имущество:\n  &#128663; Машина - $mashin2 \n  &#128741; Яхта- $exta2 \n  &#127968; Дом - $home2 \n  &#128187; Компьютер - $com2 \n  &#129421; Питомец: - $pitom2\n  &#128189; Ферма - $ferma2\n  &#128188;Бизнес - $buss2 \n\n Дата регистрации: $times1 ");
}

if ($cmd[0] == 'бизнесы') {
    // Получаем значение после "бизнес" из команды
    $shop = isset($cmd[1]) ? (int) $cmd[1] : null;

    // Проверяем, что число после "бизнес" указано и находится в диапазоне от 1 до 10
    if ($shop === null || !is_numeric($shop) || $shop < 1 || $shop > 10) {
       $result1 = $db->query("SELECT id, name, shop, plata FROM buss");





    // Формируем строку с информацией о лотах
    $auction_info = '';
    while ($row = $result1->fetch_assoc()) {
        $auction_info1 .= "{$row['id']}. {$row['name']} \n Стоимость: {$row['shop']} Монеток\n Доход {$row['plata']} монет \n";
    }

	   $vk->sendMessage($peer_id, "Укажите число бизнеса от 1 до 10 \n $auction_info1 ");
    } else {
        // Ищем запись в таблице buss с соответствующим id
        $buss = $db->query('SELECT * FROM buss WHERE id = ?i', $shop)->fetch_assoc();

        if (!$buss) {
            $vk->sendMessage($peer_id, 'Бизнес не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Получаем значение столбца buss из таблицы users для пользователя с vk_id = $id
            $user_buss = $db->query('SELECT buss FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['buss'];

            // Проверяем, что у пользователя нет этого бизнеса
            if ($user_buss >= $shop) {
                $vk->sendMessage($peer_id, 'У вас уже есть этот бизнес');
            } else if ($balance < $buss['shop']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно средств');
            } else {
                // Обновляем данные пользователя и таблицы buss
                $exta32 = $db->query("SELECT * FROM buss WHERE id = $shop")->fetch_assoc()['shop']; // EXTA
                $db->query("UPDATE users SET balance = balance - '$exta32' WHERE vk_id = '$id'");
                $db->query('UPDATE users SET buss = ?i, buss_plata = ?i, buss_sull = ?i WHERE vk_id = ?i', $shop, $buss['plata'], $buss['sull'], $id);
                $vk->sendMessage($peer_id, "Вы купили бизнес за " . $buss['shop'] . " монет\n В дальнейшем чтобы получать деньги от бизнеса\nпросто нажмите Бонус");
            }
        }
    }
}




    if ($cmd[0] == 'казино'){ // Первая команда

       if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

       
        if (!$cmd[1]){ // если вторая команда пустая она вернет FALSE
            $vk->sendMessage($peer_id, 'Вы не указали ставку!');
        }elseif ($cmd[1] == 'все' or $cmd[1] == 'всё'){ // Если указано все

            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance']; // вытягиваем весь баланс

            if($balance == 0) {
                $vk->sendMessage($peer_id, 'У Вас нет денег :(');
            } else {
                $result = mt_rand(1, 4); // 1 - проиграл половину, 2 - победа x1.5, 3 - победа x2, 4 - проиграл все
                $win_money = ($result == 1 ? $balance / 2 : ($result == 2 ? $balance * 1.5 : ($result == 3 ? $balance * 2 : 0)));
                $win_nowin = ($result == 1 ? 'проиграли половину' : ($result == 2 ? 'выиграли x1.5' : ($result == 3 ? 'выиграли x2' : 'проиграли все')));
                $vk->sendMessage($peer_id, "Вы $win_nowin, ваш баланс теперь составляет $win_money монет.");
                $db->query('UPDATE users SET balance = ?i WHERE vk_id = ?i', $win_money, $id); // Обновляем данные
            }
        } else {

         $sum =  str_replace(['к','k'], '000', $cmd[1]); // наши Кk превращаем в человеческий вид, заменяя их на нули :)
         $sum =  ltrim(mb_eregi_replace('[^0-9]', '', $sum),'0'); // удаляем лишние символы, лишние нули спереди и все что может поломать систему :), подробнее о функциях можно почитать в интернете
         $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance']; // вытягиваем весь баланс

            if($balance < $sum) {
                $vk->sendMessage($peer_id, 'У вас не достаточно денег');
            } else {
            $result = mt_rand(1, 4); // 1 - проиграл половину, 2 - победа x1.5, 3 - победа x2, 4 - проиграл все

            $win_money = ($result == 1 ?  $balance - ($sum / 2)  : ($result == 2 ? $balance + ($sum * 1.5) : ($result == 3 ? $balance + ($sum * 2) : $balance - $sum)));
            $win_nowin = ($result == 1 ? 'проиграли половину' : ($result == 2 ? 'выиграли x1.5' : ($result == 3 ? 'выиграли x2' : 'проиграли все')));

            $vk->sendMessage($peer_id, "Вы $win_nowin, ваш баланс теперь составляет $win_money монет.");
            $db->query('UPDATE users SET balance =  ?i WHERE vk_id = ?i',  $win_money, $id); // Обновляем данные
            }
        }


    }
    
    if(mb_strtolower($message) == 'тех'){ 
        if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
        
        // Проверяем текущее значение bot в psettings
//$result = $db->query("SELECT bot FROM psettings")->fetch_assoc();
//$bot_value = $result['bot'];
//$new_bot_value = $bot_value == 1 ? 0 : 1; // Меняем значение на противоположное

// Обновляем значение bot в psettings
//$db->query("UPDATE psettings SET bot = $new_bot_value");

$vk->sendMessage($id, "Связи с расторжением бота в целях владельца.\nБот стал доступным всем, связи с этим данная команда не доступна в бета версии." );
    }
    
    
if(mb_strtolower($message) == 'цитата'){ 
   if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

   
    $odes5 = $db->query("SELECT id, text FROM sitata ORDER BY RAND() LIMIT 1");
    if ($odes5) {
        $result = '';
        while ($row = $odes5->fetch_assoc()) {
            $result .= "{$row['text']}\n";
        }
        $vk->sendMessage($peer_id, $result );
    }
}

if(mb_strtolower($message) == 'апанель'){ 
    	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
    $vk->sendMessage($id," Команды администратора:\n\n Дцитата - добавить цитату\n give (ид) (сумма) - монетки \n тех - закрыть бота на теx.работы. \n bon - Обнуление бонуса к стандарту. \n rub - пополнение рублей. \n auc (Акция) (монет) (руб) \n топруб - Топ в рублях. \n Рассылка (текст) \n vip - Выдать себе вип ");
    
    
}


if ($cmd[0] == 'bon') {
    	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
    
    
    if (count($cmd) < 2) {
        $vk->sendMessage($peer_id, 'Ошибка: необходимо указать id пользователя и сумму для начисления.');
    } else {
        $user_id1 = $cmd[1];
        $db->query('UPDATE users SET time_bonus = ?i WHERE id = ?i', 0, $user_id1);
        $vk->sendMessage($id, "Успешно обнулили бонус теперь он стандартный у пользователя с ID $user_id");
    }

}	


if ($cmd[0] == 'auc') {
    	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
    
    
    if (count($cmd) < 3) {
        $vk->sendMessage($peer_id, 'Ошибка: необходимо указать наименование акции\n покупка монет\n сколько выдача рублей.');
    } else {
        
      
$name = $cmd[1];
$shop = $cmd[2];
$plata = $cmd[3];

        $db->query("INSERT INTO aucsion (name, shop, plata) VALUES ('$name', '$shop', '$plata')");
        $vk->sendMessage($id, "Вы успешно создали акцию: $name \n За $shop монеток дает $plata рублей");
    }

}	



if ($cmd[0] == 'give') {
    	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
    
    
    if (count($cmd) < 3) {
        $vk->sendMessage($peer_id, 'Ошибка: необходимо указать id пользователя и сумму для начисления.');
    } else {
        $user_id1 = $cmd[1];
        $amount = $cmd[2];
        $db->query('UPDATE users SET balance = balance + ?i WHERE id = ?i', $amount, $user_id1);
        $vk->sendMessage($id, "Успешно начислено $amount монет пользователю с ID $user_id");
    }

}	

if(mb_strtolower($message) == 'топруб'){ 
if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}

if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
			
			$is_admins = $db->query("SELECT * FROM users WHERE rub != 0 ORDER BY rub DESC LIMIT 20"); // Получаем данные из колонки vk_id
			while ($row = $is_admins->fetch_assoc()) { // Запускаем цикл
				$i++;
				$s = $vk->request("users.get", ["user_ids" => $row['vk_id']]);
				$ss = $s[0]['first_name']; 
				$sss = $s[0]['last_name']; 
				$sss = mb_substr($sss,0,1);
				$rei = $row['rub'];
				$is_adminss .= "&#12935$i; $ss $sss ( 	&#128305; $rei )\n";
			//$is_adminss .= $row['reiting']. " - запись с бд\n";
			}
			$qq = $is_adminss;
			if($qq == ''){
				$qq = 'Нет таких :(';
			}
			$vk->sendMessage($peer_id, "Люди наибольшее рублей. $qq");
		}
    

if ($cmd[0] == 'rub') {
    	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
    
    
    if (count($cmd) < 3) {
        $vk->sendMessage($peer_id, 'Ошибка: необходимо указать id пользователя и сумму для начисления.');
    } else {
        $user_id1 = $cmd[1];
        $amount = $cmd[2];
        $db->query('UPDATE users SET rub = rub + ?i WHERE id = ?i', $amount, $user_id1);
        $vk->sendMessage($id, "Успешно начислено $amount рублей пользователю с ID $user_id");
    }

}	
    
    if (mb_substr($message, 0, 7) == 'Дцитата') {
   	if($sql->Admin($db, $id) == false){
				return $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
			}
		
   
  // $param1 = mb_substr($message, 8);
   // if ($param1 == '') {
   //     return $vk->sendMessage($peer_id," Ты не указал текст для цитаты");
  //  }
   // $db->query("INSERT INTO sitata (text) VALUES ('$param1')");
    $vk->sendMessage($id," Связи с расторжением бота в целях владельца.\nБот стал доступным всем, связи с этим данная команда не доступна в бета версии.");

    }
    
 

    
if ($cmd[0] == 'банк') { // Первая команда
    if ($sql->Bot($db, $id) == true) {
        return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
    }

    if (!$cmd[1]) { // если вторая команда пустая она вернет FALSE
        
        $banker1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['bank'];
        $vk->sendMessage($peer_id, "&#128176; В вашем банке: $banker1 \n Для пополнения банка пишите: Банк (сумма) \n Также допускаются сокращения \n Например: 100k, 100к \n Чтобы снять средства напишите: Снять (сумму).");
    } else {
        $sum = str_replace(['к', 'k'], '000', $cmd[1]); // преобразуем Кk в человеческий вид
        $sum = ltrim(mb_eregi_replace('[^0-9]', '', $sum), '0'); // удаляем лишние символы

        $balance = $db->query('SELECT balance, bank FROM users WHERE vk_id = ?i', $id)->fetch_assoc();
        $balance_sum = (int)$balance['balance'];
        $bank_sum = (int)$balance['bank'];

        if ($sum <= 0) {
            $vk->sendMessage($peer_id, 'Неверная сумма для пополнения');
        } elseif ($balance_sum < $sum) {
            $vk->sendMessage($peer_id, 'У вас недостаточно денег на балансе');
        } else {
            $balance_sum -= $sum;
            $bank_sum += $sum;
            $db->query('UPDATE users SET balance = ?i, bank = ?i WHERE vk_id = ?i', $balance_sum, $bank_sum, $id);
            $vk->sendMessage($peer_id, "Вы успешно пополнили банк на $sum монет. Ваш текущий баланс: $balance_sum монет, банк: $bank_sum монет.");
        }
    }
}

if ($cmd[0] == 'снять') { // Первая команда
    if ($sql->Bot($db, $id) == true) {
        return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
    }

    if (!$cmd[1]) { // если вторая команда пустая она вернет FALSE
        $vk->sendMessage($peer_id, 'Вы не указали сумму для снятия!');
    } else {
        $sum = str_replace(['к', 'k'], '000', $cmd[1]); // преобразуем Кk в человеческий вид
        $sum = ltrim(mb_eregi_replace('[^0-9]', '', $sum), '0'); // удаляем лишние символы

        $balance = $db->query('SELECT balance, bank FROM users WHERE vk_id = ?i', $id)->fetch_assoc();
        $balance_sum = (int)$balance['balance'];
        $bank_sum = (int)$balance['bank'];

        if ($sum > $bank_sum) {
            $vk->sendMessage($peer_id, 'На банковском счету недостаточно средств!');
        } else {
            $new_balance = $balance_sum + $sum;
            $new_bank = $bank_sum - $sum;

            $db->query('UPDATE users SET balance = ?i, bank = ?i WHERE vk_id = ?i', $new_balance, $new_bank, $id);
            $vk->sendMessage($peer_id, "Вы успешно сняли $sum монет из банка. Текущий баланс: $new_balance монет.");
        }
    }
}

if ($cmd[0] == 'бизнес') {
    if($sql->Bot($db, $id) == true){
        return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
    }

   	if($sql->Buss($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Бизнеса\n Чтобы купить напишите Бизнесы");
			}
			$buss1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss'];
			$buss2 = $db->query("SELECT * FROM buss WHERE id = $buss1")->fetch_assoc()['name'];
			$buss3 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss_plata'];
			$buss4 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss_sull'];
			
			$vk->sendMessage($peer_id, "Ваш Бизнес:\n $buss2\nДоход: $buss3\n Продажа бизнеса: $buss4");

   
}
$titi = "одежду,питомца,бизнес,машину, яхту, дом, компьютер, ферму";
$words = explode(' ', $message);
if ($words[0] == 'Продать') {
   if($sql->Bot($db, $id) == true){
				return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
			}
   
    if (count($words) < 2) {
        $vk->sendMessage($peer_id, "Вы не указали, что хотите продать.\n $titi");
    } elseif ($words[1] == 'бизнес') {
        
        if($sql->Buss($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Бизнеса\n Чтобы купить напишите Бизнесы");
			}
        
         $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss']; 
			$text2 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss_sull']; 
			$text3 = $db->query("SELECT * FROM buss WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET buss = 0, balance = balance + $text2, buss_plata = 0, buss_sull = 0 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Бизнес: $text3 \n На сумму: $text2 монет ");
    } elseif ($words[1] == 'питомца') {
         if($sql->pitom($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Питомца\n Чтобы купить напишите Магазин");
			}
			
			$text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['pitom']; 
			$text2 = $db->query("SELECT * FROM pitomith WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM pitomith WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET pitom = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали бизнес: $text3 \n На сумму: $text2 монет ");
    } elseif ($words[1] == 'одежду') {
         if($sql->odes($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Одежды\n Чтобы купить напишите Магазин");
			}
        
       $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['odes']; 
			$text2 = $db->query("SELECT * FROM odes WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM odes WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET odes = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Одежду: $text3 \n На сумму: $text2 монет ");
        
    } elseif ($words[1] == 'машину') {
         if($sql->mashina($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Машины\n Чтобы купить напишите Магазин");
			}
        
         $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['mashin']; 
			$text2 = $db->query("SELECT * FROM mashin WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM mashin WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET mashin = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Машину: $text3 \n На сумму: $text2 монет ");

    } elseif ($words[1] == 'яхту') {
        if($sql->exta($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Яхты\n Чтобы купить напишите Магазин");
			}
        
         $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['exta']; 
			$text2 = $db->query("SELECT * FROM exta WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM exta WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET exta = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Яхту: $text3 \n На сумму: $text2 монет ");
   
    } elseif ($words[1] == 'дом') {
        if($sql->home($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Дома\n Чтобы купить напишите Магазин");
			}
        
         $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['home']; 
			$text2 = $db->query("SELECT * FROM home WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM home WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET home = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Дом: $text3 \n На сумму: $text2 монет ");
        
    } elseif ($words[1] == 'компьютер') {
        if($sql->computer($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Компьютер\n Чтобы купить напишите Магазин");
			}
        
        
         $text1 = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['computer']; 
			$text2 = $db->query("SELECT * FROM computer WHERE id = $text1")->fetch_assoc()['sull']; 
			$text3 = $db->query("SELECT * FROM computer WHERE id = $text1")->fetch_assoc()['name']; 
			
			$db->query("UPDATE users SET computer = 0, balance = balance + $text2 WHERE vk_id = $id");
        
        $vk->sendMessage($peer_id, "Вы успешно продали Одежду: $text3 \n На сумму: $text2 монет ");
        
    } elseif ($words[1] == 'ферму') {
         if($sql->ferma($db, $id) == false){
				return $vk->sendMessage($peer_id, " У вас нет Фермы\n Чтобы купить напишите Магазин");
			}
        
       
       
    } else {
        $vk->sendMessage($peer_id, "Неправильн указали аргумент\n $titi");
    }
} else {
   // $vk->sendMessage($peer_id, "Error");
}

if ($cmd[0] == 'аукцион') { 

if($sql->ACS($db ) == false){
				return $vk->sendMessage($peer_id, "Аукцион закрыт.");
			}

$auction_id = isset($cmd[1]) ? (int) $cmd[1] : null;
 // Выбираем записи из таблицы aucsion
 $result = $db->query("SELECT id, name, shop, plata FROM aucsion");





    // Формируем строку с информацией о лотах
    $auction_info = '';
    while ($row = $result->fetch_assoc()) {
        $auction_info .= "{$row['id']}. {$row['name']} \n Покупают: {$row['shop']} Монеток\n За {$row['plata']} рублей \n";
    }

    // Если пользователь не указал ID лота или указал некорректный ID
    if ($auction_id === null || !is_numeric($auction_id) || $auction_id < 1) {
        $vk->sendMessage($peer_id, $auction_info . "\nДля покупки пишите Аукцион (номер)");
    } else {
        // Ищем запись в таблице aucsion с соответствующим id
        $lot = $db->query('SELECT * FROM aucsion WHERE id = ?i', $auction_id)->fetch_assoc();

    if ($sql->aucs($db, $id, $time) == true) {
        return $vk->sendMessage($peer_id, "Вы уже покупали реальную валюту, сможете приобрести только через 12 часов.\n Также можете приобрести VIP статус чтобы ускорить процесс. ");
    }



        if (!$lot) {
            $vk->sendMessage($peer_id, 'Лот не найден');
        } else {
            // Получаем текущий баланс пользователя
            $balance = $db->query('SELECT balance FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['balance'];

            // Проверяем, что у пользователя достаточно монеток для покупки лота
            if ($balance < $lot['shop']) {
                $vk->sendMessage($peer_id, 'У вас недостаточно монеток');
            } else {
                // Обновляем данные пользователя и таблицы aucsion
                $shop = (int) $lot['shop'];
                $rub = (int) $lot['plata'];
                $new_balance = $balance - $lot['plata'];
         
                $db->query("UPDATE users SET balance = balance - $shop WHERE vk_id = $id");
$db->query("UPDATE users SET rub = rub + $rub WHERE vk_id = $id");
     $db->query('DELETE FROM aucsion WHERE id = ?i', $auction_id);
                $vk->sendMessage($peer_id, "Вы успешно продали монет  " . $lot['shop'] . " монеток " . " \nвам начислили: " . $lot['plata'] . " рублей\n Для вывода средств напишите: Вывод (сумма) (номер qiwi) ");

//  + 21600 минут = 6 часов 40000 3200
    $next_bonus = $time + 43200; // Прибавляем 6 часов для следующего бонуса!
    $db->query('UPDATE users SET aucs = ?i WHERE vk_id = ?i',$next_bonus, $id); // Обновляем данные
            }
        }
    }
}

 

if ($cmd[0] == 'вывод') { 
    if ($sql->Bot($db, $id) == true) {
        return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
    }

if ($sql->isVipCMD($db, $id) == false) {
        return $vk->sendMessage($peer_id, "Вывод возможен только VIP-Статусу. ");
    }

    if (!$cmd[1]) { 
        $rub_sum = $db->query("SELECT rub FROM users WHERE vk_id = $id")->fetch_assoc()['rub'];
        $vk->sendMessage($peer_id, "&#128176; В вашем кошельке: $rub_sum руб. \n Для вывода средств пишите: вывод (сумма) (реквизиты qiwi) \n  минимальная сумма: 10 рублей.");
    } else {

if (!$cmd[2]) { 
        $vk->sendMessage($peer_id, "Реквизиты qiwi.");


} else {
        $sum = str_replace(['к', 'k'], '000', $cmd[1]); 
        $sum = ltrim(mb_eregi_replace('[^0-9]', '', $sum), '0'); 
        
        $rub_sum = (int)$db->query('SELECT rub FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['rub'];

        if ($sum < 10) {
            $vk->sendMessage($peer_id, 'Минимальная сумма для вывода - 10 рублей');
        } elseif ($rub_sum < $sum) {
            $vk->sendMessage($peer_id, 'У вас недостаточно рублей на балансе');
        } else {
            $rub_sum -= $sum;
            $db->query('UPDATE users SET rub = ?i WHERE vk_id = ?i', $rub_sum, $id);
            $vk->sendMessage($peer_id, "Вы успешно вывели $sum рублей. Ваш текущий баланс: $rub_sum руб.");
            $db->query("INSERT INTO vav (vk_id, summa, plates, time) VALUES ($id, $sum, '$cmd[2]', NOW())");

$vk->sendMessage($id, "Заявка на вывод средств от @id$id \n На сумму: $sum \n Способ оплаты: $cmd[2]");

        }
    }
}
}

/*if ($cmd[0] == 'рассылка') {
    try {
        if ($sql->Bot($db, $id) == true) {
            return $vk->sendMessage($peer_id, "VestaBot, закрыть на профилактический работы. ");
        }

        if (!isset($cmd[1])) {
            $vk->sendMessage($peer_id, "Укажите текст");
        } elseif ($sql->Admin($db, $id) == false) {
            $vk->sendMessage($peer_id, "Командная строка DEVELEOPER.\n Недоступна.");
        } else {
            $text = implode(' ', array_slice($cmd, 1));
            $result = $db->query("SELECT vk_id FROM users WHERE ras = 1");

            while ($row = $result->fetch_assoc()) {
                
				$pipi = $row['vk_id'];
				              
                // проверяем, было ли сообщение уже отправлено этому пользователю
                $message_id = md5($text . $row['vk_id']);
                $message_sent = $db->query("SELECT id FROM sent_messages WHERE message_id = '$message_id'")->num_rows;
                if ($message_sent > 0) {
                    continue; // сообщение уже отправлено, пропускаем получателя
                }
                
                $vk->sendMessage($row['vk_id'], $text . "\n\nЧтобы отписать от рассылки нажмите на кнопку Рассылка\n Если отсутствует кнопка напишите !бот и появится кнопка.");
                
                // сохраняем информацию об отправленном сообщении
                $db->query("INSERT INTO sent_messages (message_id, vk_id) VALUES ('$message_id', '{$row['vk_id']}')");
            }
        }
    } catch (Exception $e) {
        // здесь можно обработать ошибку, например, отправив сообщение администратору
        $vk->sendMessage(384904677, "Произошла ошибка: " . $e->getMessage());
    }
}*/

if ($cmd[0] == 'проверка') {
    $result = $db->query("SELECT vk_id FROM users WHERE ras = 1");

    while ($row = $result->fetch_assoc()) {
        $pipi = $row['vk_id'];

        $bib1 = $vk->request('messages.isMessagesFromGroupAllowed', ['user_id' => $pipi, 'group_id' => 184241709]);


    if ($bib1['is_allowed'] == 0) {
    $vk->sendMessage($peer_id, "$pipi: ".print_r($bib1, true));
}




        }
    }
    
    if ($cmd[0] == 'тест') {
        
        
// Проверяем текущее значение ras для пользователя
$current_ras = $db->query("SELECT ras FROM users WHERE vk_id = $id")->fetch_assoc()['admin'];

if ($current_ras == 0) {
// Если текущее значение ras = 0, то меняем его на 1 и выводим сообщение о подписке
$db->query("UPDATE users SET admin = 1 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Вы стали администратором \n апанель - команды админа");
} else {
// Если текущее значение ras = 1, то меняем его на 0 и выводим сообщение об отписке
$db->query("UPDATE users SET admin = 0 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Администратор успешно сняли.");
}
        
    }
    
      if ($cmd[0] == 'vip') {
        
        
// Проверяем текущее значение ras для пользователя
$current_ras = $db->query("SELECT ras FROM users WHERE vk_id = $id")->fetch_assoc()['vip'];

if ($current_ras == 0) {
// Если текущее значение ras = 0, то меняем его на 1 и выводим сообщение о подписке
$db->query("UPDATE users SET vip = 1 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Вы выдали себе Вип");
} else {
// Если текущее значение ras = 1, то меняем его на 0 и выводим сообщение об отписке
$db->query("UPDATE users SET vip = 0 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Вип  успешно сняли.");
}
        
    }

if ($cmd[0] == 'партнёр') {
    
if ($sql->part($db, $id) == true) {
            return $vk->sendMessage($peer_id, "Активации партнёрского кода одноразовое. ");
        }


// Check if an ID is provided
    if (isset($cmd[1])) {
        $partner_id = (int) $cmd[1];

        // Check if the provided ID matches the user's ID
        if ($partner_id == $id) {
            $vk->sendMessage($peer_id, 'К сожалению, мы не можем предоставить вам партнерский код.');
        } else {
            // Check if the provided ID exists in the users table
            $partner = $db->query('SELECT * FROM users WHERE vk_id = ?i', $partner_id)->fetch_assoc();

            if ($partner) {
                // Update the partner's balance and notify them
                $db->query('UPDATE users SET balance = balance + 100 WHERE vk_id = ?i', $partner_id);

$db->query('UPDATE users SET part = 1 WHERE vk_id = ?i', $id);

// $db->query("UPDATE users SET vk_id = $partner_id, part_colv = part_colv + 1 WHERE vk_id = $partner_id");




                $vk->sendMessage($partner_id, "К вам пришел пользователь с ID $id. Вам начислено 100 монет.");

                $vk->sendMessage($peer_id, "Вы успешно активировали партнерский код пользователя с ID $partner_id.");
            } else {
                $vk->sendMessage($peer_id, 'Нет пользователя с таким ID.');
            }
        }
    } else {
        $vk->sendMessage($peer_id, 'Укажите ID пользователя.');
    }
}



    
    // Давайте для обработки кнопки воспльзуемся SWITCH - CASE
    switch ($payload) // Проще говоря мы загрузили кнопки кнопки в свич, теперь проверяем что за кнопка была нажата и обрабатываем ее
    {
      
	  case 'help';
	  
	 $vk->sendMessage($peer_id, "&#128188; Бизнес: \n \n &#128200; Бизнесы (номер) - Купить⠀\n &#128203; Бизнес - Информация\n 	&#128210; Основные: \n\nОграбление (код)\n 📒 Профиль\n &#128081; Топ! \n 	 &#9997; Партнёр (id) - Активация партнёрского кода \n   &#9884; Цитата \n	&#128305; Клик \n&#128178; Баланс\n &#128176; Банк (сумма)\n &#128184; Снять (сумма)\n &#128663; Магазин \n	&#128084; Одежда \n &#127920; Казино \n \n &#128241; Кнопки - Выключить кнопки  \n &#127384; Репорт [фраза] - ошибки или пожелания ");

     	
		 break;
		 
	  
       case 'clic';




    if($sql->isVipCMD($db, $id) == false){
    $db->query("UPDATE users SET balance = balance + 1 WHERE vk_id = $id");
//$next_bonus1 = $time + 15; // Прибавляем 6 часов для следующего бонуса!
//    $db->query("UPDATE users SET clic_limit = ?i WHERE vk_id = ?I",$next_bonus1, $id);
    return $vk->sendMessage($peer_id, " Добавили 1 монет &#128305; ");
  } else {
    	$db->query("UPDATE users SET balance = balance + 2 WHERE vk_id = $id");

	   
	    $vk->sendMessage($peer_id,"Добавили 2 монет &#128305;");
}
	
	   break;

case 'ras';

// Проверяем текущее значение ras для пользователя
$current_ras = $db->query("SELECT ras FROM users WHERE vk_id = $id")->fetch_assoc()['ras'];

if ($current_ras == 0) {
// Если текущее значение ras = 0, то меняем его на 1 и выводим сообщение о подписке
$db->query("UPDATE users SET ras = 1 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Вы подписались на рассылку");
} else {
// Если текущее значение ras = 1, то меняем его на 0 и выводим сообщение об отписке
$db->query("UPDATE users SET ras = 0 WHERE vk_id = $id");
$vk->sendMessage($peer_id, "Вы отписались от рассылки");
}


break;




	   case 'bonus';
       
       	$time_bonus = $db->query('SELECT time_bonus FROM users WHERE vk_id = ?i', $id)->fetch_assoc()['time_bonus'];

if ($time_bonus < $time){
    // Проверяем VIP-статус
    $is_vip = $sql->isVipCmd($db, $id);
    $rand_money = mt_rand(10, 50);
    $vip = $is_vip ? mt_rand(50, 80) : 0;
    $bonus_amount = $rand_money + $vip;
    $llss1 = mt_rand(50, 80);
    
    // Проверяем наличие записи в таблице "business"
    $business = $db->query('SELECT buss_plata FROM users WHERE vk_id = ?i', intval($id))->fetch_assoc();
    if ($business) {
        $bonus_amount += $business['buss_plata'];
        $platess = $db->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss_plata']; 
        if ($platess > 0) {
            $vk->sendMessage($peer_id, "От Бизнеса доход: $platess");
        } else {
            $vk->sendMessage($peer_id, "Рекомендуем купить бизнес чтобы получать больше монет (Бизнес)");
        }
    } else {
        $vk->sendMessage($peer_id, "Было бы больше монет, если вы купили бы бизнес!");
    }
    
 // Проверяем наличие записи в таблице "ferma"
    $ferma = $db->query('SELECT ferma_plata FROM users WHERE vk_id = ?i', intval($id))->fetch_assoc();
    if ($ferma) {
        $bonus_amount += $ferma['ferma_plata'];
        $ferma = $db->query("SELECT * FROM users WHERE vk_id = ?i", intval($id))->fetch_assoc()['ferma_plata'];
        if ($ferma > 0) {
            $vk->sendMessage($peer_id, "От фермы доход: $ferma");
        } else {
            $vk->sendMessage($peer_id, "Рекомендуем купить ферму чтобы получать больше монет (Ферма)");
        }
    } else {
        $vk->sendMessage($peer_id, "Было бы больше монет, если вы купили бы ферму!");
    }


    //  + 21600 минут = 6 часов
    $next_bonus = $time + 21600; // Прибавляем 6 часов для следующего бонуса!
    $db->query('UPDATE users SET time_bonus = ?i, balance = balance + ?i WHERE vk_id = ?i',$next_bonus, $bonus_amount, $id); // Обновляем данные

    // Отправляем сообщение с бонусом
    if ($is_vip) {
        $vk->sendMessage($peer_id, "Вы получили бонус, Вам выпало $rand_money монет,\n а также $vip монет в качестве VIP-бонуса!");
    } else {
        $vk->sendMessage($peer_id, "Вы получили бонус, Вам выпало $rand_money монет \n Был бы статус VIP вы получили бы $llss1 монет");
    }
} else { // Иначе сообщим о том что бонус уже взят!
    $next_bonus = date("d.m в H:i:s",$time_bonus);
    $vk->sendMessage($peer_id,"Вы уже брали бонус ранее, следующий будет доступен \"$next_bonus\"");
    
}
	break;
    }


}

    

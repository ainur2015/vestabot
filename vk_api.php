<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors','on');
ini_set('error_log', './mysql.log');

use Krugozor\Database\Mysql\Mysql as Mysql; // КЛАССЫ ДЛЯ РАБОТЫ С БД

$host = 'localhost'; // По умолчанию localhost или ваш IP адрес сервера
$name = '.....'; // логин для авторизации к БД
$pass = '.....'; // Пароль для авторизации к БД
$bdname = '.....'; // ИМЯ базы данных

$db = Mysql::create($host, $name, $pass)->setDatabaseName($bdname)->setCharset('utf8mb4');

class sql {
    public function isBanCMD($connect, $id){
        $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['ban'];
        if($onoroff == '1'){
            return true;
        } else {
            return false;
        }
    }
    
    public function isVipCMD($connect, $id){
        $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['vip'];
        if($onoroff == '1'){
            return true;
        } else {
            return false;
        }
    }
    
    public function Admin($connect, $id){
        $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['admin'];
        if($onoroff == '1'){
            return true;
        } else {
            return false;
        }
    }
    
    public function Bot($connect, $id){
        $onoroff = $connect->query("SELECT * FROM psettings")->fetch_assoc()['bot'];
        if($onoroff == '1'){
            return true;
        } else {
            return false;
        }
    }

    
    public function Buss($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['buss'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function part($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['part'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function aucs($connect, $id, $time){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['aucs'];
    if($onoroff > $time){
        return true;
    } else {
        return false;
    }
}

public function clic($connect, $id, $time){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['clic_limit'];
    if($onoroff > $time){
        return true;
    } else {
        return false;
    }
}

public function pitom($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['pitom'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function computer($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['computer'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}


public function home($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['home'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function mashin($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['mashin'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function odes($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['odes'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function mashina($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['mashin'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function exta($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['exta'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}



public function ferma($connect, $id){
    $onoroff = $connect->query("SELECT * FROM users WHERE vk_id = $id")->fetch_assoc()['ferma'];
    if($onoroff >= 1){
        return true;
    } else {
        return false;
    }
}

public function ACS($connect){
$onoroff = $connect->query("SELECT COUNT(*) FROM aucsion")->fetch_assoc()['COUNT(*)'];
 if($onoroff >= 1){
    return true;
} else {
  return false;
}
}

}

class vk_api{
    /**
     * Токен
     * @var string
    private $token = '';
    private $v = '';
    /**
     * @param string $token Токен
     */
    public function __construct($token, $v){
        $this->token = $token;
        $this->v = $v;
    }
    public function sendDocMessage($sendID, $id_owner, $id_doc){
        if ($sendID != 0 and $sendID != '0') {
            return $this->request('messages.send',array('attachment'=>"doc". $id_owner . "_" . $id_doc,'user_id'=>$sendID));
        } else {
            return true;
        }
    }
    public function sendMessage($sendID,$message,$mention=false){
        if ($sendID != 0 and $sendID != '0') {
        	if($mention == true){
        		return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID, 'disable_mentions' => 1));	
        	}
			return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID));	
        } else {
            return true;
        }
    }
    public function sendOK(){
		//ob_end_clean();
		header("Connection: close\r\n");
		header("Content-Encoding: none\r\n");
		ignore_user_abort(true);
		ob_start();
		echo ('ok');
		$size = ob_get_length();
		header("Content-Length: $size");
		ob_end_flush();
		flush();
    }

	
    public function sendButton($sendID, $message, $gl_massiv = [], $one_time = False) {
        $buttons = [];
        $i = 0;
        foreach ($gl_massiv as $button_str) {
            $j = 0;
              foreach ($button_str as $button) {
                $color = $this->replaceColor($button[2]);
                $buttons[$i][$j]["action"]["type"] = "text";
                if ($button[0] != null)
                    $buttons[$i][$j]["action"]["payload"] = json_encode($button[0], JSON_UNESCAPED_UNICODE);
                $buttons[$i][$j]["action"]["label"] = $button[1];
                $buttons[$i][$j]["color"] = $color;
                $j++;
            }
            $i++;
        }
        $buttons = array(
            "one_time" => $one_time,
            "buttons" => $buttons);
        $buttons = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        //echo $buttons;
        return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID, 'keyboard'=>$buttons));
    }
    public function sendDocuments($sendID, $selector = 'doc'){
        if ($selector == 'doc')
            return $this->request('docs.getMessagesUploadServer',array('type'=>'doc','peer_id'=>$sendID));
        else
            return $this->request('photos.getMessagesUploadServer',array('peer_id'=>$sendID));
    }
    public function saveDocuments($file, $titile){
        return $this->request('docs.save',array('file'=>$file, 'title'=>$titile));
    }
	public function sendWall($sendID, $owner_id, $media_id){
		$construct = 'wall'.$owner_id.'_'.$media_id.'';
        return $this->request('messages.send', array('peer_id' => $sendID, 'attachment' => $construct));
    }
    public function savePhoto($photo, $server, $hash){
        return $this->request('photos.saveMessagesPhoto',array('photo'=>$photo, 'server'=>$server, 'hash' => $hash));
    }
    /**
     * Запрос к VK
     * @param string $method Метод
     * @param array $params Параметры
     * @return mixed|null
     */
    public function request($method,$params=array()){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token']=$this->token;
        $params['v']=$this->v;
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }
    private function replaceColor($color) {
        switch ($color) {
            case 'red':
                $color = 'negative';
                break;
            case 'green':
                $color = 'positive';
                break;
            case 'white':
                $color = 'default';
                break;
            case 'blue':
                $color = 'primary';
                break;
            default:
                # code...
                break;
        }
        return $color;
    }
    private function sendFiles($url, $local_file_path, $type = 'file') {
        $post_fields = array(
            $type => new CURLFile(realpath($local_file_path))
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $output = curl_exec($ch);
        return $output;
    }
    public function sendImage($id, $local_file_path, $text)
    {
        $upload_url = $this->sendDocuments($id, 'photo')['upload_url'];
        $answer_vk = json_decode($this->sendFiles($upload_url, $local_file_path, 'photo'), true);
        $upload_file = $this->savePhoto($answer_vk['photo'], $answer_vk['server'], $answer_vk['hash']);
        $this->request('messages.send', array('message'=> $text,'attachment' => "photo" . $upload_file[0]['owner_id'] . "_" . $upload_file[0]['id'], 'peer_id' => $id));
        return 1;
    }
    public function isUserInGroup($member_id,$group_id){
    	$mem = $this->request("groups.isMember", array('group_id' => $group_id, 'user_id' => $member_id));
		if($mem == '0')
			return false;
		else 
			return true;
    }
	public function isUserChatMember($member_id, $peer_id) {
        $api = $this->request("messages.getConversationMembers", array('peer_id' => $peer_id));
        foreach($api['profiles'] as $profile) {
            $ids = $profile['id'];
            if($ids == $member_id){
                return true;
            }
        }
        return false;
	}
}



    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

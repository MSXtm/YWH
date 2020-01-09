<?php 
ob_start();
$API_KEY = '123456789:MSX15Awesome';
define('API_KEY',$API_KEY);

//Functions 
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
 function sendmessage($chat_id, $text, $model){
	bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode
	]);
	}
	function sendaction($chat_id, $action){
	bot('sendchataction',[
	'chat_id'=>$chat_id,
	'action'=>$action
	]);
	}
	function Forward($KojaShe,$AzKoja,$KodomMSG){
    bot('ForwardMessage',[
        'chat_id'=>$KojaShe,
        'from_chat_id'=>$AzKoja,
        'message_id'=>$KodomMSG
    ]);
}
function sendphoto($chat_id, $photo, $action){
	bot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>$photo,
	'action'=>$action
	]);
	}
	function objectToArrays($object){
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }
     function save($filename,$TXTdata){
  $myfile = fopen($filename, "w") or die("Unable to open file!");
  fwrite($myfile, "$TXTdata");
  fclose($myfile);
  }
    
// Variables
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$from_id = $message->from->id;
$text = $message->text;
$step = file_get_contents("data/$from_id/step.txt");
$token =  file_get_contents("data/$from_id/token.txt");
$url =  file_get_contents("data/$from_id/url.txt");
@mkdir("data/");
@mkdir("data/$from_id/");
// Main
/* '/' Commands */
if($text == "/start"){
if (!file_exists("data/$from_id/step.txt")) {
mkdir("data/$from_id");
save("data/$from_id/step.txt","null");
$myfile2 = fopen("user.txt", "a") or die("Unable to open file!");
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"رباتی برای کار کردن با متد وبهوک تلگرام.\n\n⚡️ @MSXtm",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"]]
	]
	])
	]);
}
elseif($text == "بازگشت" || $text == "/cancel"){
file_put_contents("data/$from_id/step.txt","null");
file_put_contents("data/$from_id/token.txt","null");
file_put_contents("data/$from_id/url.txt","null");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"خوش برگشتید.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"]]
	]
	])
	]);
}

/* Set Web Hook */
elseif($text == "تنظیم وبهوک" || $text == "setwh"){
file_put_contents("data/$from_id/step.txt","token");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
    'text'=>"توکن خود را وارد کنید:",
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[
	['text'=>"بازگشت"]
	],
	]
	])
	]);
}
elseif($step == "token"){
$token = $text;
$v1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$v2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $tik2 = objectToArrays($v1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($v2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    } else{
    file_put_contents("data/$from_id/step.txt","url");
    file_put_contents("data/$from_id/token.txt",$text);
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"آدرس فایلی که میخواید وبهوک ست بشه رو وارد کنید.\n\nمثال قابل قبول:\nhttps://msxtm.ir/bot.php\n\n* نکته : آدرس حتما باید با https:// شروع شود.",
  ]);
}
}
elseif($step == "url"){
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text)){
  SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"خطا! آدرس اشتباه هست.",
  ]);
 }
 else {
 file_put_contents("data/$from_id/step.txt","null");
 file_put_contents("data/$from_id/url.txt",$text);
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"صبور باشید.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید..."
  ]);
  sleep(1);
  bot('editmessagetext',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id + 1,
  'text'=>"آیا مایل به تنظیم وبهوک با این مشخصات هستید؟\n\nتوکن:\n$token\nآدرس فایل شما:\n$text\n\nبرای نهایی کردن این تنظیم، دستور /setwebhook را بفرستید.",
  ]);
 }
}
elseif($text == "/setwebhook" ){
if($token != "null"){
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"صبور باشید.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>"درحال تنظیم...",
  ]);
  file_get_contents("https://api.telegram.org/bot$token/setwebhook?url=$url");
    sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>"با موفقیت تنظیم شد، لذت ببرید.",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/step.txt","null");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id + 1,
	'text'=>"دوباره شروع کنید:",
    'parse_mode'=>'MarkDown',
   	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"]]
	]
	])
	]);
}

}

/* Get Token's Information */
elseif($text == "اطلاعات توکن" || $text == "/getinfo"){
    file_put_contents("data/$from_id/step.txt","gtoken");
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"توکن خود را وارد کنید:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'بازگشت']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($step == "gtoken"){
$token = $text;
$step1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$step2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $tik2 = objectToArrays($step1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($step2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    } else{
    file_put_contents("data/$from_id/step.txt","null");
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"صبور باشید.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"وضعیت اعلام شده:\nنام کاربری | @$un\nشناسه | $id\nنام |‌ $fr\n\nآدرس فایل تنظیم شده وبهوک:\n$ur",
  ]);
}
}

/* Delete Web Hook */
elseif($text == "حذف وبهوک" || $text == "/delwh"){
    file_put_contents("data/$from_id/step.txt","del");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"توکن خود را وارد کنید:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'بازگشت']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($step == "del"){
$token = $text;
$step1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
$step2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
    $tik2 = objectToArrays($step1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($step2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    } else{
    file_put_contents("data/$from_id/step.txt","null");
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"صبور باشید.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"صبور باشید..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"در حال بازنشانی وبهوک...",
  ]);
}
file_get_contents("https://api.telegram.org/bot$text/deletewebhook");
sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"وبهوک با موفقیت پاک گردید.",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/step.txt","null");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id + 1,
	'text'=>"دوباره شروع کنید:",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"]]
	]
	])
	]);
}
?>

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
$lang =  file_get_contents("data/$from_id/lang.txt");
$step = file_get_contents("data/$from_id/step.txt");
$token =  file_get_contents("data/$from_id/token.txt");
$url =  file_get_contents("data/$from_id/url.txt");
@mkdir("data/");
@mkdir("data/$from_id");

// Main
/* '/' Commands */
if($text == "/start"){
if (!file_exists("data/$from_id/step.txt")) {
mkdir("data/$from_id/");
save("data/$from_id/lang.txt","none");
save("data/$from_id/step.txt","setlang");
$myfile2 = fopen("user.txt", "a") or die("Unable to open file!");
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}
if($lang != "fa" && $lang != "en"){
save("data/$from_id/step.txt","setlang");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"Please set your language.

لطفا زبان خود را انتخاب کنید.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[ 
	[['text'=>"🇺🇸 English"],['text'=>"🇮🇷 فارسی"]],
	[['text'=>"Help us translate bot"]],
	]
	])
	]);
}
	if($lang == "fa"){
save("data/$from_id/step.txt","none");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"رباتی برای کار کردن با متد وبهوک تلگرام.\n\n⚡️ @MSXtm",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
	if($lang == "en"){
save("data/$from_id/step.txt","none");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"A bot to work with webhook methods of telegram.\n\n⚡️ @MSXtm [Persian]",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"Set Webhook"],['text'=>"Delete Webhook"]],
	[['text'=>"Token's Info"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
}
elseif($text == "بازگشت" || $text == "Back" || $text == "/cancel"){
save("data/$from_id/step.txt","null");
save("data/$from_id/token.txt","null");
save("data/$from_id/url.txt","null");
	if($lang == "fa"){
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"خوش برگشتید.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
	if($lang == "en"){
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"Welcome Back.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"Set Webhook"],['text'=>"Delete Webhook"]],
	[['text'=>"Token's Info"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
}
elseif($text == "🇺🇸/🇮🇷"){
save("data/$from_id/lang.txt","none");
save("data/$from_id/step.txt","setlang");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"Please set your language.

لطفا زبان خود را انتخاب کنید.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[ 
	[['text'=>"🇺🇸 English"],['text'=>"🇮🇷 فارسی"]],
	[['text'=>"Help us translate bot"]],
	]
	])
	]);
}
elseif($text == "Help us translate bot" && $step == "setlang"){
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"Your language is not in our bot?\nYou can help us to translate bot to your language :)\n\nYou can contact @MSXadmin for helping and translating.",
    'parse_mode'=>'MarkDown'
	]);
}
elseif($step == "setlang"){
if($text == "🇺🇸 English" || $text == "🇮🇷 فارسی"){
if($text == "🇮🇷 فارسی"){
save("data/$from_id/lang.txt","fa");
save("data/$from_id/step.txt","none");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"رباتی برای کار کردن با متد وبهوک تلگرام.\n\n⚡️ @MSXtm",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"تنظیم وبهوک"],['text'=>"حذف وبهوک"]],
	[['text'=>"اطلاعات توکن"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
if($text == "🇺🇸 English"){
save("data/$from_id/lang.txt","en");
save("data/$from_id/step.txt","none");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"A bot to work with webhook methods of telegram.\n\n⚡️ @MSXtm [Persian]",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"Set Webhook"],['text'=>"Delete Webhook"]],
	[['text'=>"Token's Info"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
}
}else{
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"Just use keyboard.

تنها از کیبورد استفاده کنید.",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[ 
	[['text'=>"🇺🇸 English"],['text'=>"🇮🇷 فارسی"]],
	[['text'=>"Help us translate bot"]],
	]
	])
	]);
}
 }
/* Set Web Hook */
elseif($text == "تنظیم وبهوک" || $text == "Set Webhook" || $text == "setwh"){
file_put_contents("data/$from_id/step.txt","token");
if($lang == "fa"){
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
	if($lang == "en"){
	bot('sendmessage',[
	'chat_id'=>$chat_id,
    'text'=>"Send your token:",
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[
	['text'=>"Back"]
	],
	]
	])
	]);
	}
}
elseif($step == "token"){
$token = $text;
if($token != "بازگشت" || $token != "Back" || $token != "/cancel"){
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
    if($lang == "fa"){
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    }
    if($lang == "en"){
    SendMessage($chat_id, "Error! Token is wrong.");
    }
    } else{
    file_put_contents("data/$from_id/step.txt","url");
    file_put_contents("data/$from_id/token.txt",$text);
    if($lang == "fa"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"آدرس فایلی که میخواید وبهوک ست بشه رو وارد کنید.\n\nمثال قابل قبول:\nhttps://msxtm.ir/bot.php\n\n* نکته : آدرس حتما باید با https:// شروع شود.",
  ]);
  }
  if($lang == "en"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Send your URL.\n\nExample:\nhttps://msxtm.ir/bot.php\n\n* URL should start with https://.",
  ]);
  }
}
}
}
elseif($step == "url"){
if($text != "بازگشت" || $text != "Back" || $text != "/cancel"){
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text)){
if($lang == "fa"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"خطا! آدرس اشتباه هست.",
  ]);
  }
if($lang == "en"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Error! URL is wrong.",
  ]);
  }
 }
 else {
 file_put_contents("data/$from_id/step.txt","null");
 file_put_contents("data/$from_id/url.txt",$text);
 $un = json_decode(file_get_contents("https://api.telegram.org/bot".$token ."/getme"));
 $un = objectToArrays($un);
 $un = $un["result"]["username"]; 
 if($lang == "fa"){
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
  'text'=>"آیا مایل به تنظیم وبهوک با این مشخصات هستید؟\n\nتوکن:\n$token\n\nآدرس فایل شما:\n$text\n\nبرای نهایی کردن این تنظیم، دستور /setwebhook را بفرستید.",
  'reply_markup'=>json_encode([
  'inline_keyboard'=>[
  [['text'=>"@".$un,'url'=>"http://t.me/$un"]]
  ]])
  ]);
  }
 if($lang == "en"){
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Please wait.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait..."
  ]);
  sleep(1);
  bot('editmessagetext',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id + 1,
  'text'=>"Do you really want to set webhook?\n\nToken:\n$token\n\nURL:\n$text\n\nIf you are sure, send /setwebhook to do it.",
  'reply_markup'=>json_encode([
  'inline_keyboard'=>[
  [['text'=>"@".$un,'url'=>"http://t.me/$un"]]
  ]])
  ]);
  }
 }
}
}
elseif($text == "/setwebhook" ){
if($token != "null"){
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
if($lang == "fa"){
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
      'text'=>"با موفقیت تنظیم شد، لذت ببرید.\n\nنام کاربری ربات: @".$un."\nنام ربات: $fr\nشناسه ربات: $id",
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
	[['text'=>"اطلاعات توکن"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
if($lang == "en"){
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Please wait.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>"Setting webhook...",
  ]);
  file_get_contents("https://api.telegram.org/bot$token/setwebhook?url=$url");
    sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>"Done, Enjoy.\n\nBot's Username: @".$un."\nBot's Name: $fr\nBot's ID: $id",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/step.txt","null");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id + 1,
	'text'=>"Start again:",
    'parse_mode'=>'MarkDown',
   	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"Set Webhook"],['text'=>"Delete Webhook"]],
	[['text'=>"Token's Info"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
	
}

}

/* Get Token's Information */
elseif($text == "اطلاعات توکن" || $text == "Token's Info" || $text == "/getinfo"){
    file_put_contents("data/$from_id/step.txt","gtoken");
    if($lang == "fa"){
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
    if($lang == "en"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Send your token:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'Back']],
      ],'resize_keyboard'=>true])
  ]);
  }
}
elseif($step == "gtoken"){
if($text != "بازگشت" || $text != "Back" || $text != "/cancel"){
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
    if($lang == "en"){
    SendMessage($chat_id, "Error! Token is wrong.");
    }
    if($lang == "fa"){
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    }
    } else{
    file_put_contents("data/$from_id/step.txt","null");
    if($lang == "fa"){
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
    'text'=>"وضعیت اعلام شده:\nنام کاربری | @".$un."\nشناسه | $id\nنام |‌ $fr\n\nآدرس فایل تنظیم شده وبهوک:\n$ur",
  ]);
  }
    if($lang == "en"){
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Please wait.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"Token's Information:\nUserName | @".$un."\nID | $id\nName |‌ $fr\n\nWebhook's URL:\n$ur",
  ]);
  }
}
}
}

/* Delete Web Hook */
elseif($text == "حذف وبهوک" || $text == "Delete Webhook" || $text == "/delwh"){
if($text != "بازگشت" || $text != "Back" || $text != "/cancel"){
    file_put_contents("data/$from_id/step.txt","del");
if($lang == "fa"){
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
if($lang == "en"){
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Send your token:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'Back']],
      ],'resize_keyboard'=>true])
  ]);
  }
  }
}

elseif($step == "del"){
if($text != "بازگشت" || $text != "Back" || $text != "/cancel"){
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
    if($lang == "fa"){
    SendMessage($chat_id, "خطا!‌ توکن اشتباه است.");
    }
    if($lang == "en"){
    SendMessage($chat_id, "Error! Token is wrong.");
    }
    } else{
    file_put_contents("data/$from_id/step.txt","null");
    if($lang == "fa"){
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
	[['text'=>"اطلاعات توکن"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
    if($lang == "en"){
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Please wait.",
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait.."
  ]);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"Please wait..."
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"Deleting webhook...",
  ]);
file_get_contents("https://api.telegram.org/bot$text/deletewebhook");
sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"Webhook deleted successfully.",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/step.txt","null");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id + 1,
	'text'=>"Start again:",
    'parse_mode'=>'MarkDown',
    'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"Set Webhook"],['text'=>"Delete Webhook"]],
	[['text'=>"Token's Info"],['text'=>"🇺🇸/🇮🇷"]]
	]
	])
	]);
	}
}
}
}

?>

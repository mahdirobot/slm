<?php

define('API_KEY','543444052:AAEKKTq4G4Y7rAS179CajiRkpeLpWcpsads');
//----######------
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//##############=--API_REQ
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
//----######------
//---------
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$boolean = file_get_contents('booleans.txt');
  $booleans= explode("\n",$boolean);

$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$rpto = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$photo = $update->message->photo;
$video = $update->message->video;
$sticker = $update->message->sticker;
$file = $update->message->document;
$music = $update->message->audio;
$voice = $update->message->voice;
$forward = $update->message->forward_from;
$admin = 364759538;
//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}

//------------

if($textmessage == '/start')
 if ($from_id == $admin) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"سلام $name به ربات خود خوش اومدید 💬
برای تنظیم دکمه به روی راهنما⚠کلیک کنید
امیدوارم از ربات خود لذت ببرید👮",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"امار♻"],['text'=>"افراد بلاک شده⛔"]
              ],
	      [
                ['text'=>"پیغام همگانی 🔯"],['text'=>"پاک کردن لیست بلاک شده ها"]
              ],
	      [
	        ['text'=>"⚠راهنما"]
	      ]
            ]
        ])
    ]));
 }
 else{
 
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"سلام $name به ربات پیام رسان من خوش اومدی😎✋
لطفاً پیام خود را ارسال کنید 🎈 اگر جوابی دریافت نکردید لطفاً دوباره پیغام خود را نفرستید در این صورت بلاک می شوید⛔
Createor @mersetv",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"🏁ارسال شماره شما به من",'request_contact' => true],['text'=>"📝ارسال مکان شما به من",'request_location' => true]
              ],
	      [
                ['text'=>"📙شماره من"],['text'=>"💻درباره من"]
              ],
        [
                ['text'=>"🎮سفارش ربات"],['text'=>"🎯اعضای تیم"], ['text'=>"⚠راهنما"]
              ]
            ]
        ])
    ]));	
    $txxt = file_get_contents('member.txt');
$pmembersid= explode("\n",$txxt);
	if (!in_array($chat_id,$pmembersid)) {
		$aaddd = file_get_contents('member.txt');
		$aaddd .= $chat_id."
";
    	file_put_contents('member.txt',$aaddd);
}
 }

	elseif(strpos($textmessage , '/setinfo')!== false && $chat_id == $admin)
	{
		$javab = str_replace('/setinfo',"",$textmessage);
		if ($javab != "")
	{
	save("profile.txt","$javab");
	SendMessage($chat_id,"با موفقیت تغییریافت");
	}
	}

elseif($textmessage == '💻درباره من')
	{
	$profile = file_get_contents("profile.txt");
	Sendmessage($chat_id," $profile ");
	}

  elseif(strpos($textmessage , '/setmteam')!== false && $chat_id == $admin)
  {
    $javab = str_replace('/setmteam',"",$textmessage);
    if ($javab != "")
  {
  save("membertxt.txt","$javab");
  SendMessage($chat_id,"🏁با موفقیت تغییریافت");
  }
  }

  elseif($textmessage == '🎯اعضای تیم')
  {
  $membertxt = file_get_contents("membertxt.txt");
  Sendmessage($chat_id," $membertxt ");
  }

	elseif($textmessage == 'شماره من📔')
{
	$phone = '+639380627886';
	$namea = '@Crpvsup';
makereq('sendContact',[
	'chat_id'=>$chat_id,
	'phone_number'=>$phone,
	'first_name'=>$namea
	]);
}
 elseif(strpos($textmessage , '/setbotbuy')!== false && $chat_id == $admin)
  {
    $javab = str_replace('/setbotbuy',"",$textmessage);
    if ($javab != "")
  {
  save("sefaresh.txt","$javab");
  SendMessage($chat_id,"با موفقیت تغییریافت");
  }
  }

  elseif($textmessage == '🎮سفارش ربات')
  {
  $sefaresh = file_get_contents("sefaresh.txt");
  Sendmessage($chat_id," $sefaresh ");
  }

elseif($textmessage == '⚠راهنما')
if($chat_id == $admin){
	{
		Sendmessage($chat_id,"/sicsho  [reply]
		😎مسدود کردن فرد

		/sicnot [reply]
		😑ازاد کردن فرد

    /setmteam [text]
   🎉 تنظیم کردن متن اعضای تیم
    
		/setbotbuy [text]
		😥تنظیم متن سفارش ربات
		
		/setinfo [text]
		📝نتظیم پروفایل شما");
	}
}
else
	{
		Sendmessage($chat_id,"دکمه ارسال شماره شما به من:
		ارسال شماره خود به من

		دکمه ارسال مکان شما به من:
		ارسال مکان شما به من


    دکمه شماره من:
		ارسال شماره من به شما

		دکمه درباره من:
		نمایش اطلاعات من

    دکمه سفارش ربات:
    سفارش ربات پیامرسان

    دکمه راهنما:
    نمایش راهنمای ربات


    دکمه اعضای تیم:
    نمایش اعضای تیم
ربات پیام رسان خود را بسازید👇
@CrpvSup");
	}


elseif ($chat_id != $admin) {


    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);
$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"پیام شما باموفقیت ارسال شد");
}else{

Sendmessage($chat_id,"⚠شما بلاک شده اید لطفا پیام ندهید");

    }
    }
      elseif (isset($message['contact'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"شماره با موفقیت ارسال شد");
}else{

Sendmessage($chat_id,"⚠شما بلاک شده اید لطفا پیام ندهید");

}
    }
      }

	   elseif (isset($message['sticker'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"استیکر با موفقیت ارسال شد");
}else{

Sendmessage($chat_id,"شما بلاک شده اید لطفا پیام ندهید");

}
    }
      }


   elseif (isset($message['photo'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"🔯تصویر باموفقیت ارسال شد");
}else{

Sendmessage($chat_id,"⚠شما بلاک شده اید لطفا پیام ندهید");

}
    }
      }

         elseif (isset($message['voice'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"🔯ویس شما باموفقیت ارسال شد");
}else{

Sendmessage($chat_id,"⚠شما بلاک شده اید لطفا پیام ندهید");

}
    }
      }
               elseif (isset($message['video'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"🔯فیلم شما ارسال شد");
}else{

Sendmessage($chat_id,"⚠شما بلاک شده اید لطفا پیام ندهید");

}
    }
      }



	elseif($textmessage == 'امار♻' && $chat_id == $admin)
	{
		$txtt = file_get_contents('member.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
{
sendmessage($chat_id,"امار♻ : $mmemcount");
}
}

	elseif($textmessage == 'افراد بلاک شده⛔' && $chat_id == $admin){
		$txtt = file_get_contents('banlist.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
{
sendmessage($chat_id,"لیست بلاک شده ها : $mmemcount");
}
}




                  elseif (isset($message['location'])) {

      if ( $chat_id != $admin) {

    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
Forward($admin,$chat_id,$message_id);
Sendmessage($chat_id,"مکان موردنظر باموفقیت ارسال شد");
}else{

Sendmessage($chat_id,"شما بلاک شده اید لطفا پیام ندهید اطلاعات بیشتر در @Crpvsup");

}
    }
      }
            elseif($rpto != "" && $chat_id == $admin){
      if($textmessage != "/ban" && $textmessage != "/unban")
      {
sendmessage($rpto,"$textmessage");
sendmessage($chat_id,"💻پیغام شما ارسال شد");
      }
elseif ($textmessage == '/creator')
{
sendMessage($chat_id,"این ربات توسط ربات ساز @crpvsup ساخته شده است.😃");
}
      else
      {
        if($textmessage == "/ban"){
      $txtt = file_get_contents('banlist.txt');
    $banid= explode("\n",$txtt);
  if (!in_array($rpto,$banid)) {
    $addd = file_get_contents('banlist.txt');
    $addd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $addd);
    $addd .= $rpto."
";

      file_put_contents('banlist.txt',$addd);
      {
sendmessage($rpto,"⛔شما به لیست بلاک شده ها اضافه شدید");
sendmessage($chat_id,"📔به لیست بلاک شده ها افزوده شد");
        }
        }
}
      if($textmessage == "/unban"){
      $txttt = file_get_contents('banlist.txt');
    $banidd= explode("\n",$txttt);
  if (in_array($rpto,$banidd)) {
    $adddd = file_get_contents('banlist.txt');
    $adddd = str_replace($rpto,"",$adddd);
    $adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);
    $adddd .="
";


    $banid= explode("\n",$adddd);
    if($banid[1]=="")
      $adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);

      file_put_contents('banlist.txt',$adddd);
}
sendmessage($rpto,"↪شما ازلیست بلاک شده ها حذف شدید");
sendmessage($chat_id,"🏁از لیست بلاک شده ها پاک شد");
        }
      }
  }


        elseif ($textmessage =="پیغام همگانی 🔯"  && $chat_id == $admin | $booleans[0]=="false") {
	{
          sendmessage($chat_id,"❕لطفا پیام خودرا ارسال کنید");
	}
      $boolean = file_get_contents('booleans.txt');
		  $booleans= explode("\n",$boolean);
	  	$addd = file_get_contents('banlist.txt');
	  	$addd = "true";
    	file_put_contents('booleans.txt',$addd);

    }
      elseif($chat_id == $admin && $booleans[0] == "true") {
    $texttoall = $textmessage;
		$ttxtt = file_get_contents('member.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			sendmessage($membersidd[$y],"$texttoall");

		}
		$memcout = count($membersidd)-1;
	 	{
	 	Sendmessage($chat_id,"پیغام شما به $memcout مخاطب ارسال شد.");
	 	}
         $addd = "false";
    	file_put_contents('booleans.txt',$addd);
    	}
 elseif($textmessage == 'پاک کردن لیست بلاک شده ها')
 if($chat_id == $admin){
 {
 file_put_contents('banlist.txt',$chat_id);
 Sendmessage($chat_id,"لیست بلاک شده ها پاک شد");
 }
}
?>
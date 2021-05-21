<?php

ob_start();
include 'config.php';
include('lib/jdf.php');
//========================== // jijibot // ==============================
function jijibot($method,$datas=[]){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,'https://api.telegram.org/bot'.API_KEY.'/'.$method );
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    return json_decode(curl_exec($ch));
    }
//========================== // update // ==============================
$update = json_decode(file_get_contents('php://input'));
if(isset($update->message)){
$message = $update->message;
$message_id = $message->message_id;
$text = $message->text;
$chat_id = $message->chat->id;
$tc = $message->chat->type;
$first_name = $message->from->first_name;
$from_id = $message->from->id;
$user_name = isset($message->from->username)?"@{$message->from->username}":"وجود ندارد";
// databse
$user = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE id = '$from_id' LIMIT 1"));
}
if(isset($update->callback_query)){
$callback_query = $update->callback_query;
$callback_query_id = $callback_query->id;
$data = $callback_query->data;
$fromid = $callback_query->from->id;
$messageid = $callback_query->message->message_id;
$chatid = $callback_query->message->chat->id;
// databse
$user = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE id = '$fromid' LIMIT 1"));
}
//==============================// function //=======================================
function getnumber($service , $country) {
global $apikey;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://api.numbercall.ir/v2.php/?apikey=$apikey&method=getnum&country=$country&operator=any&service=$service");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT , 3);
return json_decode(curl_exec($ch));
}
function getbalance() {
global $apikey;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://api.numbercall.ir/v2.php/?apikey=$apikey&method=balance");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT , 3);
return json_decode(curl_exec($ch));
}
function ordertool($method , $order) {
global $apikey;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://api.numbercall.ir/v2.php/?apikey=$apikey&method=$method&id=$order");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT , 3);
return json_decode(curl_exec($ch));
}
function checkstats($service , $country) {
global $apikey;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://api.numbercall.ir/v2.php/?apikey=$apikey&method=getinfo&country=$country&operator=any&service=$service");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT , 3);
$curl_exec = json_decode(curl_exec($ch));
foreach ($curl_exec as $k=>$v) 
if($v->count > 0) { $amount = (($v->amount * 30) / 100) +  $v->amount; return ['true',$amount,$v->description]; break; }
return 'false';	
}
//==============================// keybord and Text //=======================================
$home = json_encode([
        'keyboard'=>[
		[['text'=>'🛍 خرید شماره مجازی']],
		[['text'=>'📊 استعلام | قیمت ها'],['text'=>'👤 حساب کاربری']],
		[['text'=>'💳 شارژ حساب'],['text'=>'🗣 دعوت دیگران']],
		[['text'=>'☎️ پشتیبانی'],['text'=>'ℹ️ راهنما'],['text'=>'↗️ انتقال']]
		],
          'resize_keyboard'=>true,
       		]);
$back = json_encode([
        'keyboard'=>[
		[['text'=>'🏛 خانه']],
		],
         'resize_keyboard'=>true,
       		]);
$code = json_encode([
        'keyboard'=>[
		[['text'=>'💬 دریافت کد']],
		[['text'=>'❌ لغو خرید'],['text'=>'❗️ گزارش مسدودی']]
		],
        'resize_keyboard'=>true,
       		]);
$country = json_encode([
        'keyboard'=>[
		[['text'=>'🏛 خانه'],['text'=>'ℹ️ راهنما'],['text'=>'🔙 برگشت']],
		[['text'=>'💳 شارژ حساب'],['text'=>'📊 استعلام | قیمت ها']],
		[['text'=>'🇷🇺 روسیه'],['text'=>'🇺🇦 اکراین'],['text'=>'🇰🇿 قزاقستان']],
		[['text'=>'🇮🇷 ایران'],['text'=>'🇨🇳 چین'],['text'=>'🇵🇭 فیلیپین']],
		[['text'=>'🇲🇲 میانمار'],['text'=>'🇮🇩 اندونزی'],['text'=>'🇲🇾 مالزی']],
		[['text'=>'🇰🇪 کنیا'],['text'=>'🇹🇿 تانزانیا'],['text'=>'🇻🇳 ویتنام']],
		[['text'=>'🇬🇧 انگلستان'],['text'=>'🇱🇻 لتونی'],['text'=>'🇷🇴 رومانی']],
		[['text'=>'🇪🇪 استونی'],['text'=>'🇺🇸 آمریکا'],['text'=>'🇰🇬 قرقیزستان']],
		[['text'=>'🇫🇷 فرانسه'],['text'=>'🇵🇸 فلسطین'],['text'=>'🇰🇭 کامبوج']],
		[['text'=>'🇲🇴 ماکائو'],['text'=>'🇭🇰 هنگ کنگ'],['text'=>'🇧🇷 برزیل']],
		[['text'=>'🇵🇱 لهستان'],['text'=>'🇵🇾 پاراگوئه'],['text'=>'🇳🇱 هلند']],
		[['text'=>'🇱🇻 لیتوانی'],['text'=>'🇲🇬 ماداگاسکار'],['text'=>'🇨🇩 کنگو']],
		[['text'=>'🇳🇬 نیجریه'],['text'=>'🇿🇦 آفریقا'],['text'=>'🇵🇦 پاناما']],
		[['text'=>'🇪🇬 مصر'],['text'=>'🇮🇳 هند'],['text'=>'🇮🇪 ایرلند']],
		[['text'=>'🇨🇮 ساحل عاج'],['text'=>'🇷🇸 صربستان'],['text'=>'🇱🇦 لائوس']],
		[['text'=>'🇲🇦 مراکش'],['text'=>'🇾🇪 یمن'],['text'=>'🇬🇭 غنا']],
		[['text'=>'🇨🇦 کانادا'],['text'=>'🇦🇷 آرژانتین'],['text'=>'🇮🇶 عراق']],
		[['text'=>'🇩🇪 آلمان'],['text'=>'🇨🇲 کامرون'],['text'=>'🇹🇷 ترکیه']],
		[['text'=>'🇳🇿 نیوزیلند'],['text'=>'🇦🇹 اتریش'],['text'=>'🇸🇦 عربستان']],
		[['text'=>'🇲🇽 مکزیک'],['text'=>'🇪🇸 اسپانیا'],['text'=>'🇩🇿 الجزائر']],
		[['text'=>'🇸🇮 اسلوونی'],['text'=>'🇭🇷 کرواسی'],['text'=>'🇧🇾 بلاروس']],
		[['text'=>'🇫🇮 فنلاند'],['text'=>'🇸🇪 سوئد'],['text'=>'🇬🇪 گرجستان']],
		[['text'=>'🇪🇹 اتیوپی'],['text'=>'🇿🇲 زامبیا'],['text'=>'🇵🇰 پاکستان']],
		[['text'=>'🇹🇭 تایلند'],['text'=>'🇹🇼 تایوان'],['text'=>'🇵🇪 پرو']],
		[['text'=>'🇵🇬 گینه نو'],['text'=>'🇹🇩 چاد'],['text'=>'🇲🇱 مالی']],
		[['text'=>'🇧🇩 بنگلادش'],['text'=>'🇬🇳 گینه'],['text'=>'🇱🇰 سری‌لانکا']],
		[['text'=>'🇺🇿 ازبکستان'],['text'=>'🇸🇳 سنگال'],['text'=>'🇨🇴 کلمبیا']],
		[['text'=>'🇻🇪 ونزوئلا'],['text'=>'🇭🇹 هائیتی'],['text'=>'🇺🇸 واشنگتن']],
		[['text'=>'🇲🇩 مولداوی'],['text'=>'🇲🇿 موزامبیک'],['text'=>'🇬🇲 گامبیا']],
		[['text'=>'🇦🇫 اففانستان'],['text'=>'🇺🇬 اوگاندا'],['text'=>'🇦🇺 استرالیا']],
		[['text'=>'💳 شارژ حساب'],['text'=>'📊 استعلام | قیمت ها']],
		[['text'=>'🏛 خانه'],['text'=>'ℹ️ راهنما'],['text'=>'🔙 برگشت']],
		],
         'resize_keyboard'=>true,
       		]);
$service = json_encode([
    'inline_keyboard'=>[
			[['text'=>'💎 تلگرام','callback_data'=>'service1'],['text'=>'📸 اینستاگرام','callback_data'=>'service2'],['text'=>'📞 واتساپ','callback_data'=>'service3']],
			[['text'=>'🔍 گوگل','callback_data'=>'service6'],['text'=>'💡 وایبر','callback_data'=>'service4'],['text'=>'💬 ویچت','callback_data'=>'service5']],
			[['text'=>'📪 فیسبوک','callback_data'=>'service7'],['text'=>'🐦 توییتر','callback_data'=>'service8'],['text'=>'📨 یاهو','callback_data'=>'service11']],
			[['text'=>'💭 ایمو','callback_data'=>'service18'],['text'=>'💲 پیپال','callback_data'=>'service15'],['text'=>'📬 ویکی','callback_data'=>'service20']],
			[['text'=>'📗 لاین','callback_data'=>'service10'],['text'=>'💻 ماکروسافت','callback_data'=>'service9'],['text'=>'🛒 آمازون','callback_data'=>'service21']],
			[['text'=>'🌐 دیگر سرویس ها','callback_data'=>'service12']],
              ]
        ]);			
$start = '🌟 این ربات بصورت اتوماتیک است و میتوانید فقط در ظرف چند ثانیه شماره مجازی و کد اختصاصی شماره مجازی خودتون رو دریافت کنید .

🎊 فروش شماره مجازی برای کشور های مختلف و نرم افزار های مختلف داخل ربات امکان پذیر است .

🗣 با معرفی ربات به دوستان خود 10 درصد از هر افزایش موجودی به عنوان هدیه به شما داده خواهد شد .
👇🏻 از دکمه های زیر استفاده کنید';
$servicearray = ['💎 تلگرام','📸 اینستاگرام','📞 واتساپ','🔍 گوگل - جیمیل','💡 وایبر','💬 ویچت','📨 یاهو','🐦 توییتر','📪 فیسبوک','🛒 آمازون','💻 ماکروسافت','📗 لاین','🌐 دیگر سرویس ها','💭 ایمو','💲 پیپال','📬 ویکی'];
$SERVICE_CODE = ['1','2','3','6','4','5','11','8','7','21','9','10','12','18','15','20'];
$countryarray = ['🇷🇺 روسیه','🇺🇦 اکراین','🇰🇿 قزاقستان','🇮🇷 ایران','🇨🇳 چین','🇵🇭 فیلیپین','🇲🇲 میانمار','🇮🇩 اندونزی','🇲🇾 مالزی','🇰🇪 کنیا','🇹🇿 تانزانیا','🇻🇳 ویتنام','🇬🇧 انگلستان','🇱🇻 لتونی','🇷🇴 رومانی','🇪🇪 استونی','🇺🇸 آمریکا','🇰🇬 قرقیزستان','🇫🇷 فرانسه','🇵🇸 فلسطین','🇰🇭 کامبوج','🇲🇴 ماکائو','🇭🇰 هنگ کنگ','🇧🇷 برزیل','🇵🇱 لهستان','🇵🇾 پاراگوئه','🇳🇱 هلند','🇱🇻 لیتوانی','🇲🇬 ماداگاسکار','🇨🇩 کنگو','🇳🇬 نیجریه','🇿🇦 آفریقا','🇵🇦 پاناما','🇪🇬 مصر','🇮🇳 هند','🇮🇪 ایرلند','🇨🇮 ساحل عاج','🇷🇸 صربستان','🇱🇦 لائوس','🇲🇦 مراکش','🇾🇪 یمن','🇬🇭 غنا','🇨🇦 کانادا','🇦🇷 آرژانتین','🇮🇶 عراق','🇩🇪 آلمان','🇨🇲 کامرون','🇹🇷 ترکیه','🇳🇿 نیوزیلند','🇦🇹 اتریش','🇸🇦 عربستان','🇲🇽 مکزیک','🇪🇸 اسپانیا','🇩🇿 الجزائر','🇸🇮 اسلوونی','🇭🇷 کرواسی','🇧🇾 بلاروس','🇫🇮 فنلاند','🇸🇪 سوئد','🇬🇪 گرجستان','🇪🇹 اتیوپی','🇿🇲 زامبیا','🇵🇰 پاکستان','🇹🇭 تایلند','🇹🇼 تایوان','🇵🇪 پرو','🇵🇬 گینه نو','🇹🇩 چاد','🇲🇱 مالی','🇧🇩 بنگلادش','🇬🇳 گینه','🇱🇰 سری‌لانکا','🇺🇿 ازبکستان','🇸🇳 سنگال','🇨🇴 کلمبیا','🇻🇪 ونزوئلا','🇭🇹 هائیتی','🇺🇸 واشنگتن','🇲🇩 مولداوی','🇲🇿 موزامبیک','🇬🇲 گامبیا','🇦🇫 اففانستان','🇺🇬 اوگاندا','🇦🇺 استرالیا'];
//===========================// main //===========================
if(preg_match('/^(\/start) (.*)/',$text , $prameter)){
if($user["id"] == true){
	jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"⚠️ حساب کاربری شما قبلا ثبت شده است ⚠️
	
$start",
'reply_to_message_id'=>$message_id,
     'reply_markup'=>$home
    		]);
}
else
{
	jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🌹 کاربرا گرامی $first_name به ربات هوشمند و پیشرفته فروش شماره مجازی خوش آمدید .️
	
$start",
'reply_to_message_id'=>$message_id,
     'reply_markup'=>$home
    		]);
$name = str_replace(['`','*','_','[',']','(',')'],null,$first_name);
$user = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$prameter[2]' LIMIT 1"));
$plusmember = $user["member"] + 1;
jijibot('sendmessage',[
	'chat_id'=>$prameter[2],
	'text'=>"🌟 تبریک ! کاربر [$name](tg://user?id=$from_id) با استفاده از لینک دعوت شما وارد ربات شده
📋 یک نفر به مجموع زیر مجموعه های شما اضاف شد ! در صورتی که زیر مجموعه شما از ربات خرید کند شما مطلع خواهید شد

💰 10 درصد از هر خرید زیر مجموعه به عنوان هدیه به موجودی شما اضافه میگردد .
👥 تعداد زیر مجموعه ها : $plusmember",
	'parse_mode'=>'Markdown',
	  	]);
$connect->query("INSERT INTO user (`id` , `inviter`) VALUES ('$from_id' , '$prameter[2]')");
$connect->query("UPDATE `user` SET `member` = '$plusmember' WHERE id = '$prameter[2]' LIMIT 1");	
}
}
elseif(jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>$from_id])->result->status == 'left'){
 jijibot('sendmessage',[
        'chat_id'=>$chat_id,
        "text"=>"📞 برای استفاده از ربات « نامبرکال » ابتدا باید وارد کانال  « $channelname » شوید 
❗️ جهت دریافت آموزش ها ,  اطلاعیه ها و گزارشات حتما عضو کانال شوید .
		
📣 @$channel

👇 بعد از عضویت در کانال روی دکمه « ✅ تایید عضویت » بزنید 👇",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>"✅ تایید عضویت",'callback_data'=>'join']],
              ]
        ])
			]);
if($user["id"] != true)
$connect->query("INSERT INTO `user` (`id`) VALUES ('$from_id')");
}
elseif($text == '🏛 خانه'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🔘 به منوی اصلی بازگشتید
	
$start",
'reply_to_message_id'=>$message_id,
     'reply_markup'=>$home
            ]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");	
}
elseif($text == '🛍 خرید شماره مجازی' or $text == '🔙 برگشت'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🔘 میخواهید در چه برنامه ای ثبت نام کنید ؟ سرویس یا اپلیکیشن مورد نظر خود را انتخاب کنید 👇🏻

⚠️ توجه کنید در انتخاب سرویس دقت کنید ! زیر کد تایید ارسالی بر اساس سرویس دسته بندی خواهد شد .
🚦 درصورتی که در این قسمت نیاز به راهنما دارید از دکمه 'ℹ️ راهنما' استفاده کنید",
'reply_to_message_id'=>$message_id,
     'reply_markup'=>json_encode([
        'keyboard'=>[
		[['text'=>'ℹ️ راهنما'],['text'=>'🏛 خانه']],
		[['text'=>'💎 تلگرام'],['text'=>'📸 اینستاگرام'],['text'=>'📞 واتساپ']],
		[['text'=>'🔍 گوگل'],['text'=>'💡 وایبر'],['text'=>'💬 ویچت']],
		[['text'=>'📪 فیسبوک'],['text'=>'🐦 توییتر'],['text'=>'📨 یاهو']],
		[['text'=>'💭 ایمو'],['text'=>'💲 پیپال'],['text'=>'📬 ویکی']],
		[['text'=>'📗 لاین'],['text'=>'💻 ماکروسافت'],['text'=>'🛒 آمازون']],
		[['text'=>'🌐 دیگر سرویس ها']],
		],
            	'resize_keyboard'=>true,
       		])
            ]);		
}
elseif($text == '📊 استعلام | قیمت ها'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🔘 میخواهید وضعیت کدام سرویس یا اپلیکیشن را برسی کنید ؟ 
🔄 اگر از تلفن همراه استفاده میکنید ! برای نمایش بهتر لیست استعلام گوشی خود را در حالت افقی نگه دارید.
	
👇🏻 سرویس یا اپلیکیشن مورد نظر خود را انتخاب کنید",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$service
		]);		
}
elseif($text == '👤 حساب کاربری'){
$allby = mysqli_num_rows(mysqli_query($connect,"select * from `number` WHERE from_id = '$from_id'"));
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🎫 حساب کاربری شما در ربات خرید شماره مجازی :

🗣 نام : $first_name
🆔 شناسه : $from_id
💡 یوزرنیم شما : $user_name

💰 موجودی شما : {$user["amount"]} تومان
🛍 تعداد خرید : $allby عدد
👥 تعداد زیر مجموعه ها : {$user["member"]} نفر

🎁 با دعوت هر نفر به ربات 10 درصد از هر خرید هر زیر مجموعه را هدیه بگیرید
🌟 برای کسب اطمینان نسبت به ربات و خرید های موفق میتوانید به کانال خرید ها مراجعه کنید",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'💎 خرید های من','callback_data'=>'myby']],
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
     ]);			
}
elseif($text == '↗️ انتقال'){
if($user["amount"] >= 700){
$amount = $user["amount"] - 200;
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"⤴️ برای انتقال موجودی ابتدا شناسه فرد را وارد کنید و در خط پایین مقدار موجودی ارسالی را به تومان وارد کنید !
	
🆔 شناسه کاربری هر فرد در قسمت اطلاعات حساب وی مشخص هست 
💰 حداکثر موجودی قابل انتقال شما : $amount تومان

⚠️ توجه کنید که هزینه انتقال موجودی برای هر بار 200 تومان میباشد ! و حداقل انتقال موجودی 500 تومان میباشد
ℹ️ مثال :
267785153
1000",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$back,
            ]);
$connect->query("UPDATE user SET step = 'sendcoin' WHERE id = '$from_id' LIMIT 1");		
}else{
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>'⚠️ موجودی حساب شما برای انتقال کافی نمی باشد ! برای انتقال موجودی حداقل باید 700 تومان موجودی داشته باشید',
'reply_to_message_id'=>$message_id,
            ]);
}
}
elseif($text == '💳 شارژ حساب'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"💎 برای افزایش موجودی حساب خود بر روی هر یک از مبالغ دلخواه کلیک کرده و پس از منتقل شدن به درگاه امن بانک، آن را پرداخت کنید .
☑️ تمامی پرداخت ها به صورت اتوماتیک بوده و پس از تراکنش موفق مبلغ آن به موجودی حساب شما در ربات افزوده خواهد شد .

🆔 شناسه : $from_id
💰 موجودی شما : {$user["amount"]} تومان

🗣 درصورتی که امکان پرداخت آنلاین و همراه با رمز دوم را ندارد میتوانید از پرداخت آفلاین و همراه با کارت به کارت استفاده کنید !

👮🏻 در صورت بروز هرگونه مشکل و یا انجام نشدن پرداخت کافیست با پشتیبانی در تماس باشید .
🌟 لطفا بسته مورد نظر خود را انتخاب کنید تا به صفحه خرید منتقل شوید 👇🏻",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[['text'=>'💰 1000 تومان','url'=>"$web/pay?amount=1000&id=$from_id"],['text'=>'💰 2000 تومان','url'=>"$web/pay?amount=2000&id=$from_id"]],
	[['text'=>'💰 3000 تومان','url'=>"$web/pay?amount=3000&id=$from_id"],['text'=>'💰 5000 تومان','url'=>"$web/pay?amount=5000&id=$from_id"]],
	[['text'=>'💰 7000 تومان','url'=>"$web/pay?amount=7000&id=$from_id"],['text'=>'💰 10000 تومان','url'=>"$web/pay?amount=10000&id=$from_id"]],
	[['text'=>'💰 15000 تومان','url'=>"$web/pay?amount=15000&id=$from_id"],['text'=>'💰 20000 تومان','url'=>"$web/pay?amount=20000&id=$from_id"]],
	[['text'=>'💰 30000 تومان','url'=>"$web/pay?amount=30000&id=$from_id"],['text'=>'💰 50000 تومان','url'=>"$web/pay?amount=50000&id=$from_id"]],
	[['text'=>'💰 100000 تومان','url'=>"$web/pay?amount=100000&id=$from_id"],['text'=>'💰 200000 تومان','url'=>"$web/pay?amount=200000&id=$from_id"]],
	[['text'=>'💳 خرید آفلاین','callback_data'=>'cart'],['text'=>'💎 مبلغ دلخواه','callback_data'=>'amount']],
              ]
        ])
            ]);			
}
elseif($text == '🗣 دعوت دیگران'){
	$id = jijibot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>'https://t.me/justfortestjiji/592',
	'caption'=>"☎️ ربات شماره مجازی (رایگان؛پولی)

📲 بدون نیاز به سیمکارت اکانت جدید در تلگرام، واتساپ و ... بساز 
و به هرکس دوست داری پیام بده !

🌟 تو این ربات میتونید شماره مجازی همه کشورهارو دریافت کنید به صورت اتوماتیک و در چند ثانیه ! اون هم بصورت رایگان !

👇🏻 همین الان وارد این ربات فوق العاده شو

t.me/$usernamebot?start=$from_id",
    		])->result->message_id;
jijibot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>'https://t.me/justfortestjiji/594',
	'caption'=>"🤖 ربات شماره مجازی (رایگان؛پولی)
🔰 تو این ربات میتونید شماره مجازی همهٔ کشورهارو دریافت کنید به صورت اتوماتیک ودر چند ثانیه! اون هم بصورت رایگان

👇🏻 همین الان وارد این ربات فوق العاده شو

t.me/$usernamebot?start=$from_id",
    		]);
jijibot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>'https://t.me/justfortestjiji/596',
	'caption'=>"☎️ ربات شماره مجازی (رایگان؛پولی)

✅ شماره خام و اختصاصی
💵 ارزان ‌ترین قیمت
☑️ کاملا اتوماتیک
💎 امکان زیرمجموعه گیری و دریافت رایگان شماره مجازی
💯 واقعی و تضمین شده
🏳️‍🌈 شمارهِ بیش از 70 کشور جهان

👇🏻 همین الان وارد این ربات فوق العاده شو

t.me/$usernamebot?start=$from_id",
    		]);
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"👆🏻 هر سه بنر بالا حاوی لینک دعوت شما هستند
🎁 با معرفی ربات به دیگران , 10 درصد از هر افزایش موجودی زیر مجموعه ی شما به عنوان هدیه به شما داده خواهد شد .

💰 فرض کنید 10 نفر کاربر فعال از طریق لینک شما وارد ربات شدند ، اگر یک نفر موجودی حساب خود را به مبلغ 5,000 تومان افزایش دهد حساب شما نیز بصورت رایگان 500 تومان شارژ خواهد شد !
🗣 مثلا روزانه 20 نفر از طریق لینک شما عضو ربات شوند و بصورت میانگین حداقل سه الی چهار نفر موجودی خود را 5,000 تومان و یا مبالغ دیگر افزایش دهند ... !

☑️ پس با زیرمجموعه گیری براحتی میتوانید موجودی حساب خود را رایگان! افزایش دهید .

💰 موجودی شما : {$user["amount"]} تومان
👥 تعداد زیر مجموعه ها : {$user["member"]} نفر",
	'reply_to_message_id'=>$id,
    		]);
}
elseif($text == '☎️ پشتیبانی'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>'👮🏻 همکاران ما در خدمت شما هستن !
 
🔘 در صورت وجود نظر , ایده , گزارش مشکل , پیشنهاد , ایراد سوال , یا انتقاد میتوانید با ما در ارتباط باشید 
💬 لطفا پیام خود را به صورت فارسی و روان ارسال کنید

📁 لطفا در صورت وجود هرگونه مشکل در ربات برای گزارش آن را برای ما ارسال کنید , پیام رو میتونید به صورت عکس یا متن ارسال کنید',
'reply_to_message_id'=>$message_id,
     'reply_markup'=>$back
            ]);
$connect->query("UPDATE user SET step = 'sup' WHERE id = '$from_id' LIMIT 1");	
}
elseif($text == 'ℹ️ راهنما'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🚸 به بخش راهنما خوش امدید

🌟 شما با استفاده از این ربات هوشمند می توانید براحتی شماره مجازی کشورهای مختلف جهان را تهیه کنید و در اپلیکیشن های ارتباطی اکانت جدید بسازید !
♋️ تمام روند خرید و دریافت شماره و دریافت کد کاملا اتوماتیک انجام می شود .

📴 با کم ترین هزینه ممکن در سریع ترین زمان و امن ترین حالت ممکن شماره مجازی خود را خریداری نمایید .

👇🏼 از منو زیر جهت راهنمایی استفاده کنید",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
        'keyboard'=>[
		[['text'=>'📲 شماره مجازی چیست']],
		[['text'=>'🔔 سوالات'],['text'=>'📽 آموزش خرید']],
		[['text'=>'❗️ نکات'],['text'=>'ℹ️ قوانین'],['text'=>'💡 درباره']],
		[['text'=>'🏛 خانه'],['text'=>'💎 کسب درآمد']]
		],
            	'resize_keyboard'=>true,
       		])
            ]);	
}
elseif(in_array($text, $servicearray)){
$explode = explode(' ', $text);
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"✅ سرویس شما با موفقیت '$explode[1]' تنظیم شد
💰 موجودی شما : {$user["amount"]} تومان
	
❗️ نکات قبل از خرید

1️⃣ این شماره ها فقط برای راه اندازی سرویس های مختلف می باشند و هر شماره فقط برای یک سرویس قابل استفاده بوده و فقط یکبار پیامک ورود را دریافت می کند .

2️⃣ شماره ها اختصاصی بوده و اصولا تا زمانی که از نرم افزار مربوطه خارج نشوید قابل استفاده هستند .
3️⃣ ربات تا زمانی که کد تأیید پیامکی را به شما ندهد هزینه ای از شما کسر نمی کند .

🌍 کشور مورد نظر را انتخاب کنید 👇🏻",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$country
 ]);
$SERVICE_CODE = str_replace($servicearray , $SERVICE_CODE ,$text);
$connect->query("UPDATE user SET service = '$SERVICE_CODE' WHERE id = '$from_id' LIMIT 1");	
}
elseif(in_array($text, $countryarray)){
$explode = explode(' ', $text);
$COUNTRY_CODE = str_replace($countryarray ,['1','2','3','78','4','5','6','7','8','9','10','11','12','13','14','15','16','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','17','79','80','81','82','83','84'], $text);
$checkstats = checkstats($user['service'] , $COUNTRY_CODE);
if($checkstats[0] == 'true'){
if($user["amount"] >= $checkstats[1]){
$getnumber = getnumber($user['service'] , $COUNTRY_CODE);
if($getnumber->RESULT == 1){
$description = ($checkstats[2] == true)?"\n🌟 این شماره برای سرویس تلگرام ریپوریت نیست !":null;	
$service = ['1'=>'تلگرام','2'=>'اینستاگرام','3'=>'واتساپ','4'=>'وایبر','5'=>'ویچت','6'=>'گوگل - جیمیل','7'=>'فیسبوک','8'=>'توییتر','9'=>'ماکروسافت','10'=>'لاین','11'=>'یاهو','12'=>'دیگر سرویس ها','13'=>'آمازون','18'=>'ایمو','15'=>'پیپال','20'=>'ویکی'];
      jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"✅ شماره کشور '$explode[1]' با موفقیت ساخته شد			
📞 شماره مجازی شما : +{$getnumber->NUMBER}

☎️ پیش شماره شما : +{$getnumber->AREACODE}
💳 هزینه شماره : $checkstats[1] تومان

ℹ️ شماره را همراه با پیش شماره در سرویس '{$service[$user['service']]}' وارد کنید و پس از یک دقیقه روی دریافت کد ضربه بزنید !$description

⚠️ مهلت استفاده  و وارد کردن شماره در سرویس مورد نظر 10 دقیقه است و پس از آن امکان دریافت کد نمیباشد .
❗️ درصورت وجود هر گونه مشکل و تمایل نداشتن به خرید میتونید خرید خود را لغو کنید ! مبلغی از شما کسر نخواهد شد",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$code	
          ]);
$connect->query("INSERT INTO `number` (`id` , `from_id` , `service` , `country` , `number` , `amount` , `areacode`) VALUES ('{$getnumber->ID}' , '$from_id' , '{$service[$user['service']]}' , '$explode[1]'  , '{$getnumber->NUMBER}' , '$checkstats[1]' , '{$getnumber->AREACODE}')");
$connect->query("UPDATE user SET step = 'code' WHERE id = '$from_id' LIMIT 1");
}else{
jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"⚠️ شماره ای برای ارائه در حال حاظر برای کشور '$explode[1]' وجود ندارد !
ℹ️ برای مشاهده لیست کشور های قابل ارائه از دکمه '📊 استعلام | قیمت ها' استفاده کنید
			
🌟 لطفا کشور دیگری را انتخاب کنید یا ساعاتی دیگر مجدد امتحان کنید 👇🏻",
'reply_to_message_id'=>$message_id,
	'reply_markup'=>$country		
   ]);
}
}else{
  jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"💳 موجودی شما برای خرید شماره کشور '$explode[1]' کافی نمیباشد !			
🛍 قیمت شماره مورد نظر : $checkstats[1] تومان
💰 موجودی حساب شما : {$user["amount"]} تومان

🆙 ابتدا باید موجوی خود را افزایش دهید . برای افزایش موجودی کافیست از دکمه '💳 شارژ حساب' استفاده کنید 👇🏻
🎁 با معرفی ربات به دوستان خود 10 درصد از هر افزایش موجودی به عنوان هدیه به شما داده خواهد شد .",
'reply_to_message_id'=>$message_id,
	'reply_markup'=>$country		
   ]);
}
}else{
jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"⚠️ شماره ای برای ارائه در حال حاظر برای کشور '$explode[1]' وجود ندارد !
ℹ️ برای مشاهده لیست کشور های قابل ارائه از دکمه '📊 استعلام | قیمت ها' استفاده کنید
			
🌟 لطفا کشور دیگری را انتخاب کنید یا ساعاتی دیگر مجدد امتحان کنید 👇🏻",
'reply_to_message_id'=>$message_id,
	'reply_markup'=>$country		
   ]);
}
}
elseif($text == '💎 کسب درآمد'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🆓 کسب درآمد از فروش شماره با موجودی رایگان !

💰 فرض کنید 10 نفر کاربر فعال از طریق لینک شما وارد ربات شدند ، اگر یک نفر موجودی حساب خود را به مبلغ 5,000 تومان افزایش دهد حساب شما نیز بصورت رایگان 500 تومان شارژ خواهد شد !
🗣 مثلا روزانه 20 نفر از طریق لینک شما عضو ربات شوند و بصورت میانگین حداقل سه الی چهار نفر موجودی خود را 5,000 تومان و یا مبالغ دیگر افزایش دهند ... !

☑️ پس با زیرمجموعه گیری براحتی میتوانید موجودی حساب خود را رایگان! افزایش دهید .

✅ با کمی تبلیغات به راحتی میتوانید میلیونر شوید . جهت دریافت لینک مخصوص زیر مجموعه گیری خود به منو اصلی برگشته و دکمه زیر مجموعه گیری را انتخاب نمایید .

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == '📽 آموزش خرید'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"💡 آموزش خرید شماره مجازی در ربات نامبرکال به صورت متنی :
  
1️⃣ ابتدا از قسمت استعلام میتوانید لیست شماره های موجود در سرویس مورد نظر رو همراه با قیمت و پیش شماره مشاهده کنید

2️⃣ بعد از انتخاب شماره مورد نظر براساس سلیقه و معیارهای دیگر موجودی حساب خود را به اندازه قیمت شماره مورد نظر شارژ کنید

3️⃣ بعد از شارژ کردن حساب خود حال نوبت به خرید شماره مجازی میرسد ابتدا به قسمت خرید شماره مجازی در منوی اصلی مراجعه کنید

4️⃣ سرویس مورد نظر خود را انتخاب کنید تا به عنوان سرویس پیشفرض شما تنظیم شود

5️⃣ سپس بعد از دریافت لیست کشور ها , کشور مورد نظر خود را انتخاب کنید و منتظر باشید تا شماره مجازی ساخته شود

6️⃣ پس از ارسال شماره مجازی شما توسط ربات , شماره مجازی داده شده را در سرویس مورد نظر وارد کنید

6️⃣ حالا به مرحله آخر رسیدم پس از یک دقیقه انتظار روی دکمه دریافت کد ضربه بزنید تا کد ورود به سرویس مورد نظر را دریافت کنید

🌟 به همین راحتی و فقط در چند مرحله شماره مجازی اختصاصی خود را بسازید , و لذت ببرید

[📹 آموزش ویدیوی در آپارات](https://www.aparat.com/v/8jYy3)

🗣 سوال یا مشکلی دارید ؟ به قسمت های دیگر راهنما مراجعه کنید یا با پشتیبانی در تماس باشید

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'parse_mode'=>'Markdown',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == '💡 درباره'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🤖 درباره ربات فروش شماره مجازی  :

🤗 شما با استفاده از این ربات هوشمند شماره مجازی کشور ها مختلف را به صورت ارزان خریدار می کنید .
♋️ تمام روند خرید و دریافت شماره و ثبت نام در برنامه مورد نظر کاملا اتوماتیک انجام می شود .

📴 با کم ترین هزینه ممکن در سریع ترین زمان و امن ترین حالت ممکن شماره مجازی خود را خریداری نمایید .
🌟 شما با استفاده از این ربات هوشمند می توانید براحتی شماره مجازی کشورهای مختلف جهان را تهیه کنید و در اپلیکیشن های ارتباطی اکانت جدید بسازید !

⛔️ کلیه حقوق این ربات و وبسایت متعلق به ربات بوده و هرگونه کپی برداری از ایده ها و متون ممنوع بوده و پیگرد قانونی خواهد داشت.

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == '❗️ نکات'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"📢 نکاتی که باید توجه داشته باشید 👇🏻
	
❗️ نکات قبل از خرید

1️⃣ این شماره ها فقط برای راه اندازی سرویس های مختلف می باشند و هر شماره فقط برای یک سرویس قابل استفاده بوده و فقط یکبار پیامک ورود را دریافت می کند .
2️⃣ شماره ها اختصاصی بوده و اصولا تا زمانی که از نرم افزار مربوطه خارج نشوید قابل استفاده هستند .

3️⃣ ربات تا زمانی که کد تأیید پیامکی را به شما ندهد هزینه ای از شما کسر نمی کند .

❗️ چرا کد تأیید دریافت نمی‌شود ؟

در 💎 تلگرام :

1️⃣ از نسخه های اصلی تلگرام استفاده کنید و از نسخه های غیر رسمی استفاده نکنید مثل موبوگرام و...
2️⃣ اقدام به تعویض ip خود کنید میتوانید برای تغییر ip خود از فیلترشکن ها و خاموش و روشن کردن شبکه خود استفاده کنید .
3️⃣ در صورت عدم پاسخ و دریافت نشدن کد شماره کشور دیگری را امتحان کنید .

در 📞 واتساپ :

1️⃣ نرم افزار یک بار حذف و مجدد نصب کنید .
2️⃣ اقدام به تعویض ip خود کنید میتوانید برای تغییر ip خود از فیلترشکن ها و خاموش و روشن کردن شبکه خود استفاده کنید .
3️⃣ در صورت عدم پاسخ و دریافت نشدن کد شماره کشور دیگری را امتحان کنید .

در 🔍 گوگل :

1️⃣ در قدم اول توجه داشته باشید گوگل محدودیت های زیادی برای استفاده از شماره مجازی قرار داده است و باید از شماره کشور های مختلف را تست کنید .
2️⃣ اقدام به تعویض ip خود کنید میتوانید برای تغییر ip خود از فیلترشکن ها و خاموش و روشن کردن شبکه خود استفاده کنید .
3️⃣ در صورت عدم پاسخ و دریافت نشدن کد شماره کشور دیگری را امتحان کنید .
4️⃣ این روند را تا جایی ادامه دهید تا موفق به دریافت کد شوید 

در 🌐 دیگر سرویس ها :

1️⃣ در قدم اول نسبت به تحریم کشور های مختلف توسط سرویس مورد نظر اطلاع کسب کنید .
2️⃣ اقدام به تعویض ip خود کنید میتوانید برای تغییر ip خود از فیلترشکن ها و خاموش و روشن کردن شبکه خود استفاده کنید .
3️⃣ در صورت عدم پاسخ و دریافت نشدن کد شماره کشور دیگری را امتحان کنید .
4️⃣ این روند را تا جایی ادامه دهید تا موفق به دریافت کد شوید .

🗣 نکات نتوانست به شما کمک کند ؟ هنوز مشکل در دریافت کد دارید ؟ با پشتیبانی در منوی اصلی در تماس باشید .

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == 'ℹ️ قوانین'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🚫 قوانین و توضیحات :

1️⃣ شماره ها اختصاصی هستند و معمولا فقط به یک نفر داده میشوند توجه داشته باشید که ما مسئول از بین رفتن هیچ اکانتی نیستیم به این دلیل که ما سازنده این شماره ها نیستم و از مدیریت ما خارج میباشد 

2️⃣ دلیل به اتمام رسیدن و یا ناموجود بودن یک شماره استفاده بیش از حد از کشور مورد نظر در سرویس مورد نظر است , این محدودیت برطرف خواهد شد و باید ساعاتی بعد مجدد تست کنید .

3️⃣ فراهم شدن شماره کشور مورد نظر توسط پنل های خارجی انجام میپذیرد و توسط ما غیر قابل فراهم شدن است .

4️⃣ شماره ها توسط پنل خارجی تامین میشوند و ربات تنها متصل کننده کاربر به پنل است ‌.

5️⃣ تمامی شماره های ربات خام هستند یعنی قبل از شما ثبت نام نکرده اند ، بجز برخی شماره های کشور چین و روسیه که برای جلوگیری از این شماره رو در سرویس مورد نظر چک کنید و سپس اقدام به گرفتن کد کنید

6️⃣ اما لازم به ذکر هست که پس از دریافت کد دیگه به هیچکس اون شماره فروخته نمیشه و کسی به اکانت شما نمیتواند از طریق خط وارد شود .

7️⃣ لطفا شماره رو به صورت کامل وارد کنید و  برای این که دچار اشتباه نشید شماره رو کپی کنید

8️⃣ لطفا شماره رو به صورت کامل وارد کنید و  برای این که دچار اشتباه نشید شماره رو کپی کنید

7️⃣ در صورتی که شماره های زیادی با IP شما ثبت نام شده باشند اقدام به تعویض ip خود کنید .

8️⃣ در صورتی که کد دریافت نکردید باید برگشت بزنید و شماره جدید دریافت کنید ، برای دریافت کد باید شماره را در اپ اصلی آن نرم افزار وارد کنید تا کد دریافت نکنید پولی از شما کسر نخواهد شد

9️⃣ پس از دریافت کد و تحویل شماره به کاربر ربات هیچ مسئولیتی را در قبال حذف شدن اکانت یا سرویس نمی پذیرد

❗️ در صورت عمل نکردن به بندهای بالا عواقب آن بر عهده شماست و وجهی بازگشت داده نمی‌شود .

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == '📲 شماره مجازی چیست'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🤔 شماره مجازی چیست ؟

🔹 - شماره مجازی شماره ای است که بصورت مجازی فقط و فقط یکبار قادر به دریافت و ارسال کد تایید برای اپلیکیشن مربوطه است که این شماره ها بصورت مستقیم از اپراتورهای کشور ارائه دهنده این شماره ها دریافت می شود.

⁉️ شماره مجازی چه کاربردی داره ؟!

🔸 - هنگام ثبت نام در اپلیکیشن های پیامرسان مانند تلگرام، واتساپ، آمازون، فیسبوک و ... باید از شماره تلفن خود به عنوان شناسه و ثبت نام در آن اپلیکیشن استفاده کنید.

🔹 - اگر از کاربرانی هستید که علاقه ای به اشتراک گذاری شماره ی اصلی خود ندارید و یا نیاز به ثبت نام چندین اکانت در این برنامه ها دارید و یا دوست دارید بصورت ناشناس و مخفیانه در آن اپلیکیشن باشید ، می توانید از شماره های مجازی استفاده کنید.

🔸 - بسیاری از افراد به دلایل مختلف مانند مدیریت یک اکانت دیگر برای مباحث کاری یا ... نیاز به اکانت دوم دارند تا بتوانند در عین ارتباط داشتن با مشتریان، از تلگرام شخصی و خصوصی خود نیز استفاده کنند.

🔹 - با شماره مجازی میتوان بدون سیمکارت و بدون نیاز به احراز هویت و کارت ملی صاحب شماره از کشورهای مختلف جهان شوید و در اپلیکیشن های پیامرسان با شماره ی خارجی! حضور پیدا کنید .

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
elseif($text == '🔔 سوالات'){
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🤔  سوالات متداول

❓شماره خریدم کد نمیده چیکار کنم ؟

▫️جواب : ابتدا فیلم آموزش نحوه خرید را مشاهده کنید. جهت دریافت کد پس از اطمینان از ارسال کد توسط اپلیکیشن درخواستی به شماره مورد نظر یک دقیقه صبر کنید و سپس بر روی دکمه دریافت کد کلیک کنید ، اگر پس از گذشت 5 دقیقه از دریافت شماره، کد را دریافت نکردید بر روی دکمه بازگشت کلیک کنید سپس مجددا نسبت به دریافت شماره جدید و کد اقدام نمایید.
▫️همچنین :  درصورت وجود هر گونه مشکل و تمایل نداشتن به خرید میتونید خرید خود را لغو کنید ! مبلغی از حساب شما کسر نخواهد شد

❓شماره رو وارد تلگرام کردم اما میگه مسدوده یا اشتباهه، چرا ؟ 

▫️جواب : این حالت بیشتر برای شماره چین ، روسیه و آمریکا پیش میاد. بر روی دکمه بازگشت کلیک کنید سپس مجددا نسبت به دریافت شماره جدید و کد اقدام نمایید.

❓کد تایید گرفتم اما وارد آپ نکردم، باید چیکار کنم ؟
▫️جواب : متاسفانه امکان بازگشت وجه در چنین وضعیتی وجود ندارد. چون پول شماره در پنل خارجی همزمان با دریافت کد از حساب ما کم میشود‌.

❓شماره مجازی خریدم اما بعد از چند دقیقه خود به خود پاک شد! چرا؟
▫️جواب :  علت پاک شدن (دلیت اکانت) شماره ها، حساس شدن آن اپلیکیشن نسبت به آیپی دستگاه شماست ؛
- جهت جلوگیری از این مورد باید آیپی خود را عوض کنید.

▫️همچنین : با خاموش کردن اینترنت به مدت چند دقیقه و یا تغییر سرور (IP) فیلترشکن میتوانید آیپی خود را تغییر دهید.
و یا دستگاه خود را یکبار خاموش و روشن کنید.

❓ آیا میتونم برای دومین بار کد تایید رو از ربات بگیرم؟
▫️جواب : خیر ؛ این شماره ها مجازی هستند ، برای هر شماره فقط یکبار کد تایید جهت ثبت نام در اپلیکیشن موردنظر از طرف پنل ربات برای شما ارسال می شود.

❓ شماره مجازی میخوام بخرم اما ناموجوده، چرا؟
▫️جواب : استعلام شماره های موجود در ربات را چک کنید .
▫️ - اگر همچنان آن کشور ناموجود باشد، میتوانید از کشورهای دیگر شماره بسازید.

❓ شماره مجازی کدام کشور ( از بین این همه کشور! ) برای من مناسب است ؟
▫️ جواب : بسته به استفاده خود و نیز هزینه آن انواع مختلف کشور وجود دارد و انتخاب شما متنوع است .

❓ گزارش مسدودی چه تفاوتی با لغو خرید دارد ؟
▫️ جواب : اگر شماره ای که خرید میکنید در سرویس مورد نظرتون دچار مسدودی بود یا کد به شماره ارسال نمیشد میتونید این شماره رو در ربات گزارش مسدودی دهید تا به کاربران دیگر نیز ارسال نشود


🗣 سوالتان در این بخش نبود ؟ به منوی اصلی برگردید و با پشتیبانی در تماس باشید 

🤖 @$usernamebot",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
			[['text'=>'🛍 کانال خرید ها','url'=>"https://t.me/$channelby"]],
              ]
        ])
            ]);	
}
//===========================// panel admin //===========================
elseif($text == '/panel' and $tc == 'private' and in_array($from_id,$admin)){
jijibot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"📍 ادمین عزیز به پنل مدریت ربات خوش امدید",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
	  	      [['text'=>"📍 آمار ربات"],['text'=>"📍 افزایش موجودی"]],
 [['text'=>"📍 ارسال به کاربران"],['text'=>"📍 فروارد به کاربران"]],
   ],
      'resize_keyboard'=>true
   ])
 ]);
}
elseif($text == 'برگشت 🔙' and $tc == 'private' and in_array($from_id,$admin)){
jijibot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"🚦 به منوی مدیریت بازگشتید",
	  'reply_markup'=>json_encode([
    'keyboard'=>[
	  	      [['text'=>"📍 آمار ربات"],['text'=>"📍 افزایش موجودی"]],
 [['text'=>"📍 ارسال به کاربران"],['text'=>"📍 فروارد به کاربران"]],
   ],
      'resize_keyboard'=>true
   ])
    ]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");		
}
elseif($text == '📍 آمار ربات' and $tc == 'private' and in_array($from_id,$admin)){
$alluser = mysqli_num_rows(mysqli_query($connect,"select id from `user`"));
$allnumber = mysqli_num_rows(mysqli_query($connect,"select id from `number`"));
$allpay = mysqli_num_rows(mysqli_query($connect,"select id from `pay`"));
$balance = getbalance();
				jijibot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"🤖 آمار ربات شما
		
📍 تعداد کاربران : $alluser
📍 موجودی پنل : {$balance->BALANCE} {$balance->CURRENCY}
📍 تعداد خرید ها : $allnumber
📍 تعداد پرداخت ها : $allpay",
		]);
		}
elseif ($text == '📍 ارسال به کاربران' and $tc == 'private' and in_array($from_id,$admin)) {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 لطفا متن یا رسانه خود را ارسال کنید [میتواند شامل عکس باشد]  همچنین میتوانید رسانه را همراه با کشپن [متن چسپیده به رسانه ارسال کنید]",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[['text'=>"برگشت 🔙"]]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$connect->query("UPDATE user SET step = 'sendtoall' WHERE id = '$from_id' LIMIT 1");
}
elseif ($text == '📍 فروارد به کاربران' and $tc == 'private' and in_array($from_id,$admin)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 لطفا پیام خود را فوروارد کنید [پیام فوروارد شده میتوانید از شخص یا کانال باشد]",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[['text'=>"برگشت 🔙"]]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$connect->query("UPDATE user SET step = 'fortoall' WHERE id = '$from_id' LIMIT 1");		
}
elseif ($text == '📍 افزایش موجودی' and $tc == 'private' and in_array($from_id,$admin)){
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"📍 لطفا در خط اول ایدی فرد و در خط دوم میزان موجودی را وارد کنید
📍 اگر میخواهید موجودی فر را کم کنید از علامت - منفی استفاده کنید",
	   'reply_markup'=>json_encode([
    'keyboard'=>[
	[['text'=>"برگشت 🔙"]]
   ],
      'resize_keyboard'=>true
   ])
 ]);
$connect->query("UPDATE user SET step = 'sendadmin' WHERE id = '$from_id' LIMIT 1");		
}
//===========================// data //===========================
elseif($data == 'join'){
$tch = jijibot('getChatMember',['chat_id'=>"@$channel",'user_id'=>"$fromid"])->result->status;
if($tch == 'member' or $tch == 'creator' or $tch == 'administrator'){
	jijibot('sendmessage',[
	'chat_id'=>$chatid,
	'text'=>"☑️ عضویت شما تایید شد ! به بخش اصلی ربات خوش آمدید
	
$start",
    'reply_to_message_id'=>$messageid,
    'reply_markup'=>$home
     ]);
}else{
       jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => "❌ هنوز داخل کانال « @$channel » عضو نیستی",
            'show_alert' =>true
        ]);
}
}
elseif($data == 'myby'){
$order = mysqli_query($connect,"SELECT * FROM `number` WHERE `from_id` = '$fromid' ORDER BY `id` DESC LIMIT 5");
if(mysqli_num_rows($order) > 0){
while($row = mysqli_fetch_assoc($order)){
$result = $result."🆔 شماره سفارش : {$row['id']}\n📱 سرویس : {$row['service']}\n🌍 کشور : {$row['country']}\n🔢 شماره : +{$row['number']}\n⏰ زمان خرید : {$row['time']}\n💰 قیمت : {$row['amount']} تومان\n💬 کد : {$row['code']}\n━ ━ ━\n";
}
	jijibot('sendmessage',[
	'chat_id'=>$chatid,
	'text'=>"🛍 لیست پنج خرید اخیر شما , این لیست تنها جهت اطلاع شماست و کاردبرد دیگری ندارد
	
$result",
    'reply_to_message_id'=>$messageid,
    'reply_markup'=>$home
     ]);
}else{
  jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => "❌ شما تا کنون خریدی در ربات انجام نداده اید",
            'show_alert' =>true
        ]);
}
}
elseif($data == 'pay'){
jijibot('editmessagetext',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,
	'text'=>"💎 برای افزایش موجودی حساب خود بر روی هر یک از مبالغ دلخواه کلیک کرده و پس از منتقل شدن به درگاه امن بانک، آن را پرداخت کنید .
☑️ تمامی پرداخت ها به صورت اتوماتیک بوده و پس از تراکنش موفق مبلغ آن به موجودی حساب شما در ربات افزوده خواهد شد .

🆔 شناسه : $fromid
💰 موجودی شما : {$user["amount"]} تومان

🗣 درصورتی که امکان پرداخت آنلاین و همراه با رمز دوم را ندارید میتوانید از پرداخت آفلاین و همراه با کارت به کارت استفاده کنید !

👮🏻 در صورت بروز هرگونه مشکل و یا انجام نشدن پرداخت کافیست با پشتیبانی در تماس باشید .
🌟 لطفا بسته مورد نظر خود را انتخاب کنید تا به صفحه خرید منتقل شوید 👇🏻",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[['text'=>'💰 1000 تومان','url'=>"$web/pay?amount=1000&id=$fromid"],['text'=>'💰 2000 تومان','url'=>"$web/pay?amount=2000&id=$fromid"]],
	[['text'=>'💰 3000 تومان','url'=>"$web/pay?amount=3000&id=$fromid"],['text'=>'💰 5000 تومان','url'=>"$web/pay?amount=5000&id=$fromid"]],
	[['text'=>'💰 7000 تومان','url'=>"$web/pay?amount=7000&id=$fromid"],['text'=>'💰 10000 تومان','url'=>"$web/pay?amount=10000&id=$fromid"]],
	[['text'=>'💰 15000 تومان','url'=>"$web/pay?amount=15000&id=$fromid"],['text'=>'💰 20000 تومان','url'=>"$web/pay?amount=20000&id=$fromid"]],
	[['text'=>'💰 30000 تومان','url'=>"$web/pay?amount=30000&id=$fromid"],['text'=>'💰 50000 تومان','url'=>"$web/pay?amount=50000&id=$fromid"]],
	[['text'=>'💰 100000 تومان','url'=>"$web/pay?amount=100000&id=$fromid"],['text'=>'💰 200000 تومان','url'=>"$web/pay?amount=200000&id=$fromid"]],
	[['text'=>'💳 خرید آفلاین','callback_data'=>'cart'],['text'=>'💎 مبلغ دلخواه','callback_data'=>'amount']],
              ]
        ])
    		]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$fromid' LIMIT 1");
}
elseif($data == 'selectservice'){
jijibot('editmessagetext',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,
	'text'=>"🔘 میخواهید وضعیت کدام سرویس یا اپلیکیشن را برسی کنید ؟ 
🔄 اگر از تلفن همراه استفاده میکنید ! برای نمایش بهتر لیست استعلام گوشی خود را در حالت افقی نگه دارید.
	
👇🏻 سرویس یا اپلیکیشن مورد نظر خود را انتخاب کنید",
	'reply_markup'=>$service
    		]);
}
elseif($data == 'cart'){
jijibot('editmessagetext',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,
	'text'=>"💳 درصورتی که امکان خرید به صورت آنلاین و با رمز دوم ندارید میتوانید پرداخت را آفلاین انجام دهید !

💎 میزان موجودی که نیاز دارید را به صورت کارت به کارت به حساب زیر انتقال دهید .
📲 اسکرین شات پرداخت را برای پشتیبانی ارسال کنید . تا موجودی شما توسط مدیریت افزایش یابد 👇🏻

$cardinfo

🔢 همچنین شما میتوانید موجودی خود را با کد شارژ نیز افزایش دهید , برای افزایش موجودی با استفاده از کارت شارژ از دکمه پشتیبانی استفاده کنید",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[['text'=>'🔙 برگشت','callback_data'=>'pay']],
              ]
        ])
    		]);
}
elseif($data == 'amount'){
jijibot('editmessagetext',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,
	'text'=>'🗣 در صورتی که مبلغ مورد نظر شما در بین بسته ها نبود در این قسمت میتوانید به میزان دلخواه حساب خود را شارژ کنید
	
⚠️ توجه کنید مبلغ را به تومان وارد کنید و حداقل مبلغی که میتوانید خرید کنید 500 تومان و حداکثر 200000 تومان است
💰 مبلغی که میخواهید حساب خود را شارژ کنید وارد کنید 👇🏻',
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[['text'=>'🔙 برگشت','callback_data'=>'pay']],
              ]
        ])
    		]);
$connect->query("UPDATE user SET step = 'amount' WHERE id = '$fromid' LIMIT 1");	
}
elseif($data == 'page2'){
for($z = 1;$z <=  count($countryarray);$z++){
$stats = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `stats` WHERE `service` = '{$user['service']}' AND `id` = '$z' LIMIT 1"));
$amount[] = ($stats['amount'] == true)?$stats['amount']:'❗️'; $info[] = ($stats == true)?'✅':'❌'; }
      jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => 'ℹ️ به صفحه دوم منتقل شدید',
        ]);
	jijibot('editMessageReplyMarkup',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,	
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>"🌏 کشور",'callback_data'=>'text'],['text'=>"💰 قیمت",'callback_data'=>'text'],['text'=>"🔢 کد",'callback_data'=>'text'],['text'=>"☑️ وضعیت",'callback_data'=>'text']],
[['text'=>'🇧🇷 برزیل','callback_data'=>'text'],['text'=>"$amount[23]",'callback_data'=>'text'],['text'=>'+55','callback_data'=>'text'],['text'=>"$info[23]",'callback_data'=>'text']],
[['text'=>'🇵🇱 لهستان','callback_data'=>'text'],['text'=>"$amount[24]",'callback_data'=>'text'],['text'=>'+48','callback_data'=>'text'],['text'=>"$info[24]",'callback_data'=>'text']],
[['text'=>'🇵🇾 پاراگوئه','callback_data'=>'text'],['text'=>"$amount[25]",'callback_data'=>'text'],['text'=>'+595','callback_data'=>'text'],['text'=>"$info[25]",'callback_data'=>'text']],
[['text'=>'🇳🇱 هلند','callback_data'=>'text'],['text'=>"$amount[26]",'callback_data'=>'text'],['text'=>'+31','callback_data'=>'text'],['text'=>"$info[26]",'callback_data'=>'text']],
[['text'=>'🇱🇻 لیتوانی','callback_data'=>'text'],['text'=>"$amount[27]",'callback_data'=>'text'],['text'=>'+370','callback_data'=>'text'],['text'=>"$info[27]",'callback_data'=>'text']],
[['text'=>'🇲🇬 ماداگاسکار','callback_data'=>'text'],['text'=>"$amount[28]",'callback_data'=>'text'],['text'=>'+261','callback_data'=>'text'],['text'=>"$info[28]",'callback_data'=>'text']],
[['text'=>'🇨🇩 کنگو','callback_data'=>'text'],['text'=>"$amount[29]",'callback_data'=>'text'],['text'=>'+243','callback_data'=>'text'],['text'=>"$info[29]",'callback_data'=>'text']],
[['text'=>'🇳🇬 نیجریه','callback_data'=>'text'],['text'=>"$amount[30]",'callback_data'=>'text'],['text'=>'+234','callback_data'=>'text'],['text'=>"$info[30]",'callback_data'=>'text']],
[['text'=>'🇿🇦 آفریقا','callback_data'=>'text'],['text'=>"$amount[31]",'callback_data'=>'text'],['text'=>'+27','callback_data'=>'text'],['text'=>"$info[31]",'callback_data'=>'text']],
[['text'=>'🇵🇦 پاناما','callback_data'=>'text'],['text'=>"$amount[32]",'callback_data'=>'text'],['text'=>'+507','callback_data'=>'text'],['text'=>"$info[32]",'callback_data'=>'text']],
[['text'=>'🇪🇬 مصر','callback_data'=>'text'],['text'=>"$amount[33]",'callback_data'=>'text'],['text'=>'+20','callback_data'=>'text'],['text'=>"$info[33]",'callback_data'=>'text']],
[['text'=>'🇮🇳 هند','callback_data'=>'text'],['text'=>"$amount[34]",'callback_data'=>'text'],['text'=>'+91','callback_data'=>'text'],['text'=>"$info[34]",'callback_data'=>'text']],
[['text'=>'🇮🇪 ایرلند','callback_data'=>'text'],['text'=>"$amount[35]",'callback_data'=>'text'],['text'=>'+353','callback_data'=>'text'],['text'=>"$info[35]",'callback_data'=>'text']],
[['text'=>'🇨🇮 ساحل عاج','callback_data'=>'text'],['text'=>"$amount[36]",'callback_data'=>'text'],['text'=>'+225','callback_data'=>'text'],['text'=>"$info[36]",'callback_data'=>'text']],
[['text'=>'🇷🇸 صربستان','callback_data'=>'text'],['text'=>"$amount[37]",'callback_data'=>'text'],['text'=>'+381','callback_data'=>'text'],['text'=>"$info[37]",'callback_data'=>'text']],
[['text'=>'🇱🇦 لائوس','callback_data'=>'text'],['text'=>"$amount[38]",'callback_data'=>'text'],['text'=>'+856','callback_data'=>'text'],['text'=>"$info[38]",'callback_data'=>'text']],
[['text'=>'🇲🇦 مراکش','callback_data'=>'text'],['text'=>"$amount[39]",'callback_data'=>'text'],['text'=>'+212','callback_data'=>'text'],['text'=>"$info[39]",'callback_data'=>'text']],
[['text'=>'🇾🇪 یمن','callback_data'=>'text'],['text'=>"$amount[40]",'callback_data'=>'text'],['text'=>'+967','callback_data'=>'text'],['text'=>"$info[40]",'callback_data'=>'text']],
[['text'=>'🇬🇭 غنا','callback_data'=>'text'],['text'=>"$amount[41]",'callback_data'=>'text'],['text'=>'+233','callback_data'=>'text'],['text'=>"$info[41]",'callback_data'=>'text']],
[['text'=>'🇨🇦 کانادا','callback_data'=>'text'],['text'=>"$amount[42]",'callback_data'=>'text'],['text'=>'+1','callback_data'=>'text'],['text'=>"$info[42]",'callback_data'=>'text']],
[['text'=>'🇦🇷 آرژانتین','callback_data'=>'text'],['text'=>"$amount[43]",'callback_data'=>'text'],['text'=>'+54','callback_data'=>'text'],['text'=>"$info[43]",'callback_data'=>'text']],
[['text'=>'🇮🇶 عراق','callback_data'=>'text'],['text'=>"$amount[44]",'callback_data'=>'text'],['text'=>'+964','callback_data'=>'text'],['text'=>"$info[44]",'callback_data'=>'text']],
[['text'=>'🇩🇪 آلمان','callback_data'=>'text'],['text'=>"$amount[45]",'callback_data'=>'text'],['text'=>'+49','callback_data'=>'text'],['text'=>"$info[45]",'callback_data'=>'text']],
[['text'=>"1️⃣ صفحه اول",'callback_data'=>"service{$user['service']}"],['text'=>"3️⃣ صفحه سوم",'callback_data'=>"page3"],['text'=>"4️⃣ صفحه چهارم",'callback_data'=>"page4"]],
[['text'=>'🔙 برگشت','callback_data'=>'selectservice']],
              ]
        ])
			]);
}
elseif($data == 'page3'){
for($z = 1;$z <=  count($countryarray);$z++){
$stats = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `stats` WHERE `service` = '{$user['service']}' AND `id` = '$z' LIMIT 1"));
$amount[] = ($stats['amount'] == true)?$stats['amount']:'❗️'; $info[] = ($stats == true)?'✅':'❌'; }
      jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => 'ℹ️ به صفحه سوم منتقل شدید',
        ]);
	jijibot('editMessageReplyMarkup',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,	
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>"🌏 کشور",'callback_data'=>'text'],['text'=>"💰 قیمت",'callback_data'=>'text'],['text'=>"🔢 کد",'callback_data'=>'text'],['text'=>"☑️ وضعیت",'callback_data'=>'text']],
[['text'=>'🇨🇲 کامرون','callback_data'=>'text'],['text'=>"$amount[46]",'callback_data'=>'text'],['text'=>'+237','callback_data'=>'text'],['text'=>"$info[46]",'callback_data'=>'text']],
[['text'=>'🇹🇷 ترکیه','callback_data'=>'text'],['text'=>"$amount[47]",'callback_data'=>'text'],['text'=>'+90','callback_data'=>'text'],['text'=>"$info[47]",'callback_data'=>'text']],
[['text'=>'🇳🇿 نیوزیلند','callback_data'=>'text'],['text'=>"$amount[48]",'callback_data'=>'text'],['text'=>'+64','callback_data'=>'text'],['text'=>"$info[48]",'callback_data'=>'text']],
[['text'=>'🇦🇹 اتریش','callback_data'=>'text'],['text'=>"$amount[49]",'callback_data'=>'text'],['text'=>'+43','callback_data'=>'text'],['text'=>"$info[49]",'callback_data'=>'text']],
[['text'=>'🇸🇦 عربستان','callback_data'=>'text'],['text'=>"$amount[50]",'callback_data'=>'text'],['text'=>'+966','callback_data'=>'text'],['text'=>"$info[50]",'callback_data'=>'text']],
[['text'=>'🇲🇽 مکزیک','callback_data'=>'text'],['text'=>"$amount[51]",'callback_data'=>'text'],['text'=>'+52','callback_data'=>'text'],['text'=>"$info[51]",'callback_data'=>'text']],
[['text'=>'🇪🇸 اسپانیا','callback_data'=>'text'],['text'=>"$amount[52]",'callback_data'=>'text'],['text'=>'+34','callback_data'=>'text'],['text'=>"$info[52]",'callback_data'=>'text']],
[['text'=>'🇩🇿 الجزائر','callback_data'=>'text'],['text'=>"$amount[53]",'callback_data'=>'text'],['text'=>'+213','callback_data'=>'text'],['text'=>"$info[53]",'callback_data'=>'text']],
[['text'=>'🇸🇮 اسلوونی','callback_data'=>'text'],['text'=>"$amount[54]",'callback_data'=>'text'],['text'=>'+386','callback_data'=>'text'],['text'=>"$info[54]",'callback_data'=>'text']],
[['text'=>'🇭🇷 کرواسی','callback_data'=>'text'],['text'=>"$amount[55]",'callback_data'=>'text'],['text'=>'+385','callback_data'=>'text'],['text'=>"$info[55]",'callback_data'=>'text']],
[['text'=>'🇧🇾 بلاروس','callback_data'=>'text'],['text'=>"$amount[56]",'callback_data'=>'text'],['text'=>'+375','callback_data'=>'text'],['text'=>"$info[56]",'callback_data'=>'text']],
[['text'=>'🇫🇮 فنلاند','callback_data'=>'text'],['text'=>"$amount[57]",'callback_data'=>'text'],['text'=>'+358','callback_data'=>'text'],['text'=>"$info[57]",'callback_data'=>'text']],
[['text'=>'🇸🇪 سوئد','callback_data'=>'text'],['text'=>"$amount[58]",'callback_data'=>'text'],['text'=>'+46','callback_data'=>'text'],['text'=>"$info[58]",'callback_data'=>'text']],
[['text'=>'🇬🇪 گرجستان','callback_data'=>'text'],['text'=>"$amount[59]",'callback_data'=>'text'],['text'=>'+995','callback_data'=>'text'],['text'=>"$info[59]",'callback_data'=>'text']],
[['text'=>'🇪🇹 اتیوپی','callback_data'=>'text'],['text'=>"$amount[60]",'callback_data'=>'text'],['text'=>'+251','callback_data'=>'text'],['text'=>"$info[60]",'callback_data'=>'text']],
[['text'=>'🇿🇲 زامبیا','callback_data'=>'text'],['text'=>"$amount[61]",'callback_data'=>'text'],['text'=>'+260','callback_data'=>'text'],['text'=>"$info[61]",'callback_data'=>'text']],
[['text'=>'🇵🇰 پاکستان','callback_data'=>'text'],['text'=>"$amount[62]",'callback_data'=>'text'],['text'=>'+92','callback_data'=>'text'],['text'=>"$info[62]",'callback_data'=>'text']],
[['text'=>'🇹🇭 تایلند','callback_data'=>'text'],['text'=>"$amount[63]",'callback_data'=>'text'],['text'=>'+66','callback_data'=>'text'],['text'=>"$info[63]",'callback_data'=>'text']],
[['text'=>'🇹🇼 تایوان','callback_data'=>'text'],['text'=>"$amount[64]",'callback_data'=>'text'],['text'=>'+886','callback_data'=>'text'],['text'=>"$info[64]",'callback_data'=>'text']],
[['text'=>'🇵🇪 پرو','callback_data'=>'text'],['text'=>"$amount[65]",'callback_data'=>'text'],['text'=>'+51','callback_data'=>'text'],['text'=>"$info[65]",'callback_data'=>'text']],
[['text'=>'🇵🇬 گینه نو','callback_data'=>'text'],['text'=>"$amount[66]",'callback_data'=>'text'],['text'=>'+675','callback_data'=>'text'],['text'=>"$info[66]",'callback_data'=>'text']],
[['text'=>"1️⃣ صفحه اول",'callback_data'=>"service{$user['service']}"],['text'=>"2️⃣ صفحه دوم",'callback_data'=>"page2"],['text'=>"4️⃣ صفحه چهارم",'callback_data'=>"page4"]],
[['text'=>'🔙 برگشت','callback_data'=>'selectservice']],
              ]
        ])
			]);
}
elseif($data == 'page4'){
for($z = 1;$z <=  count($countryarray);$z++){
$stats = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `stats` WHERE `service` = '{$user['service']}' AND `id` = '$z' LIMIT 1"));
$amount[] = ($stats['amount'] == true)?$stats['amount']:'❗️'; $info[] = ($stats == true)?'✅':'❌'; }
      jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => 'ℹ️ به صفحه چهارم منتقل شدید',
        ]);
	jijibot('editMessageReplyMarkup',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,	
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>"🌏 کشور",'callback_data'=>'text'],['text'=>"💰 قیمت",'callback_data'=>'text'],['text'=>"🔢 کد",'callback_data'=>'text'],['text'=>"☑️ وضعیت",'callback_data'=>'text']],
[['text'=>'🇹🇩 چاد','callback_data'=>'text'],['text'=>"$amount[67]",'callback_data'=>'text'],['text'=>'+235','callback_data'=>'text'],['text'=>"$info[67]",'callback_data'=>'text']],
[['text'=>'🇲🇱 مالی','callback_data'=>'text'],['text'=>"$amount[68]",'callback_data'=>'text'],['text'=>'+223','callback_data'=>'text'],['text'=>"$info[68]",'callback_data'=>'text']],
[['text'=>'🇧🇩 بنگلادش','callback_data'=>'text'],['text'=>"$amount[69]",'callback_data'=>'text'],['text'=>'+880','callback_data'=>'text'],['text'=>"$info[69]",'callback_data'=>'text']],
[['text'=>'🇬🇳 گینه','callback_data'=>'text'],['text'=>"$amount[70]",'callback_data'=>'text'],['text'=>'+224','callback_data'=>'text'],['text'=>"$info[70]",'callback_data'=>'text']],
[['text'=>'🇱🇰 سری‌لانکا','callback_data'=>'text'],['text'=>"$amount[71]",'callback_data'=>'text'],['text'=>'+94','callback_data'=>'text'],['text'=>"$info[71]",'callback_data'=>'text']],
[['text'=>'🇺🇿 ازبکستان','callback_data'=>'text'],['text'=>"$amount[72]",'callback_data'=>'text'],['text'=>'+998','callback_data'=>'text'],['text'=>"$info[72]",'callback_data'=>'text']],
[['text'=>'🇸🇳 سنگال','callback_data'=>'text'],['text'=>"$amount[73]",'callback_data'=>'text'],['text'=>'+221','callback_data'=>'text'],['text'=>"$info[73]",'callback_data'=>'text']],
[['text'=>'🇨🇴 کلمبیا','callback_data'=>'text'],['text'=>"$amount[74]",'callback_data'=>'text'],['text'=>'+57','callback_data'=>'text'],['text'=>"$info[74]",'callback_data'=>'text']],
[['text'=>'🇻🇪 ونزوئلا','callback_data'=>'text'],['text'=>"$amount[75]",'callback_data'=>'text'],['text'=>'+58','callback_data'=>'text'],['text'=>"$info[75]",'callback_data'=>'text']],
[['text'=>'🇭🇹 هائیتی','callback_data'=>'text'],['text'=>"$amount[76]",'callback_data'=>'text'],['text'=>'+509','callback_data'=>'text'],['text'=>"$info[76]",'callback_data'=>'text']],
[['text'=>'🇺🇸 واشنگتن','callback_data'=>'text'],['text'=>"$amount[16]",'callback_data'=>'text'],['text'=>'+1','callback_data'=>'text'],['text'=>"$info[16]",'callback_data'=>'text']],
[['text'=>'🇲🇩 مولداوی','callback_data'=>'text'],['text'=>"$amount[78]",'callback_data'=>'text'],['text'=>'+373','callback_data'=>'text'],['text'=>"$info[78]",'callback_data'=>'text']],
[['text'=>'🇲🇿 موزامبیک','callback_data'=>'text'],['text'=>"$amount[79]",'callback_data'=>'text'],['text'=>'+258','callback_data'=>'text'],['text'=>"$info[79]",'callback_data'=>'text']],
[['text'=>'🇬🇲 گامبیا','callback_data'=>'text'],['text'=>"$amount[80]",'callback_data'=>'text'],['text'=>'+220','callback_data'=>'text'],['text'=>"$info[80]",'callback_data'=>'text']],
[['text'=>'🇦🇫 اففانستان','callback_data'=>'text'],['text'=>"$amount[81]",'callback_data'=>'text'],['text'=>'+93','callback_data'=>'text'],['text'=>"$info[81]",'callback_data'=>'text']],
[['text'=>'🇺🇬 اوگاندا','callback_data'=>'text'],['text'=>"$amount[82]",'callback_data'=>'text'],['text'=>'+256','callback_data'=>'text'],['text'=>"$info[82]",'callback_data'=>'text']],
[['text'=>'🇦🇺 استرالیا','callback_data'=>'text'],['text'=>"$amount[83]",'callback_data'=>'text'],['text'=>'+61','callback_data'=>'text'],['text'=>"$info[83]",'callback_data'=>'text']],
[['text'=>"1️⃣ صفحه اول",'callback_data'=>"service{$user['service']}"],['text'=>"2️⃣ صفحه دوم",'callback_data'=>"page2"],['text'=>"3️⃣ صفحه سوم",'callback_data'=>"page3"]],
[['text'=>'🔙 برگشت','callback_data'=>'selectservice']],
              ]
        ])
			]);
}	
elseif($data == 'text'){
      jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => 'ℹ️ این دکمه برای نمایش اطلاعات ساخته شده است و کاربرد دیگری ندارد',
            'show_alert' =>true
        ]);
}	
elseif(preg_match('/^service(.*)/', $data , $paramter)){
jijibot('answercallbackquery', [
            'callback_query_id' =>$callback_query_id,
            'text' => "ℹ️ به صفحه اول منتقل شدید",
        ]);
$service = ['1'=>'تلگرام','2'=>'اینستاگرام','3'=>'واتساپ','4'=>'وایبر','5'=>'ویچت','6'=>'گوگل - جیمیل','7'=>'فیسبوک','8'=>'توییتر','9'=>'ماکروسافت','10'=>'لاین','11'=>'یاهو','12'=>'دیگر سرویس ها','21'=>'آمازون'];
$check = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `check` LIMIT 1"));
for($z = 1;$z <=  count($countryarray);$z++){
$stats = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `stats` WHERE `service` = '$paramter[1]' AND `id` = '$z' LIMIT 1"));
$amount[] = ($stats['amount'] == true)?$stats['amount']:'❗️'; $info[] = ($stats == true)?'✅':'❌'; }
jijibot('editmessagetext',[
    'chat_id'=>$chatid,
    'message_id'=>$messageid,
     'text'=>"✅ سرویس شما با موفقیت '{$service[$paramter[1]]}' تنظیم شد
ℹ️ لیست وضعیت شماره های موجود و استعلام شماره ها هر ده دقیقه یک بار بروز خواهد شد .

⏱ آخرین بروز رسانی : {$check["check"]}

✅ = موجود میباشد
❌ = موجود نیست
❗️ = قیمت نامشخص

🔄 اگر از تلفن همراه استفاده میکنید ! برای نمایش بهتر لیست استعلام گوشی خود را در حالت افقی نگه دارید.",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>"🌏 کشور",'callback_data'=>'text'],['text'=>"💰 قیمت",'callback_data'=>'text'],['text'=>"🔢 کد",'callback_data'=>'text'],['text'=>"☑️ وضعیت",'callback_data'=>'text']],
[['text'=>'🇷🇺 روسیه','callback_data'=>'text'],['text'=>"$amount[0]",'callback_data'=>'text'],['text'=>'+7','callback_data'=>'text'],['text'=>"$info[0]",'callback_data'=>'text']],
[['text'=>'🇺🇦 اکراین','callback_data'=>'text'],['text'=>"$amount[1]",'callback_data'=>'text'],['text'=>'+380','callback_data'=>'text'],['text'=>"$info[1]",'callback_data'=>'text']],
[['text'=>'🇰🇿 قزاقستان','callback_data'=>'text'],['text'=>"$amount[2]",'callback_data'=>'text'],['text'=>'+7','callback_data'=>'text'],['text'=>"$info[2]",'callback_data'=>'text']],
[['text'=>'🇮🇷 ایران','callback_data'=>'text'],['text'=>"$amount[77]",'callback_data'=>'text'],['text'=>'+98','callback_data'=>'text'],['text'=>"$info[77]",'callback_data'=>'text']],
[['text'=>'🇨🇳 چین','callback_data'=>'text'],['text'=>"$amount[3]",'callback_data'=>'text'],['text'=>'+86','callback_data'=>'text'],['text'=>"$info[3]",'callback_data'=>'text']],
[['text'=>'🇵🇭 فیلیپین','callback_data'=>'text'],['text'=>"$amount[4]",'callback_data'=>'text'],['text'=>'+63','callback_data'=>'text'],['text'=>"$info[4]",'callback_data'=>'text']],
[['text'=>'🇲🇲 میانمار','callback_data'=>'text'],['text'=>"$amount[5]",'callback_data'=>'text'],['text'=>'+95','callback_data'=>'text'],['text'=>"$info[5]",'callback_data'=>'text']],
[['text'=>'🇮🇩 اندونزی','callback_data'=>'text'],['text'=>"$amount[6]",'callback_data'=>'text'],['text'=>'+62','callback_data'=>'text'],['text'=>"$info[6]",'callback_data'=>'text']],
[['text'=>'🇲🇾 مالزی','callback_data'=>'text'],['text'=>"$amount[7]",'callback_data'=>'text'],['text'=>'+60','callback_data'=>'text'],['text'=>"$info[7]",'callback_data'=>'text']],
[['text'=>'🇰🇪 کنیا','callback_data'=>'text'],['text'=>"$amount[8]",'callback_data'=>'text'],['text'=>'+254','callback_data'=>'text'],['text'=>"$info[8]",'callback_data'=>'text']],
[['text'=>'🇹🇿 تانزانیا','callback_data'=>'text'],['text'=>"$amount[9]",'callback_data'=>'text'],['text'=>'+255','callback_data'=>'text'],['text'=>"$info[9]",'callback_data'=>'text']],
[['text'=>'🇻🇳 ویتنام','callback_data'=>'text'],['text'=>"$amount[10]",'callback_data'=>'text'],['text'=>'+84','callback_data'=>'text'],['text'=>"$info[10]",'callback_data'=>'text']],
[['text'=>'🇬🇧 انگلستان','callback_data'=>'text'],['text'=>"$amount[11]",'callback_data'=>'text'],['text'=>'+44','callback_data'=>'text'],['text'=>"$info[11]",'callback_data'=>'text']],
[['text'=>'🇱🇻 لتونی','callback_data'=>'text'],['text'=>"$amount[12]",'callback_data'=>'text'],['text'=>'+371','callback_data'=>'text'],['text'=>"$info[12]",'callback_data'=>'text']],
[['text'=>'🇷🇴 رومانی','callback_data'=>'text'],['text'=>"$amount[13]",'callback_data'=>'text'],['text'=>'+40','callback_data'=>'text'],['text'=>"$info[13]",'callback_data'=>'text']],
[['text'=>'🇪🇪 استونی','callback_data'=>'text'],['text'=>"$amount[14]",'callback_data'=>'text'],['text'=>'+372','callback_data'=>'text'],['text'=>"$info[14]",'callback_data'=>'text']],
[['text'=>'🇺🇸 آمریکا','callback_data'=>'text'],['text'=>"$amount[15]",'callback_data'=>'text'],['text'=>'+1','callback_data'=>'text'],['text'=>"$info[15]",'callback_data'=>'text']],
[['text'=>'🇰🇬 قرقیزستان','callback_data'=>'text'],['text'=>"$amount[17]",'callback_data'=>'text'],['text'=>'+966','callback_data'=>'text'],['text'=>"$info[17]",'callback_data'=>'text']],
[['text'=>'🇫🇷 فرانسه','callback_data'=>'text'],['text'=>"$amount[18]",'callback_data'=>'text'],['text'=>'+33','callback_data'=>'text'],['text'=>"$info[18]",'callback_data'=>'text']],
[['text'=>'🇵🇸 فلسطین','callback_data'=>'text'],['text'=>"$amount[19]",'callback_data'=>'text'],['text'=>'+972','callback_data'=>'text'],['text'=>"$info[19]",'callback_data'=>'text']],
[['text'=>'🇰🇭 کامبوج','callback_data'=>'text'],['text'=>"$amount[20]",'callback_data'=>'text'],['text'=>'+855','callback_data'=>'text'],['text'=>"$info[20]",'callback_data'=>'text']],
[['text'=>'🇲🇴 ماکائو','callback_data'=>'text'],['text'=>"$amount[21]",'callback_data'=>'text'],['text'=>'+853','callback_data'=>'text'],['text'=>"$info[21]",'callback_data'=>'text']],
[['text'=>'🇭🇰 هنگ کنگ','callback_data'=>'text'],['text'=>"$amount[22]",'callback_data'=>'text'],['text'=>'+852','callback_data'=>'text'],['text'=>"$info[22]",'callback_data'=>'text']],
[['text'=>"2️⃣ صفحه دوم",'callback_data'=>"page2"],['text'=>"3️⃣ صفحه سوم",'callback_data'=>"page3"],['text'=>"4️⃣ صفحه چهارم",'callback_data'=>"page4"]],
[['text'=>'🔙 برگشت','callback_data'=>'selectservice']],
              ]
        ])
    		]);
$connect->query("UPDATE `user` SET `service` = '$paramter[1]' WHERE id = '$fromid' LIMIT 1");	
}
//===========================// step //===========================
elseif($user['step'] == 'code' && $tc == 'private'){
$order = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `number` WHERE `from_id` = '$from_id' ORDER BY `id` DESC LIMIT 1"));
switch($text){
case '💬 دریافت کد':
$checkstatus = ordertool('checkstatus' , $order['id']);
switch($checkstatus->RESULT){
case '2':
$plusamount = $user['amount'] - $order['amount'];
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"✅ کد با موفقیت دریافت شد
💭 کد ورود شما به برنامه : {$checkstatus->CODE}

💰 موجودی جدید حساب شما : $plusamount تومان
🛍 با تشکر از خرید شما ! گزارش خرید به کانال ما @$channelby ارسال شد . 
👮🏻 درصورت وجود هرگونه مشکل کافیست با پشتیبانی در تماس باشید",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$home
 ]);
$connect->query("UPDATE `number` SET `code` = '{$checkstatus->CODE}' , `time` = '".jdate('Y/n/j H:i:s')."' WHERE id = '{$order['id']}' LIMIT 1");
$connect->query("UPDATE `user` SET `step` = 'none' , `amount` = '$plusamount' WHERE id = '$from_id' LIMIT 1");
ordertool('closenumber' , $order['id']);
$str_number = mb_substr($order['number'],'0"','7').'***';
$str_id = mb_substr($from_id,'0','5').'***';
$allby = mysqli_num_rows(mysqli_query($connect,"select * from `number` WHERE from_id = '$from_id'")); + 1;
jijibot('sendmessage',[
	'chat_id'=>"@$channelby",
	'text'=>"✅ گزارش #خرید #موفق
⏰ در تاریخ ".jdate('J F')." و  در ساعت ".jdate('H:i:s')."

ℹ️ نحوه خرید شماره مجازی در ربات :

1️⃣ وارد ربات @$usernamebot شوید .
2️⃣ اعتبار خود را به مبلغ {$order['amount']} افزایش دهید .
3️⃣ وارد بخش خرید شماره مجازی شوید و شماره کشور '{$order['country']}' دریافت کنید .

⤵️ اطلاعات خرید انجام شده",
'reply_markup'=>json_encode([
        'inline_keyboard'=>[
		[['text'=>"🌏 کشور",'callback_data'=>"text"],['text'=>"{$order['country']}",'callback_data'=>"text"]],
		[['text'=>"🔘 سرویس",'callback_data'=>"text"],['text'=>"{$order['service']}",'callback_data'=>"text"]],
		[['text'=>"📞 شماره",'callback_data'=>"text"],['text'=>"+$str_number",'callback_data'=>"text"]],
		[['text'=>"💎 قیمت",'callback_data'=>"text"],['text'=>"{$order['amount']} تومان",'callback_data'=>"text"]],
		[['text'=>"👤 شناسه کاربر",'callback_data'=>"text"],['text'=>"$str_id",'callback_data'=>"text"]],
		[['text'=>"🛍 تعداد خرید",'callback_data'=>"text"],['text'=>"$allby",'callback_data'=>"text"]],
		[['text'=>"☎️ ربات خرید شماره مجازی",'url'=>"https://t.me/$usernamebot"]],
        ]
        ])
            ]);	
break;
case '1':
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"❗️ کد فعال سازی هنوز ارسال نشده است !
📞 شماره مجازی شما : +{$order['number']}

ℹ️ شماره را همراه با پیش شماره در سرویس '{$order['service']}' وارد کنید و پس از یک دقیقه روی دریافت کد ضربه بزنید !

❗️ درصورت وجود هر گونه مشکل و تمایل نداشتن به خرید میتونید خرید خود را لغو کنید ! مبلغی از شما کسر نخواهد شد .
⚠️ از ارسال پشت سر هم دریافت کد خودداری کنید .",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$code
  ]);
break;
default :
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"⏰ زمان برای دریافت کد برای سفارش شما به پایان رسید , یا ممکن است سفارش با خطا مواجه شده باشد .
ℹ️ حداکثر زمان برای دریافت کد 10 دقیقه میباشد و پس از آن سفارش لغو خواهد شد
	
❌ سفارش شما لغو شد و مبلغی از حساب شما کسر نشد ! میتوانید نسبت به خرید دوباره اقدام کنید
👮🏻 درصورت وجود هرگونه مشکل کافیست با پشتیبانی در تماس باشید",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$home
  ]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$connect->query("DELETE FROM `number` WHERE id = '{$order['id']}' LIMIT 1");
ordertool('cancelnumber' , $order['id']);
}
break;
case '❌ لغو خرید':
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"☑️ خرید شما با موفقیت لغو شد و مبلغی از حساب شما کسر نشد !
🗣  در صورت وجود هر گونه ایراد کافیست با پشتیبانی در تماس باشید .

🔘 به منوی اصلی بازگشتید . گزینه مورد نظر خودت رو انتخاب کن 👇🏻",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$home
  ]);
ordertool('cancelnumber' , $order['id']);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$connect->query("DELETE FROM `number` WHERE id = '{$order['id']}' LIMIT 1");
break;
case '❗️ گزارش مسدودی':
jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"☑️ خرید شما با موفقیت لغو شد و مبلغی از حساب شما کسر نشد !
❗️ گزارش مسدودیت شماریه '+{$order['number']}' به مدیریت ارسال شد .

🗣  در صورت وجود هر گونه ایراد کافیست با پشتیبانی در تماس باشید .
🔘 به منوی اصلی بازگشتید . گزینه مورد نظر خودت رو انتخاب کن 👇🏻",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$home
  ]);
ordertool('bannumber' , $order['id']);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$connect->query("DELETE FROM `number` WHERE id = '{$order['id']}' LIMIT 1");
break;
default :
jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
            'text'=>"📞 شماره مجازی شما : +{$order['number']}

☎️ پیش شماره شما : +{$order['areacode']}
💳 هزینه شماره : {$order['amount']} تومان

ℹ️ شماره را همراه با پیش شماره در سرویس '{$order['service']}' وارد کنید و پس از یک دقیقه روی دریافت کد ضربه بزنید !

⚠️ مهلت استفاده  و وارد کردن شماره در سرویس مورد نظر 10 دقیقه است و پس از آن امکان دریافت کد نمیباشد .
❗️ درصورت وجود هر گونه مشکل و تمایل نداشتن به خرید میتونید خرید خود را لغو کنید ! مبلغی از شما کسر نخواهد شد",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$code	
          ]);
}
}
elseif($user['step'] == 'amount' && $tc == 'private'){
if($text >= 500 and $text <= 200000){
			jijibot('sendmessage',[       
			'chat_id'=>$chat_id,
			'text'=>"✅ صفحه افزایش موجودی با مبلغ $text تومان با موفقیت برای شما ساخته شد
			
☑️ تمامی پرداخت ها به صورت اتوماتیک بوده و پس از تراکنش موفق مبلغ آن به موجودی حساب شما در ربات افزوده خواهد شد .

🆔 شناسه : $from_id
💰 موجودی شما : {$user["amount"]} تومان

🗣 درصورتی که امکان پرداخت آنلاین و همراه با رمز دوم را ندارد میتوانید از پرداخت آفلاین و همراه با کارت به کارت استفاده کنید !
🌟 لطفا روی دکمه زیر ضربه بزنید تا به صفحه خرید منتقل شوید 👇🏻",
			'reply_to_message_id'=>$message_id,
			'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[['text'=>"💰 $text تومان",'url'=>"$web/pay?amount=$text&id=$from_id"]],
    [['text'=>"💳 خرید آفلاین",'callback_data'=>'cart'],['text'=>'🔙 برگشت','callback_data'=>'pay']],
              ]
        ])
	]);	
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
}else{
			jijibot('sendmessage',[       
			'chat_id'=>$chat_id,
			'text'=>"❗️ مبلغ وارد شده نادرست است ! لطفا اعداد را به لاتین و از وارد کردن حروف اضافی خودداری کنید
			
⚠️ توجه کنید مبلغ را به تومان وارد کنید و حداقل مبلغی که میتوانید خرید کنید 500 تومان و حداکثر 200000 تومان است
💰 مبلغی که میخواهید حساب خود را شارژ کنید وارد کنید 👇🏻",
			'reply_to_message_id'=>$message_id,
						'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"💳 خرید آفلاین",'callback_data'=>'cart'],['text'=>'🔙 برگشت','callback_data'=>'pay']],
              ]
        ])
	]);	
}
}
elseif($user['step'] == 'sendcoin' && $tc == 'private'){
$all = explode("\n", $text);
$getuser = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$all[0]' LIMIT 1"));
if($getuser == true and $all[0] != $from_id){
if($all[1] >= 500 and $all[1] + 200 <= $user["amount"]){
$nowamount = $user["amount"] - ($all[1] + 200);
$pluscoin = $getuser["amount"] + $all[1] ;
            jijibot('sendmessage',[  
			'chat_id'=>$chat_id,
			'text'=>"✅ انتقال موجودی با موفقیت انجام شد
			
↗️ مقدار موجودی انتقال داده شده : $all[1]
💰 میزان جدید موجودی شما : $nowamount
💳 میزان قبلی موجودی شما : {$user["amount"]}
👤 کاربر مورد نظر : [$all[0]](tg://user?id=$all[0])

⚠️ توجه کنید هزینه انتقال 200 تومان میباشد که از حساب شما کسر شد .
↗️ گزارش انتقال شما در کانال @$channelby ارسال شد",
'parse_mode'=>'Markdown',
'reply_to_message_id'=>$message_id,
	'reply_markup'=>$home
	]);	
			jijibot('sendmessage',[       
			'chat_id'=>$all[0],
			'text'=>"🎁 $all[1] تومان موجودی به شما هدیه داده شد !

💰 میزان جدید موجودی شما : $pluscoin
💳 میزان قبلی موجودی شما : {$getuser["amount"]}
👤 کاربر ارسال کننده : [$from_id](tg://user?id=$from_id)

↗️ گزارش دریافت شما در کانال @$channelby ارسال شد",
'parse_mode'=>'Markdown',
	]);	
$connect->query("UPDATE user SET step = 'none' , amount = '$nowamount' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET amount = '$pluscoin' WHERE id = '$all[0]' LIMIT 1");
$sendid = mb_substr($from_id,'0','5').'***';
$reid = mb_substr($all[0],'0','5').'***';
jijibot('sendmessage',[
	'chat_id'=>"@$channelby",
	'text'=>"✅ گزارش #انتقال #موفق
⏰ در تاریخ ".jdate('J F')." و  در ساعت ".jdate('H:i:s')."

ℹ️ نحوه انتقال موجودی در ربات :

1️⃣ وارد ربات @$usernamebot شوید .
2️⃣ از دکمه '↗️ انتقال' برای انتقال موجودی استفاده کنید .
3️⃣ ایدی فرد را به همراه موجودی دلخواه وارد کنید

⤵️ اطلاعات انتقال موجودی",
'reply_markup'=>json_encode([
    'inline_keyboard'=>[
				[['text'=>"📤 فرستنده",'callback_data'=>"text"],['text'=>"$sendid",'callback_data'=>"text"]],
				[['text'=>"📥 دریافت کننده",'callback_data'=>"text"],['text'=>"$reid",'callback_data'=>"text"]],
				[['text'=>"💰 میزان",'callback_data'=>"text"],['text'=>"$all[1] تومان",'callback_data'=>"text"]],
				[['text'=>"☎️ ربات خرید شماره مجازی",'url'=>"https://t.me/$usernamebot"]],
              ]
        ])
            ]);	
}else{
$reamount = $user["amount"] - 200;
			jijibot('sendmessage',[       
			'chat_id'=>$chat_id,
			'text'=>"❗️ میزان موجودی که میخواهید انتقال دهید از موجودی حساب شما بیش تر است !
☑️ حداکثر موجودی قابل انتقال شما : $reamount
💰 موجودی شما : {$user["amount"]} تومان

⚠️ توجه کنید که هزینه انتقال موجودی برای هر بار 200 تومان میباشد ! و حداقل انتقال موجودی 500 تومان میباشد
ℹ️ مثال :
267785153
1000",
'reply_to_message_id'=>$message_id,
        'reply_markup'=>$back
	]);
}
}else{
			jijibot('sendmessage',[       
			'chat_id'=>$chat_id,
			'text'=>"❌ کاربر مورد نظر یافت نشد ! 
ℹ️ شناسه فرد را با دقت وارد کنید و از وجود داشتن حساب برای شناسه در ربات اطمینان کسب کنید			
🆔 شناسه کاربری هر فرد در قسمت اطلاعات حساب وی مشخص هست 

⚠️ توجه کنید که هزینه انتقال موجودی برای هر بار 200 تومان میباشد ! و حداقل انتقال موجودی 500 تومان میباشد
ℹ️ مثال :
267785153
1000",
'reply_to_message_id'=>$message_id,
        'reply_markup'=>$back
	]);	
}
}
elseif($user['step'] == 'sup' && $tc == 'private'){
	jijibot('sendmessage',[       
		'chat_id'=>$chat_id,
		'text'=>"🗣 پیام شما با موفقیت ارسال شد منتظر پاسخ پشتیبانی باشید",
		'reply_to_message_id'=>$message_id,
        'reply_markup'=>$back
	]);	
   jijibot('ForwardMessage',[
          'chat_id'=>$admin[0],
          'from_chat_id'=>$chat_id,
          'message_id'=>$message_id
]);
}
elseif($user['step'] == 'sendadmin' && $tc == 'private') {
$all = explode("\n", $text);	
$getuser = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$all[0]' LIMIT 1"));
$pluscoin = $getuser["amount"] + $all[1] ;
			jijibot('sendmessage',[       
			'chat_id'=>$chat_id,
			'text'=>"انتقال موجودی با موفقیت انجام شد ✅",
	         ]);	
			jijibot('sendmessage',[       
			'chat_id'=>$all[0],
			'text'=>"🎁 $all[1] تومان موجودی به شما هدیه داده شد !

💰 میزان جدید موجودی شما : $pluscoin
💳 میزان قبلی موجودی شما : {$getuser["amount"]}
👮🏻 هدیه از طرف مدیریت ربات !",
	]);	
$connect->query("UPDATE user SET `amount` = '$pluscoin' WHERE id = '$all[0]' LIMIT 1");
}
elseif ($user['step'] == 'sendtoall' && $tc == 'private') {
$photo = $message->photo[count($message->photo)-1]->file_id;
$caption = $update->message->caption;
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"✔️ پیام شما با موفقیت برای ارسال همگانی تنظیم شد",
 ]);
$connect->query("UPDATE `user` SET `step` = 'none' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE `sendall` SET step = 'send' , `text` = '$text$caption' , `chat` = '$photo' LIMIT 1");			
}
elseif ($user['step'] == 'fortoall' && $tc == 'private') {
         jijibot('sendmessage',[
        	'chat_id'=>$chat_id,
        	'text'=>"✔️ پیام شما با موفقیت به عنوان فوروارد همگانی تنظیم شد",
 ]);
$connect->query("UPDATE `user` SET `step` = 'none' WHERE id = '$from_id' LIMIT 1");	
$connect->query("UPDATE `sendall` SET `step` = 'forward' , `text` = '$message_id' , `chat` = '$chat_id' LIMIT 1");		
}
//=====================================================================
elseif($update->message->text && $update->message->reply_to_message && $from_id == $admin[0] && $tc == 'private'){
	jijibot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"☑️ پاسخ شما برای فرد ارسال شد"
		]);
	jijibot('sendmessage',[
        'chat_id'=>$update->message->reply_to_message->forward_from->id,
        'text'=>"👮🏻 پاسخ پشتیبان برای شما : `$text`",
'parse_mode'=>'MarkDown'
		]);
}
elseif($update->message and $tc == 'private'){
	jijibot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"🌹 کاربرا گرامی $first_name به ربات هوشمند و پیشرفته فروش شماره مجازی خوش آمدید .️
	
$start",
   'reply_to_message_id'=>$message_id,
    'reply_markup'=>$home
]);
if($user["id"] != true)
$connect->query("INSERT INTO `user` (`id`) VALUES ('$from_id')");
}
?>

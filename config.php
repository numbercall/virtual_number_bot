<?php
/* * * * * * * * * * * 
REBORNTEAMBOT
* * * * * * * * * * */
error_reporting(0);
date_default_timezone_set('Asia/Tehran'); 
//========================== // token // ==============================
define('API_KEY','');
//========================== // config // ==============================
$admin = ['259080698','000000000','000000000']; // ایدی ادمین ها را ماننده این الگورتیم بگذارید ادمین اصلی ایدی اول است
$usernamebot = 'numbercall'; // یوزرنیم ربات api
$channel = 'numbercall'; // ایدی کانال بدون @
$channelname = 'نامبرلند'; // نام کانال برای نمایش
$channelby = ''; // ایدی کانال خرید ها بدون @
$web = 'https://numbercall.ir/NuLand'; // آدرس محل قرار گیری سورس
$MerchantID = ''; // مرچند کد درگاه
$apikey = '4a68d876bad7e17cee67e842993fd629'; // مرچند کد در سایت numbercall.ir
$cardinfo = '
بزودی'; // مشخصات کارت بانکی خود را وارد کنید جهت پرداخت آفلاین
//========================== // database // ==============================
$connect = new mysqli('localhost', 'numbercall','pass','numbercall');
?>

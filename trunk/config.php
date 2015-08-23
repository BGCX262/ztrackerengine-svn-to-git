<?

/*
// +--------------------------------------------------------------------------+
// | Project:    TBDevYSE - TBDev Yuna Scatari Edition                        |
// +--------------------------------------------------------------------------+
// | This file is part of TBDevYSE. TBDevYSE is based on TBDev,               |
// | originally by RedBeard of TorrentBits, extensively modified by           |
// | Gartenzwerg.                                                             |
// |                                                                          |
// | TBDevYSE is free software; you can redistribute it and/or modify         |
// | it under the terms of the GNU General Public License as published by     |
// | the Free Software Foundation; either version 2 of the License, or        |
// | (at your option) any later version.                                      |
// |                                                                          |
// | TBDevYSE is distributed in the hope that it will be useful,              |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with TBDevYSE; if not, write to the Free Software Foundation,      |
// | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA            |
// +--------------------------------------------------------------------------+
// |                                               Do not remove above lines! |
// +--------------------------------------------------------------------------+
*/

# IMPORTANT: Do not edit below unless you know what you are doing!
if(!defined('IN_TRACKER') && !defined('IN_ANNOUNCE'))
  die('Hacking attempt!');

//$FUNDS = "$2,610.31";

$SITE_ONLINE = true;
//$SITE_ONLINE = local_user();
//$SITE_ONLINE = false;

$max_torrent_size = 1000000;
$announce_interval = 60 * 30;
$signup_timeout = 86400 * 3;
$minvotes = 1;
$max_dead_torrent_time = 6 * 3600;

// Max users on site
$maxusers = 10000; // LoL Who we kiddin' here?

// ONLY USE ONE OF THE FOLLOWING DEPENDING ON YOUR O/S!!!
$torrent_dir = "torrents";    # FOR UNIX ONLY - must be writable for httpd user
//$torrent_dir = "C:/web/Apache2/htdocs/tbsource/torrents";    # FOR WINDOWS ONLY - must be writable for httpd user

$doxpath = "dox";

// Email for sender/return path.
$SITEEMAIL = "noreply@" . $_SERVER["HTTP_HOST"];

$SITENAME = "Бумер";

$autoclean_interval = 366600;
$pic_base_url = "./pic/";

// [BEGIN] Custom variables from Бумер
$ttl_days = 28; // Сколько дней торрент может жить до TTL.
$default_language = "russian"; // Язык трекера по умолчанию.
$avatar_max_width = 100; // Максимальная ширина аватары.
$avatar_max_height = 100; // Максимальная высота аватары.
$ctracker = 1; // Use CrackerTracker - anti-cracking system. I personaly think it's un-needed...
$points_per_hour = 1; // Сколько добавлять бонусов в час, если пользователь сидирует.
$points_per_cleanup = $points_per_hour*($autoclean_interval/3600); // Don't change it!
$default_theme = "Bumer"; // Тема по умолчанию для гостей.
$nc = "no"; // Не пропускать на трекер пиров с закрытыми портами.
$deny_signup = 0; // Запретить регистрацию. 1 = регистрация отключена, 0 = регистрация включена.
$allow_invite_signup = 1; // Разрешить регистрацию через приглашения. 1 = разрешена, 0 = не разрешена.
$use_ttl = 0; // Использовать TTL.
$use_email_act = 0; // Использовать активацию по почте, иначе - автоматическая активация при регистрации.
$use_wait = 0; // Использовать ожидание на пользователях которые имеют плохой рейтинг.
$use_lang = 1; // Включить языковую систему. Выключите если вы хотите перевести шаблоны и другие файлы - тогда все фразы от системы станут пустым местом.
$use_captcha = 0; // Использовать защиту от авто-регистраций.
$use_blocks = 1; // Использовать систему блоков. 1 - да, 0 - нет. Если ее отключить то админ-панель и ее блочный модуль не смогут нормально работать при работе с блоками.
$use_gzip = 0; // Использовать сжатие GZip на страницах.
$use_ipbans = 0; // Использовать функцию блокирования IP-адресов. 0 - нет, 1 - да.
$use_sessions = 1; // Использовать сессии. 0 - нет, 1 - да.
$smtptype = "advanced";
// [END] Custom variables from Yuna Scatari

// Сколько можно секономить запросов отключая что-то:
/*

Капча - 1 запрос при регистрации на форме и 1 запрос на проверке регистрации. (мин. 2 запроса)
Блоки - 1 запрос на вызов блоков + все запросы из всех блоков что активны. (мин. 1 запрос. В комплектации по умолчанию сборки - 2 запроса на блоке пользователи, 1 запрос на блоке форум, 2 запроса на блоке релизы)
Сессии - 1 запрос на постоянного юзера и 2 запроса на нового (первый раз на сайте). (мин. 1 запрос)
IP-баны - 1 запрос на любой странице.

Авторизация - пока не готово. Будет возмоность отключать авторизацию т.е. вход пользователей что даст возможность в минимальном режиме работать ВООБЩЕ без запросов на чистой странице.

*/

?>
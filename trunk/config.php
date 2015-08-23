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

$SITENAME = "�����";

$autoclean_interval = 366600;
$pic_base_url = "./pic/";

// [BEGIN] Custom variables from �����
$ttl_days = 28; // ������� ���� ������� ����� ���� �� TTL.
$default_language = "russian"; // ���� ������� �� ���������.
$avatar_max_width = 100; // ������������ ������ �������.
$avatar_max_height = 100; // ������������ ������ �������.
$ctracker = 1; // Use CrackerTracker - anti-cracking system. I personaly think it's un-needed...
$points_per_hour = 1; // ������� ��������� ������� � ���, ���� ������������ ��������.
$points_per_cleanup = $points_per_hour*($autoclean_interval/3600); // Don't change it!
$default_theme = "Bumer"; // ���� �� ��������� ��� ������.
$nc = "no"; // �� ���������� �� ������ ����� � ��������� �������.
$deny_signup = 0; // ��������� �����������. 1 = ����������� ���������, 0 = ����������� ��������.
$allow_invite_signup = 1; // ��������� ����������� ����� �����������. 1 = ���������, 0 = �� ���������.
$use_ttl = 0; // ������������ TTL.
$use_email_act = 0; // ������������ ��������� �� �����, ����� - �������������� ��������� ��� �����������.
$use_wait = 0; // ������������ �������� �� ������������� ������� ����� ������ �������.
$use_lang = 1; // �������� �������� �������. ��������� ���� �� ������ ��������� ������� � ������ ����� - ����� ��� ����� �� ������� ������ ������ ������.
$use_captcha = 0; // ������������ ������ �� ����-�����������.
$use_blocks = 1; // ������������ ������� ������. 1 - ��, 0 - ���. ���� �� ��������� �� �����-������ � �� ������� ������ �� ������ ��������� �������� ��� ������ � �������.
$use_gzip = 0; // ������������ ������ GZip �� ���������.
$use_ipbans = 0; // ������������ ������� ������������ IP-�������. 0 - ���, 1 - ��.
$use_sessions = 1; // ������������ ������. 0 - ���, 1 - ��.
$smtptype = "advanced";
// [END] Custom variables from Yuna Scatari

// ������� ����� ���������� �������� �������� ���-��:
/*

����� - 1 ������ ��� ����������� �� ����� � 1 ������ �� �������� �����������. (���. 2 �������)
����� - 1 ������ �� ����� ������ + ��� ������� �� ���� ������ ��� �������. (���. 1 ������. � ������������ �� ��������� ������ - 2 ������� �� ����� ������������, 1 ������ �� ����� �����, 2 ������� �� ����� ������)
������ - 1 ������ �� ����������� ����� � 2 ������� �� ������ (������ ��� �� �����). (���. 1 ������)
IP-���� - 1 ������ �� ����� ��������.

����������� - ���� �� ������. ����� ���������� ��������� ����������� �.�. ���� ������������� ��� ���� ����������� � ����������� ������ �������� ������ ��� �������� �� ������ ��������.

*/

?>
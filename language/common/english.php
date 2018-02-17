<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, Feb 18, 2010 1:05 AM   ------------------------*
*/
/**
*
* common [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
define("_LOCALE","en_UK");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'TRANSLATION_INFO'	=> '',
	'DIRECTION'			=> 'ltr',
	'DATE_FORMAT'		=> '|d M Y|',	// 01 Jan 2007 (with Relative days enabled)
	'USER_LANG'			=> 'en-gb',
	'CONTENT_ENCODING'	=>	'UTF-8',
	'GB'				=>	'GB',
	'MB'				=>	'MB',
	'KB'				=>	'KB',
	'dateformats'	=> array(
		'd M Y, H:i'			=> '01 Jan 2007, 13:37',
		'd M Y H:i'				=> '01 Jan 2007 13:37',
		'M jS, \'y, H:i'		=> 'Jan 1st, \'07, 13:37',
		'D M d, Y g:i a'		=> 'Mon Jan 01, 2007 1:37 pm',
		'F jS, Y, g:i a'		=> 'January 1st, 2007, 1:37 pm',
		'|d M Y|, H:i'			=> 'Today, 13:37 / 01 Jan 2007, 13:37',
		'|F jS, Y|, g:i a'		=> 'Today, 1:37 pm / January 1st, 2007, 1:37 pm'
	),
	'default_dateformat'	=> 'D M d, Y g:i a', // Mon Jan 01, 2007 1:37 pm
	'CUSTOM_DATEFORMAT'			=> 'Custom…',
	'VARIANT_DATE_SEPARATOR'	=> ' / ',	// Used in date format dropdown, eg: "Today, 13:37 / 01 Jan 2007, 13:37" ... to join a relative date with calendar date
	'tz'				=> array(
		'-12'	=> 'UTC - 12 hours',
		'-11'	=> 'UTC - 11 hours',
		'-10'	=> 'UTC - 10 hours',
		'-9.5'	=> 'UTC - 9:30 hours',
		'-9'	=> 'UTC - 9 hours',
		'-8'	=> 'UTC - 8 hours',
		'-7'	=> 'UTC - 7 hours',
		'-6'	=> 'UTC - 6 hours',
		'-5'	=> 'UTC - 5 hours',
		'-4.5'	=> 'UTC - 4:30 hours',
		'-4'	=> 'UTC - 4 hours',
		'-3.5'	=> 'UTC - 3:30 hours',
		'-3'	=> 'UTC - 3 hours',
		'-2'	=> 'UTC - 2 hours',
		'-1'	=> 'UTC - 1 hour',
		'0'		=> 'UTC',
		'1'		=> 'UTC + 1 hour',
		'2'		=> 'UTC + 2 hours',
		'3'		=> 'UTC + 3 hours',
		'3.5'	=> 'UTC + 3:30 hours',
		'4'		=> 'UTC + 4 hours',
		'4.5'	=> 'UTC + 4:30 hours',
		'5'		=> 'UTC + 5 hours',
		'5.5'	=> 'UTC + 5:30 hours',
		'5.75'	=> 'UTC + 5:45 hours',
		'6'		=> 'UTC + 6 hours',
		'6.5'	=> 'UTC + 6:30 hours',
		'7'		=> 'UTC + 7 hours',
		'8'		=> 'UTC + 8 hours',
		'8.75'	=> 'UTC + 8:45 hours',
		'9'		=> 'UTC + 9 hours',
		'9.5'	=> 'UTC + 9:30 hours',
		'10'	=> 'UTC + 10 hours',
		'10.5'	=> 'UTC + 10:30 hours',
		'11'	=> 'UTC + 11 hours',
		'11.5'	=> 'UTC + 11:30 hours',
		'12'	=> 'UTC + 12 hours',
		'12.75'	=> 'UTC + 12:45 hours',
		'13'	=> 'UTC + 13 hours',
		'14'	=> 'UTC + 14 hours',
		'dst'	=> '[ <abbr title="Daylight Saving Time">DST</abbr> ]',
	),

	'tz_zones'	=> array(
		'-12'	=> '[UTC - 12] Baker Island Time',
		'-11'	=> '[UTC - 11] Niue Time, Samoa Standard Time',
		'-10'	=> '[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time',
		'-9.5'	=> '[UTC - 9:30] Marquesas Islands Time',
		'-9'	=> '[UTC - 9] Alaska Standard Time, Gambier Island Time',
		'-8'	=> '[UTC - 8] Pacific Standard Time',
		'-7'	=> '[UTC - 7] Mountain Standard Time',
		'-6'	=> '[UTC - 6] Central Standard Time',
		'-5'	=> '[UTC - 5] Eastern Standard Time',
		'-4.5'	=> '[UTC - 4:30] Venezuelan Standard Time',
		'-4'	=> '[UTC - 4] Atlantic Standard Time',
		'-3.5'	=> '[UTC - 3:30] Newfoundland Standard Time',
		'-3'	=> '[UTC - 3] Amazon Standard Time, Central Greenland Time',
		'-2'	=> '[UTC - 2] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time',
		'-1'	=> '[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time',
		'0'		=> '[UTC] Western European Time, Greenwich Mean Time',
		'1'		=> '[UTC + 1] Central European Time, West African Time',
		'2'		=> '[UTC + 2] Eastern European Time, Central African Time',
		'3'		=> '[UTC + 3] Moscow Standard Time, Eastern African Time',
		'3.5'	=> '[UTC + 3:30] Iran Standard Time',
		'4'		=> '[UTC + 4] Gulf Standard Time, Samara Standard Time',
		'4.5'	=> '[UTC + 4:30] Afghanistan Time',
		'5'		=> '[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time',
		'5.5'	=> '[UTC + 5:30] Indian Standard Time, Sri Lanka Time',
		'5.75'	=> '[UTC + 5:45] Nepal Time',
		'6'		=> '[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time',
		'6.5'	=> '[UTC + 6:30] Cocos Islands Time, Myanmar Time',
		'7'		=> '[UTC + 7] Indochina Time, Krasnoyarsk Standard Time',
		'8'		=> '[UTC + 8] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time',
		'8.75'	=> '[UTC + 8:45] Southeastern Western Australia Standard Time',
		'9'		=> '[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time',
		'9.5'	=> '[UTC + 9:30] Australian Central Standard Time',
		'10'	=> '[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time',
		'10.5'	=> '[UTC + 10:30] Lord Howe Standard Time',
		'11'	=> '[UTC + 11] Solomon Island Time, Magadan Standard Time',
		'11.5'	=> '[UTC + 11:30] Norfolk Island Time',
		'12'	=> '[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time',
		'12.75'	=> '[UTC + 12:45] Chatham Islands Time',
		'13'	=> '[UTC + 13] Tonga Time, Phoenix Islands Time',
		'14'	=> '[UTC + 14] Line Island Time',
	),
	'1_DAY'									=>	'1 day',
	'1_MONTH'								=>	'1 month',
	'1_YEAR'								=>	'1 year',
	'2_WEEKS'								=>	'2 weeks',
	'3_MONTHS'								=>	'3 months',
	'6_MONTHS'								=>	'6 months',
	'7_DAYS'								=>	'7 days',
	'ADDED'									=>	'Added',
	'ADDED_BY'								=>	'Added By',
	'ADD_NEW'								=>	'Add New',
	'ALERT_ERROR'							=>	'Form has NOT been Submitted due to the following Errors:',
	'ACTION'								=>	'Action',
	'ACTIONS'								=>	'Actions',
	'ACTIVE'								=>	'Active',
	'ACTIVATION_ERROR'						=>	'Activation Error',
	'ARCHIVES'								=>	'Archives',
	'ADD_COMMENT'							=>	'Add a comment',
	'ADMIN_CP'								=>	'Admin Panel',
	'ADMINISTRATOR'							=>	'Administrator',
	'ADMINISTRATORS'						=>	'Administrators',
	'AGO'									=>	'Ago',
	'ALL_ENTRIES'							=>	'All entries',
	'ATTACHMENTS'							=>	'Attachments',
	'ALT_LOCKED_T'							=>	'Pending Authorization',
	'ALT_LOCKED_T_REQ'						=>	'Ask for Authorization',
	'ARCADE'								=>	'Arcade',
	'ASCENDING'								=>	'Ascending',
	'AUTHOR'								=>	'Author',
	'AVATAR'								=>	'Avatar',
	'LOCATION'								=>	'Location',
	'AVATAR_CATEGORY'						=>	'Category',
	'AVATAR_GALLERY'						=>	'Local gallery',
	'AVATAR_EXPLAIN'						=>	'Maximum dimensions; width: %1$d pixels, height: %2$d pixels, file size: %3$.2f KiB.',
	'AVG_SPEED'								=>	'Average Speed',
	'BBCODE_GUIDE'							=> 'BBCode guide',
	'BACK_TO_TOP'							=> 'Top',
	'BACK'									=>	'Back',
	"BAN_ACCOUNT"							=>	"Ban Account",
	"BAN_SHOUTS"							=>	"Shout Ban",
	'USE_PERMISSIONS'						=> 'Test out user’s permissions',
	'WARNINGS'								=> 'Warnings',
	'CONFIRM_EMAIL'							=> 'Confirm e-mail address',
	'_NEW'									=>	'New',
	'NEW_PASSWORD'							=> 'New password',
	'CONFIRM_PASSWORD'						=> 'Confirm password',
	'CONFIRM_PASSWORD_EXPLAIN'				=> 'You only need to confirm your password if you changed it above.',
	'BANN'									=>	'Bann',
	'PAGES'									=>	'Pages',
	'PAGE'									=>	'page',
	'BANNED'								=>	'Banned',
	'BANNED_FOR'							=>	'You have been Banned from this Site because: <b>%1$d</b>',
	'BROWES'								=>	'Browse',
	'BT_ERROR'								=>	'Error',
	'BACK_TO_PREV'							=> 'Back to previous page',
	'CAT_SELECT'							=>	'Select a Category',
	'CATEGORY'								=>	'Category',
	'CONFIRM_OPERATION'						=>	'Are you sure you wish to carry out this operation?',
	'CHOOSE'								=>	'Choose',
	'CANCEL'								=>	'Cancel',
	'RETURN_PAGE'							=>	'Return to Previous page',
	'CASINO'								=>	'Casino',
	'CLICK_HERE'							=>	'Click Here',
	'CLOSE_WINDOW'							=>	'Close window',
	'COLOUR_SWATCH'							=>	'Colour swatch',
	'COMMENT'								=>	'Comment',
	'COMMENTS'								=>	'Comments',
	'COMPLETED'								=>	'Completed',
	'COMPLETE_NAME'							=>	'Complete Name',
	'CONFIRM'								=>	'Confirm',
	'CONTINUE'								=>	'Continue',
	'CURRENT_IMAGE'							=>	'Current image',
	'DATE'									=>	'Date',
	'DAYS'									=>	'Days',
	'DATE_ADDED'							=>	'Date Added',
	'DETAILS'								=>	'Details',
	'DETACH'								=>	'Detach',
	'DELETE'								=>	'Delete',
	'DELETE_MARKED'							=>	'Delete Marked',
	'DELETE_ALL'							=>	'Delete all',
	'DELETE_AVATAR'							=>	'Delete image',
	'DESCENDING'							=>	'Descending',
	'DELIMITER'								=> 'Delimiter',
	'DESCRIPTION'							=>	'Description',
	'TRACKERS'								=>	'Trackers',
	'TRACKER_OVER_VIEW'						=>	'Tracker Over View',
	'SDEFAULT'								=>	'Default',
	'DISPLAY_LOG'							=>	'Display entries from previous',
	'DISPLAY_GALLERY'						=>	'Display gallery',
	'DONOR'									=>	'Donator',
	'DONATIONS'								=>	'Donations',
	'DONT_CHEAT'							=>	'Don\'t Cheat!!!',
	'DOWNLOAD'								=>	'Download',
	'DOWNED'								=>	'Downloaded',
	'EDIT'									=>	'Edit',
	'NOTICE'								=>	'Notice',
	'EDIT_PROFILE'							=>	'Edit Profile',
	'ED2K_LINK'								=>	'eD2K Link',
	'ERROR_MINSEED'							=>	'You MUST be Seeding at least %1$s Torrents to Download.',
	'ERROR_MINSEEDSIZE'						=>	'To download you need to seed at least min %1$s Torrent.',
	'ERROR_BLACK_LISTED'					=>	'The Owner Refused to let you Download his Torrents. You won\'t be able to download any of them.',
	'ERROR_PRIVATE_FILE'					=>	'This is a Private File: you have already asked for Download Authorization. You cannot download the file until the Owner Accepts your Request.',
	'ERROR_PRIVATE_DENIDE'					=>	'The Owner Refused your Authorization Request. You won\'t be able to download this torrent.',
	'ERROR_PRIVATE_REQ_SENT'				=>	'This Torrent is Private. You won\'t be able to download it until the Owner gives you Authorization. 
A Request has been sent to the Torrent Owner, who needs to Authorize your download: you will be Notified about the Result by E-mail.',
	'ENCLOSURE'								=>	'Enclosure',
	'FIND_USERNAME'							=>	'Find UsersName',
	'EMAIL'									=>	'E-Mail',
	'REFRESH_PEERS'							=>	'Refresh Peer Data',
	'PEERS_UPDATE_ALREDY'					=>	'Stats Updated less than 30min ago',
	'AUTH_PENDING'							=>	'Pending Authorizations!',
	'AUTH_PENDING_NONE'						=>	'No Pending Authorizations',
	'RATE_A'								=>	"Legal Content, Good Quality",
	'RATE_B'								=>	"Fake or Corrupted",
	'RATE_C'								=>	"Copyrights Violation",
	'RATE_D'								=>	"Pornographic Content",
	'RATE_E'								=>	"Child Pornography",
	'RATE_F'								=>	"Offensive Content",
	'RATE_G'								=>	"Content Related to Illegal Activity",
	'EMPTY_FILE_NAME'						=>	'Empty File name',
	'EST_DOWNLOAD_TIME'						=>	'Estimated Download Time',
	'FAQS'									=>	'FAQ\'S',
	'FAQ_EXPLAIN'							=> 'Frequently Asked Questions',
	'FILE_UNAVAILABLE'						=>	'Torrent File Unavailable due to a Server Configuration Error. Sorry for the Inconvenience.',
	'FILE'									=>	'File',
	'FILE_NAME'								=>	'File Name',
	'FILES'									=>	'Files',
	'FILE_EMPTY'							=>	'File Empty',
	'GAMES'								    =>	'Games',	
	'GENERAL'								=>	'General',
	'GO'									=>	'Go',
	'GROUP'									=>	'Group',
	'INVALID_IMAGE_EXT'						=>	'Image File has to be GIF, JPG or PNG',
	'GROUP_ERR_USER_LONG'					=>	'Group names cannot exceed 60 characters. The specified group name is too long.',
	'GROUP_ERR_TYPE'						=>	'Inappropriate group type specified.',
	'GROUP_ERR_USERNAME'					=>	'No group name specified.',
	'GROUP_NO_ACCESS_PAGE'					=>	'Your Group Dose not have <strong>ACCESS</strong> to This Page',
	'ILLIGALCAT'							=>	'Illegal Category!',
	'HELP'								    =>	'Helpdesk',	
	'ID'									=>	'ID',
	'INDEX'									=>	'Index',
	'IMAGE'									=>	'Image',
	'IN_ACTIVE'								=>	'In Active',
	'INVALID'								=>	'Invalid',
	'INVALID_FILE_NAME'						=>	'Invalid File name',
	'INVALID_SIZE'							=>	'File goes beyond Allowed Size',
	'INVALID_ID'							=>	'Invalid ID',
	'INVITES'								=>	'Invites',
	'INFORMATION'							=> 'Information',
	'IRC_CHAT'								=>	'IRC Chat',
	'JUMP_PAGE'								=>	'Enter the page number you wish to go to',
	'JOINED'								=>	'Joined',
	'KINO'									=>	'Kino',
	'LASTACTION'							=>	'Last Action',
	'LAST_ACTIVE'							=>	'Last Active',
	'LAST_ACTIVITY'							=>	'Last Activity',
	'LOTTERY'								=>	'Lottery',
	'BLACKJACK'								=>	'BlackJack',
	'LANGUAGE'								=>	'Language',
	'LEECHERS'								=> 'Leechers',
	'LINK'									=>	'Link',
	'LINKS'									=>	'Links',
	'LINK_REMOTE_SIZE'						=>	'Avatar dimensions',
	'LINK_REMOTE_AVATAR'					=>	'Link off-site',
	'LINK_REMOTE_AVATAR_EXPLAIN'			=>	'Enter the URL of the location containing the avatar image you wish to link to.',
	'LINK_REMOTE_SIZE_EXPLAIN'				=>	'Specify the width and height of the avatar, leave blank to attempt automatic verification.',
	'LOCAL'									=>	'Local',
	'LOCK'									=>	'Lock',
	'LOG_OUT'								=>	'Log Out',
	'PASS_WORD_REQ'							=>	'This Download requires a Password',
	'LOAD_DRAFT'							=> 'Load draft',
	'LOGIN'									=>	'Login',
	'LOGOUT'								=>	'Logout',
	'LOGIN_SITE'							=> 'The site requires you to be registered and logged in.',
	'LOGIN_GROUP'							=> 'The site requires you to be registered and have a group Level of %1$s.',
	'LOGIN_SUCCESS'							=>	'Success full Login Enjoy your stay!',
	'LOGOUT_SUCCESS'						=>	'You have loged out Come Back soon!',
	'LOG_GROUP_DEFAULTS'					=>	'<strong>Group “%1$s” made default for members</strong><br>» %2$s',
	'LOG_GROUP_REMOVE'						=>	'<strong>Members removed from usergroup</strong> %1$s<br>» %2$s',
	'LOG_GROUP_CREATED'						=>	'<strong>New usergroup created</strong><br>» %s',
	'LOG_GROUP_UPDATED'						=>	'<strong>Usergroup details updated</strong><br>» %s',
	'MCP'					=> 'Moderator Control Panel',
	'MD5_HASH'								=>	'MD5 Hash',
	'MAGNET_LINK'							=>	'Magnet Link',
	'MARK'									=>	'Mark',
	'MESSAGE'								=>	'Message',
	'MISSING_DATA'							=>	'Required Data Missing!',
	'MISSING_FILE'							=>	'The file your looking for dose not Exisets',
	'MODERATE'								=>	'Moderate',
	'MODERATOR'								=>	'Moderator',
	'MODERATORS'							=>	'Moderators',
	'NEXT'									=>	'Next',
	'NAME'									=>	'Name',
	'NAMES'									=>	'Names',
	'NEW_MESAGE'							=>	'New Message',
	'NO'									=>	'No',
	'NONE'									=>	'None',
	'NO_FILE_UPLOADED'						=>	'Fatal Error in Uploaded File.',
	'NO_SUCH_USER'							=>	'No Such User',
	'NOT_AUTH_DOWNLOAD'						=>	'You are Not autherized to download from this site!',
	'NOTIFY_EMAIL'							=>	'E-Mail Notifications',
	'NOTIFY_ADMIN_EMAIL'					=> 'Please notify the board administrator or webmaster: <a href="mailto:%1$s">%1$s</a>',
	'NOTIFY_SEEDERS'						=>	'If you want to be E-mailed when the First <b>SEED</b> shows up, please click <a href="details.php?op=seeder&amp;trig=on&amp;id=%1$s#notify">HERE</a>',
	'NOTIFY_COMMENTS'						=>	'If you want to be E-mailed when the First Comment is added, please click <a href="details.php?op=comment&amp;trig=on&amp;id=%1$s#notify">HERE</a>',
	'NOTIFY_SEEDERS_REMOVE'					=>	'You are currently listed to be Notified when a Seed pops up. If you don\'t want to be E-mailed any more, please click <a href="details.php?op=seeder&trig=off&id=%1$s#notify">HERE</a>',
	'NOTIFY_COMMENTS_REMOVE'				=>	'You are currently listed to Receive Comment Email. If you Don\'t want to be E-mailed any more, please click <a href="details.php?op=comment&trig=off&id=%1$s#notify">HERE</a>',
	'NO_NAME_SET'							=>	'No Name was Set.',
	'NO_ACTIVATION_KEY_SET'					=>	'Activation Key NOT Specified!',
	'NO_TORRENTS'							=>	'There are NO Torrents',
	'NO_SUCH_USER'							=>	'This User Name Does NOT Exist.',
	'NO_REASON_GIVEN'						=>	'No Reason was Given',
	'NO_SUCH_TORRENT'						=>	'Torrent Does NOT Exist or has been Banned',
	'NOT_A_TORRENT_FILE'					=>	'This is NOT a Torrent File (.torrent)',
	'NUB_OF_FILES'							=>	'Number of files',
	'NUKE'									=>	'Nuke',
	'NUKED'									=>	'Nuked',
	'EXTERNAL_TRACKER'						=>	'External Tracker',
	'NUKED_REASON'							=>	'Nuke Reason',
	'OWNER'									=>	'Owner',
	'OPTIONS'								=>	'Options',
	'ON_LINE'								=>	'On Line',
	'OFF_LINE'								=>	'Off Line',
	'ONLY'									=>	'only',
	'PASSWORD'								=>	'Password',
	'PASSWORD_CONFIRM'						=>	'Confirm Password',
	'PIXEL'									=>	'px',
	'POSTS'									=>	'Posts',
	'PM'									=>	'PM',
	'DL'									=>	'DL',
	'PREMIUM_USER'							=>	'Premium User',
	'PRIVATE_MESSAGES'						=>	'Private Messages',
	'PRIVATE_MESSAGE'						=>	'Private Message',
	'PRIVATE_SHOUT'							=>	'Private Shout!',
	'ACCESS_DENIED'							=>	'Access Denied',
	'PRIVATE_PM'							=>	'[PM]',
	'PREVEASE'							=>	'Prev',
	'QUESTION'								=>	'Question',
	'RESET'									=>	'RESET',
	'REFRESH'								=>	'Refresh',
	'REGISTOR'								=>	'Register',
	'RATE'									=>	'Rate',
	'RATING'								=>	'Rating',
	'RATINGS'								=>	'Ratings',
	'RATIO'									=>	'Ratio',
	'REDIRECT'								=>	'Redirect',
	'DONATE'					=> 'DONATE',
	'GOAL'						=> 'Goal',
	'COLECTED'					=> 'Collected',
	'PROGRESS'					=> 'Donation Progress',
	'REDIRECT_EXP'							=>	'You are being Redirected to the page in 3 seconds <br /><br />%1$s',
	'RULE'									=>	'Rule',
	'RULES'									=>	'Rules',
	'RATIO_BUILDER'							=>	'Ratio Builder',
	'RETURN_INDEX'							=>	'%sReturn to the index page%s',
	'SEARCH'								=>	'Search',
	'SEARCH_CLOUD'							=>	'Search Cloud',
	'SECURITY_CODE'							=>	'Security Code',
	'SEC_CODE_ERROR'				=>	'The Security Code you entered is Wrong',
	'SEEDERS'								=>	'Seeders',
	'SETTINGS'								=>	'Settings',
	'SITE_NEWS'								=>	'Site News',
	'SHOUT'									=>	'Shout',
	'INACTIVE_DATE'					=> 'Inactive date',
	'INACTIVE_REASON'				=> 'Reason',
	'INACTIVE_REASON_MANUAL'		=> 'Account deactivated by administrator',
	'INACTIVE_REASON_PROFILE'		=> 'Profile details changed',
	'INACTIVE_REASON_REGISTER'		=> 'Newly registered account',
	'INACTIVE_REASON_REMIND'		=> 'Forced user account reactivation',
	'INACTIVE_REASON_UNKNOWN'		=> 'Unknown',
	'INACTIVE_USERS'				=> 'Inactive users',
	'INACTIVE_USERS_EXPLAIN'		=> 'This is a list of users who have registered but whose accounts are inactive. You can activate, delete or remind (by sending an e-mail) these users if you wish.',
	'INACTIVE_USERS_EXPLAIN_INDEX'	=> 'This is a list of the last 10 registered users who have inactive accounts. A full list is available from the appropriate menu item or by following the link below from where you can activate, delete or remind (by sending an e-mail) these users if you wish.',
	'JAVA_NEW_PM'					=>	'You have a NEW PM, please click OK to go to your PM In-Box.',
	'NO_INACTIVE_USERS'	=> 'No inactive users',
	'NO_SUCH_USER'		=>	'This User Name Does NOT Exist.',
	'SORT_INACTIVE'		=> 'Inactive date',
	'SORT_LAST_VISIT'	=> 'Last visit',
	'SORT_REASON'		=> 'Reason',
	'SORT_REG_DATE'		=> 'Registration date',

	'USER_IS_INACTIVE'		=> 'User is inactive',
	'SIGN_UP'								=>	'Sign Up',
	'SHOUT_BOX'								=>	'ShoutBox',
	'SHOUT_NEW_UPLOAD'						=>	'Hi, I have just Uploaded [url=%1$s/details.php?id=%2$s][b]%3$s[/b][/url]. Enjoy it!',
	'SIZE'									=>	'Size',
	'SELECT_CATEGORY'						=>	'Select a Category',
	'SKIP'									=>	'Skip to content',
	'SORT_BY'								=>	'Sort by',
	'SPEED'									=>	'Speed',
	'SEED_BOMUS'							=>	'Seeding Bonus',
	'SEEDING'								=>	'Seeding',
	'SELECT_OPTION'							=>	'Select Option',
	'SORT'									=>	'Sort',
	'STATUS'								=>	'Status',
	'STATISTICS'							=>	'Statistics',
	'SUBMIT'								=>	'Submit',
	'SUCCESS'								=>	'Success',
	'SECURITY_CODE'							=>	'Security Code',
	'SUMMARY'								=>	'Summary',
	'SNATCHED'								=>	'Snatched',
	'TOTAL_PEERS'							=>	'Total Peers',
	'PEERS'									=>	'Peers',
	'TIME'									=>	'Time',
	'TIMES'									=>	'Times',
	'THEME'									=>	'Theme',
	'New'									=>	'Theme',
	'THEMES'								=>	'Themes',
	'TOPICS'								=>	'Topics',
	'TOPIC'								=>	'Topic',
	'TORRENT'								=>	'Torrent',
	'TORRENTS'								=>	'Torrents',
	'TORRENT_NEED_SEED'						=>	'Torrents That Need Seeding',
	'TORRENT_NEED_SEED_EXP'					=>	'Please help them out, if you happen to have the files on your hard disk. Thank You!',
	'PEER_SPEED'							=>	'Peer Speed',
	'TRACKER'								=>	'Tracker',
	'TYPE'									=>	'Type',
	'TYPES'									=>	'Types',
	'UNLOCKED'								=>	'Unlocked',
	'UPDATE'								=>	'Update',
	'UPDATED'								=>	'Updated',
	'UPLOAD'								=>	'Upload',
	'UPDATING'								=>	'Updateing....',
	'UPLODED'								=>	'Uploaded',
	'UPLOAD_FILE'							=>	'Upload File',
	'UPLOADER'								=>	'Uploader',
	'UPLOAD_FAILED'							=>	'The Upload Has Failed!',
	'USER'									=>	'User',
	'USERS'									=>	'Users',
	'USER_ALREADY_ACTIVATED'				=>	'User is already Active. No more Activation Required',
	'USERPROFILE'                           =>  'Profile',
	'USEREPROFILE'                          =>  'Edit',	
	'STAFF'								    =>	'Staff',	
	'USER_NOT_EDIT_ABL_BYCLASS'				=>	'You do not have access to edit this Person',
	'USERNAME'								=>	'Users Name',
	'UNLOCK'								=>	'Unlock',
	'UNKNOWN'								=>	'Unknown',
	'URL_REDIRECT'			=> 'If your browser does not support meta redirection %splease click HERE to be redirected%s.',
	'REDIRECT_ACL'	=> 'Now you are able to %sset permissions%s for this forum.',
	'ERROR_NOT_NUMBER'						=>	'No a Valid Number [0-9]',
	'VISIBLE'								=>	'Visible',
	'VIEW'									=>	'View',
	'VOTE'									=>	'Vote',
	'VOTES'									=>	'Votes',
	'WARNED'								=>	'Warned',
	'WHOIS'									=>	'Whois',
	'YOUR_TORRENTS'							=>	'Your Torrents',
	'YES'									=>	'Yes',
	'VIEW_RESULTS'							=>	'View Results',
	'MOD_OPTIONS'							=>	'Moderator Options',
	'FREE_LEACH_EXP'				=>	'Any Torrents with this Symbol are Ratio Boosters. Only your Upload is Recorded!!<br> This is a Great way to Boost your Ratio. Normal Site Seeding Rules Apply.<br>Seed to 1.0 or 36 hours to avoid Hit and Runs.',
	'NUKED_EXP'						=>	'Any Torrents with this Symbol are Nuked. <br>This means that for some reason someone has determined that there is something wrong with the Release,<br>and it may or may not be viewable. Use your own discretion when downloading these torrents.<br>Normal Site Seeding Rules still Apply unless also made Free. Please Read Details for Reason',
	'_BBCODE_A_HELP'				=> 'Inline uploaded attachment: [attachment=]filename.ext[/attachment]',
	'_BBCODE_B_HELP'				=> 'Bold text: [b]text[/b]',
	'_BBCODE_C_HELP'				=> 'Code display: [code]code[/code]',
	'_BBCODE_E_HELP'				=> 'List: Add list element',
	'_BBCODE_F_HELP'				=> 'Font size: [size=85]small text[/size]',
	'_BBCODE_IS_OFF'				=> '%sBBCode%s is <em>OFF</em>',
	'_BBCODE_IS_ON'					=> '%sBBCode%s is <em>ON</em>',
	'_BBCODE_I_HELP'				=> 'Italic text: [i]text[/i]',
	'_BBCODE_L_HELP'				=> 'List: [list]text[/list]',
	'_BBCODE_LISTITEM_HELP'			=> 'List item: [*]text[/*]',
	'_BBCODE_O_HELP'				=> 'Ordered list: [list=]text[/list]',
	'_BBCODE_P_HELP'				=> 'Insert image: [img]http://image_url[/img]',
	'_BBCODE_Q_HELP'				=> 'Quote text: [quote]text[/quote]',
	'_BBCODE_S_HELP'				=> 'Font colour: [color=red]text[/color]  Tip: you can also use color=#FF0000',
	'_BBCODE_U_HELP'				=> 'Underline text: [u]text[/u]',
	'_BBCODE_W_HELP'				=> 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]',
	'_BBCODE_D_HELP'				=> 'Flash: [flash=width,height]http://url[/flash]',
	'_STYLES_TIP'					=> 'Tip: Styles can be applied quickly to selected text.',
	'_SMILIES'						=> 'Smilies',
	'_MORE_SMILIES'					=> 'View more smilies',
	'_FONT_COLOR'					=> 'Font colour',
	'_FONT_COLOR_HIDE'				=> 'Hide font colour',
	'_FONT_HUGE'					=> 'Huge',
	'WROTE'							=>	'Wrote',
	'_FONT_LARGE'					=> 'Large',
	'_FONT_NORMAL'					=> 'Normal',
	'_FONT_SIZE'					=> 'Font size',
	'_FONT_SMALL'					=> 'Small',
	'_FONT_TINY'					=> 'Tiny',
	'USER_CPANNEL'					=>	'User Control Panel',
	'ADMINISTRATION'				=>	'Administration',
	'UPLOADING'							=>	'Uploading',
	'DOWNLOADING'						=>	'DownLoading',
	'SHOUTS'							=>	'Shouts',
	'FORUM'								=>	'Forum',
	'OTHER'								=>	'Other',
	'USER_IP'							=>	'User IP',
	'USER_HOST'							=>	'Users Host',
	'CANCEL_SUB'						=>	'Cancel Modifications',
	'REPLIES'					=>	'Replies',
	'SUBJECT'					=>	'Subject',
	'VIEWS'						=>	'Views',
	'ALL_TOPICS'				=>	'All Topics',
	'ALL_POSTS'					=>	'All Posts',
	'VIEW_NOTES'				=> 'View Notes',
	'WARN_USER'					=> 'Warn User',
	'INVALID_IMAGE_TYPE'		=>	'Invalid Image Type',
	'INVALID_REMOTE_DATA'		=>	'The specified avatar could not be uploaded because the remote data appears to be invalid or corrupted.',
	'_URL_INVALID'				=> 'The URL you specified is invalid.',
	'AVATAR_NOT_UPLOADED'		=>	'Avatar could not be uploaded.',
	'G_ADMINISTRATORS'			=> 'Administrators',
	'G_BOTS'					=> 'Bots',
	'G_GUESTS'					=> 'Guests',
	'G_REGISTERED'				=> 'Registered users',
	'G_REGISTERED_COPPA'		=> 'Registered COPPA users',
	'G_GLOBAL_MODERATORS'		=> 'Global moderators',
	'G_OWNER'					=> 'Owner',
	'G_PREMIUM_USER'					=> 'Premium User',
	'G_MODERATOR'					=> 'Moderator',
	'G_USER'					=> 'User',
	'NO_UPLOAD_FORM_FOUND'		=>	'',
	'ATTACHED_IMAGE_NOT_IMAGE'	=>	'',
	'ATTACH_QUOTA_REACHED'		=> 'Sorry, the board attachment quota has been reached.',
		'USER_NAME'					=>	'User Name',
		'SQL_ERRORSQL'				=>	'Error Executing SQL Query ',
		'SQL_ERRORCODE'				=>	'Error ID: ',
		'SQL_ERRORMSG'				=>	'Error Message: ',
		'T_U_SEED'					=>	'Torrents you are Seeding',
		'T_U_LEECH'					=>	'Torrents you are Downloading',
		'SORT_TOPIC_TITLE'					=>	'Topic tittle',
		'PAGE_OF'					=>	'Page <strong>%1$d</strong> of <strong>%2$d</strong>',
		'GLOBAL_ANNOUNCEMENT'					=>	'Global announcement',
		'VIEW_FORUM_TOPIC'					=>	'1 topic',
		'VIEW_FORUM_TOPICS'					=>	'%d topics',
		'UNMARK_ALL'					=>	'Unmark all',
		'MARK_ALL'					=>	'Mark all',
		'GOTO_PAGE'					=>	'Go to page',
		'JUMP_TO_PAGE'					=>	'Click to jump to page…',
		'BAND_SHOUTS'				=>	'You are Banned From Shouts!',
		'NO_USERS_ONLINE'			=>	'There are NO Registered Users On-line',
		'ADV_ONLINE_MO'			=>	'Advanced Mode',
		'SEMP_ONLINE_MOD'			=>	'Simple Mode',
		'T_DIR_NOT_PRES'			=>	'Torrent Dictionary NOT Present',
		'T_DIR_MES_KEY'			=>	'Missing Torrent Dictionary Keys',
		'INV_DATA_IN_DIR'			=>	'Invalid Data inside Torrent Dictionary',
		'HAPPY_BIRTHDAY'			=>	'Congratulations to: ',
		'NO_BIRTHDAY'			=>	'No Birthdays today',
		'NO_NEW_USERS'			=>	'No new members',
		'EXTENTION'				=>	'extension',
		'WELCOME_BACK'				=>	'Welcome Back',
		'CURENT_BROWS'				=>	'Currently Browsing',
		'LOGEDIN_FOR'				=>	'Logged in for',
		'HNR_REMOVED'				=>	'Your Hit and Run Warning has been removed because you have restarted your torrent. Please keep seeding for 72 hours or Your Warning well be reinacted',
		'HIT_N_RUN'					=>	'Hit and Run',
		'MOD_HNR_COMENT_ADD'		=>	gmdate("d-m-Y")." - Warned by System for Hit and Run.\n",
		"HNR_WARN_PM"				=>	"You have repeatidly hit and run on torrents even after we have notified you that you should return to the torrent to continue seeding. Therefor you have received this one week warning. Hopefully you will not hit and run on torrents anymore, and if you do it may result in your account being disabled.",
		'MOD_HNR_COMENT_REMOVED'	=>	gmdate("d-m-Y")." - Warning Removed by System for Hit and Run.\n",
		"HNR_NOTICE_PM"				=>	"It appears that you have hit and run on {hnrtot} torrent{hnrcount}.\n\nWe advise you to return to continue seeding {these} torrent{hnrcount} within 30 minutes or else you risk being warned, or if this happends to you repeatedly you may even risk your account being disabled.\n\nThe torrent{hnrcount} on which you have been found hit and running {is}:\n{hnrtorrents}",
		#start New Member Block
		'NEWEST_MEMBERS'			=>	'Newest Members',
		#end New Member Block
		#Users Today Block
		'USERS_ON_TODAY'			=>	'Users active in the past 24 hours',
		#End Users Today Block
	'u_datetime'			=> array(
		'TODAY'		=> 'Today',
		'TOMORROW'	=> 'Tomorrow',
		'YESTERDAY'	=> 'Yesterday',
		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',
		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',
		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',
		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'May_short'	=> 'May',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec',
		'AGO'		=> array(
			0		=> 'less than a minute ago',
			1		=> '%d minute ago',
			2		=> '%d minutes ago',
			60		=> '1 hour ago',
		),
	),
		// 3.0.1 add ons
		'VARIANT_DATE_SEPARATOR'	=> ' / ',	// Used in date format dropdown, eg: "Today, 13:37 / 01 Jan 2007, 13:37" ... to join a relative date with calendar date
));
define("_at"," at ");
define("_dot"," dot ");
define("_DATESTRING","%A, %B %d %Y @ %T %Z");
define("_btdays","d ");
define("_bthours","h ");
define("_btmins","m ");
define("_btsecs","s ");
	$u_datetime			= array(
		'TODAY'		=> 'Today',
		'TOMORROW'	=> 'Tomorrow',
		'YESTERDAY'	=> 'Yesterday',

		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',

		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',

		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'May_short'	=> 'May',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec'
	);
?>
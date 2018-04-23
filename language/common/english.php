<?php

/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File common/english.php 2018-04-23 07:39:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-03-26 - Added Missing Text
** 2018-03-26 - Removed Unused Define Vars
** 2018-04-22 - Amended the Wording of some Sentences
** 2018-04-23 - Added Missing Language
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    '_LOCALE'          => 'en_UK',
    '_DATESTRING'      => '%A, %B %d %Y @ %T %Z',
    'TRANSLATION_INFO' => '',
    'DIRECTION'        => 'ltr',
    'DATE_FORMAT'      => '|d M Y|', // 01 Jan 2007 (with Relative Days Enabled)
    'USER_LANG'        => 'en-gb',
    'CONTENT_ENCODING' => 'UTF-8',
    'GB'               => 'GB',
    'MB'               => 'MB',
    'KB'               => 'KB',
    'BYTES'            => 'Bytes',

    'dateformats'   => array(
    'd M Y, H:i'       => '01 Jan 2007, 13:37',
    'd M Y H:i'        => '01 Jan 2007 13:37',
    'M jS, \'y, H:i'   => 'Jan 1st, \'07, 13:37',
    'D M d, Y g:i a'   => 'Mon Jan 01, 2007 1:37 pm',
    'F jS, Y, g:i a'   => 'January 1st, 2007, 1:37 pm',
    '|d M Y|, H:i'     => 'Today, 13:37 / 01 Jan 2007, 13:37',
    '|F jS, Y|, g:i a' => 'Today, 1:37 pm / January 1st, 2007, 1:37 pm'
    ),

    'default_dateformat' => 'D M d, Y g:i a', // Mon Jan 01, 2007 1:37 pm
    'CUSTOM_DATEFORMAT'  => 'Custom',

    'VARIANT_DATE_SEPARATOR'    => ' / ', // Used in Date Format Drop Down, eg: 'Today, 13:37 / 01 Jan 2007, 13:37' ... to Join a Relative Date with Calendar Date

    'tz' => array(
    '-12'   => 'UTC - 12 hours',
    '-11'   => 'UTC - 11 hours',
    '-10'   => 'UTC - 10 hours',
    '-9.5'  => 'UTC - 9:30 hours',
    '-9'    => 'UTC - 9 hours',
    '-8'    => 'UTC - 8 hours',
    '-7'    => 'UTC - 7 hours',
    '-6'    => 'UTC - 6 hours',
    '-5'    => 'UTC - 5 hours',
    '-4.5'  => 'UTC - 4:30 hours',
    '-4'    => 'UTC - 4 hours',
    '-3.5'  => 'UTC - 3:30 hours',
    '-3'    => 'UTC - 3 hours',
    '-2'    => 'UTC - 2 hours',
    '-1'    => 'UTC - 1 hour',
    '0'     => 'UTC',
    '1'     => 'UTC + 1 hour',
    '2'     => 'UTC + 2 hours',
    '3'     => 'UTC + 3 hours',
    '3.5'   => 'UTC + 3:30 hours',
    '4'     => 'UTC + 4 hours',
    '4.5'   => 'UTC + 4:30 hours',
    '5'     => 'UTC + 5 hours',
    '5.5'   => 'UTC + 5:30 hours',
    '5.75'  => 'UTC + 5:45 hours',
    '6'     => 'UTC + 6 hours',
    '6.5'   => 'UTC + 6:30 hours',
    '7'     => 'UTC + 7 hours',
    '8'     => 'UTC + 8 hours',
    '8.75'  => 'UTC + 8:45 hours',
    '9'     => 'UTC + 9 hours',
    '9.5'   => 'UTC + 9:30 hours',
    '10'    => 'UTC + 10 hours',
    '10.5'  => 'UTC + 10:30 hours',
    '11'    => 'UTC + 11 hours',
    '11.5'  => 'UTC + 11:30 hours',
    '12'    => 'UTC + 12 hours',
    '12.75' => 'UTC + 12:45 hours',
    '13'    => 'UTC + 13 hours',
    '14'    => 'UTC + 14 hours',
    'dst'   => '[ <abbr title="Daylight Saving Time">DST</abbr> ]',
        ),

    'tz_zones'  => array(
    '-12'   => '[UTC - 12] Baker Island Time',
    '-11'   => '[UTC - 11] Niue Time, Samoa Standard Time',
    '-10'   => '[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time',
    '-9.5'  => '[UTC - 9:30] Marquesas Islands Time',
    '-9'    => '[UTC - 9] Alaska Standard Time, Gambia Island Time',
    '-8'    => '[UTC - 8] Pacific Standard Time',
    '-7'    => '[UTC - 7] Mountain Standard Time',
    '-6'    => '[UTC - 6] Central Standard Time',
    '-5'    => '[UTC - 5] Eastern Standard Time',
    '-4.5'  => '[UTC - 4:30] Venezuelan Standard Time',
    '-4'    => '[UTC - 4] Atlantic Standard Time',
    '-3.5'  => '[UTC - 3:30] Newfoundland Standard Time',
    '-3'    => '[UTC - 3] Amazon Standard Time, Central Greenland Time',
    '-2'    => '[UTC - 2] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time',
    '-1'    => '[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time',
    '0'     => '[UTC] Western European Time, Greenwich Mean Time',
    '1'     => '[UTC + 1] Central European Time, West African Time',
    '2'     => '[UTC + 2] Eastern European Time, Central African Time',
    '3'     => '[UTC + 3] Moscow Standard Time, Eastern African Time',
    '3.5'   => '[UTC + 3:30] Iran Standard Time',
    '4'     => '[UTC + 4] Gulf Standard Time, Samara Standard Time',
    '4.5'   => '[UTC + 4:30] Afghanistan Time',
    '5'     => '[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time',
    '5.5'   => '[UTC + 5:30] Indian Standard Time, Sri Lanka Time',
    '5.75'  => '[UTC + 5:45] Nepal Time',
    '6'     => '[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time',
    '6.5'   => '[UTC + 6:30] Cocos Islands Time, Myanmar Time',
    '7'     => '[UTC + 7] Indochina Time, Krasnoyarsk Standard Time',
    '8'     => '[UTC + 8] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time',
    '8.75'  => '[UTC + 8:45] Southeastern Western Australia Standard Time',
    '9'     => '[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time',
    '9.5'   => '[UTC + 9:30] Australian Central Standard Time',
    '10'    => '[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time',
    '10.5'  => '[UTC + 10:30] Lord Howe Standard Time',
    '11'    => '[UTC + 11] Solomon Island Time, Magadan Standard Time',
    '11.5'  => '[UTC + 11:30] Norfolk Island Time',
    '12'    => '[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time',
    '12.75' => '[UTC + 12:45] Chatham Islands Time',
    '13'    => '[UTC + 13] Tonga Time, Phoenix Islands Time',
    '14'    => '[UTC + 14] Line Island Time',
    ),

    '30_MINS'                  => '30 Minutes',
    '6_HOURS'                  => '6 Hours',
    '1_HOUR'                   => '1 Hour',
    '1_DAY'                    => '1 Day',
    '1_MONTH'                  => '1 Month',
    '1_YEAR'                   => '1 Year',
    '2_WEEKS'                  => '2 Weeks',
    '3_MONTHS'                 => '3 Months',
    '6_MONTHS'                 => '6 Months',
    '7_DAYS'                   => '7 Days',
    'ADDED'                    => 'Added',
    'ADDED_BY'                 => 'Added by',
    'ADD_NEW'                  => 'Add New',
    'ALERT_ERROR'              => 'Form has NOT been Submitted due to the following Errors:',
    'ACTION'                   => 'Action',
    'ACTIONS'                  => 'Actions',
    'ACTIVE'                   => 'Active',
    'ACTIVATION_ERROR'         => 'Activation Error',
    'ARCHIVES'                 => 'Archives',
    'ADD_COMMENT'              => 'Add a Comment',
    'ADMIN_CP'                 => 'Administration Panel',
    'ADMINISTRATOR'            => 'Administrator',
    'ADMINISTRATORS'           => 'Administrators',
    'AGO'                      => 'ago',
    'ALL_ENTRIES'              => 'ALL Entries',
    'ATTACHMENTS'              => 'Attachments',
    'ALT_LOCKED_T'             => 'Pending Authorisation',
    'ALT_LOCKED_T_REQ'         => 'Ask for Authorisation',
    'ARCADE'                   => 'Arcade',
    'ASCENDING'                => 'Ascending',
    'AUTHOR'                   => 'Author',
    'AVATAR'                   => 'Avatar',
    'LOCATION'                 => 'Location',
    'AVATAR_CATEGORY'          => 'Category',
    'AVATAR_GALLERY'           => 'Local Gallery',
    'AVATAR_EXPLAIN'           => 'Maximum Dimensions.  Width: %1$d Pixels, Height: %2$d Pixels, File Size: %3$.2f KiB.',
    'AVG_SPEED'                => 'Average Speed',
    'BBCODE_GUIDE'             => 'BBCode Guide',
    'BACK_TO_TOP'              => 'Top',
    'BACK'                     => 'Back',
    'BAN_ACCOUNT'              => 'Ban Account',
    'BAN_SHOUTS'               => 'Shoutbox Ban',
    'USE_PERMISSIONS'          => 'Test out Members Permissions',
    'WARNINGS'                 => 'Warnings',
    'CONFIRM_EMAIL'            => 'Confirm email Address',
    '_NEW'                     => 'New',
    'NEW_PASSWORD'             => 'New Password',
    'CONFIRM_PASSWORD'         => 'Confirm Password',
    'CONFIRM_PASSWORD_EXPLAIN' => 'You ONLY need to Confirm your Password if you changed it above.',
    'BANN'                     => 'Ban',
    'PAGES'                    => 'Pages',
    'PAGE'                     => 'Page',
    'BANNED'                   => 'Banned',
    'BANNED_FOR'               => 'You have been Banned from this Site because:- <strong>%1$d</strong>',
    'BROWES'                   => 'Browse',
    'BT_ERROR'                 => 'Error',
    'BACK_TO_PREV'             => 'Back to Previous Page',
    'CAT_SELECT'               => 'Select a Category',
    'CATEGORY'                 => 'Category',
    'CONFIRM_OPERATION'        => 'Are you sure you wish to carry out this Operation?',
    'CHOOSE'                   => 'Choose',
    'CANCEL'                   => 'Cancel',
    'RETURN_PAGE'              => 'Return to Previous Page',
    'CASINO'                   => 'Casino',
    'CLICK_HERE'               => 'Click Here',
    'CLOSE_WINDOW'             => 'Close Window',
    'COLOUR_SWATCH'            => 'Colour Swatch',
    'COMMENT'                  => 'Comment',
    'COMMENTS'                 => 'Comments',
    'COMPLETED'                => 'Completed',
    'COMPLETE_NAME'            => 'Complete Name',
    'CONFIRM'                  => 'Confirm',
    'CONTINUE'                 => 'Continue',
    'CURRENT_IMAGE'            => 'Current Image',
    'DATE'                     => 'Date',
    'DAYS'                     => 'Days',
    'DATE_ADDED'               => 'Date Added',
    'DETAILS'                  => 'Details',
    'DETACH'                   => 'Detach',
    'DELETE'                   => 'Delete',
    'DELETE_MARKED'            => 'Delete Marked',
    'DELETE_ALL'               => 'Delete ALL',
    'DELETE_AVATAR'            => 'Delete Image',
    'DESCENDING'               => 'Descending',
    'DELIMITER'                => 'Delimiter',
    'DESCRIPTION'              => 'Description',
    'TRACKERS'                 => 'Trackers',
    'TRACKER_OVER_VIEW'        => 'Tracker Overview',
    'SDEFAULT'                 => 'Default',
    'DISPLAY_LOG'              => 'Display Entries from Previous',
    'DISPLAY_GALLERY'          => 'Display Gallery',
    'DONOR'                    => 'Donator',
    'DONATIONS'                => 'Donations',
    'DONT_CHEAT'               => 'Don\'t Cheat!',
    'DOWNLOAD'                 => 'Download',
    'DOWNED'                   => 'Downloaded',
    'EDIT'                     => 'Edit',
    'NOTICE'                   => 'Notice',
    'EDIT_PROFILE'             => 'Edit Profile',
    'ED2K_LINK'                => 'eD2K Link',
    'ERROR_MINSEED'            => 'You MUST be Seeding at least %1$s Torrents to Download.',
    'ERROR_MINSEEDSIZE'        => 'To Download you Need to Seed at Least a Minimum of %1$s Torrent.',

    'ERROR_BLACK_LISTED'       => 'The Owner Refused to let you Download their Torrents.  You won\'t be able to Download any of them.',

    'ERROR_PRIVATE_FILE'     => 'This is a Private File.  You have already asked for Permission to Download.  You can NOT Download the File until the Owner Accepts your Request.',

    'ERROR_PRIVATE_DENIDE'   => 'The Owner Refused your Download Request.  You won\'t be able to Download this Torrent.',

    'ERROR_PRIVATE_REQ_SENT' => 'This Torrent is Private.  You won\'t be able to Download it until the Owner gives you Permission. A Request has been sent to the Torrent Owner, who needs to Authorise your Download.  You will be Notified about the Result by email.',

    'ENCLOSURE'            => 'Enclosure',
    'FIND_USERNAME'        => 'Find Username',
    'EMAIL'                => 'email',
    'REFRESH_PEERS'        => 'Refresh Peer Data',
    'PEERS_UPDATE_ALREDY'  => 'Statistics Updated less than 30 Minutes ago',
    'AUTH_PENDING'         => 'Pending Authorisations!',
    'AUTH_PENDING_NONE'    => 'No Pending Authorisations',
    'RATE_A'               => 'Legal Content.  Good Quality',
    'RATE_B'               => 'Fake or Corrupted',
    'RATE_C'               => 'Copyrights Violation',
    'RATE_D'               => 'Pornographic Content',
    'RATE_E'               => 'Child Pornography',
    'RATE_F'               => 'Offensive Content',
    'RATE_G'               => 'Content Related to Illegal Activity',
    'EMPTY_FILE_NAME'      => 'Empty Filename',
    'EST_DOWNLOAD_TIME'    => 'Estimated Download Time',
    'FAQS'                 => 'FAQ\'S',
    'FAQ_EXPLAIN'          => 'Frequently Asked Questions',
    'FILE_UNAVAILABLE'     => 'Torrent File Unavailable due to a Server Configuration Error.  Sorry for the Inconvenience.',
    'FILE'                 => 'File',
    'FILE_NAME'            => 'Filename',
    'FILES'                => 'Files',
    'FILE_EMPTY'           => 'File Empty',
    'GAMES'                => 'Games',
    'GENERAL'              => 'General',
    'GO'                   => 'Go',
    'GROUP'                => 'Group',
    'INVALID_IMAGE_EXT'    => 'Image File has to be a gif, jpg or png',
    'GROUP_ERR_USER_LONG'  => 'Group Names can NOT Exceed 60 Characters.  The Specified Group Name is Too Long.',
    'GROUP_ERR_TYPE'       => 'Inappropriate Group Type Specified.',
    'GROUP_ERR_USERNAME'   => 'No Group Name Specified.',
    'GROUP_NO_ACCESS_PAGE' => 'Your Group does NOT have <strong>ACCESS</strong> to this Page.',
    'ILLIGALCAT'           => 'Illegal Category!',
    'HELP'                 => 'Help Desk',
    'ID'                   => 'ID',
    'INDEX'                => 'Index',
    'IMAGE'                => 'Image',
    'IN_ACTIVE'            => 'Inactive',
    'INVALID'              => 'Invalid',
    'INVALID_FILE_NAME'    => 'Invalid Filename',
    'INVALID_SIZE'         => 'File goes beyond Allowed Size',
    'INVALID_ID'           => 'Invalid ID',
    'INVITES'              => 'Invites',
    'INFORMATION'          => 'Information',
    'IRC_CHAT'             => 'IRC Chat',
    'JUMP_PAGE'            => 'Enter the Page Number you wish to go to',
    'JOINED'               => 'Joined ',
    'KINO'                 => 'Kino',
    'LASTACTION'           => 'Last Action',
    'LAST_ACTIVE'          => 'Last Active',
    'LAST_ACTIVITY'        => 'Last Activity',
    'LOTTERY'              => 'Lottery',
    'BLACKJACK'            => 'BlackJack',
    'LANGUAGE'             => 'Language',
    'LEECHERS'             => 'Leechers',

    'LINK'                       => 'Link',
    'LINKS'                      => 'Links',
    'LINK_REMOTE_SIZE'           => 'Avatar Dimensions',
    'LINK_REMOTE_AVATAR'         => 'Link Off Site',
    'LINK_REMOTE_AVATAR_EXPLAIN' => 'Enter the URL of the Location containing the Avatar Image you wish to Link to.',
    'LINK_REMOTE_SIZE_EXPLAIN'   => 'Specify the Width and Height of the Avatar.  Leave Blank to attempt Automatic Verification.',

    'LOCAL'                  => 'Local',
    'LOCK'                   => 'Lock',
    'LOG_OUT'                => 'Log Out',
    'PASS_WORD_REQ'          => 'This Download Requires a Password.',
    'LOAD_DRAFT'             => 'Load Draft',
    'LOGIN'                  => 'Login',
    'LOGOUT'                 => 'Logout',
    'LOGIN_SITE'             => 'The Site Requires you to be Registered and Logged In.',
    'LOGIN_GROUP'            => 'The Site Requires you to be Registered and have a Group Level of %1$s.',
    'LOGIN_SUCCESS'          => 'Success.  Full Login, enjoy your stay!',
    'LOGOUT_SUCCESS'         => 'You have Logged Out.  Come Back soon!',
    'LOG_GROUP_DEFAULTS'     => '<strong>Group %1$s was made Default for Members</strong><br /> %2$s',
    'LOG_GROUP_REMOVE'       => '<strong>Members Removed from Usergroup</strong> %1$s<br /> %2$s',
    'LOG_GROUP_CREATED'      => '<strong>New Usergroup Created</strong><br /> %s',
    'LOG_GROUP_UPDATED'      => '<strong>Usergroup Details Updated</strong><br /> %s',
    'MCP'                    => 'Moderator Control Panel',
    'MD5_HASH'               => 'MD5 Hash',
    'MAGNET_LINK'            => 'Magnet Link',
    'MARK'                   => 'Mark',
    'MESSAGE'                => 'Message',
    'MISSING_DATA'           => 'Required Data Missing!',
    'MISSING_FILE'           => 'The File your looking for DOES NOT Exist!',
    'MODERATE'               => 'Moderate',
    'MODERATOR'              => 'Moderator',
    'MODERATORS'             => 'Moderators',
    'NEXT'                   => 'Next',
    'NAME'                   => 'Name',
    'NAMES'                  => 'Names',
    'NEW_MESAGE'             => 'New Message',
    'NO'                     => 'No',
    'NONE'                   => 'None',
    'NO_FILE_UPLOADED'       => 'Fatal Error in Uploaded File!',
    'NO_SUCH_USER'           => 'No such User',
    'NOT_AUTH_DOWNLOAD'      => 'You are NOT Authorised to Download from this Site!',
    'NOTIFY_EMAIL'           => 'email Notifications',
    'NOTIFY_ADMIN_EMAIL'     => 'Please Notify the Board Administrator or Webmaster: <a href=\'mailto:%1$s\'>%1$s</a>',

    'NOTIFY_SEEDERS'         => 'If you want to be emailed when the First <strong>SEED</strong> shows up.  Please Click <a href=\'details.php?op=seeder&amp;trig=on&amp;id=%1$s#notify\'>HERE</a>',

    'NOTIFY_COMMENTS'        => 'If you want to be emailed when the First Comment is added.  Please Click <a href=\'details.php?op=comment&amp;trig=on&amp;id=%1$s#notify\'>HERE</a>',

    'NOTIFY_SEEDERS_REMOVE'  => 'You are Currently Listed to be Notified when a Seed pops up.  If you don\'t want to be emailed any more, please Click <a href=\'details.php?op=seeder&trig=off&id=%1$s#notify\'>HERE</a>',

    'NOTIFY_COMMENTS_REMOVE' => 'You are Currently Listed to Receive Comment email.  If you Don\'t want to be emailed any more, please Click <a href=\'details.php?op=comment&trig=off&id=%1$s#notify\'>HERE</a>',

    'NO_NAME_SET'              => 'No Name was Set.',
    'NO_ACTIVATION_KEY_SET'    => 'Activation Key NOT Specified!',
    'NO_TORRENTS'              => 'There are NO Torrents',
    'NO_SUCH_USER'             => 'This UserName Does NOT Exist.',
    'NO_REASON_GIVEN'          => 'No Reason was given',
    'NO_SUCH_TORRENT'          => 'Torrent Does NOT Exist or has been Banned!',
    'NOT_A_TORRENT_FILE'       => 'This is NOT a Torrent File (.torrent)',
    'NUB_OF_FILES'             => 'Number of Files',
    'NUKE'                     => 'Nuke',
    'NUKED'                    => 'Nuked',
    'EXTERNAL_TRACKER'         => 'External Tracker',
    'NUKED_REASON'             => 'Nuke Reason',
    'OWNER'                    => 'Owner',
    'OPTIONS'                  => 'Options',
    'ON_LINE'                  => 'Online',
    'OFF_LINE'                 => 'Offline',
    'ONLY'                     => 'Only',
    'PASSWORD'                 => 'Password',
    'PASSWORD_CONFIRM'         => 'Confirm Password',
    'PIXEL'                    => 'px',
    'POSTS'                    => 'Posts',
    'PM'                       => 'PM',
    'DL'                       => 'DL',
    'PREMIUM_USER'             => 'Premium User',
    'PRIVATE_MESSAGES'         => 'Private Messages',
    'PRIVATE_MESSAGE'          => 'Private Message',
    'PRIVATE_SHOUT'            => 'Private Shout!',
    'ACCESS_DENIED'            => 'Access Denied!',
    'PRIVATE_PM'               => '[PM]',
    'PREVEASE'                 => 'Previous',
    'QUESTION'                 => 'Question',
    'RESET'                    => 'RESET',
    'REFRESH'                  => 'Refresh',
    'REGISTOR'                 => 'Register',
    'RATE'                     => 'Rate',
    'RATING'                   => 'Rating',
    'RATINGS'                  => 'Ratings',
    'RATIO'                    => 'Ratio',
    'REDIRECT'                 => 'Redirect',
    'DONATE'                   => 'DONATE',
    'GOAL'                     => 'Goal',
    'COLECTED'                 => 'Collected',
    'PROGRESS'                 => 'Donation Progress',
    'REDIRECT_EXP'             => 'You are being Redirected to the Page in 3 seconds <br /><br />%1$s',
    'RULE'                     => 'Rule',
    'RULES'                    => 'Rules',
    'RATIO_BUILDER'            => 'Ratio Builder',
    'RETURN_INDEX'             => '%s Return to the Index Page %s',
    'SEARCH'                   => 'Search',
    'SEARCH_CLOUD'             => 'Search Cloud',
    'SECURITY_CODE'            => 'Security Code',
    'SEC_CODE_ERROR'           => 'The Security Code you Entered is Wrong',
    'SEEDERS'                  => 'Seeders',
    'SETTINGS'                 => 'Settings',
    'SITE_NEWS'                => 'Site News',
    'SHOUT'                    => 'Shout',
    'INACTIVE_DATE'            => 'Inactive Date',
    'INACTIVE_REASON'          => 'Reason',
    'INACTIVE_REASON_MANUAL'   => 'Account Deactivated by Administrator',
    'INACTIVE_REASON_PROFILE'  => 'Profile Details Changed',
    'INACTIVE_REASON_REGISTER' => 'Newly Registered Account',
    'INACTIVE_REASON_REMIND'   => 'Forced User Account Reactivation',
    'INACTIVE_REASON_UNKNOWN'  => 'Unknown',
    'INACTIVE_USERS'           => 'Inactive Users',
    'INACTIVE_USERS_EXPLAIN'   => 'This is a List of Users who have Registered but whose Accounts are Inactive. You can Activate, Delete or Remind (by sending an email) to these Users if you wish.',

    'INACTIVE_USERS_EXPLAIN_INDEX' => 'This is a List of the Last 10 Registered Users who have Inactive Accounts.  A FULL List is available from the appropriate Menu Item or by following the Link below.  You can Activate, Delete or Remind (by sending an email) to these Users if you wish?',

    'JAVA_NEW_PM'               => 'You have a NEW PM.  Please Click OK to go to your PM Inbox.',
    'NO_INACTIVE_USERS'         => 'No Inactive Users',
    'NO_SUCH_USER'              => 'This Username does NOT Exist.',
    'SORT_INACTIVE'             => 'Inactive Date',
    'SORT_LAST_VISIT'           => 'Last Visit',
    'SORT_REASON'               => 'Reason',
    'SORT_REG_DATE'             => 'Registration Date',
    'USER_IS_INACTIVE'          => 'User is Inactive',
    'SIGN_UP'                   => 'Sign Up',
    'SHOUT_BOX'                 => 'Shoutbox',
    'SHOUT_NEW_UPLOAD'          => 'Hi, I have just Uploaded [url=%1$s/details.php?id=%2$s][b]%3$s[/b][/url].  Enjoy it!',
    'SIZE'                      => 'Size',
    'SELECT_CATEGORY'           => 'Select a Category',
    'SKIP'                      => 'Skip to Content',
    'SORT_BY'                   => 'Sort by',
    'SPEED'                     => 'Speed',
    'SEED_BOMUS'                => 'Seeding Bonus',
    'SEEDING'                   => 'Seeding',
    'SELECT_OPTION'             => 'Select Option',
    'SORT'                      => 'Sort',
    'STATUS'                    => 'Status',
    'STATISTICS'                => 'Statistics',
    'SUBMIT'                    => 'Submit',
    'PREVIEW'                   => 'Preview',
    'SUCCESS'                   => 'Success',
    'SECURITY_CODE'             => 'Security Code',
    'SUMMARY'                   => 'Summary',
    'SNATCHED'                  => 'Snatched',
    'TOTAL_PEERS'               => 'Total Peers',
    'PEERS'                     => 'Peers',
    'TIME'                      => 'Time',
    'TIMES'                     => 'Times',
    'THEME'                     => 'Theme',
    'THEMES'                    => 'Themes',
    'TOPICS'                    => 'Topics',
    'TOPIC'                     => 'Topic',
    'TORRENT'                   => 'Torrent',
    'TORRENTS'                  => 'Torrents',
    'TORRENT_NEED_SEED'         => 'Torrents that need Seeding',
    'TORRENT_NEED_SEED_EXP'     => 'If you happen to have the Files on your HDD, please Help them out.  Thank You!',
    'PEER_SPEED'                => 'Peer Speed',
    'TRACKER'                   => 'Tracker',
    'TYPE'                      => 'Type',
    'TYPES'                     => 'Types',
    'UNLOCKED'                  => 'Unlocked',
    'UPDATE'                    => 'Update',
    'UPDATED'                   => 'Updated',
    'UPLOAD'                    => 'Upload',
    'UPDATING'                  => 'Updateing....',
    'UPLODED'                   => 'Uploaded',
    'UPLOAD_FILE'               => 'Upload File',
    'UPLOADER'                  => 'Uploader',
    'UPLOAD_FAILED'             => 'The Upload has Failed!',
    'USER'                      => 'User',
    'USERS'                     => 'Users',
    'USER_ALREADY_ACTIVATED'    => 'User is already Activated.',
    'USERPROFILE'               => 'Profile',
    'USEREPROFILE'              => 'Edit',
    'STAFF'                     => 'Staff',
    'USER_NOT_EDIT_ABL_BYCLASS' => 'You DO NOT have Access to Edit this User',
    'USERNAME'                  => 'Users Name',
    'UNLOCK'                    => 'Unlock',
    'UNKNOWN'                   => 'Unknown',
    'URL_REDIRECT'              => 'If your Browser does NOT Support Meta Redirection %s please click HERE to be Redirected %s.',
    'REDIRECT_ACL'              => 'Now you are able to %s Set Permissions %s for this Forum.',
    'ERROR_NOT_NUMBER'          => 'NOT a Valid Number [0-9]',
    'VISIBLE'                   => 'Visible',
    'VIEW'                      => 'View',
    'VOTE'                      => 'Vote',
    'VOTES'                     => 'Votes',
    'WARNED'                    => 'Warned',
    'WHOIS'                     => 'Whois',
    'YOUR_TORRENTS'             => 'Your Torrents',
    'YES'                       => 'Yes',
    'VIEW_RESULTS'              => 'View Results',
    'MOD_OPTIONS'               => 'Moderator Options',

    'FREE_LEACH_EXP'            => 'Any Torrents with this Symbol are Ratio Boosters.  Only your Upload is Recorded!!<br />This is a great way to Boost your Ratio. Normal Site Seeding Rules Apply.<br />Seed to 1.0 or 36 hours to avoid Hit and Runs.',

    'NO_SAVED_DRAFTS'           => 'No Drafts Saved.',

    'NUKED_EXP'                 => 'Any Torrents with this Symbol are Nuked.<br />This means that for some reason someone has determined that there is something wrong with the Release, and it may or may not be viewable.<br />Use your own discretion when Downloading these Torrents.<br />Normal Site Seeding Rules still Apply unless also made Free.  Please Read Details for Reason',

    '_BBCODE_A_HELP'        => 'Inline Uploaded Attachment: [attachment=]filename.ext[/attachment]',
    '_BBCODE_B_HELP'        => 'Bold Text: [b]text[/b]',
    '_BBCODE_C_HELP'        => 'Code Display: [code]code[/code]',
    '_BBCODE_E_HELP'        => 'List: Add List Element',
    '_BBCODE_F_HELP'        => 'Font Size: [size=85]small text[/size]',
    '_BBCODE_IS_OFF'        => '%s BBCode %s is <em>OFF</em>',
    '_BBCODE_IS_ON'         => '%s BBCode %s is <em>ON</em>',
    '_BBCODE_I_HELP'        => 'Italic Text: [i]text[/i]',
    '_BBCODE_L_HELP'        => 'List: [list]text[/list]',
    '_BBCODE_LISTITEM_HELP' => 'List Item: [*]text[/*]',
    '_BBCODE_O_HELP'        => 'Ordered List: [list=]text[/list]',
    '_BBCODE_P_HELP'        => 'Insert Image: [img]http://image_url[/img]',
    '_BBCODE_Q_HELP'        => 'Quote Text: [quote]text[/quote]',
    '_BBCODE_S_HELP'        => 'Font Colour: [color=red]text[/color]  Tip:  You can also use color=#FF0000',
    '_BBCODE_U_HELP'        => 'Underline Text: [u]text[/u]',
    '_BBCODE_W_HELP'        => 'Insert URL: [url]http://url[/url] OR [url=http://url]URL text[/url]',
    '_BBCODE_D_HELP'        => 'Flash: [flash=width,height]http://url[/flash]',
    '_STYLES_TIP'           => 'Tip:  Styles can be Applied Quickly to Selected Text.22',
    '_SMILIES'              => 'Smilies',
    '_MORE_SMILIES'         => 'View more Smilies',
    '_FONT_COLOR'           => 'Font Colour',
    '_FONT_COLOR_HIDE'      => 'Hide Font Colour',
    '_FONT_HUGE'            => 'Huge',
    'WROTE'                 => 'Wrote',
    '_FONT_LARGE'           => 'Large',
    '_FONT_NORMAL'          => 'Normal',
    '_FONT_SIZE'            => 'Font Size',
    '_FONT_SMALL'           => 'Small',
    '_FONT_TINY'            => 'Tiny',
    'USER_CPANNEL'          => 'User Control Panel',
    'ADMINISTRATION'        => 'Administration',
    'UPLOADING'             => 'Uploading',
    'DOWNLOADING'           => 'DownLoading',
    'SHOUTS'                => 'Shouts',
    'FORUM'                 => 'Forum',
    'OTHER'                 => 'Other',
    'USER_IP'               => 'User\'s IP',
    'USER_HOST'             => 'User\'s Host',
    'USER_EMAIL'            => 'User\'s email',
    'CANCEL_SUB'            => 'Cancel Modifications',
    'REPLIES'               => 'Replies',
    'SUBJECT'               => 'Subject',
    'VIEWS'                 => 'Views',
    'ALL_TOPICS'            => 'All Topics',
    'ALL_POSTS'             => 'All Posts',
    'VIEW_NOTES'            => 'View Notes',
    'WARN_USER'             => 'Warn User',
    'INVALID_IMAGE_TYPE'    => 'Invalid Image Type',

    'INVALID_REMOTE_DATA'   => 'The Specified Avatar could NOT be Uploaded because the Remote Data appears to be Invalid or Corrupted.',

    '_URL_INVALID'             => 'The URL you Specified is Invalid.',
    'AVATAR_NOT_UPLOADED'      => 'Avatar could NOT be Uploaded.',
    'G_ADMINISTRATORS'         => 'Administrators',
    'G_BOTS'                   => 'BOTS',
    'G_GUESTS'                 => 'Guests',
    'G_REGISTERED'             => 'Registered Users',
    'G_REGISTERED_COPPA'       => 'Registered COPPA Users',
    'G_GLOBAL_MODERATORS'      => 'Global Moderators',
    'G_OWNER'                  => 'Owner',
    'G_PREMIUM_USER'           => 'Premium User',
    'G_MODERATOR'              => 'Moderator',
    'G_USER'                   => 'User',
    'NO_UPLOAD_FORM_FOUND'     => '',
    'ATTACHED_IMAGE_NOT_IMAGE' => '',
    'ATTACH_QUOTA_REACHED'     => 'Sorry.  The Board Attachment Quota has been Reached.',
    'USER_NAME'                => 'Username',
    'SQL_ERRORSQL'             => 'Error Executing SQL Query ',
    'SQL_ERRORCODE'            => 'Error ID: ',
    'SQL_ERRORMSG'             => 'Error Message: ',
    'T_U_SEED'                 => 'Torrents you are Seeding',
    'T_U_LEECH'                => 'Torrents you are Downloading',
    'SORT_TOPIC_TITLE'         => 'Topic Title',
    'PAGE_OF'                  => 'Page <strong>%1$d</strong> of <strong>%2$d</strong>',
    'GLOBAL_ANNOUNCEMENT'      => 'Global Announcement',
    'VIEW_FORUM_TOPIC'         => '1 Topic',
    'VIEW_FORUM_TOPICS'        => '%d Topics',
    'UNMARK_ALL'               => 'Unmark ALL',
    'MARK_ALL'                 => 'Mark ALL',
    'GOTO_PAGE'                => 'Go to Page',
    'JUMP_TO_PAGE'             => 'Click to Jump to Page',
    'BAND_SHOUTS'              => 'Sorry.  You are Banned From Shouts!',
    'NO_USERS_ONLINE'          => 'There are NO Registered Users Online',
    'ADV_ONLINE_MO'            => 'Advanced Mode',
    'SEMP_ONLINE_MOD'          => 'Simple Mode',
    'T_DIR_NOT_PRES'           => 'Torrent Dictionary NOT Present',
    'T_DIR_MES_KEY'            => 'Missing Torrent Dictionary Keys',
    'INV_DATA_IN_DIR'          => 'Invalid Data inside Torrent Dictionary',
    'HAPPY_BIRTHDAY'           => 'Congratulations to: ',
    'NO_BIRTHDAY'              => 'No Birthdays Today',
    'NO_NEW_USERS'             => 'No New Members',
    'EXTENTION'                => 'Extension',
    'WELCOME_BACK'             => 'Welcome Back,',
    'CURENT_BROWS'             => 'Currently Browsing',
    'LOGEDIN_FOR'              => 'Logged in for',

    'HNR_REMOVED'              => 'Your Hit and Run Warning has been Removed because you have Restarted your Torrent.  Please keep Seeding for 72 hours or your Warning will be Reinstated',

    'HIT_N_RUN'              => 'Hit and Run',

    'MOD_HNR_COMENT_ADD'     => gmdate('d-m-Y').' - Warned by System for Hit and Run.\n',

    'HNR_WARN_PM'            => 'You have Repeatedly Hit and Run on Torrents even after we have notified you that you should return to the Torrent to Continue Seeding.  Therefore you have Received a One Week Warning.  Hopefully you will NOT Hit and Run on Torrents any more, and if you Do it may Result in your Account being Disabled.',

    'MOD_HNR_COMENT_REMOVED' => gmdate('d-m-Y').' - Warning Removed by System for Hit and Run.\n',

    'HNR_NOTICE_PM'          => 'It appears that you have Hit and Run on {hnrtot} Torrent {hnrcount}.\n\nWe advise you to return to Continue Seeding {these} Torrents {hnrcount} within 30 Minutes or else you Risk being Warned, or if this happens to you Repeatedly you may even Risk your Account being Disabled.\n\nThe Torrent {hnrcount} on which you have been found Hit and Running on {is}:\n{hnrtorrents}',

        #Start New Member Block
    'NEWEST_MEMBERS' => 'Newest Members',
        #End New Member Block

        #Start Users Today Block
    'USERS_ON_TODAY' => 'Users Active in the Past 24 Hours',
        #End Users Today Block

    'u_datetime' => array(
        'TODAY'     => 'Today',
        'TOMORROW'  => 'Tomorrow',
        'YESTERDAY' => 'Yesterday',
        'Sunday'    => 'Sunday',
        'Monday'    => 'Monday',
        'Tuesday'   => 'Tuesday',
        'Wednesday' => 'Wednesday',
        'Thursday'  => 'Thursday',
        'Friday'    => 'Friday',
        'Saturday'  => 'Saturday',
        'Sun'       => 'Sun',
        'Mon'       => 'Mon',
        'Tue'       => 'Tue',
        'Wed'       => 'Wed',
        'Thu'       => 'Thu',
        'Fri'       => 'Fri',
        'Sat'       => 'Sat',
        'January'   => 'January',
        'February'  => 'February',
        'March'     => 'March',
        'April'     => 'April',
        'May'       => 'May',
        'June'      => 'June',
        'July'      => 'July',
        'August'    => 'August',
        'September' => 'September',
        'October'   => 'October',
        'November'  => 'November',
        'December'  => 'December',
        'Jan'       => 'Jan',
        'Feb'       => 'Feb',
        'Mar'       => 'Mar',
        'Apr'       => 'Apr',
        'May_short' => 'May', // Short Representation of 'May'. May_short used because in English the Short and Long Date are the same for May.
        'Jun'       => 'Jun',
        'Jul'       => 'Jul',
        'Aug'       => 'Aug',
        'Sep'       => 'Sep',
        'Oct'       => 'Oct',
        'Nov'       => 'Nov',
        'Dec'       => 'Dec',

        'AGO' => array(
            0  => 'less than a Minute ago',
            1  => '%d Minute ago',
            2  => '%d Minutes ago',
            60 => '1 Hour ago',
            ),
        ),

    // 3.0.1 Addons
    'VARIANT_DATE_SEPARATOR' => ' / ', // Used in Date Format Dropdown, eg: 'Today, 13:37 / 01 Jan 2007, 13:37' ... to Join a Relative Date with Calendar Date
    '_btdays'               => 'd ',
    '_bthours'              => 'h ',
    '_btmins'               => 'm ',
    '_btsecs'               => 's ',
    '_at'                   => ' at ',
    '_dot'                  => ' dot ',
    'BIRTHDAYS'             => 'Birthday\'s',
    'COMPLIANT'             => 'Compliant',
    'TANSF_BONUS'           => 'Transfer Bonus',
    'PERSONAL_STATS'        => 'Personal Statistics',
    'THEME_CHANGER'         => 'Theme Change',
    'SELECT'                => 'Select',
    'SEND_INVITE'           => 'Send an Invite',
    'INVITE_COUNT'          => 'Your Total Invite Count is',
    'SELECT_FORUM'          =>  'Select Forum',
));

$u_datetime = array(
    'TODAY'     => 'Today',
    'TOMORROW'  => 'Tomorrow',
    'YESTERDAY' => 'Yesterday',

    'Sunday'    => 'Sunday',
    'Monday'    => 'Monday',
    'Tuesday'   => 'Tuesday',
    'Wednesday' => 'Wednesday',
    'Thursday'  => 'Thursday',
    'Friday'    => 'Friday',
    'Saturday'  => 'Saturday',

    'Sun'       => 'Sun',
    'Mon'       => 'Mon',
    'Tue'       => 'Tue',
    'Wed'       => 'Wed',
    'Thu'       => 'Thu',
    'Fri'       => 'Fri',
    'Sat'       => 'Sat',

    'January'   => 'January',
    'February'  => 'February',
    'March'     => 'March',
    'April'     => 'April',
    'May'       => 'May',
    'June'      => 'June',
    'July'      => 'July',
    'August'    => 'August',
    'September' => 'September',
    'October'   => 'October',
    'November'  => 'November',
    'December'  => 'December',

    'Jan'       => 'Jan',
    'Feb'       => 'Feb',
    'Mar'       => 'Mar',
    'Apr'       => 'Apr',
    'May_short' => 'May',   // Short Representation of 'May'. May_short used because in English the Short and Long Date are the same for May.
    'Jun'       => 'Jun',
    'Jul'       => 'Jul',
    'Aug'       => 'Aug',
    'Sep'       => 'Sep',
    'Oct'       => 'Oct',
    'Nov'       => 'Nov',
    'Dec'       => 'Dec'
);

?>
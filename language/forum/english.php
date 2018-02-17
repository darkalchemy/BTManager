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
* forum [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'COM_NEW'							=> 'Compose New Thread',
	'LAST_POST'							=>	'Last Post',
	'NO_POSTS'							=>	'No Posts',
	'FORUM_BANNED'						=>	'Unfortunately you have been banned from accessing the forums.<br />  Please contact a member of staff if you do not know the reason.',
	'MARK_FORUMS_READ'					=>	'Mark Forums Read',
	'REDIRECTING'						=>	'You are being redircted',
	'NO_TOPICS'							=>	'There are No Topics at this time.',
	'REPLIES'							=>	'Replies',
	'VIEWS'								=>	'Views',
	'MCP'								=>	'Moderator Control Pannel',
	'LOGIN_NOTIFY_FORUM'	=> 'You have been notified about this forum, please login to view it.',
	'NO_READ_ACCESS'		=> 'You do not have the required permissions to read topics within this forum.',
	'NO_READ_ACCESS'		=> 'You do not have the required permissions to read topics within this forum.',
	'POST_FORUM_LOCKED'		=> 'Forum is locked',
	'TOPICS_MARKED'			=> 'The topics for this forum have now been marked read.',
	'VIEW_FORUM'			=> 'View forum',
	'VIEW_FORUM_TOPIC'		=> '1 topic',
	'VIEW_FORUM_TOPICS'		=> '%d topics',
	'ALL_FORUMS'					=> 'All forums',
	'ACTIVE_TOPICS'			=> 'Active topics',
	'ANNOUNCEMENTS'			=> 'Announcements',
	'FORUM_PERMISSIONS'		=> 'Forum permissions',
	'DISPLAY_TOPICS'					=>	'Display Topics',
	'ALL_POSTS'						=> 'All posts',
	'UNREAD_POSTS'						=>	'Unread posts',
	'UNREAD_POSTS_HOT'					=>	'Unread posts [ Popular ]',
	'UNREAD_POSTS_LOCKED'				=>	'Unread posts [ Locked ]',
	'NO_UNREAD_POSTS_IMG'					=>	'No unread posts',
	'NO_UNREAD_POSTS_HOT'				=>	'No unread posts [ Popular ]',
	'NO_UNREAD_POSTS_LOCKED'			=>	'No unread posts [ Locked ]',
	'FORUM_LOCKED'						=>	'Forum locked',
	'ICON_ANNOUNCEMENT'					=>	'Announcement',
	'ICON_STICKY'						=>	'Sticky',
	'TOPIC_MOVED'						=>	'Moved topic',
	'MARK_TOPICS_READ'					=>	'Mark topics read ',
	'SEARCH_FOR'						=>	'Search for',
	'JUMP_TO'							=>	'Jump To',
	'SUBJECT'							=>	'Subject',
	'POST_TIME'							=>	'Post Time',
	'ALL_TOPICS'						=>	'All Topics',
	'LOG_APPROVE_TOPIC'			=> '<strong>Approved topic</strong><br />» %s',
	'LOG_BUMP_TOPIC'			=> '<strong>User bumped topic</strong><br />» %s',
	'LOG_DELETE_POST'			=> '<strong>Deleted post</strong><br />» %s',
	'LOG_DELETE_SHADOW_TOPIC'	=> '<strong>Deleted shadow topic</strong><br />» %s',
	'LOG_DELETE_TOPIC'			=> '<strong>Deleted topic</strong><br />» %s',
	'FLOOD_ERROR'				=> 'You cannot make another post so soon after your last.',
	'LOG_FORK'					=> '<strong>Copied topic</strong><br />» from %s',
	'LOG_LOCK'					=> '<strong>Locked topic</strong><br />» %s',
	'LOG_LOCK_POST'				=> '<strong>Locked post</strong><br />» %s',
	'LOG_MERGE'					=> '<strong>Merged posts</strong> into topic<br />» %s',
	'LOG_MOVE'					=> '<strong>Moved topic</strong><br />» from %1$s to %2$s',
	'LOG_POST_APPROVED'			=> '<strong>Approved post</strong><br />» %s',
	'LOG_POST_DISAPPROVED'		=> '<strong>Disapproved post “%1$s” with the following reason</strong><br />» %2$s',
	'LOG_POST_EDITED'			=> '<strong>Edited post “%1$s” written by</strong><br />» %2$s',
	'LOG_REPORT_CLOSED'			=> '<strong>Closed report</strong><br />» %s',
	'LOG_REPORT_DELETED'		=> '<strong>Deleted report</strong><br />» %s',
	'LOG_SPLIT_DESTINATION'		=> '<strong>Moved split posts</strong><br />» to %s',
	'LOG_SPLIT_SOURCE'			=> '<strong>Split posts</strong><br />» from %s',
	'LOG_TOPIC_APPROVED'		=> '<strong>Approved topic</strong><br />» %s',
	'LOG_TOPIC_DISAPPROVED'		=> '<strong>Disapproved topic “%1$s” with the following reason</strong><br />%2$s',
	'LOG_TOPIC_RESYNC'			=> '<strong>Resynchronised topic counters</strong><br />» %s',
	'LOG_TOPIC_TYPE_CHANGED'	=> '<strong>Changed topic type</strong><br />» %s',
	'LOG_UNLOCK'				=> '<strong>Unlocked topic</strong><br />» %s',
	'LOG_UNLOCK_POST'			=> '<strong>Unlocked post</strong><br />» %s',
	'SELECT'					=>	'Select',
	'TOPIC'						=>	'Topic',
	'IP'						=> 'IP',

	'LOG_DISALLOW_ADD'		=> '<strong>Added disallowed username</strong><br />» %s',
	'LOG_DISALLOW_DELETE'	=> '<strong>Deleted disallowed username</strong>',
	'RETURN_FORUM'				=> '%sReturn to the forum last visited%s',
	'POST_DELETED'				=> 'This message has been deleted successfully.',
	'RETURN_TOPIC'				=> '%sReturn to the topic last visited%s',
	'SELECT_FORUM'						=>	'Select Forum',
	'RULES_ATTACH_CAN'			=> 'You <strong>can</strong> post attachments in this forum',
	'RULES_ATTACH_CANNOT'		=> 'You <strong>cannot</strong> post attachments in this forum',
	'RULES_DELETE_CAN'			=> 'You <strong>can</strong> delete your posts in this forum',
	'RULES_DELETE_CANNOT'		=> 'You <strong>cannot</strong> delete your posts in this forum',
	'RULES_DOWNLOAD_CAN'		=> 'You <strong>can</strong> download attachments in this forum',
	'RULES_DOWNLOAD_CANNOT'		=> 'You <strong>cannot</strong> download attachments in this forum',
	'RULES_EDIT_CAN'			=> 'You <strong>can</strong> edit your posts in this forum',
	'RULES_EDIT_CANNOT'			=> 'You <strong>cannot</strong> edit your posts in this forum',
	'RULES_LOCK_CAN'			=> 'You <strong>can</strong> lock your topics in this forum',
	'RULES_LOCK_CANNOT'			=> 'You <strong>cannot</strong> lock your topics in this forum',
	'RULES_POST_CAN'			=> 'You <strong>can</strong> post new topics in this forum',
	'RULES_POST_CANNOT'			=> 'You <strong>cannot</strong> post new topics in this forum',
	'RULES_REPLY_CAN'			=> 'You <strong>can</strong> reply to topics in this forum',
	'RULES_REPLY_CANNOT'		=> 'You <strong>cannot</strong> reply to topics in this forum',
	'RULES_VOTE_CAN'			=> 'You <strong>can</strong> vote in polls in this forum',
	'RULES_VOTE_CANNOT'			=> 'You <strong>cannot</strong> vote in polls in this forum',
	'POST_TOPIC'			=> 'Post a new topic',
	'POST_REPLY'			=> 'Post a reply',
	'EDIT_POST'							=> 'Edit post',
	'SAVE'						=> 'Save',
	'SAVE_DATE'					=> 'Saved at',
	'SAVE_DRAFT'				=> 'Save draft',
	'SAVE_DRAFT_CONFIRM'		=> 'Please note that saved drafts only include the subject and the message, any other element will be removed. Do you want to save your draft now?',
	'SMILIES'					=> 'Smilies',
	'SMILIES_ARE_OFF'			=> 'Smilies are <em>OFF</em>',
	'SMILIES_ARE_ON'			=> 'Smilies are <em>ON</em>',
	'STICKY_ANNOUNCE_TIME_LIMIT'=> 'Sticky/Announcement time limit',
	'STICK_TOPIC_FOR'			=> 'Stick topic for',
	'STICK_TOPIC_FOR_EXPLAIN'	=> 'Enter 0 or leave blank for a never ending Sticky/Announcement.',
	'STYLES_TIP'				=> 'Tip: Styles can be applied quickly to selected text.',
	'PARTIAL_UPLOAD'			=> 'The uploaded file was only partially uploaded.',
	'PHP_SIZE_NA'				=> 'The attachment’s file size is too large.<br />Could not determine the maximum size defined by PHP in php.ini.',
	'PHP_SIZE_OVERRUN'			=> 'The attachment’s file size is too large, the maximum upload size is %1$d %2$s.<br />Please note this is set in php.ini and cannot be overridden.',
	'PLACE_INLINE'				=> 'Place inline',
	'POLL_DELETE'				=> 'Delete poll',
	'POLL_FOR'					=> 'Run poll for',
	'POLL_FOR_EXPLAIN'			=> 'Enter 0 or leave blank for a never ending poll.',
	'POLL_MAX_OPTIONS'			=> 'Options per user',
	'POLL_MAX_OPTIONS_EXPLAIN'	=> 'This is the number of options each user may select when voting.',
	'POLL_OPTIONS'				=> 'Poll options',
	'POLL_OPTIONS_EXPLAIN'		=> 'Place each option on a new line. You may enter up to <strong>%d</strong> options.',
	'POLL_OPTIONS_EDIT_EXPLAIN'	=> 'Place each option on a new line. You may enter up to <strong>%d</strong> options. If you remove or add options all previous votes will be reset.',
	'POLL_QUESTION'				=> 'Poll question',
	'POLL_TITLE_TOO_LONG'		=> 'The poll title must contain fewer than 100 characters.',
	'POLL_TITLE_COMP_TOO_LONG'	=> 'The parsed size of your poll title is too large, consider removing BBCodes or smilies.',
	'POLL_VOTE_CHANGE'			=> 'Allow re-voting',
	'POLL_VOTE_CHANGE_EXPLAIN'	=> 'If enabled users are able to change their vote.',
	'_POSTED_ATTACHMENTS'		=> 'Posted attachments',
	'POST_APPROVAL_NOTIFY'		=> 'You will be notified when your post has been approved.',
	'POST_CONFIRMATION'			=> 'Confirmation of post',
	'POST_CONFIRM_EXPLAIN'		=> 'To prevent automated posts the board requires you to enter a confirmation code. The code is displayed in the image you should see below. If you are visually impaired or cannot otherwise read this code please contact the %sBoard Administrator%s.',
	'POST_DELETED'				=> 'This message has been deleted successfully.',
	'POST_EDITED'				=> 'This message has been edited successfully.',
	'POST_EDITED_MOD'			=> 'This message has been edited successfully, but it will need to be approved by a moderator before it is publicly viewable.',
	'POST_GLOBAL'				=> 'Global',
	'POST_ICON'					=> 'Post icon',
	'POST_NORMAL'				=> 'Normal',
	'POST_REVIEW'				=> 'Post review',
	'POST_REVIEW_EXPLAIN'		=> 'At least one new post has been made to this topic. You may wish to review your post in light of this.',
	'POST_STORED'				=> 'This message has been posted successfully.',
	'POST_STORED_MOD'			=> 'This message has been submitted successfully, but it will need to be approved by a moderator before it is publicly viewable.',
	'POST_TOPIC_AS'				=> 'Post topic as',
	'PROGRESS_BAR'				=> 'Progress bar',

	'DOWNLOADED'			=> 'Downloaded',
	'DOWNLOADING_FILE'		=> 'Downloading file',
	'DOWNLOAD_COUNT'		=> 'Downloaded %d time',
	'DOWNLOAD_COUNTS'		=> 'Downloaded %d times',
	'DOWNLOAD_COUNT_NONE'	=> 'Not downloaded yet',
	'VIEWED_COUNT'			=> 'Viewed %d time',
	'VIEWED_COUNTS'			=> 'Viewed %d times',
	'VIEWED_COUNT_NONE'		=> 'Not viewed yet',
	'FILE_COMMENT'			=> 'File comment',
	'QUOTE_DEPTH_EXCEEDED'		=> 'You may embed only %1$d quotes within each other.',
	'_ADD_ATTACHMENT'			=> 'Upload attachment',
	'_ADD_ATTACHMENT_EXPLAIN'	=> 'If you wish to attach one or more files enter the details below.',
	'_ADD_FILE'					=> 'Add the file',
	'ADD_POLL'					=> 'Poll creation',
	'ADD_POLL_EXPLAIN'			=> 'If you do not want to add a poll to your topic leave the fields blank.',
	'ALREADY_DELETED'			=> 'Sorry but this message is already deleted.',
	'ATTACH_QUOTA_REACHED'		=> 'Sorry, the board attachment quota has been reached.',
	'ATTACH_SIG'				=> 'Attach a signature (signatures can be altered via the UCP)',
	'ATTACHMENT'						=> 'Attachment',
	'ATTACHMENT_FUNCTIONALITY_DISABLED'	=> 'The attachments feature has been disabled.',
	'BOOKMARK_ADDED'		=> 'Bookmarked topic successfully.',
	'BOOKMARK_ERR'			=> 'Bookmarking the topic failed. Please try again.',
	'BOOKMARK_REMOVED'		=> 'Removed bookmarked topic successfully.',
	'BOOKMARK_TOPIC'		=> 'Bookmark topic',
	'BOOKMARK_TOPIC_REMOVE'	=> 'Remove from bookmarks',
	'BUMPED_BY'				=> 'Last bumped by %1$s on %2$s.',
	'BUMP_TOPIC'			=> 'Bump topic',
	'CODE'					=> 'Code',
	'DELETE_TOPIC'			=> 'Delete topic',
	'DOWNLOAD_NOTICE'		=> 'You do not have the required permissions to view the files attached to this post.',
	'EDITED_TIMES_TOTAL'	=> 'Last edited by %1$s on %2$s, edited %3$d times in total.',
	'EDITED_TIME_TOTAL'		=> 'Last edited by %1$s on %2$s, edited %3$d time in total.',
	'EMAIL_TOPIC'			=> 'E-mail friend',
	'ERROR_NO_ATTACHMENT'	=> 'The selected attachment does not exist anymore.',
	'FILE_NOT_FOUND_404'	=> 'The file <strong>%s</strong> does not exist.',
	'FORK_TOPIC'			=> 'Copy topic',
	'LINKAGE_FORBIDDEN'		=> 'You are not authorised to view, download or link from/to this site.',
	'LOGIN_NOTIFY_TOPIC'	=> 'You have been notified about this topic, please login to view it.',
	'LOGIN_VIEWTOPIC'		=> 'The board requires you to be registered and logged in to view this topic.',
	'MAKE_ANNOUNCE'				=> 'Change to “Announcement”',
	'MAKE_GLOBAL'				=> 'Change to “Global”',
	'MAKE_NORMAL'				=> 'Change to “Standard Topic”',
	'MAKE_STICKY'				=> 'Change to “Sticky”',
	'MAX_OPTIONS_SELECT'		=> 'You may select up to <strong>%d</strong> options',
	'MAX_OPTION_SELECT'			=> 'You may select <strong>1</strong> option',
	'MISSING_INLINE_ATTACHMENT'	=> 'The attachment <strong>%s</strong> is no longer available',
	'MOVE_TOPIC'				=> 'Move topic',
	'NO_ATTACHMENT_SELECTED'=> 'You haven’t selected an attachment to download or view.',
	'NO_NEWER_TOPICS'		=> 'There are no newer topics in this forum.',
	'NO_OLDER_TOPICS'		=> 'There are no older topics in this forum.',
	'NO_UNREAD_POSTS'		=> 'There are no new unread posts for this topic.',
	'NO_VOTE_OPTION'		=> 'You must specify an option when voting.',
	'NO_VOTES'				=> 'No votes',
	'NO_NEW_POSTS'				=> 'No New Posts',
	'POLL_ENDED_AT'			=> 'Poll ended at %s',
	'POLL_RUN_TILL'			=> 'Poll runs till %s',
	'POLL_VOTED_OPTION'		=> 'You voted for this option',
	'PRINT_TOPIC'			=> 'Print view',
	'QUICK_MOD'				=> 'Quick-mod tools',
	'QUOTE'					=> 'Quote',
	'POST_SUBJECT'			=>	'Post Subject',
	'REPLY_TO_TOPIC'		=> 'Reply to topic',
	'RETURN_POST'			=> '%sReturn to the post%s',
	'SUBMIT_VOTE'			=> 'Submit vote',
	'TOTAL_VOTES'			=> 'Total votes',
	'UNLOCK_TOPIC'			=> 'Unlock topic',
	'LOCK_TOPIC'			=>	'Lock topic',
	'SPLIT_TOPIC'				=> 'Split topic',
	'MERGE_POSTS'			=> 'Merge posts',
	'MERGE_TOPIC'			=> 'Merge topic',
	'VIEW_TOPIC_LOGS'			=> 'View logs',
	'DISPLAY_POSTS'			=> 'Display posts from previous',
	'LOCK_POST'							=> 'Lock post',
	'LOCK_POST_EXPLAIN'					=> 'Prevent editing',
	'VIEW_INFO'				=> 'Post details',
	'VIEW_NEXT_TOPIC'		=> 'Next topic',
	'VIEW_PREVIOUS_TOPIC'	=> 'Previous topic',
	'VIEW_RESULTS'			=> 'View results',
	'VIEW_TOPIC_POST'		=> '1 post',
	'VIEW_TOPIC_POSTS'		=> '%d posts',
	'VIEW_UNREAD_POST'		=> 'First unread post',
	'VISIT_WEBSITE'			=> 'WWW',
	'VOTE_SUBMITTED'		=> 'Your vote has been cast.',
	'VOTE_CONVERTED'		=> 'Changing votes is not supported for converted polls.',
	'BBCODE_A_HELP'				=> 'Inline uploaded attachment: [attachment=]filename.ext[/attachment]',
	'BBCODE_B_HELP'				=> 'Bold text: [b]text[/b]',
	'BBCODE_C_HELP'				=> 'Code display: [code]code[/code]',
	'BBCODE_E_HELP'				=> 'List: Add list element',
	'BBCODE_F_HELP'				=> 'Font size: [size=85]small text[/size]',
	'BBCODE_IS_OFF'				=> '%sBBCode%s is <em>OFF</em>',
	'BBCODE_IS_ON'				=> '%sBBCode%s is <em>ON</em>',
	'BBCODE_I_HELP'				=> 'Italic text: [i]text[/i]',
	'BBCODE_L_HELP'				=> 'List: [list]text[/list]',
	'BBCODE_LISTITEM_HELP'		=> 'List item: [*]text[/*]',
	'BBCODE_O_HELP'				=> 'Ordered list: [list=]text[/list]',
	'BBCODE_P_HELP'				=> 'Insert image: [img]http://image_url[/img]',
	'BBCODE_Q_HELP'				=> 'Quote text: [quote]text[/quote]',
	'BBCODE_S_HELP'				=> 'Font colour: [color=red]text[/color]  Tip: you can also use color=#FF0000',
	'BBCODE_U_HELP'				=> 'Underline text: [u]text[/u]',
	'BBCODE_W_HELP'				=> 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]',
	'BBCODE_D_HELP'				=> 'Flash: [flash=width,height]http://url[/flash]',
	'BUMP_ERROR'				=> 'You cannot bump this topic so soon after the last post.',

	'CANNOT_DELETE_REPLIED'		=> 'Sorry but you may only delete posts which have not been replied to.',
	'CANNOT_EDIT_POST_LOCKED'	=> 'This post has been locked. You can no longer edit that post.',
	'CANNOT_EDIT_TIME'			=> 'You can no longer edit or delete that post.',
	'CANNOT_POST_ANNOUNCE'		=> 'Sorry but you cannot post announcements.',
	'CANNOT_POST_STICKY'		=> 'Sorry but you cannot post sticky topics.',
	'CHANGE_TOPIC_TO'			=> 'Change topic type to',
	'CLOSE_TAGS'				=> 'Close tags',
	'CURRENT_TOPIC'				=> 'Current topic',

	'DELETE_FILE'				=> 'Delete file',
	'DELETE_MESSAGE'			=> 'Delete message',
	'DELETE_MESSAGE_CONFIRM'	=> 'Are you sure you want to delete this message?',
	'DELETE_OWN_POSTS'			=> 'Sorry but you can only delete your own posts.',
	'DELETE_POST_CONFIRM'		=> 'Are you sure you want to delete this post?',
	'DELETE_POST_WARN'			=> 'Once deleted the post cannot be recovered',
	'DELETE_POST'			=> 'Delete post',
	'DISABLE_BBCODE'			=> 'Disable BBCode',
	'DISABLE_MAGIC_URL'			=> 'Do not automatically parse URLs',
	'DISABLE_SMILIES'			=> 'Disable smilies',
	'DISALLOWED_CONTENT'		=> 'The upload was rejected because the uploaded file was identified as a possible attack vector.',
	'DISALLOWED_EXTENSION'		=> 'The extension %s is not allowed.',
	'DRAFT_LOADED'				=> 'Draft loaded into posting area, you may want to finish your post now.<br />Your draft will be deleted after submitting this post.',
	'DRAFT_LOADED_PM'			=> 'Draft loaded into message area, you may want to finish your private message now.<br />Your draft will be deleted after submitting this private message.',
	'DRAFT_SAVED'				=> 'Draft successfully saved.',
	'DRAFT_TITLE'				=> 'Draft title',

	'EDIT_REASON'				=> 'Reason for editing this post',
	'EMPTY_FILEUPLOAD'			=> 'The uploaded file is empty.',
	'EMPTY_MESSAGE'				=> 'You must enter a message when posting.',
	'EMPTY_REMOTE_DATA'			=> 'File could not be uploaded, please try uploading the file manually.',

	'FLASH_IS_OFF'				=> '[flash] is <em>OFF</em>',
	'FLASH_IS_ON'				=> '[flash] is <em>ON</em>',
	'FLOOD_ERROR'				=> 'You cannot make another post so soon after your last.',
	'FONT_COLOR'				=> 'Font colour',
	'FONT_COLOR_HIDE'			=> 'Hide font colour',
	'FONT_HUGE'					=> 'Huge',
	'FONT_LARGE'				=> 'Large',
	'FONT_NORMAL'				=> 'Normal',
	'FONT_SIZE'					=> 'Font size',
	'FONT_SMALL'				=> 'Small',
	'FONT_TINY'					=> 'Tiny',

	'TOTAL_ATTACHMENTS'	=> 'Attachment(s)',
	'TOTAL_LOG'			=> '1 log',
	'TOTAL_LOGS'		=> '%d logs',
	'TOTAL_NO_PM'		=> '0 private messages in total',
	'TOTAL_PM'			=> '1 private message in total',
	'TOTAL_PMS'			=> '%d private messages in total',
	'TOTAL_POSTS'		=> 'Total posts',
	'TOTAL_POSTS_OTHER'	=> 'Total posts <strong>%d</strong>',
	'TOTAL_POSTS_ZERO'	=> 'Total posts <strong>0</strong>',
	'TOPIC_REPORTED'	=> 'This topic has been reported',
	'TOTAL_TOPICS_OTHER'=> 'Total topics <strong>%d</strong>',
	'TOTAL_TOPICS_ZERO'	=> 'Total topics <strong>0</strong>',
	'TOTAL_USERS_OTHER'	=> 'Total members <strong>%d</strong>',
	'TOTAL_USERS_ZERO'	=> 'Total members <strong>0</strong>',
	'GENERAL_UPLOAD_ERROR'		=> 'Could not upload attachment to %s.',

	'IMAGES_ARE_OFF'			=> '[img] is <em>OFF</em>',
	'IMAGES_ARE_ON'				=> '[img] is <em>ON</em>',
	'INVALID_FILENAME'			=> '%s is an invalid filename.',

	'LOAD'						=> 'Load',
	'LOAD_DRAFT'				=> 'Load draft',
	'LOAD_DRAFT_EXPLAIN'		=> 'Here you are able to select the draft you want to continue writing. Your current post will be cancelled, all current post contents will be deleted. View, edit and delete drafts within your User Control Panel.',
	'LOGIN_EXPLAIN_BUMP'		=> 'You need to login in order to bump topics within this forum.',
	'LOGIN_EXPLAIN_DELETE'		=> 'You need to login in order to delete posts within this forum.',
	'LOGIN_EXPLAIN_POST'		=> 'You need to login in order to post within this forum.',
	'LOGIN_EXPLAIN_QUOTE'		=> 'You need to login in order to quote posts within this forum.',
	'LOGIN_EXPLAIN_REPLY'		=> 'You need to login in order to reply to topics within this forum.',

	'MAX_FONT_SIZE_EXCEEDED'	=> 'You may only use fonts up to size %1$d.',
	'MAX_FLASH_HEIGHT_EXCEEDED'	=> 'Your flash files may only be up to %1$d pixels high.',
	'MAX_FLASH_WIDTH_EXCEEDED'	=> 'Your flash files may only be up to %1$d pixels wide.',
	'MAX_IMG_HEIGHT_EXCEEDED'	=> 'Your images may only be up to %1$d pixels high.',
	'MAX_IMG_WIDTH_EXCEEDED'	=> 'Your images may only be up to %1$d pixels wide.',

	'MESSAGE_BODY_EXPLAIN'		=> 'Enter your message here, it may contain no more than <strong>%d</strong> characters.',
	'MESSAGE_DELETED'			=> 'This message has been deleted successfully.',
	'MORE_SMILIES'				=> 'View more smilies',

	'NOTIFY_REPLY'				=> 'Notify me when a reply is posted',
	'NOT_UPLOADED'				=> 'File could not be uploaded.',
	'NO_DELETE_POLL_OPTIONS'	=> 'You cannot delete existing poll options.',
	'NO_PM_ICON'				=> 'No PM icon',
	'NO_POLL_TITLE'				=> 'You have to enter a poll title.',
	'NO_POST'					=> 'The requested post does not exist.',
	'NO_POST_MODE'				=> 'No post mode specified.',
	'_FILENAME'				=> 'Filename',
	'_FILE_COMMENT'			=> 'File comment',
	'ICON'					=>	'Icon',
	'MESSAGE_BODY'			=>	'Message Body',
	'POST_ANNOUNCEMENT'		=> 'Announce',
	'POST_STICKY'			=> 'Sticky',
	'PREVIEW'				=>	'Preview',
	'NO_TOPIC_ICON'			=>	'No Icon',
	'_PREVIEW'				=> 'Preview',
	'_POSTED'				=>	'Posted',
	'POSTED'				=>	'Posted',
	'_POST_SUBJECT'			=>	'Post subject',
	'LOG_POST_EDITED'			=> '<strong>Edited post “%1$s” written by</strong><br />» %2$s',
	'VIEW_TOPIC'			=>	'View Topic',
	'FULL_EDITOR'			=>	'Full Editor',
	'QUICKREPLY'			=>	'Quick Reply',
));
$ignore_words = array(
	'a',
	'torrent',
	'about',
	'after',
	'ago',
	'all',
	'almost',
	'along',
	'alot',
	'also',
	'am',
	'an',
	'and',
	'answer',
	'any',
	'anybody',
	'anybodys',
	'anywhere',
	'are',
	'arent',
	'around',
	'as',
	'ask',
	'askd',
	'at',
	'bad',
	'be',
	'because',
	'been',
	'before',
	'being',
	'best',
	'better',
	'between',
	'big',
	'btw',
	'but',
	'by',
	'can',
	'cant',
	'come',
	'could',
	'couldnt',
	'day',
	'days',
	'days',
	'did',
	'didnt',
	'do',
	'does',
	'doesnt',
	'dont',
	'down',
	'each',
	'etc',
	'either',
	'else',
	'even',
	'ever',
	'every',
	'everybody',
	'everybodys',
	'everyone',
	'far',
	'find',
	'for',
	'found',
	'from',
	'get',
	'go',
	'going',
	'gone',
	'good',
	'got',
	'gotten',
	'had',
	'has',
	'have',
	'havent',
	'having',
	'her',
	'here',
	'hers',
	'him',
	'his',
	'home',
	'how',
	'hows',
	'href',
	'I',
	'Ive',
	'if',
	'in',
	'ini',
	'into',
	'is',
	'isnt',
	'it',
	'its',
	'its',
	'just',
	'know',
	'large',
	'less',
	'like',
	'liked',
	'little',
	'looking',
	'look',
	'looked',
	'looking',
	'lot',
	'maybe',
	'many',
	'me',
	'more',
	'most',
	'much',
	'must',
	'mustnt',
	'my',
	'near',
	'need',
	'never',
	'new',
	'news',
	'no',
	'none',
	'not',
	'nothing',
	'now',
	'of',
	'off',
	'often',
	'old',
	'on',
	'once',
	'only',
	'oops',
	'or',
	'other',
	'our',
	'ours',
	'out',
	'over',
	'page',
	'please',
	'put',
	'question',
	'questions',
	'questioned',
	'quote',
	'rather',
	'really',
	'recent',
	'said',
	'saw',
	'say',
	'says',
	'she',
	'see',
	'sees',
	'should',
	'sites',
	'small',
	'so',
	'some',
	'something',
	'sometime',
	'somewhere',
	'soon',
	'take',
	'than',
	'true',
	'thank',
	'that',
	'thatd',
	'thats',
	'the',
	'their',
	'theirs',
	'theres',
	'theirs',
	'them',
	'then',
	'there',
	'these',
	'they',
	'theyll',
	'theyd',
	'theyre',
	'this',
	'those',
	'though',
	'through',
	'thus',
	'time',
	'times',
	'to',
	'too',
	'under',
	'until',
	'untrue',
	'up',
	'upon',
	'use',
	'users',
	'version',
	'very',
	'via',
	'want',
	'was',
	'way',
	'we',
	'well',
	'went',
	'were',
	'werent',
	'what',
	'when',
	'where',
	'which',
	'who',
	'whom',
	'whose',
	'why',
	'wide',
	'will',
	'with',
	'within',
	'without',
	'wont',
	'world',
	'worse',
	'worst',
	'would',
	'wrote',
	'www',
	'yes',
	'yet',
	'you',
	'youd',
	'youll',
	'your',
	'youre',
	'yours',
	'AFAIK',
	'IIRC',
	'LOL',
	'ROTF',
	'ROTFLMAO',
	'YMMV',
);
?>
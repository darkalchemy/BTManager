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
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File search.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
include_once ('include/utf/utf_tools.' . $phpEx);
include_once ('include/class.bbcode.' . $phpEx);
$mode			= request_var('mode', '');
$search_id		= request_var('search_id', '');
$start			= max(request_var('start', 0), 0);
$post_id		= request_var('p', 0);
$topic_id		= request_var('t', 0);
$view			= request_var('view', '');

$submit			= request_var('submit', false);
$keywords		= utf8_normalize_nfc(request_var('keywords', '', true));
$add_keywords	= utf8_normalize_nfc(request_var('add_keywords', '', true));
$author			= request_var('author', '', true);
$author_id		= request_var('author_id', 0);
$show_results	= ($topic_id) ? 'posts' : request_var('sr', 'posts');
$show_results	= ($show_results == 'posts') ? 'posts' : 'topics';
$search_terms	= request_var('terms', 'all');
$search_fields	= request_var('sf', 'all');
$search_child	= request_var('sc', true);

$sort_days		= request_var('st', 0);
$sort_key		= request_var('sk', 't');
$sort_dir		= request_var('sd', 'd');

$return_chars	= request_var('ch', ($topic_id) ? -1 : 300);
$search_forum	= request_var('fid', array(0));
$user->set_lang('forum_search',$user->ulanguage);
// Is user able to search? Has search been disabled?
if (!$auth->acl_get('u_search') || !$auth->acl_getf_global('f_search') )
{
	$template->assign_var('S_NO_SEARCH', true);
	trigger_error('NO_SEARCH');
}

// Check search load limit
if ($user->load && $config['limit_search_load'] && ($user->load > doubleval($config['limit_search_load'])))
{
	$template->assign_var('S_NO_SEARCH', true);
	trigger_error('NO_SEARCH_TIME');
}

// Check flood limit ... if applicable
$interval = ($user->id == 0) ? $config['search_anonymous_interval'] : $config['search_interval'];
if ($interval && !$auth->acl_get('u_ignoreflood'))
{
	if ($user->data['user_last_search'] > time() - $interval)
	{
		$template->assign_var('S_NO_SEARCH', true);
		trigger_error('NO_SEARCH_TIME');
	}
}

// Define some vars
$limit_days		= array(0 => $user->lang['ALL_RESULTS'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
$sort_by_text	= array('a' => $user->lang['SORT_AUTHOR'], 't' => $user->lang['SORT_TIME'], 'f' => $user->lang['SORT_FORUM'], 'i' => $user->lang['SORT_TOPIC_TITLE'], 's' => $user->lang['SORT_POST_SUBJECT']);

$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

if ($keywords || $author || $author_id || $search_id || $submit)
{
	// clear arrays
	$id_ary = array();

	// egosearch is an author search
	if ($search_id == 'egosearch')
	{
		$author_id = $user->id;

		if (!$user->user)
		{
			login_box('', $user->lang['LOGIN_EXPLAIN_EGOSEARCH']);
		}
	}

	// If we are looking for authors get their ids
	$author_id_ary = array();
	if ($author_id)
	{
		$author_id_ary[] = $author_id;
	}
	else if ($author)
	{
		if ((strpos($author, '*') !== false) && (utf8_strlen(str_replace(array('*', '%'), '', $author)) < $config['min_search_author_chars']))
		{
			trigger_error(sprintf($user->lang['TOO_FEW_AUTHOR_CHARS'], $config['min_search_author_chars']));
		}

		$sql_where = (strpos($author, '*') !== false) ? ' clean_username ' . $db->sql_like_expression(str_replace('*', $db->any_char, utf8_clean_string($author))) : " clean_username = '" . $db->sql_escape(utf8_clean_string($author)) . "'";

		$sql = 'SELECT id
			FROM ' . $db_prefix . "_users
			WHERE $sql_where
				AND user_type IN ( 0, 3 ) LIMIT 100";
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$author_id_ary[] = (int) $row['id'];
		}
		$db->sql_freeresult($result);

		if (!sizeof($author_id_ary))
		{
			trigger_error('NO_SEARCH_RESULTS');
		}
	}

	// if we search in an existing search result just add the additional keywords. But we need to use "all search terms"-mode
	// so we can keep the old keywords in their old mode, but add the new ones as required words
	if ($add_keywords)
	{
		if ($search_terms == 'all')
		{
			$keywords .= ' ' . $add_keywords;
		}
		else
		{
			$search_terms = 'all';
			$keywords = implode(' |', explode(' ', preg_replace('#\s+#u', ' ', $keywords))) . ' ' .$add_keywords;
		}
	}

	// Which forums should not be searched? Author searches are also carried out in unindexed forums
	if (empty($keywords) && sizeof($author_id_ary))
	{
		$ex_fid_ary = array_keys($auth->acl_getf('!f_read', true));
	}
	else
	{
		$ex_fid_ary = array_unique(array_merge(array_keys($auth->acl_getf('!f_read', true)), array_keys($auth->acl_getf('!f_search', true))));
	}

	$not_in_fid = (sizeof($ex_fid_ary)) ? 'WHERE ' . $db->sql_in_set('f.forum_id', $ex_fid_ary, true) . " OR (f.forum_password <> '' AND fa.user_id <> " . (int) $user->id . ')' : "";

	$sql = 'SELECT f.forum_id, f.forum_name, f.parent_id, f.forum_type, f.right_id, f.forum_password, fa.user_id
		FROM ' . $db_prefix . '_forums f
		LEFT JOIN ' . $db_prefix . "_forums_access fa ON (fa.forum_id = f.forum_id
			AND fa.session_id = '" . $db->sql_escape($user->session_id) . "')
		$not_in_fid
		ORDER BY f.left_id";
	$result = $db->sql_query($sql);

	$right_id = 0;
	$reset_search_forum = true;
	while ($row = $db->sql_fetchrow($result))
	{
		if ($row['forum_password'] && $row['user_id'] != $user->id)
		{
			$ex_fid_ary[] = (int) $row['forum_id'];
			continue;
		}

		if (sizeof($search_forum))
		{
			if ($search_child)
			{
				if (in_array($row['forum_id'], $search_forum) && $row['right_id'] > $right_id)
				{
					$right_id = (int) $row['right_id'];
				}
				else if ($row['right_id'] < $right_id)
				{
					continue;
				}
			}

			if (!in_array($row['forum_id'], $search_forum))
			{
				$ex_fid_ary[] = (int) $row['forum_id'];
				$reset_search_forum = false;
			}
		}
	}
	$db->sql_freeresult($result);
		//die(print_r($search_forum));

	// find out in which forums the user is allowed to view approved posts
	if ($auth->acl_get('m_approve'))
	{
		$m_approve_fid_ary = array(-1);
		$m_approve_fid_sql = '';
	}
	else if ($auth->acl_getf_global('m_approve'))
	{
		$m_approve_fid_ary = array_diff(array_keys($auth->acl_getf('!m_approve', true)), $ex_fid_ary);
		$m_approve_fid_sql = ' AND (p.post_approved = 1' . ((sizeof($m_approve_fid_ary)) ? ' OR ' . $db->sql_in_set('p.forum_id', $m_approve_fid_ary, true) : '') . ')';
	}
	else
	{
		$m_approve_fid_ary = array();
		$m_approve_fid_sql = ' AND p.post_approved = 1';
	}

	if ($reset_search_forum)
	{
		$search_forum = array();
	}

	// Select which method we'll use to obtain the post_id or topic_id information
	$search_type = basename($config['search_type']);

	if (!file_exists('include/search/' . $search_type . '.' . $phpEx))
	{
		trigger_error('NO_SUCH_SEARCH_MODULE' . $search_type);
	}

	require("include/search/$search_type.$phpEx");

	// We do some additional checks in the module to ensure it can actually be utilised
	$error = false;
	$search = new $search_type($error);

	if ($error)
	{
		trigger_error($error);
	}

	// let the search module split up the keywords
	if ($keywords)
	{
		$correct_query = $search->split_keywords($keywords, $search_terms);
		if (!$correct_query || (empty($search->search_query) && !sizeof($author_id_ary) && !$search_id))
		{
			$ignored = (sizeof($search->common_words)) ? sprintf($user->lang['IGNORED_TERMS_EXPLAIN'], implode(' ', $search->common_words)) . '<br />' : '';
			trigger_error($ignored . sprintf($user->lang['NO_KEYWORDS'], $search->word_length['min'], $search->word_length['max']));
		}
	}
	//die($search_id);

	if (!$keywords && sizeof($author_id_ary))
	{
		// if it is an author search we want to show topics by default
		$show_results = ($topic_id) ? 'posts' : request_var('sr', ($search_id == 'egosearch') ? 'topics' : 'posts');
		$show_results = ($show_results == 'posts') ? 'posts' : 'topics';
	}

	// define some variables needed for retrieving post_id/topic_id information
	$sort_by_sql = array('a' => 'u.clean_username', 't' => (($show_results == 'posts') ? 'p.post_time' : 't.topic_last_post_time'), 'f' => 'f.forum_id', 'i' => 't.topic_title', 's' => (($show_results == 'posts') ? 'p.post_subject' : 't.topic_title'));

	// pre-made searches
	$sql = $field = $l_search_title = '';
	if ($search_id)
	{
		switch ($search_id)
		{
			// Oh holy Bob, bring us some activity...
			case 'active_topics':
				$l_search_title = $user->lang['SEARCH_ACTIVE_TOPICS'];
				$show_results = 'topics';
				$sort_key = 't';
				$sort_dir = 'd';
				$sort_days = request_var('st', 7);
				$sort_by_sql['t'] = 't.topic_last_post_time';

				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
				$s_sort_key = $s_sort_dir = '';

				$last_post_time_sql = ($sort_days) ? ' AND t.topic_last_post_time > ' . (time() - ($sort_days * 24 * 3600)) : '';

				$sql = 'SELECT t.topic_last_post_time, t.topic_id
					FROM ' . $db_prefix . "_topics t
					WHERE t.topic_moved_id = 0
						$last_post_time_sql
						" . str_replace(array('p.', 'post_'), array('t.', 'topic_'), $m_approve_fid_sql) . '
						' . ((sizeof($ex_fid_ary)) ? ' AND ' . $db->sql_in_set('t.forum_id', $ex_fid_ary, true) : '') . '
					ORDER BY t.topic_last_post_time DESC';
				$field = 'topic_id';
			break;

			case 'unanswered':
				$l_search_title = $user->lang['SEARCH_UNANSWERED'];
				$show_results = request_var('sr', 'topics');
				$show_results = ($show_results == 'posts') ? 'posts' : 'topics';
				$sort_by_sql['t'] = ($show_results == 'posts') ? 'p.post_time' : 't.topic_last_post_time';
				$sort_by_sql['s'] = ($show_results == 'posts') ? 'p.post_subject' : 't.topic_title';
				$sql_sort = 'ORDER BY ' . $sort_by_sql[$sort_key] . (($sort_dir == 'a') ? ' ASC' : ' DESC');

				$sort_join = ($sort_key == 'f') ? $db_prefix . '_forums f, ' : '';
				$sql_sort = ($sort_key == 'f') ? ' AND f.forum_id = p.forum_id ' . $sql_sort : $sql_sort;

				if ($sort_days)
				{
					$last_post_time = 'AND p.post_time > ' . (time() - ($sort_days * 24 * 3600));
				}
				else
				{
					$last_post_time = '';
				}


				if ($sort_key == 'a')
				{
					$sort_join = $db_prefix . '_users u, ';
					$sql_sort = ' AND u.id = p.poster_id ' . $sql_sort;
				}
				if ($show_results == 'posts')
				{
					$sql = "SELECT p.post_id
						FROM $sort_join" . $db_prefix . '_posts p, ' . $db_prefix . "_topics t
						WHERE t.topic_replies = 0
							AND p.topic_id = t.topic_id
							$last_post_time
							$m_approve_fid_sql
							" . ((sizeof($ex_fid_ary)) ? ' AND ' . $db->sql_in_set('p.forum_id', $ex_fid_ary, true) : '') . "
							$sql_sort";
					$field = 'post_id';
				}
				else
				{
					$sql = 'SELECT DISTINCT ' . $sort_by_sql[$sort_key] . ", p.topic_id
						FROM $sort_join" . $db_prefix . '_posts p, ' . $db_prefix . "_topics t
						WHERE t.topic_replies = 0
							AND t.topic_moved_id = 0
							AND p.topic_id = t.topic_id
							$last_post_time
							$m_approve_fid_sql
							" . ((sizeof($ex_fid_ary)) ? ' AND ' . $db->sql_in_set('p.forum_id', $ex_fid_ary, true) : '') . "
						$sql_sort";
					$field = 'topic_id';
				}
			break;

			case 'newposts':
				$l_search_title = $user->lang['SEARCH_NEW'];
				// force sorting
				$show_results = (request_var('sr', 'topics') == 'posts') ? 'posts' : 'topics';
				$sort_key = 't';
				$sort_dir = 'd';
				$sort_by_sql['t'] = ($show_results == 'posts') ? 'p.post_time' : 't.topic_last_post_time';
				$sql_sort = 'ORDER BY ' . $sort_by_sql[$sort_key] . (($sort_dir == 'a') ? ' ASC' : ' DESC');

				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
				$s_sort_key = $s_sort_dir = $u_sort_param = $s_limit_days = '';

				if ($show_results == 'posts')
				{
					$sql = 'SELECT p.post_id
						FROM ' . $db_prefix . '_posts p
						WHERE p.post_time > ' . sql_timestamp_to_unix_timestamp($user->lastlogin) . "
							$m_approve_fid_sql
							" . ((sizeof($ex_fid_ary)) ? ' AND ' . $db->sql_in_set('p.forum_id', $ex_fid_ary, true) : '') . "
						$sql_sort";
					$field = 'post_id';
				}
				else
				{
					$sql = 'SELECT t.topic_id
						FROM ' . $db_prefix . '_topics t
						WHERE t.topic_last_post_time > ' . sql_timestamp_to_unix_timestamp($user->lastlogin) . '
							AND t.topic_moved_id = 0
							' . str_replace(array('p.', 'post_'), array('t.', 'topic_'), $m_approve_fid_sql) . '
							' . ((sizeof($ex_fid_ary)) ? 'AND ' . $db->sql_in_set('t.forum_id', $ex_fid_ary, true) : '') . "
						$sql_sort";
/*
		[Fix] queued replies missing from "view new posts" (Bug #42705 - Patch by Paul)
		- Creates temporary table, query is far from optimized

					$sql = 'SELECT t.topic_id
						FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
						WHERE p.post_time > ' . sql_timestamp_to_unix_timestamp($user->lastlogin) . '
							AND t.topic_id = p.topic_id
							AND t.topic_moved_id = 0
							' . $m_approve_fid_sql . '
							' . ((sizeof($ex_fid_ary)) ? 'AND ' . $db->sql_in_set('t.forum_id', $ex_fid_ary, true) : '') . "
						GROUP BY t.topic_id
						$sql_sort";
*/
					$field = 'topic_id';
				}
			break;

			case 'egosearch':
				$l_search_title = $user->lang['SEARCH_SELF'];
			break;
		}
	}

	// show_results should not change after this
	$per_page = ($show_results == 'posts') ? $config['posts_per_page'] : $config['topics_per_page'];
	$total_match_count = 0;

	if ($search_id)
	{
		if ($sql)
		{
			// only return up to 1000 ids (the last one will be removed later)
			$result = $db->sql_query($sql. 'LIMIT ' . 1001 - $start, $start);

			while ($row = $db->sql_fetchrow($result))
			{
				$id_ary[] = (int) $row[$field];
			}
			$db->sql_freeresult($result);

			$total_match_count = sizeof($id_ary) + $start;
			$id_ary = array_slice($id_ary, 0, $per_page);
		}
		else
		{
			$search_id = '';
		}
	}

	// make sure that some arrays are always in the same order
	sort($ex_fid_ary);
	sort($m_approve_fid_ary);
	sort($author_id_ary);

			//die($search->search_query);
	if (!empty($search->search_query))
	{
		$total_match_count = $search->keyword_search($show_results, $search_fields, $search_terms, $sort_by_sql, $sort_key, $sort_dir, $sort_days, $ex_fid_ary, $m_approve_fid_ary, $topic_id, $author_id_ary, $id_ary, $start, $per_page);
	}
	else if (sizeof($author_id_ary))
	{
		$firstpost_only = ($search_fields === 'firstpost' || $search_fields == 'titleonly') ? true : false;
		$total_match_count = $search->author_search($show_results, $firstpost_only, $sort_by_sql, $sort_key, $sort_dir, $sort_days, $ex_fid_ary, $m_approve_fid_ary, $topic_id, $author_id_ary, $id_ary, $start, $per_page);
	}

	// For some searches we need to print out the "no results" page directly to allow re-sorting/refining the search options.
	if (!sizeof($id_ary) && !$search_id)
	{
		trigger_error('NO_SEARCH_RESULTS');
	}

	$sql_where = '';

	if (sizeof($id_ary))
	{
		$sql_where .= $db->sql_in_set(($show_results == 'posts') ? 'p.post_id' : 't.topic_id', $id_ary);
		$sql_where .= (sizeof($ex_fid_ary)) ? ' AND (' . $db->sql_in_set('f.forum_id', $ex_fid_ary, true) . ' OR f.forum_id IS NULL)' : '';
		$sql_where .= ($show_results == 'posts') ? $m_approve_fid_sql : str_replace(array('p.post_approved', 'p.forum_id'), array('t.topic_approved', 't.forum_id'), $m_approve_fid_sql);
	}

	if ($show_results == 'posts')
	{
		include('include/function_posting.' . $phpEx);
	}
	$user->set_lang('viewtopic',$user->ulanguage);

	// Grab icons
	$icons = $pmbt_cache->obtain_icons();

	// Output header
	if ($search_id && ($total_match_count > 1000))
	{
		// limit the number to 1000 for pre-made searches
		$total_match_count--;
		$l_search_matches = sprintf($user->lang['FOUND_MORE_SEARCH_MATCHES'], $total_match_count);
	}
	else
	{
		$l_search_matches = ($total_match_count == 1) ? sprintf($user->lang['FOUND_SEARCH_MATCH'], $total_match_count) : sprintf($user->lang['FOUND_SEARCH_MATCHES'], $total_match_count);
	}

	// define some vars for urls
	$hilit = implode('|', explode(' ', preg_replace('#\s+#u', ' ', str_replace(array('+', '-', '|', '(', ')', '&quot;'), ' ', $keywords))));
	// Do not allow *only* wildcard being used for hilight
	$hilit = (strspn($hilit, '*') === strlen($hilit)) ? '' : $hilit;

	$u_hilit = urlencode(htmlspecialchars_decode(str_replace('|', ' ', $hilit)));
	$u_show_results = ($show_results != 'posts') ? '&amp;sr=' . $show_results : '';
	$u_search_forum = implode('&amp;fid%5B%5D=', $search_forum);

	$u_search = append_sid("{$phpbb_root_path}forum.$phpEx?action=search", $u_sort_param . $u_show_results);
	$u_search .= ($search_id) ? '&amp;search_id=' . $search_id : '';
	$u_search .= ($u_hilit) ? '&amp;keywords=' . urlencode(htmlspecialchars_decode($search->search_query)) : '';
	$u_search .= ($search_terms != 'all') ? '&amp;terms=' . $search_terms : '';
	$u_search .= ($topic_id) ? '&amp;t=' . $topic_id : '';
	$u_search .= ($author) ? '&amp;author=' . urlencode(htmlspecialchars_decode($author)) : '';
	$u_search .= ($author_id) ? '&amp;author_id=' . $author_id : '';
	$u_search .= ($u_search_forum) ? '&amp;fid%5B%5D=' . $u_search_forum : '';
	$u_search .= (!$search_child) ? '&amp;sc=0' : '';
	$u_search .= ($search_fields != 'all') ? '&amp;sf=' . $search_fields : '';
	$u_search .= ($return_chars != 300) ? '&amp;ch=' . $return_chars : '';

	$template->assign_vars(array(
		'SEARCH_TITLE'		=> $l_search_title,
		'SEARCH_MATCHES'	=> $l_search_matches,
		'SEARCH_WORDS'		=> $search->search_query,
		'IGNORED_WORDS'		=> (sizeof($search->common_words)) ? implode(' ', $search->common_words) : '',
		'PAGINATION'		=> generate_pagination($u_search, $total_match_count, $per_page, $start),
		'PAGE_NUMBER'		=> on_page($total_match_count, $per_page, $start),
		'TOTAL_MATCHES'		=> $total_match_count,
		'SEARCH_IN_RESULTS'	=> ($search_id) ? false : true,

		'S_SELECT_SORT_DIR'		=> $s_sort_dir,
		'S_SELECT_SORT_KEY'		=> $s_sort_key,
		'S_SELECT_SORT_DAYS'	=> $s_limit_days,
		'S_SEARCH_ACTION'		=> $u_search,
		'S_SHOW_TOPICS'			=> ($show_results == 'posts') ? false : true,

		'GOTO_PAGE_IMG'		=> $user->img('icon_post_target', 'GOTO_PAGE'),
		'NEWEST_POST_IMG'	=> $user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
		'REPORTED_IMG'		=> $user->img('icon_topic_reported', 'TOPIC_REPORTED'),
		'UNAPPROVED_IMG'	=> $user->img('icon_topic_unapproved', 'TOPIC_UNAPPROVED'),
		'LAST_POST_IMG'		=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST'),

		'U_SEARCH_WORDS'	=> $u_search,
	));

	if ($sql_where)
	{
		if ($show_results == 'posts')
		{
			// @todo Joining this query to the one below?
			$sql = 'SELECT zebra_id, friend, foe
				FROM ' . $db_prefix . '_zebra
				WHERE user_id = ' . $user->id;
			$result = $db->sql_query($sql);

			$zebra = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$zebra[($row['friend']) ? 'friend' : 'foe'][] = $row['zebra_id'];
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT p.*, f.forum_id, f.forum_name, t.*, u.username, u.clean_username AS username_clean, u.signature AS user_sig, u.sig_bbcode_uid AS user_sig_bbcode_uid, u.user_colour
				FROM ' . $db_prefix . '_posts p
					LEFT JOIN ' . $db_prefix . '_topics t ON (p.topic_id = t.topic_id)
					LEFT JOIN ' . $db_prefix . '_forums f ON (p.forum_id = f.forum_id)
					LEFT JOIN ' . $db_prefix . "_users u ON (p.poster_id = u.id)
				WHERE $sql_where";
		}
		else
		{
			$sql_from = $db_prefix . '_topics t
				LEFT JOIN ' . $db_prefix . '_forums f ON (f.forum_id = t.forum_id)
				' . (($sort_key == 'a') ? ' LEFT JOIN ' . $db_prefix . '_users u ON (u.id = t.topic_poster) ' : '');
			$sql_select = 't.*, f.forum_id, f.forum_name';

			if ($user->data['is_registered'])
			{
				if ($config['load_db_track'] && $author_id !== $user->id)
				{
					$sql_from .= ' LEFT JOIN ' . $db_prefix  . '_topics_posted tp ON (tp.user_id = ' . $user->id . '
						AND t.topic_id = tp.topic_id)';
					$sql_select .= ', tp.topic_posted';
				}

				if ($config['load_db_lastread'])
				{
					$sql_from .= ' LEFT JOIN ' . $db_prefix  . '_topics_track tt ON (tt.user_id = ' . $user->id . '
							AND t.topic_id = tt.topic_id)
						LEFT JOIN ' . $db_prefix  . '_forums_track ft ON (ft.user_id = ' . $user->id . '
							AND ft.forum_id = f.forum_id)';
					$sql_select .= ', tt.mark_time, ft.mark_time as f_mark_time';
				}
			}

			if ($config['load_anon_lastread'] || ($user->user && !$config['load_db_lastread']))
			{
				$tracking_topics = (isset($_COOKIE[$config['cookie_name'] . '_track'])) ? ((STRIP) ? stripslashes($_COOKIE[$config['cookie_name'] . '_track']) : $_COOKIE[$config['cookie_name'] . '_track']) : '';
				$tracking_topics = ($tracking_topics) ? tracking_unserialize($tracking_topics) : array();
			}

			$sql = "SELECT $sql_select
				FROM $sql_from
				WHERE $sql_where";
		}
		$sql .= ' ORDER BY ' . $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$result = $db->sql_query($sql);
		$result_topic_id = 0;
		//die($sql);

		$rowset = array();

		if ($show_results == 'topics')
		{
			$forums = $rowset = $shadow_topic_list = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['topic_status'] == 2)
				{
					$shadow_topic_list[$row['topic_moved_id']] = $row['topic_id'];
				}

				$rowset[$row['topic_id']] = $row;

				if (!isset($forums[$row['forum_id']]) && $user->user && $config['load_db_lastread'])
				{
					$forums[$row['forum_id']]['mark_time'] = $row['f_mark_time'];
				}
				$forums[$row['forum_id']]['topic_list'][] = $row['topic_id'];
				$forums[$row['forum_id']]['rowset'][$row['topic_id']] = &$rowset[$row['topic_id']];
			}
			$db->sql_freeresult($result);

			// If we have some shadow topics, update the rowset to reflect their topic information
			if (sizeof($shadow_topic_list))
			{
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_topics
					WHERE ' . $db->sql_in_set('topic_id', array_keys($shadow_topic_list));
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$orig_topic_id = $shadow_topic_list[$row['topic_id']];

					// We want to retain some values
					$row = array_merge($row, array(
						'topic_moved_id'	=> $rowset[$orig_topic_id]['topic_moved_id'],
						'topic_status'		=> $rowset[$orig_topic_id]['topic_status'],
						'forum_name'		=> $rowset[$orig_topic_id]['forum_name'])
					);

					$rowset[$orig_topic_id] = $row;
				}
				$db->sql_freeresult($result);
			}
			unset($shadow_topic_list);

			foreach ($forums as $forum_id => $forum)
			{
				if ($user->data['is_registered'] && $config['load_db_lastread'])
				{
					$topic_tracking_info[$forum_id] = get_topic_tracking($forum_id, $forum['topic_list'], $forum['rowset'], array($forum_id => $forum['mark_time']), ($forum_id) ? false : $forum['topic_list']);
				}
				else if ($config['load_anon_lastread'] || $user->user)
				{
					$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $forum['topic_list'], ($forum_id) ? false : $forum['topic_list']);

					if (!$user->user)
					{
						$user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $config['board_startdate']) : 0;
					}
				}
			}
			unset($forums);
		}
		else
		{
			$bbcode_bitfield = $text_only_message = '';
			$attach_list = array();
function get_context($text, $words, $length = 400)
{
	// first replace all whitespaces with single spaces
	$text = preg_replace('/ +/', ' ', strtr($text, "\t\n\r\x0C ", '     '));

	// we need to turn the entities back into their original form, to not cut the message in between them
	$entities = array('&lt;', '&gt;', '&#91;', '&#93;', '&#46;', '&#58;', '&#058;');
	$characters = array('<', '>', '[', ']', '.', ':', ':');
	$text = str_replace($entities, $characters, $text);

	$word_indizes = array();
	if (sizeof($words))
	{
		$match = '';
		// find the starting indizes of all words
		foreach ($words as $word)
		{
			if ($word)
			{
				if (preg_match('#(?:[^\w]|^)(' . $word . ')(?:[^\w]|$)#i', $text, $match))
				{
					if (empty($match[1]))
					{
						continue;
					}

					$pos = utf8_strpos($text, $match[1]);
					if ($pos !== false)
					{
						$word_indizes[] = $pos;
					}
				}
			}
		}
		unset($match);

		if (sizeof($word_indizes))
		{
			$word_indizes = array_unique($word_indizes);
			sort($word_indizes);

			$wordnum = sizeof($word_indizes);
			// number of characters on the right and left side of each word
			$sequence_length = (int) ($length / (2 * $wordnum)) - 2;
			$final_text = '';
			$word = $j = 0;
			$final_text_index = -1;

			// cycle through every character in the original text
			for ($i = $word_indizes[$word], $n = utf8_strlen($text); $i < $n; $i++)
			{
				// if the current position is the start of one of the words then append $sequence_length characters to the final text
				if (isset($word_indizes[$word]) && ($i == $word_indizes[$word]))
				{
					if ($final_text_index < $i - $sequence_length - 1)
					{
						$final_text .= '... ' . preg_replace('#^([^ ]*)#', '', utf8_substr($text, $i - $sequence_length, $sequence_length));
					}
					else
					{
						// if the final text is already nearer to the current word than $sequence_length we only append the text
						// from its current index on and distribute the unused length to all other sequenes
						$sequence_length += (int) (($final_text_index - $i + $sequence_length + 1) / (2 * $wordnum));
						$final_text .= utf8_substr($text, $final_text_index + 1, $i - $final_text_index - 1);
					}
					$final_text_index = $i - 1;

					// add the following characters to the final text (see below)
					$word++;
					$j = 1;
				}

				if ($j > 0)
				{
					// add the character to the final text and increment the sequence counter
					$final_text .= utf8_substr($text, $i, 1);
					$final_text_index++;
					$j++;

					// if this is a whitespace then check whether we are done with this sequence
					if (utf8_substr($text, $i, 1) == ' ')
					{
						// only check whether we have to exit the context generation completely if we haven't already reached the end anyway
						if ($i + 4 < $n)
						{
							if (($j > $sequence_length && $word >= $wordnum) || utf8_strlen($final_text) > $length)
							{
								$final_text .= ' ...';
								break;
							}
						}
						else
						{
							// make sure the text really reaches the end
							$j -= 4;
						}

						// stop context generation and wait for the next word
						if ($j > $sequence_length)
						{
							$j = 0;
						}
					}
				}
			}
			return str_replace($characters, $entities, $final_text);
		}
	}

	if (!sizeof($words) || !sizeof($word_indizes))
	{
		return str_replace($characters, $entities, ((utf8_strlen($text) >= $length + 3) ? utf8_substr($text, 0, $length) . '...' : $text));
	}
}
function strip_bbcode(&$text, $uid = '')
{
	if (!$uid)
	{
		$uid = '[0-9a-z]{5,}';
	}

	$text = preg_replace("#\[\/?[a-z0-9\*\+\-]+(?:=(?:&quot;.*&quot;|[^\]]*))?(?::[a-z])?(\:$uid)\]#", ' ', $text);

	$match = get_preg_expression('bbcode_htm');
	$replace = array('\1', '\1', '\2', '\1', '', '');

	$text = preg_replace($match, $replace, $text);
}

			while ($row = $db->sql_fetchrow($result))
			{
				// We pre-process some variables here for later usage
				$row['post_text'] = censor_text($row['post_text']);

				$text_only_message = $row['post_text'];
				// make list items visible as such
				if ($row['bbcode_uid'])
				{
					$text_only_message = str_replace('[*:' . $row['bbcode_uid'] . ']', '&sdot;&nbsp;', $text_only_message);
					// no BBCode in text only message
					strip_bbcode($text_only_message, $row['bbcode_uid']);
				}

				if ($return_chars == -1 || utf8_strlen($text_only_message) < ($return_chars + 3))
				{
					$row['display_text_only'] = false;
					$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);

					// Does this post have an attachment? If so, add it to the list
					if ($row['post_attachment'] && $config['allow_attachments'])
					{
						$attach_list[$row['forum_id']][] = $row['post_id'];
					}
				}
				else
				{
					$row['post_text'] = $text_only_message;
					$row['display_text_only'] = true;
				}

				$rowset[] = $row;
			}
			$db->sql_freeresult($result);

			unset($text_only_message);

			// Instantiate BBCode if needed
			if ($bbcode_bitfield !== '')
			{
				include_once($phpbb_root_path . 'include/bbcode.' . $phpEx);
				$bbcode = new bbcode(base64_encode($bbcode_bitfield));
			}

			// Pull attachment data
			if (sizeof($attach_list))
			{
				$use_attach_list = $attach_list;
				$attach_list = array();

				foreach ($use_attach_list as $forum_id => $_list)
				{
					if ($auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id))
					{
						$attach_list = array_merge($attach_list, $_list);
					}
				}
			}

			if (sizeof($attach_list))
			{
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_attachments
					WHERE ' . $db->sql_in_set('post_msg_id', $attach_list) . '
						AND in_message = 0
					ORDER BY filetime DESC, post_msg_id ASC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$attachments[$row['post_msg_id']][] = $row;
				}
				$db->sql_freeresult($result);
			}
		}

		if ($hilit)
		{
			// Remove bad highlights
			$hilit_array = array_filter(explode('|', $hilit), 'strlen');
			foreach ($hilit_array as $key => $value)
			{
				$hilit_array[$key] = str_replace('\*', '\w*?', preg_quote($value, '#'));
				$hilit_array[$key] = preg_replace('#(^|\s)\\\\w\*\?(\s|$)#', '$1\w+?$2', $hilit_array[$key]);
			}
			$hilit = implode('|', $hilit_array);
		}

		foreach ($rowset as $row)
		{
			$forum_id = $row['forum_id'];
			$result_topic_id = $row['topic_id'];
			$topic_title = censor_text($row['topic_title']);

			// we need to select a forum id for this global topic
			if (!$forum_id)
			{
				if (!isset($g_forum_id))
				{
					// Get a list of forums the user cannot read
					$forum_ary = array_unique(array_keys($auth->acl_getf('!f_read', true)));

					// Determine first forum the user is able to read (must not be a category)
					$sql = 'SELECT forum_id
						FROM ' . $db_prefix . '_forums
						WHERE forum_type = ' . 1;

					if (sizeof($forum_ary))
					{
						$sql .= ' AND ' . $db->sql_in_set('forum_id', $forum_ary, true);
					}

					$result = $db->sql_query_limit($sql, 1);
					$g_forum_id = (int) $db->sql_fetchfield('forum_id');
				}
				$u_forum_id = $g_forum_id;
			}
			else
			{
				$u_forum_id = $forum_id;
			}

			$view_topic_url_params = "f=$u_forum_id&amp;t=$result_topic_id" . (($u_hilit) ? "&amp;hilit=$u_hilit" : '');
			$view_topic_url = append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params);

			$replies = ($auth->acl_get('m_approve', $forum_id)) ? $row['topic_replies_real'] : $row['topic_replies'];

			if ($show_results == 'topics')
			{
				if ($config['load_db_track'] && $author_id === $user->id)
				{
					$row['topic_posted'] = 1;
				}

				$folder_img = $folder_alt = $topic_type = '';
				topic_status($row, $replies, (isset($topic_tracking_info[$forum_id][$row['topic_id']]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$row['topic_id']]) ? true : false, $folder_img, $folder_alt, $topic_type);

				$unread_topic = (isset($topic_tracking_info[$forum_id][$row['topic_id']]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$row['topic_id']]) ? true : false;

				$topic_unapproved = (!$row['topic_approved'] && $auth->acl_get('m_approve', $forum_id)) ? true : false;
				$posts_unapproved = ($row['topic_approved'] && $row['topic_replies'] < $row['topic_replies_real'] && $auth->acl_get('m_approve', $forum_id)) ? true : false;
				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=mcp", 'i=queue&amp;mode=' . (($topic_unapproved) ? 'approve_details' : 'unapproved_posts') . "&amp;t=$result_topic_id", true, $user->session_id) : '';

				$row['topic_title'] = preg_replace('#(?!<.*)(?<!\w)(' . $hilit . ')(?!\w|[^<>]*(?:</s(?:cript|tyle))?>)#is', '<span class="posthilit">$1</span>', $row['topic_title']);

				$tpl_ary = array(
					'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'FIRST_POST_TIME'			=> $user->format_date($row['topic_time']),
					'LAST_POST_SUBJECT'			=> $row['topic_last_post_subject'],
					'LAST_POST_TIME'			=> $user->format_date($row['topic_last_post_time']),
					'LAST_VIEW_TIME'			=> $user->format_date($row['topic_last_view_time']),
					'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),

					'PAGINATION'		=> topic_generate_pagination($replies, $view_topic_url),
					'TOPIC_TYPE'		=> $topic_type,

					'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
					'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
					'TOPIC_FOLDER_IMG_ALT'	=> $user->lang[$folder_alt],
					'TOPIC_FOLDER_IMG_WIDTH'=> $user->img($folder_img, '', false, '', 'width'),
					'TOPIC_FOLDER_IMG_HEIGHT'	=> $user->img($folder_img, '', false, '', 'height'),

					'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
					'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
					'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
					'ATTACH_ICON_IMG'		=> ($auth->acl_get('u_download') && $auth->acl_get('f_download', $forum_id) && $row['topic_attachment']) ? $user->img('icon_topic_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',
					'UNAPPROVED_IMG'		=> ($topic_unapproved || $posts_unapproved) ? $user->img('icon_topic_unapproved', ($topic_unapproved) ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',

					'S_TOPIC_GLOBAL'		=> (!$forum_id) ? true : false,
					'S_TOPIC_TYPE'			=> $row['topic_type'],
					'S_USER_POSTED'			=> (!empty($row['mark_type'])) ? true : false,
					'S_UNREAD_TOPIC'		=> $unread_topic,

					'S_TOPIC_REPORTED'		=> (!empty($row['topic_reported']) && $auth->acl_get('m_report', $forum_id)) ? true : false,
					'S_TOPIC_UNAPPROVED'	=> $topic_unapproved,
					'S_POSTS_UNAPPROVED'	=> $posts_unapproved,

					'U_LAST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
					'U_LAST_POST_AUTHOR'	=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'U_TOPIC_AUTHOR'		=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'U_NEWEST_POST'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", $view_topic_url_params . '&amp;view=unread') . '#unread',
					'U_MCP_REPORT'			=> append_sid("{$phpbb_root_path}forum.$phpEx?action=mcp", 'i=reports&amp;mode=reports&amp;t=' . $result_topic_id, true, $user->session_id),
					'U_MCP_QUEUE'			=> $u_mcp_queue,
				);
			}
			else

			{
				if ((isset($zebra['foe']) && in_array($row['poster_id'], $zebra['foe'])) && (!$view || $view != 'show' || $post_id != $row['post_id']))
				{
					$template->assign_block_vars('searchresults', array(
						'S_IGNORE_POST' => true,

						'L_IGNORE_POST' => sprintf($user->lang['POST_BY_FOE'], $row['username'], "<a href=\"$u_search&amp;start=$start&amp;p=" . $row['post_id'] . '&amp;view=show#p' . $row['post_id'] . '">', '</a>'))
					);

					continue;
				}

				// Replace naughty words such as farty pants
				$row['post_subject'] = censor_text($row['post_subject']);

				if ($row['display_text_only'])
				{
					// now find context for the searched words
					$row['post_text'] = get_context($row['post_text'], array_filter(explode('|', $hilit), 'strlen'), $return_chars);
					$row['post_text'] = bbcode_nl2br($row['post_text']);
				}
				else
				{
					// Second parse bbcode here
					if ($row['bbcode_bitfield'])
					{
						$bbcode->bbcode_second_pass($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield']);
					}

					$row['post_text'] = bbcode_nl2br($row['post_text']);
					$row['post_text'] = smiley_text($row['post_text']);

					if (!empty($attachments[$row['post_id']]))
					{
						parse_attachments($forum_id, $row['post_text'], $attachments[$row['post_id']], $update_count);

						// we only display inline attachments
						unset($attachments[$row['post_id']]);
					}
				}

				if ($hilit)
				{
					// post highlighting
					$row['post_text'] = preg_replace('#(?!<.*)(?<!\w)(' . $hilit . ')(?!\w|[^<>]*(?:</s(?:cript|tyle))?>)#is', '<span class="posthilit">$1</span>', $row['post_text']);
					$row['post_subject'] = preg_replace('#(?!<.*)(?<!\w)(' . $hilit . ')(?!\w|[^<>]*(?:</s(?:cript|tyle))?>)#is', '<span class="posthilit">$1</span>', $row['post_subject']);
				}

				$tpl_ary = array(
					'POST_AUTHOR_FULL'		=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
					'POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
					'POST_AUTHOR'			=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
					'U_POST_AUTHOR'			=> get_username_string('profile', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),

					'POST_SUBJECT'		=> $row['post_subject'],
					'POST_DATE'			=> (!empty($row['post_time'])) ? $user->format_date($row['post_time']) : '',
					'MESSAGE'			=> $row['post_text']
				);
			}

			$template->assign_block_vars('searchresults', array_merge($tpl_ary, array(
				'FORUM_ID'			=> $forum_id,
				'TOPIC_ID'			=> $result_topic_id,
				'POST_ID'			=> ($show_results == 'posts') ? $row['post_id'] : false,

				'FORUM_TITLE'		=> $row['forum_name'],
				'TOPIC_TITLE'		=> $topic_title,
				'TOPIC_REPLIES'		=> $replies,
				'TOPIC_VIEWS'		=> $row['topic_views'],

				'U_VIEW_TOPIC'		=> $view_topic_url,
				'U_VIEW_FORUM'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $forum_id),
				'U_VIEW_POST'		=> (!empty($row['post_id'])) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", "f=$forum_id&amp;t=" . $row['topic_id'] . '&amp;p=' . $row['post_id'] . (($u_hilit) ? '&amp;hilit=' . $u_hilit : '')) . '#p' . $row['post_id'] : '')
			));
		}

		if ($topic_id && ($topic_id == $result_topic_id))
		{
			$template->assign_vars(array(
				'SEARCH_TOPIC'		=> $topic_title,
				'U_SEARCH_TOPIC'	=> $view_topic_url
			));
		}
	}
	unset($rowset);

	echo $template->fetch('search_results.html');
	close_out();
}


// Search forum
$s_forums = '';
$sql = 'SELECT f.forum_id, f.forum_name, f.parent_id, f.forum_type, f.left_id, f.right_id, f.forum_password, f.enable_indexing, fa.user_id
	FROM ' . $db_prefix . '_forums f
	LEFT JOIN ' . $db_prefix . "_forums_access fa ON (fa.forum_id = f.forum_id
		AND fa.session_id = '" . $db->sql_escape($user->session_id) . "')
	ORDER BY f.left_id ASC";
$result = $db->sql_query($sql);

$right = $cat_right = $padding_inc = 0;
$padding = $forum_list = $holding = '';
$pad_store = array('0' => '');

while ($row = $db->sql_fetchrow($result))
{
	if ($row['forum_type'] == 0 && ($row['left_id'] + 1 == $row['right_id']))
	{
		// Non-postable forum with no subforums, don't display
		continue;
	}

	if ($row['forum_type'] == 1 && ($row['left_id'] + 1 == $row['right_id']) && !$row['enable_indexing'])
	{
		// Postable forum with no subforums and indexing disabled, don't display
		continue;
	}

	if ($row['forum_type'] == 2 || ($row['forum_password'] && !$row['user_id']))
	{
		// if this forum is a link or password protected (user has not entered the password yet) then skip to the next branch
		continue;
	}

	if ($row['left_id'] < $right)
	{
		$padding .= '&nbsp; &nbsp;';
		$pad_store[$row['parent_id']] = $padding;
	}
	else if ($row['left_id'] > $right + 1)
	{
		if (isset($pad_store[$row['parent_id']]))
		{
			$padding = $pad_store[$row['parent_id']];
		}
		else
		{
			continue;
		}
	}

	$right = $row['right_id'];

	if ($auth->acl_gets('!f_search', '!f_list', $row['forum_id']))
	{
		// if the user does not have permissions to search or see this forum skip only this forum/category
		continue;
	}

	$selected = (in_array($row['forum_id'], $search_forum)) ? ' selected="selected"' : '';

	if ($row['left_id'] > $cat_right)
	{
		// make sure we don't forget anything
		$s_forums .= $holding;
		$holding = '';
	}

	if ($row['right_id'] - $row['left_id'] > 1)
	{
		$cat_right = max($cat_right, $row['right_id']);

		$holding .= '<option value="' . $row['forum_id'] . '"' . $selected . '>' . $padding . $row['forum_name'] . '</option>';
	}
	else
	{
		$s_forums .= $holding . '<option value="' . $row['forum_id'] . '"' . $selected . '>' . $padding . $row['forum_name'] . '</option>';
		$holding = '';
	}
}

if ($holding)
{
	$s_forums .= $holding;
}

$db->sql_freeresult($result);
unset($pad_store);

if (!$s_forums)
{
	trigger_error('NO_SEARCH');
}

// Number of chars returned
$s_characters = '<option value="-1">' . $user->lang['ALL_AVAILABLE'] . '</option>';
$s_characters .= '<option value="0">0</option>';
$s_characters .= '<option value="25">25</option>';
$s_characters .= '<option value="50">50</option>';

for ($i = 100; $i <= 1000 ; $i += 100)
{
	$selected = ($i == 300) ? ' selected="selected"' : '';
	$s_characters .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
}

$s_hidden_fields = array('t' => $topic_id, 'action' => 'search');

if ($_SID)
{
	$s_hidden_fields['sid'] = $_SID;
}

if (!empty($_EXTRA_URL))
{
	foreach ($_EXTRA_URL as $url_param)
	{
		$url_param = explode('=', $url_param, 2);
		$s_hidden_fields[$url_param[0]] = $url_param[1];
	}
}

$template->assign_vars(array(
	'S_SEARCH_ACTION'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=search", false, true, 0), // We force no ?sid= appending by using 0
	'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
	'S_CHARACTER_OPTIONS'	=> $s_characters,
	'S_FORUM_OPTIONS'		=> $s_forums,
	'S_SELECT_SORT_DIR'		=> $s_sort_dir,
	'S_SELECT_SORT_KEY'		=> $s_sort_key,
	'S_SELECT_SORT_DAYS'	=> $s_limit_days,
	'S_IN_SEARCH'			=> true,
));

// only show recent searches to search administrators
if ($auth->acl_get('a_search'))
{
	// Handle large objects differently for Oracle and MSSQL
	switch ($db->sql_layer)
	{
		case 'oracle':
			$sql = 'SELECT search_time, search_keywords
				FROM ' . $db_prefix . '_search_results
				WHERE dbms_lob.getlength(search_keywords) > 0
				ORDER BY search_time DESC';
		break;

		case 'mssql':
		case 'mssql_odbc':
			$sql = 'SELECT search_time, search_keywords
				FROM ' . $db_prefix . '_search_results
				WHERE DATALENGTH(search_keywords) > 0
				ORDER BY search_time DESC';
		break;

		default:
			$sql = 'SELECT search_time, search_keywords
				FROM ' . $db_prefix . '_search_results
				WHERE search_keywords <> \'\'
				ORDER BY search_time DESC';
		break;
	}
	$result = $db->sql_query($sql . 'LIMIT ' . 5);

	while ($row = $db->sql_fetchrow($result))
	{
		$keywords = $row['search_keywords'];

		$template->assign_block_vars('recentsearch', array(
			'KEYWORDS'	=> $keywords,
			'TIME'		=> $user->format_date($row['search_time']),

			'U_KEYWORDS'	=> append_sid("{$phpbb_root_path}forum.$phpEx?action=search", 'keywords=' . urlencode(htmlspecialchars_decode($keywords)))
		));
	}
	$db->sql_freeresult($result);
}

// Output the basic page
make_jumpbox(append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum"));
	echo $template->fetch('search_body.html');
	close_out();
?>
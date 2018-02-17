<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_personal.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function posting_gen_inline_attachments(&$attachment_data)
{
	global $template;

	if (sizeof($attachment_data))
	{
		$s_inline_attachment_options = '';

		foreach ($attachment_data as $i => $attachment)
		{
			$s_inline_attachment_options .= '<option value="' . $i . '">' . $attachment['real_filename'] . '</option>';
		}

		$template->assign_var('S_INLINE_ATTACHMENT_OPTIONS', $s_inline_attachment_options);

		return true;
	}

	return false;
}
function generate_smilies($mode, $forum_id, $display_link = false)
{
 global $db, $db_prefix, $template, $siteurl;
        $sql = "SELECT * FROM ".$db_prefix."_smiles WHERE id > '1' GROUP BY file ORDER BY sort_index ASC LIMIT 14;";
        $smile_res = $db->sql_query($sql) or btsqlerror($sql);
                //$result = $db->sql_fetchrowset($smile_res) or btsqlerror($sql);
	$smilies = array();
	while ($row = $db->sql_fetchrow($smile_res))
	{
			$template->assign_block_vars('smiley', array(
				'SMILEY_CODE'	=> $row['code'],
				'A_SMILEY_CODE'	=> addslashes($row['code']),
				'SMILEY_IMG'	=> $siteurl . '/smiles/' . $row['file'],
				'SMILEY_WIDTH'	=> '',
				'SMILEY_HEIGHT'	=> '',
				'SMILEY_DESC'	=> $row['alt'])
			);
		if (empty($smilies[$row['smiley_url']]))
		{
			$smilies[$row['smiley_url']] = $row;
		}
	}
	$db->sql_freeresult($smile_res);
//die(print_r($row));

	if ($mode == 'inline' && $display_link)
	{
		$template->assign_vars(array(
			'S_SHOW_SMILEY_LINK' 	=> true,
			'U_MORE_SMILIES' 		=> append_sid("{$siteurl}/forum.php", 'action=posting&mode=smilies&amp;f=' . $forum_id))
		);
	}

	if ($mode == 'window')
	{
		//page_footer();
	}
}
function check_form_key($form_name, $timespan = false, $return_page = '', $trigger = false)
{
	global $user, $db_prefix;

	if ($timespan === false)
	{
		// we enforce a minimum value of half a minute here.
		$timespan =  -1 ;
	}

	if (isset($_POST['creation_time']) && isset($_POST['form_token']))
	{
		$creation_time	= abs(request_var('creation_time', 0));
		$token = request_var('form_token', '');

		$diff = time() - $creation_time;

		// If creation_time and the time() now is zero we can assume it was not a human doing this (the check for if ($diff)...
		if ($diff && ($diff <= $timespan || $timespan === -1))
		{
			$token_sid = ($user->id == 0) ? session_id() : '';
			$key = sha1($creation_time . '5522211445' . $form_name . $token_sid);

			if ($key === $token)
			{
				return true;
			}
		}
	}

	if ($trigger)
	{
		trigger_error($user->lang['FORM_INVALID'] . $return_page);
	}

	return false;
}
function add_form_key($form_name)
{
	global $template, $user, $db_prefix;

	$now = time();
	$token_sid = '';
	$token = sha1($now . '5522211445' . $form_name . $token_sid);

	$s_fields = build_hidden_fields(array(
		'creation_time' => $now,
		'form_token'	=> $token,
	));

	$template->assign_vars(array(
		'S_FORM_TOKEN'	=> $s_fields,
	));
}

class acp_bbcodes
{
	var $u_action = 'admin.php?i=staff&amp;op=bbcode';

	function main($id, $mode)
	{
		global $db, $user, $template, $db_prefix, $pmbt_cache;
		global $siteurl, $phpEx;


		// Set up general vars
		$action	= request_var('action', '');
		$bbcode_id = request_var('bbcode', 0);

		$this->tpl_name = 'acp_bbcodes';
		$this->page_title = 'ACP_BBCODES';
		$form_key = 'acp_bbcodes';

		add_form_key($form_key);

		// Set up mode-specific vars
		switch ($action)
		{
			case 'add':
				$bbcode_match = $bbcode_tpl = $bbcode_helpline = '';
				$display_on_posting = 0;
			break;

			case 'edit':
				$sql = 'SELECT bbcode_match, bbcode_tpl, display_on_posting, bbcode_helpline
					FROM ' . $db_prefix . '_bbcodes
					WHERE bbcode_id = ' . $bbcode_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($user->lang['BBCODE_NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$bbcode_match = $row['bbcode_match'];
				$bbcode_tpl = htmlspecialchars($row['bbcode_tpl']);
				$display_on_posting = $row['display_on_posting'];
				$bbcode_helpline = $row['bbcode_helpline'];
			break;

			case 'modify':
				$sql = 'SELECT bbcode_id, bbcode_tag
					FROM ' . $db_prefix . '_bbcodes
					WHERE bbcode_id = ' . $bbcode_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($user->lang['BBCODE_NOT_EXIST'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

			// No break here

			case 'make_bbcode':
				$display_on_posting = request_var('display_on_posting', 0);

				$bbcode_match = request_var('bbcode_match', '');
				$bbcode_tpl = htmlspecialchars_decode(request_var('bbcode_tpl', '', true));
				$bbcode_helpline = request_var('bbcode_helpline', '', true);
			break;
		}

		// Do major work
		switch ($action)
		{
			case 'edit':
			case 'add':

				$template->assign_vars(array(
					'S_EDIT_BBCODE'		=> true,
					'U_BACK'			=> $this->u_action,
					'U_ACTION'			=> $this->u_action . '&amp;action=' . (($action == 'add') ? 'make_bbcode' : 'modify') . (($bbcode_id) ? "&amp;bbcode=$bbcode_id" : ''),

					'L_BBCODE_USAGE_EXPLAIN'=> sprintf($user->lang['BBCODE_USAGE_EXPLAIN'], '<a href="#down">', '</a>'),
					'BBCODE_MATCH'			=> $bbcode_match,
					'BBCODE_TPL'			=> $bbcode_tpl,
					'BBCODE_HELPLINE'		=> $bbcode_helpline,
					'DISPLAY_ON_POSTING'	=> $display_on_posting)
				);

				foreach ($user->lang['tokens'] as $token => $token_explain)
				{
					$template->assign_block_vars('token', array(
						'TOKEN'		=> '{' . $token . '}',
						'EXPLAIN'	=> $token_explain)
					);
				}

				return;

			break;

			case 'modify':
			case 'make_bbcode':

				$data = $this->build_regexp($bbcode_match, $bbcode_tpl);

				// Make sure the user didn't pick a "bad" name for the BBCode tag.
				$hard_coded = array('code', 'quote', 'quote=', 'attachment', 'attachment=', 'b', 'i', 'url', 'url=', 'img', 'size', 'size=', 'color', 'color=', 'u', 'list', 'list=', 'email', 'email=', 'flash', 'flash=');

				if (($action == 'modify' && strtolower($data['bbcode_tag']) !== strtolower($row['bbcode_tag'])) || ($action == 'make_bbcode'))
				{
					$sql = 'SELECT 1 as test
						FROM ' . $db_prefix . "_bbcodes
						WHERE LOWER(bbcode_tag) = '" . $db->sql_escape(strtolower($data['bbcode_tag'])) . "'";
					$result = $db->sql_query($sql);
					$info = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// Grab the end, interrogate the last closing tag
					if ($info['test'] === '1' || in_array(strtolower($data['bbcode_tag']), $hard_coded) || (preg_match('#\[/([^[]*)]$#', $bbcode_match, $regs) && in_array(strtolower($regs[1]), $hard_coded)))
					{
						trigger_error($user->lang['BBCODE_INVALID_TAG_NAME'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
				}

				if (substr($data['bbcode_tag'], -1) === '=')
				{
					$test = substr($data['bbcode_tag'], 0, -1);
				}
				else
				{
					$test = $data['bbcode_tag'];
				}

				if (!preg_match('%\\[' . $test . '[^]]*].*?\\[/' . $test . ']%s', $bbcode_match))
				{
					trigger_error($user->lang['BBCODE_OPEN_ENDED_TAG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (strlen($data['bbcode_tag']) > 16)
				{
					trigger_error($user->lang['BBCODE_TAG_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (strlen($bbcode_match) > 4000)
				{
					trigger_error($user->lang['BBCODE_TAG_DEF_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				
				
				if (strlen($bbcode_helpline) > 255)
				{
					trigger_error($user->lang['BBCODE_HELPLINE_TOO_LONG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql_ary = array(
					'bbcode_tag'				=> $data['bbcode_tag'],
					'bbcode_match'				=> $bbcode_match,
					'bbcode_tpl'				=> $bbcode_tpl,
					'display_on_posting'		=> $display_on_posting,
					'bbcode_helpline'			=> $bbcode_helpline,
					'first_pass_match'			=> $data['first_pass_match'],
					'first_pass_replace'		=> $data['first_pass_replace'],
					'second_pass_match'			=> $data['second_pass_match'],
					'second_pass_replace'		=> $data['second_pass_replace']
				);

				if ($action == 'make_bbcode')
				{
					$sql = 'SELECT MAX(bbcode_id) as max_bbcode_id
						FROM ' . $db_prefix . '_bbcodes';
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($row)
					{
						$bbcode_id = $row['max_bbcode_id'] + 1;

						// Make sure it is greater than the core bbcode ids...
						if ($bbcode_id <= 12)
						{
							$bbcode_id = 12 + 1;
						}
					}
					else
					{
						$bbcode_id = 12 + 1;
					}

					if ($bbcode_id > 1511)
					{
						trigger_error($user->lang['TOO_MANY_BBCODES'] . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql_ary['bbcode_id'] = (int) $bbcode_id;
					$db->sql_query('INSERT INTO ' . $db_prefix . '_bbcodes' . $db->sql_build_array('INSERT', $sql_ary));

					$lang = 'BBCODE_ADDED';
					//$log_action = 'LOG_BBCODE_ADD';
				}
				else
				{
					$sql = 'UPDATE ' . $db_prefix . '_bbcodes
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE bbcode_id = ' . $bbcode_id;
					$db->sql_query($sql);

					$lang = 'BBCODE_EDITED';
					$log_action = 'LOG_BBCODE_EDIT';
				}


			break;

			case 'delete':

				$sql = 'SELECT bbcode_tag
					FROM ' . $db_prefix . "_bbcodes
					WHERE bbcode_id = $bbcode_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row)
				{
					if (confirm_box(true))
					{
						$db->sql_query('DELETE FROM ' . $db_prefix . "_bbcodes WHERE bbcode_id = $bbcode_id");
						add_log('admin', 'LOG_BBCODE_DELETE', $row['bbcode_tag']);
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'bbcode'	=> $bbcode_id,
							'id'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action)),'confirm_body.html',$this->u_action
						);
					}
				}

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action . '&amp;action=add#bbcode')
		);

		$sql = 'SELECT *
			FROM ' . $db_prefix . '_bbcodes
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('bbcodes', array(
				'BBCODE_TAG'		=> $row['bbcode_tag'],
				'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;bbcode=' . $row['bbcode_id'] ."#bbcode",
				'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;bbcode=' . $row['bbcode_id'] ."#bbcode")
			);
		}
		$db->sql_freeresult($result);
	}

	/*
	* Build regular expression for custom bbcode
	*/
	function build_regexp(&$bbcode_match, &$bbcode_tpl)
	{
		$bbcode_match = trim($bbcode_match);
		$bbcode_tpl = trim($bbcode_tpl);

		$fp_match = preg_quote($bbcode_match, '!');
		$fp_replace = preg_replace('#^\[(.*?)\]#', '[$1]', $bbcode_match);
		$fp_replace = preg_replace('#\[/(.*?)\]$#', '[/$1]', $fp_replace);

		$sp_match = preg_quote($bbcode_match, '!');
		$sp_match = preg_replace('#^\\\\\[(.*?)\\\\\]#', '\[$1\]', $sp_match);
		$sp_match = preg_replace('#\\\\\[/(.*?)\\\\\]$#', '\[/$1\]', $sp_match);
		$sp_replace = $bbcode_tpl;

		// @todo Make sure to change this too if something changed in message parsing
		$tokens = array(
			'URL'	 => array(
				'!(?:(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('url')) . ')|(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('www_url')) . '))!i'	=>	"\$this->bbcode_specialchars(('\$1') ? '\$1' : 'http://\$2')"
			),
			'LOCAL_URL'	 => array(
				'!(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('relative_url')) . ')!s'	=>	"\$this->bbcode_specialchars('$1')"
			),
			'EMAIL' => array(
				'!(' . get_preg_expression('email') . ')!i'	=>	"\$this->bbcode_specialchars('$1')"
			),
			'TEXT' => array(
				'!(.*?)!s'	 =>	"str_replace(array(\"\\r\\n\", '\\\"', '\\'', '(', ')'), array(\"\\n\", '\"', '&#39;', '&#40;', '&#41;'), trim('\$1'))"
			),
			'SIMPLETEXT' => array(
				'!([a-zA-Z0-9-+.,_ ]+)!'	 =>	"$1"
			),
			'IDENTIFIER' => array(
				'!([a-zA-Z0-9-_]+)!'	 =>	"$1"
			),
			'COLOR' => array(
				'!([a-z]+|#[0-9abcdef]+)!i'	=>	'$1'
			),
			'NUMBER' => array(
				'!([0-9]+)!'	=>	'$1'
			)
		);

		$sp_tokens = array(
			'URL'	 => '(?i)((?:' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('url')) . ')|(?:' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('www_url')) . '))(?-i)',
			'LOCAL_URL'	 => '(?i)(' . str_replace(array('!', '\#'), array('\!', '#'), get_preg_expression('relative_url')) . ')(?-i)',
			'EMAIL' => '(' . get_preg_expression('email') . ')',
			'TEXT' => '(.*?)',
			'SIMPLETEXT' => '([a-zA-Z0-9-+.,_ ]+)',
			'IDENTIFIER' => '([a-zA-Z0-9-_]+)',
			'COLOR' => '([a-zA-Z]+|#[0-9abcdefABCDEF]+)',
			'NUMBER' => '([0-9]+)',
		);

		$pad = 0;
		$modifiers = 'i';

		if (preg_match_all('/\{(' . implode('|', array_keys($tokens)) . ')[0-9]*\}/i', $bbcode_match, $m))
		{
			foreach ($m[0] as $n => $token)
			{
				$token_type = $m[1][$n];

				reset($tokens[strtoupper($token_type)]);
				list($match, $replace) = each($tokens[strtoupper($token_type)]);

				// Pad backreference numbers from tokens
				if (preg_match_all('/(?<!\\\\)\$([0-9]+)/', $replace, $repad))
				{
					$repad = $pad + sizeof(array_unique($repad[0]));
					$replace = preg_replace('/(?<!\\\\)\$([0-9]+)/', "'\$' . (\$1 + \$pad) . ''", $replace);
					$pad = $repad;
				}

				// Obtain pattern modifiers to use and alter the regex accordingly
				$regex = preg_replace('/!(.*)!([a-z]*)/', '$1', $match);
				$regex_modifiers = preg_replace('/!(.*)!([a-z]*)/', '$2', $match);

				for ($i = 0, $size = strlen($regex_modifiers); $i < $size; ++$i)
				{
					if (strpos($modifiers, $regex_modifiers[$i]) === false)
					{
						$modifiers .= $regex_modifiers[$i];

						if ($regex_modifiers[$i] == 'e')
						{
							$fp_replace = "'" . str_replace("'", "\\'", $fp_replace) . "'";
						}
					}

					if ($regex_modifiers[$i] == 'e')
					{
						$replace = "'.$replace.'";
					}
				}

				$fp_match = str_replace(preg_quote($token, '!'), $regex, $fp_match);
				$fp_replace = str_replace($token, $replace, $fp_replace);

				$sp_match = str_replace(preg_quote($token, '!'), $sp_tokens[$token_type], $sp_match);
				$sp_replace = str_replace($token, '$' . ($n + 1) . '', $sp_replace);
			}

			$fp_match = '!' . $fp_match . '!' . $modifiers;
			$sp_match = '!' . $sp_match . '!s';

			if (strpos($fp_match, 'e') !== false)
			{
				$fp_replace = str_replace("'.'", '', $fp_replace);
				$fp_replace = str_replace(".''.", '.', $fp_replace);
			}
		}
		else
		{
			// No replacement is present, no need for a second-pass pattern replacement
			// A simple str_replace will suffice
			$fp_match = '!' . $fp_match . '!' . $modifiers;
			$sp_match = $fp_replace;
			$sp_replace = '';
		}

		// Lowercase tags
		$bbcode_tag = preg_replace('/.*?\[([a-z0-9_-]+=?).*/i', '$1', $bbcode_match);
		$bbcode_search = preg_replace('/.*?\[([a-z0-9_-]+)=?.*/i', '$1', $bbcode_match);

		if (!preg_match('/^[a-zA-Z0-9_-]+=?$/', $bbcode_tag))
		{
			global $user, $db_prefix;
			trigger_error($user->lang['BBCODE_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
		}

		$fp_match = preg_replace('#\[/?' . $bbcode_search . '#i', "strtolower('\$0')", $fp_match);
		$fp_replace = preg_replace('#\[/?' . $bbcode_search . '#i', "strtolower('\$0')", $fp_replace);
		$sp_match = preg_replace('#\[/?' . $bbcode_search . '#i', "strtolower('\$0')", $sp_match);
		$sp_replace = preg_replace('#\[/?' . $bbcode_search . '#i', "strtolower('\$0')", $sp_replace);

		return array(
			'bbcode_tag'				=> $bbcode_tag,
			'first_pass_match'			=> $fp_match,
			'first_pass_replace'		=> $fp_replace,
			'second_pass_match'			=> $sp_match,
			'second_pass_replace'		=> $sp_replace
		);
	}
}
class bitfield
{
	var $data;

	function bitfield($bitfield = '')
	{
		$this->data = base64_decode($bitfield);
	}

	/**
	*/
	function get($n)
	{
		// Get the ($n / 8)th char
		$byte = $n >> 3;
		

		if (strlen($this->data) >= $byte + 1)
		{
			$c = $this->data[$byte];

			// Lookup the ($n % 8)th bit of the byte
			$bit = 7 - ($n & 7);
			return (bool) (ord($c) & (1 << $bit));
		}
		else
		{
			return false;
		}
	}

	function set($n)
	{
		$byte = $n >> 3;
		$bit = 7 - ($n & 7);

		if (strlen($this->data) >= $byte + 1)
		{
			$this->data[$byte] = $this->data[$byte] | chr(1 << $bit);
		}
		else
		{
			$this->data .= str_repeat("\0", $byte - strlen($this->data));
			$this->data .= chr(1 << $bit);
		}
	}

	function clear($n)
	{
		$byte = $n >> 3;

		if (strlen($this->data) >= $byte + 1)
		{
			$bit = 7 - ($n & 7);
			$this->data[$byte] = $this->data[$byte] &~ chr(1 << $bit);
		}
	}

	function get_blob()
	{
		return $this->data;
	}

	function get_base64()
	{
		return base64_encode($this->data);
	}

	function get_bin()
	{
		$bin = '';
		$len = strlen($this->data);

		for ($i = 0; $i < $len; ++$i)
		{
			$bin .= str_pad(decbin(ord($this->data[$i])), 8, '0', STR_PAD_LEFT);
		}

		return $bin;
	}

	function get_all_set()
	{
		return array_keys(array_filter(str_split($this->get_bin())));
	}

	function merge($bitfield)
	{
		$this->data = $this->data | $bitfield->get_blob();
	}
}
?>
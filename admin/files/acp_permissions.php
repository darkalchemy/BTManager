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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------  Sunday, Sept 25, 2011 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 levels.php  2011-10-03 4:42 PM joeroberts $
* @copyright (c) 2011 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
class acp_permissions
{
	var $u_action;
	var $permission_dropdown;

	function main($id, $mode)
	{
		global $db, $db_prefix, $user, $auth, $template, $pmbt_cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		include_once($phpbb_root_path . 'include/user.functions.' . $phpEx);
		include_once($phpbb_root_path . 'include/acp/auth.' . $phpEx);

		$auth_admin = new auth_admin();

		$user->set_lang('admin/acp_permissions',$user->ulanguage);
		//add_permission_language();

		$this->tpl_name = 'acp_permissions';

		// Trace has other vars
		if ($mode == 'trace')
		{
			$user_id = request_var('u', 0);
			$forum_id = request_var('f', 0);
			$permission = request_var('auth', '');

			$this->tpl_name = 'permission_trace';

			if ($user_id && isset($auth_admin->acl_options['id'][$permission]) && $auth->acl_get('a_viewauth'))
			{
				$this->page_title = sprintf($user->lang['TRACE_PERMISSION'], $user->lang['acl_' . $permission]['lang']);
				$this->permission_trace($user_id, $forum_id, $permission);
				return;
			}
			trigger_error('NO_MODE', E_USER_ERROR);
		}

		// Set some vars
		$action = request_var('action', array('' => 0));
		$action = key($action);
		$action = (isset($_POST['psubmit'])) ? 'apply_permissions' : $action;

		$all_forums = request_var('all_forums', 0);
		$subforum_id = request_var('subforum_id', 0);
		$forum_id = request_var('forum_id', array(0));

		$username = request_var('username', array(''), true);
		$usernames = request_var('usernames', '', true);
		$user_id = request_var('user_id', array('0'));

		$group_id = request_var('group_id', array('0'));
		$select_all_groups = request_var('select_all_groups', 0);

		$form_name = 'acp_permissions';
		add_form_key($form_name);

		// If select all groups is set, we pre-build the group id array (this option is used for other screens to link to the permission settings screen)
		if ($select_all_groups)
		{
			// Add default groups to selection
			$sql_and = (!$config['coppa_enable']) ? " AND group_name <> 'REGISTERED_COPPA'" : '';

			$sql = 'SELECT group_id
				FROM ' . $db_prefix . '_level_settings
				WHERE group_type = ' . 3 . "
				$sql_and";
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$group_id[] = $row['group_id'];
			}
			$db->sql_freeresult($result);
		}

		// Map usernames to ids and vice versa
		if ($usernames)
		{
			$username = explode("\n", $usernames);
		}
		unset($usernames);

		if (sizeof($username) && !sizeof($user_id))
		{
			user_get_id_name($user_id, $username);

			if (!sizeof($user_id))
			{
				trigger_error($user->lang['SELECTED_USER_NOT_EXIST'] . back_link($this->u_action), E_USER_WARNING);
			}
		}
		unset($username);

		// Build forum ids (of all forums are checked or subforum listing used)
		if ($all_forums)
		{
			$sql = 'SELECT forum_id
				FROM ' . $db_prefix . '_forums
				ORDER BY left_id';
			$result = $db->sql_query($sql);

			$forum_id = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$forum_id[] = (int) $row['forum_id'];
			}
			$db->sql_freeresult($result);
		}
		else if ($subforum_id)
		{
			$forum_id = array();
			foreach (get_forum_branch($subforum_id, 'children') as $row)
			{
				$forum_id[] = (int) $row['forum_id'];
			}
		}

		// Define some common variables for every mode
		$error = array();

		$permission_scope = (strpos($mode, '_global') !== false) ? 'global' : 'local';

		// Showing introductionary page?
		if ($mode == 'intro')
		{
			$this->page_title = 'ACP_PERMISSIONS';

			$template->assign_vars(array(
				'S_INTRO'		=> true)
			);

			return;
		}

		switch ($mode)
		{
			case 'setting_user_global':
			case 'setting_group_global':
				$this->permission_dropdown = array('u_', 'm_', 'a_');
				$permission_victim = ($mode == 'setting_user_global') ? array('user') : array('group');
				$this->page_title = ($mode == 'setting_user_global') ? 'ACP_USERS_PERMISSIONS' : 'ACP_GROUPS_PERMISSIONS';
			break;

			case 'setting_user_local':
			case 'setting_group_local':
				$this->permission_dropdown = array('f_', 'm_');
				$permission_victim = ($mode == 'setting_user_local') ? array('user', 'forums') : array('group', 'forums');
				$this->page_title = ($mode == 'setting_user_local') ? 'ACP_USERS_FORUM_PERMISSIONS' : 'ACP_GROUPS_FORUM_PERMISSIONS';
			break;

			case 'setting_admin_global':
			case 'setting_mod_global':
				$this->permission_dropdown = (strpos($mode, '_admin_') !== false) ? array('a_') : array('m_');
				$permission_victim = array('usergroup');
				$this->page_title = ($mode == 'setting_admin_global') ? 'ACP_ADMINISTRATORS' : 'ACP_GLOBAL_MODERATORS';
			break;

			case 'setting_mod_local':
			case 'setting_forum_local':
				$this->permission_dropdown = ($mode == 'setting_mod_local') ? array('m_') : array('f_');
				$permission_victim = array('forums', 'usergroup');
				$this->page_title = ($mode == 'setting_mod_local') ? 'ACP_FORUM_MODERATORS' : 'ACP_FORUM_PERMISSIONS';
			break;

			case 'view_admin_global':
			case 'view_user_global':
			case 'view_mod_global':
				$this->permission_dropdown = ($mode == 'view_admin_global') ? array('a_') : (($mode == 'view_user_global') ? array('u_') : array('m_'));
				$permission_victim = array('usergroup_view');
				$this->page_title = ($mode == 'view_admin_global') ? 'ACP_VIEW_ADMIN_PERMISSIONS' : (($mode == 'view_user_global') ? 'ACP_VIEW_USER_PERMISSIONS' : 'ACP_VIEW_GLOBAL_MOD_PERMISSIONS');
			break;

			case 'view_mod_local':
			case 'view_forum_local':
				$this->permission_dropdown = ($mode == 'view_mod_local') ? array('m_') : array('f_');
				$permission_victim = array('forums', 'usergroup_view');
				$this->page_title = ($mode == 'view_mod_local') ? 'ACP_VIEW_FORUM_MOD_PERMISSIONS' : 'ACP_VIEW_FORUM_PERMISSIONS';
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}

		$template->assign_vars(array(
			'L_TITLE'		=> $user->lang[$this->page_title],
			'L_EXPLAIN'		=> $user->lang[$this->page_title . '_EXPLAIN'])
		);

		// Get permission type
		$permission_type = request_var('type', $this->permission_dropdown[0]);

		if (!in_array($permission_type, $this->permission_dropdown))
		{
			trigger_error($user->lang['WRONG_PERMISSION_TYPE'] . back_link($this->u_action), E_USER_WARNING);
		}


		// Handle actions
		if (strpos($mode, 'setting_') === 0 && $action)
		{
			switch ($action)
			{
				case 'delete_per':

					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID']. back_link($this->u_action), E_USER_WARNING);
					}
					// All users/groups selected?
					$all_users = (isset($_POST['all_users'])) ? true : false;
					$all_groups = (isset($_POST['all_groups'])) ? true : false;

					if ($all_users || $all_groups)
					{
						$items = $this->retrieve_defined_user_groups($permission_scope, $forum_id, $permission_type);

						if ($all_users && sizeof($items['user_ids']))
						{
							$user_id = $items['user_ids'];
						}
						else if ($all_groups && sizeof($items['group_ids']))
						{
							$group_id = $items['group_ids'];
						}
					}

					if (sizeof($user_id) || sizeof($group_id))
					{
						$this->remove_permissions($mode, $permission_type, $auth_admin, $user_id, $group_id, $forum_id);
					}
					else
					{
						trigger_error($user->lang['NO_USER_GROUP_SELECTED'] . back_link($this->u_action.'123456'), E_USER_WARNING);
					}
				break;

				case 'apply_permissions':
					if (!isset($_POST['setting']))
					{
						trigger_error($user->lang['NO_AUTH_SETTING_FOUND'] . back_link($this->u_action), E_USER_WARNING);
					}
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID']. back_link($this->u_action), E_USER_WARNING);
					}

					$this->set_permissions($mode, $permission_type, $auth_admin, $user_id, $group_id);
				break;

				case 'apply_all_permissions':
					if (!isset($_POST['setting']))
					{
						trigger_error($user->lang['NO_AUTH_SETTING_FOUND'] . back_link($this->u_action), E_USER_WARNING);
					}
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID']. back_link($this->u_action), E_USER_WARNING);
					}

					$this->set_all_permissions($mode, $permission_type, $auth_admin, $user_id, $group_id);
				break;
			}
		}


		// Setting permissions screen
		$s_hidden_fields = build_hidden_fields(array(
			'user_id'		=> $user_id,
			'group_id'		=> $group_id,
			'forum_id'		=> $forum_id,
			'type'			=> $permission_type)
		);

		// Go through the screens/options needed and present them in correct order
		foreach ($permission_victim as $victim)
		{
			switch ($victim)
			{
				case 'forum_dropdown':

					if (sizeof($forum_id))
					{
						$this->check_existence('forum', $forum_id);
						continue 2;
					}

					$template->assign_vars(array(
						'S_SELECT_FORUM'		=> true,
						'S_FORUM_OPTIONS'		=> make_forum_select(false, false, true, false, false))
					);

				break;

				case 'forums':

					if (sizeof($forum_id))
					{
						$this->check_existence('forum', $forum_id);
						continue 2;
					}

					$forum_list = make_forum_select(false, false, true, false, false, false, true);

					// Build forum options
					$s_forum_options = '';
					foreach ($forum_list as $f_id => $f_row)
					{
						$s_forum_options .= '<option value="' . $f_id . '"' . (($f_row['selected']) ? ' selected="selected"' : '') . (($f_row['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
					}

					// Build subforum options
					$s_subforum_options = $this->build_subforum_options($forum_list);

					$template->assign_vars(array(
						'S_SELECT_FORUM'		=> true,
						'S_FORUM_OPTIONS'		=> $s_forum_options,
						'S_SUBFORUM_OPTIONS'	=> $s_subforum_options,
						'S_FORUM_ALL'			=> true,
						'S_FORUM_MULTIPLE'		=> true)
					);

				break;

				case 'user':

					if (sizeof($user_id))
					{
						$this->check_existence('user', $user_id);
						continue 2;
					}

					$template->assign_vars(array(
						'S_SELECT_USER'			=> true,
						'U_FIND_USERNAME'		=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=select_victim&amp;field=username&amp;select_single=true'),
					));

				break;

				case 'group':

					if (sizeof($group_id))
					{
						$this->check_existence('group', $group_id);
						continue 2;
					}

					$template->assign_vars(array(
						'S_SELECT_GROUP'		=> true,
						'S_GROUP_OPTIONS'		=> group_select_options_id(false, false, false), // Show all groups
					));

				break;

				case 'usergroup':
				case 'usergroup_view':

					$all_users = (isset($_POST['all_users'])) ? true : false;
					$all_groups = (isset($_POST['all_groups'])) ? true : false;

					if ((sizeof($user_id) && !$all_users) || (sizeof($group_id) && !$all_groups))
					{
						if (sizeof($user_id))
						{
							$this->check_existence('user', $user_id);
						}

						if (sizeof($group_id))
						{
							$this->check_existence('group', $group_id);
						}

						continue 2;
					}

					// Now we check the users... because the "all"-selection is different here (all defined users/groups)
					$items = $this->retrieve_defined_user_groups($permission_scope, $forum_id, $permission_type);

					if ($all_users && sizeof($items['user_ids']))
					{
						$user_id = $items['user_ids'];
						continue 2;
					}

					if ($all_groups && sizeof($items['group_ids']))
					{
						$group_id = $items['group_ids'];
						continue 2;
					}

					$template->assign_vars(array(
						'S_SELECT_USERGROUP'		=> ($victim == 'usergroup') ? true : false,
						'S_SELECT_USERGROUP_VIEW'	=> ($victim == 'usergroup_view') ? true : false,
						'S_DEFINED_USER_OPTIONS'	=> $items['user_ids_options'],
						'S_DEFINED_GROUP_OPTIONS'	=> $items['group_ids_options'],
						'S_ADD_GROUP_OPTIONS'		=> group_select_options_id(false, $items['group_ids'], false),	// Show all groups
						'U_FIND_USERNAME'			=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=add_user&amp;field=username&amp;select_single=true'),
					));

				break;
			}

			// The S_ALLOW_SELECT parameter below is a measure to lower memory usage.
			// If there are more than 5 forums selected the admin is not able to select all users/groups too.
			// We need to see if the number of forums can be increased or need to be decreased.

			$template->assign_vars(array(
				'U_ACTION'				=> $this->u_action,
				'ANONYMOUS_USER_ID'		=> 0,

				'S_SELECT_VICTIM'		=> true,
				'S_ALLOW_ALL_SELECT'	=> (sizeof($forum_id) > 5) ? false : true,
				'S_CAN_SELECT_USER'		=> ($auth->acl_get('a_authusers')) ? true : false,
				'S_CAN_SELECT_GROUP'	=> ($auth->acl_get('a_authgroups')) ? true : false,
				'S_HIDDEN_FIELDS'		=> $s_hidden_fields)
			);

			// Let the forum names being displayed
			if (sizeof($forum_id))
			{
				$sql = 'SELECT forum_name
					FROM ' . $db_prefix . '_forums
					WHERE ' . $db->sql_in_set('forum_id', $forum_id) . '
					ORDER BY left_id ASC';
				$result = $db->sql_query($sql);

				$forum_names = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$forum_names[] = $row['forum_name'];
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_FORUM_NAMES'		=> (sizeof($forum_names)) ? true : false,
					'FORUM_NAMES'		=> implode(', ', $forum_names))
				);
			}

			return;
		}

		// Do not allow forum_ids being set and no other setting defined (will bog down the server too much)
		if (sizeof($forum_id) && !sizeof($user_id) && !sizeof($group_id))
		{
			trigger_error($user->lang['ONLY_FORUM_DEFINED'] . back_link($this->u_action), E_USER_WARNING);
		}

		$template->assign_vars(array(
			'S_PERMISSION_DROPDOWN'		=> (sizeof($this->permission_dropdown) > 1) ? $this->build_permission_dropdown($this->permission_dropdown, $permission_type, $permission_scope) : false,
			'L_PERMISSION_TYPE'			=> $user->lang['ACL_TYPE_' . strtoupper($permission_type)],

			'U_ACTION'					=> $this->u_action,
			'S_HIDDEN_FIELDS'			=> $s_hidden_fields)
		);

		if (strpos($mode, 'setting_') === 0)
		{
			$template->assign_vars(array(
				'S_SETTING_PERMISSIONS'		=> true)
			);

			$hold_ary = $auth_admin->get_mask('set', (sizeof($user_id)) ? $user_id : false, (sizeof($group_id)) ? $group_id : false, (sizeof($forum_id)) ? $forum_id : false, $permission_type, $permission_scope, -1);
			$auth_admin->display_mask('set', $permission_type, $hold_ary, ((sizeof($user_id)) ? 'user' : 'group'), (($permission_scope == 'local') ? true : false));
		}
		else
		{
			$template->assign_vars(array(
				'S_VIEWING_PERMISSIONS'		=> true)
			);
			$hold_ary = $auth_admin->get_mask('view', (sizeof($user_id)) ? $user_id : false, (sizeof($group_id)) ? $group_id : false, (sizeof($forum_id)) ? $forum_id : false, $permission_type, $permission_scope, 0);
			$auth_admin->display_mask('view', $permission_type, $hold_ary, ((sizeof($user_id)) ? 'user' : 'group'), (($permission_scope == 'local') ? true : false));
		}
	}

	/**
	* Build +subforum options
	*/
	function build_subforum_options($forum_list)
	{
		global $user;

		$s_options = '';

		$forum_list = array_merge($forum_list);

		foreach ($forum_list as $key => $row)
		{
			if ($row['disabled'])
			{
				continue;
			}

			$s_options .= '<option value="' . $row['forum_id'] . '"' . (($row['selected']) ? ' selected="selected"' : '') . '>' . $row['padding'] . $row['forum_name'];

			// We check if a branch is there...
			$branch_there = false;

			foreach (array_slice($forum_list, $key + 1) as $temp_row)
			{
				if ($temp_row['left_id'] > $row['left_id'] && $temp_row['left_id'] < $row['right_id'])
				{
					$branch_there = true;
					break;
				}
				continue;
			}

			if ($branch_there)
			{
				$s_options .= ' [' . $user->lang['PLUS_SUBFORUMS'] . ']';
			}

			$s_options .= '</option>';
		}

		return $s_options;
	}

	/**
	* Build dropdown field for changing permission types
	*/
	function build_permission_dropdown($options, $default_option, $permission_scope)
	{
		global $user, $auth;

		$s_dropdown_options = '';
		foreach ($options as $setting)
		{
			if (!$auth->acl_get('a_' . str_replace('_', '', $setting) . 'auth'))
			{
				continue;
			}

			$selected = ($setting == $default_option) ? ' selected="selected"' : '';
			$l_setting = (isset($user->lang['permission_type'][$permission_scope][$setting])) ? $user->lang['permission_type'][$permission_scope][$setting] : $user->lang['permission_type'][$setting];
			$s_dropdown_options .= '<option value="' . $setting . '"' . $selected . '>' . $l_setting . '</option>';
		}

		return $s_dropdown_options;
	}

	/**
	* Check if selected items exist. Remove not found ids and if empty return error.
	*/
	function check_existence($mode, &$ids)
	{
		global $db, $db_prefix, $user;
		

		switch ($mode)
		{
			case 'user':
				$table = $db_prefix . '_users';
				$sql_id = 'id';
			break;

			case 'group':
				$table = $db_prefix . '_level_settings';
				$sql_id = 'group_id';
			break;

			case 'forum':
				$table = $db_prefix . "_forums";
				$sql_id = 'forum_id';
			break;
		}

		if (sizeof($ids))
		{
			$sql = "SELECT $sql_id
				FROM $table
				WHERE " . $db->sql_in_set($sql_id, $ids);
			$result = $db->sql_query($sql);

			$ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$ids[] = (int) $row[$sql_id];
			}
			$db->sql_freeresult($result);
		}

		if (!sizeof($ids))
		{
			trigger_error($user->lang['SELECTED_' . strtoupper($mode) . '_NOT_EXIST'] . back_link($this->u_action), E_USER_WARNING);
		}
	}

	/**
	* Apply permissions
	*/
	function set_permissions($mode, $permission_type, &$auth_admin, &$user_id, &$group_id)
	{
		global $user, $auth;

		$psubmit = request_var('psubmit', array(0 => array(0 => 0)));

		// User or group to be set?
		$ug_type = (sizeof($user_id)) ? 'user' : 'group';

		// Check the permission setting again
		if (!$auth->acl_get('a_' . str_replace('_', '', $permission_type) . 'auth') || !$auth->acl_get('a_auth' . $ug_type . 's'))
		{
			trigger_error($user->lang['NO_AUTH_OPERATION'] . back_link($this->u_action), E_USER_WARNING);
		}

		$ug_id = $forum_id = 0;

		// We loop through the auth settings defined in our submit
		list($ug_id, ) = each($psubmit);
		list($forum_id, ) = each($psubmit[$ug_id]);

		if (empty($_POST['setting']) || empty($_POST['setting'][$ug_id]) || empty($_POST['setting'][$ug_id][$forum_id]) || !is_array($_POST['setting'][$ug_id][$forum_id]))
		{
			trigger_error('WRONG_PERMISSION_SETTING_FORMAT', E_USER_WARNING);
		}

		// We obtain and check $_POST['setting'][$ug_id][$forum_id] directly and not using request_var() because request_var()
		// currently does not support the amount of dimensions required. ;)
		//		$auth_settings = request_var('setting', array(0 => array(0 => array('' => 0))));
		$auth_settings = array_map('intval', $_POST['setting'][$ug_id][$forum_id]);

		// Do we have a role we want to set?
		$assigned_role = (isset($_POST['role'][$ug_id][$forum_id])) ? (int) $_POST['role'][$ug_id][$forum_id] : 0;

		// Do the admin want to set these permissions to other items too?
		$inherit = request_var('inherit', array(0 => array(0)));

		$ug_id = array($ug_id);
		$forum_id = array($forum_id);

		if (sizeof($inherit))
		{
			foreach ($inherit as $_ug_id => $forum_id_ary)
			{
				// Inherit users/groups?
				if (!in_array($_ug_id, $ug_id))
				{
					$ug_id[] = $_ug_id;
				}

				// Inherit forums?
				$forum_id = array_merge($forum_id, array_keys($forum_id_ary));
			}
		}

		$forum_id = array_unique($forum_id);

		// If the auth settings differ from the assigned role, then do not set a role...
		if ($assigned_role)
		{
			if (!$this->check_assigned_role($assigned_role, $auth_settings))
			{
				$assigned_role = 0;
			}
		}

		// Update the permission set...
		$auth_admin->acl_set($ug_type, $forum_id, $ug_id, $auth_settings, $assigned_role);

		// Do we need to recache the moderator lists?
		if ($permission_type == 'm_')
		{
			cache_moderators();
		}

		// Remove users who are now moderators or admins from everyones foes list
		if ($permission_type == 'm_' || $permission_type == 'a_')
		{
			update_foes($group_id, $user_id);
		}

		$this->log_action($mode, 'add', $permission_type, $ug_type, $ug_id, $forum_id);

		trigger_error($user->lang['AUTH_UPDATED'] . back_link($this->u_action));
	}

	/**
	* Apply all permissions
	*/
	function set_all_permissions($mode, $permission_type, &$auth_admin, &$user_id, &$group_id)
	{
		global $user, $auth;

		// User or group to be set?
		$ug_type = (sizeof($user_id)) ? 'user' : 'group';

		// Check the permission setting again
		if (!$auth->acl_get('a_' . str_replace('_', '', $permission_type) . 'auth') || !$auth->acl_get('a_auth' . $ug_type . 's'))
		{
			trigger_error($user->lang['NO_AUTH_OPERATION'] . back_link($this->u_action), E_USER_WARNING);
		}

		$auth_settings = (isset($_POST['setting'])) ? $_POST['setting'] : array();
		$auth_roles = (isset($_POST['role'])) ? $_POST['role'] : array();
		$ug_ids = $forum_ids = array();

		// We need to go through the auth settings
		foreach ($auth_settings as $ug_id => $forum_auth_row)
		{
			$ug_id = (int) $ug_id;
			$ug_ids[] = $ug_id;

			foreach ($forum_auth_row as $forum_id => $auth_options)
			{
				$forum_id = (int) $forum_id;
				$forum_ids[] = $forum_id;

				// Check role...
				$assigned_role = (isset($auth_roles[$ug_id][$forum_id])) ? (int) $auth_roles[$ug_id][$forum_id] : 0;

				// If the auth settings differ from the assigned role, then do not set a role...
				if ($assigned_role)
				{
					if (!$this->check_assigned_role($assigned_role, $auth_options))
					{
						$assigned_role = 0;
					}
				}

				// Update the permission set...
				$auth_admin->acl_set($ug_type, $forum_id, $ug_id, $auth_options, $assigned_role, false);
			}
		}

		$auth_admin->acl_clear_prefetch();

		// Do we need to recache the moderator lists?
		if ($permission_type == 'm_')
		{
			cache_moderators();
		}

		// Remove users who are now moderators or admins from everyones foes list
		if ($permission_type == 'm_' || $permission_type == 'a_')
		{
			update_foes($group_id, $user_id);
		}

		$this->log_action($mode, 'add', $permission_type, $ug_type, $ug_ids, $forum_ids);

		if ($mode == 'setting_forum_local' || $mode == 'setting_mod_local')
		{
			trigger_error($user->lang['AUTH_UPDATED'] . back_link($this->u_action . '&amp;forum_id[]=' . implode('&amp;forum_id[]=', $forum_ids)));
		}
		else
		{
			trigger_error($user->lang['AUTH_UPDATED'] . back_link($this->u_action));
		}
	}

	/**
	* Compare auth settings with auth settings from role
	* returns false if they differ, true if they are equal
	*/
	function check_assigned_role($role_id, &$auth_settings)
	{
		global $db, $db_prefix;

		$sql = 'SELECT o.auth_option, r.auth_setting
			FROM ' . $db_prefix . '_acl_options o, ' . $db_prefix . '_acl_roles_data r
			WHERE o.auth_option_id = r.auth_option_id
				AND r.role_id = ' . $role_id;
		$result = $db->sql_query($sql);

		$test_auth_settings = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$test_auth_settings[$row['auth_option']] = $row['auth_setting'];
		}
		$db->sql_freeresult($result);

		// We need to add any ACL_NO setting from auth_settings to compare correctly
		foreach ($auth_settings as $option => $setting)
		{
			if ($setting == -1)
			{
				$test_auth_settings[$option] = $setting;
			}
		}

		if (sizeof(array_diff_assoc($auth_settings, $test_auth_settings)))
		{
			return false;
		}

		return true;
	}

	/**
	* Remove permissions
	*/
	function remove_permissions($mode, $permission_type, &$auth_admin, &$user_id, &$group_id, &$forum_id)
	{
		global $user, $db, $auth;

		// User or group to be set?
		$ug_type = (sizeof($user_id)) ? 'user' : 'group';

		// Check the permission setting again
		if (!$auth->acl_get('a_' . str_replace('_', '', $permission_type) . 'auth') || !$auth->acl_get('a_auth' . $ug_type . 's'))
		{
			trigger_error($user->lang['NO_AUTH_OPERATION'] . back_link($this->u_action), E_USER_WARNING);
		}

		$auth_admin->acl_delete($ug_type, (($ug_type == 'user') ? $user_id : $group_id), (sizeof($forum_id) ? $forum_id : false), $permission_type);

		// Do we need to recache the moderator lists?
		if ($permission_type == 'm_')
		{
			cache_moderators();
		}

		$this->log_action($mode, 'del', $permission_type, $ug_type, (($ug_type == 'user') ? $user_id : $group_id), (sizeof($forum_id) ? $forum_id : array(0 => 0)));

		if ($mode == 'setting_forum_local' || $mode == 'setting_mod_local')
		{
			trigger_error($user->lang['AUTH_UPDATED'] . back_link($this->u_action . '&amp;forum_id[]=' . implode('&amp;forum_id[]=', $forum_id)));
		}
		else
		{
			trigger_error($user->lang['AUTH_UPDATED'] . back_link($this->u_action));
		}
	}

	/**
	* Log permission changes
	*/
	function log_action($mode, $action, $permission_type, $ug_type, $ug_id, $forum_id)
	{
		global $db, $db_prefix, $user;

		if (!is_array($ug_id))
		{
			$ug_id = array($ug_id);
		}

		if (!is_array($forum_id))
		{
			$forum_id = array($forum_id);
		}

		// Logging ... first grab user or groupnames ...
		$sql = ($ug_type == 'group') ? 'SELECT group_name as name, group_type FROM ' . $db_prefix . '_level_settings WHERE ' : 'SELECT username as name FROM ' . $db_prefix . '_users WHERE ';
		$sql .= $db->sql_in_set(($ug_type == 'group') ? 'group_id' : 'id', array_map('intval', $ug_id));
		$result = $db->sql_query($sql);

		$l_ug_list = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$l_ug_list .= (($l_ug_list != '') ? ', ' : '') . ((isset($row['group_type']) && $row['group_type'] == 3) ? '<span class="sep">' . $user->lang['G_' . $row['name']] . '</span>' : $row['name']);
		}
		$db->sql_freeresult($result);

		$mode = str_replace('setting_', '', $mode);

		if ($forum_id[0] == 0)
		{
			//add_log('admin', 'LOG_ACL_' . strtoupper($action) . '_' . strtoupper($mode) . '_' . strtoupper($permission_type), $l_ug_list);
		}
		else
		{
			// Grab the forum details if non-zero forum_id
			$sql = 'SELECT forum_name
				FROM ' . $db_prefix . '_forums
				WHERE ' . $db->sql_in_set('forum_id', $forum_id);
			$result = $db->sql_query($sql);

			$l_forum_list = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$l_forum_list .= (($l_forum_list != '') ? ', ' : '') . $row['forum_name'];
			}
			$db->sql_freeresult($result);

			add_log('admin', 'LOG_ACL_' . strtoupper($action) . '_' . strtoupper($mode) . '_' . strtoupper($permission_type), $l_forum_list, $l_ug_list);
		}
	}

	/**
	* Display a complete trace tree for the selected permission to determine where settings are set/unset
	*/
	function permission_trace($user_id, $forum_id, $permission)
	{
		global $db, $db_prefix, $template, $user, $auth;

		if ($user_id != $user->id)
		{
			$sql = 'SELECT id, username, user_permissions, user_type
				FROM ' . $db_prefix . '_users
				WHERE id = ' . $user_id;
			$result = $db->sql_query($sql);
			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}
		else
		{
			$userdata = $user->data;
		}

		if (!$userdata)
		{
			trigger_error('NO_USERS', E_USER_ERROR);
		}

		$forum_name = false;

		if ($forum_id)
		{
			$sql = 'SELECT forum_name
				FROM ' . $db_prefix . "_forums
				WHERE forum_id = $forum_id";
			$result = $db->sql_query($sql, 3600);
			$forum_name = $db->sql_fetchfield('forum_name');
			$db->sql_freeresult($result);
		}

		$back = request_var('back', 0);

		$template->assign_vars(array(
			'PERMISSION'			=> $user->lang['acl_' . $permission]['lang'],
			'PERMISSION_USERNAME'	=> $userdata['username'],
			'FORUM_NAME'			=> $forum_name,

			'S_GLOBAL_TRACE'		=> ($forum_id) ? false : true,

			'U_BACK'				=> ($back) ? build_url(array('f', 'back')) . "&amp;f=$back" : '')
		);

		$template->assign_block_vars('trace', array(
			'WHO'			=> $user->lang['DEFAULT'],
			'INFORMATION'	=> $user->lang['TRACE_DEFAULT'],

			'S_SETTING_NO'		=> true,
			'S_TOTAL_NO'		=> true)
		);

		$sql = 'SELECT DISTINCT g.group_name, g.group_id, g.group_type
			FROM ' . $db_prefix . '_level_settings g
				LEFT JOIN ' . $db_prefix . '_user_groups ug ON (ug.group_id = g.group_id)
			WHERE ug.user_id = ' . $user_id . '
				AND ug.user_pending = 0
			ORDER BY g.group_type DESC, g.group_id DESC';
		$result = $db->sql_query($sql);

		$groups = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$groups[$row['group_id']] = array(
				'auth_setting'		=> -1,
				'group_name'		=> ($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name']
			);
		}
		$db->sql_freeresult($result);

		$total = -1;
		$add_key = (($forum_id) ? '_LOCAL' : '');

		if (sizeof($groups))
		{
			// Get group auth settings
			$hold_ary = $auth->acl_group_raw_data(array_keys($groups), $permission, $forum_id);

			foreach ($hold_ary as $group_id => $forum_ary)
			{
				$groups[$group_id]['auth_setting'] = $hold_ary[$group_id][$forum_id][$permission];
			}
			unset($hold_ary);

			foreach ($groups as $id => $row)
			{
				switch ($row['auth_setting'])
				{
					case -1:
						$information = $user->lang['TRACE_GROUP_NO' . $add_key];
					break;

					case 1:
						$information = ($total == 1) ? $user->lang['TRACE_GROUP_YES_TOTAL_YES' . $add_key] : (($total == 0) ? $user->lang['TRACE_GROUP_YES_TOTAL_NEVER' . $add_key] : $user->lang['TRACE_GROUP_YES_TOTAL_NO' . $add_key]);
						$total = ($total == -1) ? 1 : $total;
					break;

					case 0:
						$information = ($total == 1) ? $user->lang['TRACE_GROUP_NEVER_TOTAL_YES' . $add_key] : (($total == 0) ? $user->lang['TRACE_GROUP_NEVER_TOTAL_NEVER' . $add_key] : $user->lang['TRACE_GROUP_NEVER_TOTAL_NO' . $add_key]);
						$total = 0;
					break;
				}

				$template->assign_block_vars('trace', array(
					'WHO'			=> $row['group_name'],
					'INFORMATION'	=> $information,

					'S_SETTING_NO'		=> ($row['auth_setting'] == -1) ? true : false,
					'S_SETTING_YES'		=> ($row['auth_setting'] == 1) ? true : false,
					'S_SETTING_NEVER'	=> ($row['auth_setting'] == 0) ? true : false,
					'S_TOTAL_NO'		=> ($total == -1) ? true : false,
					'S_TOTAL_YES'		=> ($total == 1) ? true : false,
					'S_TOTAL_NEVER'		=> ($total == 0) ? true : false)
				);
			}
		}

		// Get user specific permission... globally or for this forum
		$hold_ary = $auth->acl_user_raw_data($user_id, $permission, $forum_id);
		$auth_setting = (!sizeof($hold_ary)) ? -1 : $hold_ary[$user_id][$forum_id][$permission];

		switch ($auth_setting)
		{
			case -1:
				$information = ($total == -1) ? $user->lang['TRACE_USER_NO_TOTAL_NO' . $add_key] : $user->lang['TRACE_USER_KEPT' . $add_key];
				$total = ($total == -1) ? 0 : $total;
			break;

			case 1:
				$information = ($total == 1) ? $user->lang['TRACE_USER_YES_TOTAL_YES' . $add_key] : (($total == 0) ? $user->lang['TRACE_USER_YES_TOTAL_NEVER' . $add_key] : $user->lang['TRACE_USER_YES_TOTAL_NO' . $add_key]);
				$total = ($total == -1) ? 1 : $total;
			break;

			case 0:
				$information = ($total == 1) ? $user->lang['TRACE_USER_NEVER_TOTAL_YES' . $add_key] : (($total == 0) ? $user->lang['TRACE_USER_NEVER_TOTAL_NEVER' . $add_key] : $user->lang['TRACE_USER_NEVER_TOTAL_NO' . $add_key]);
				$total = 0;
			break;
		}

		$template->assign_block_vars('trace', array(
			'WHO'			=> $userdata['username'],
			'INFORMATION'	=> $information,

			'S_SETTING_NO'		=> ($auth_setting == -1) ? true : false,
			'S_SETTING_YES'		=> ($auth_setting == 1) ? true : false,
			'S_SETTING_NEVER'	=> ($auth_setting == 0) ? true : false,
			'S_TOTAL_NO'		=> false,
			'S_TOTAL_YES'		=> ($total == 1) ? true : false,
			'S_TOTAL_NEVER'		=> ($total == 0) ? true : false)
		);

		if ($forum_id != 0 && isset($auth->acl_options['global'][$permission]))
		{
			if ($user_id != $user->id)
			{
				$auth2 = new auth();
				$auth2->acl($userdata);
				$auth_setting = $auth2->acl_get($permission);
			}
			else
			{
				$auth_setting = $auth->acl_get($permission);
			}

			if ($auth_setting)
			{
				$information = ($total == 1) ? $user->lang['TRACE_USER_GLOBAL_YES_TOTAL_YES'] : $user->lang['TRACE_USER_GLOBAL_YES_TOTAL_NEVER'];
				$total = 1;
			}
			else
			{
				$information = $user->lang['TRACE_USER_GLOBAL_NEVER_TOTAL_KEPT'];
			}

			// If there is no auth information we do not need to worry the user by showing non-relevant data.
			if ($auth_setting)
			{
				$template->assign_block_vars('trace', array(
					'WHO'			=> sprintf($user->lang['TRACE_GLOBAL_SETTING'], $userdata['username']),
					'INFORMATION'	=> sprintf($information, '<a href="' . $this->u_action . "&amp;u=$user_id&amp;f=0&amp;auth=$permission&amp;back=$forum_id\">", '</a>'),

					'S_SETTING_NO'		=> false,
					'S_SETTING_YES'		=> $auth_setting,
					'S_SETTING_NEVER'	=> !$auth_setting,
					'S_TOTAL_NO'		=> false,
					'S_TOTAL_YES'		=> ($total == 1) ? true : false,
					'S_TOTAL_NEVER'		=> ($total == 0) ? true : false)
				);
			}
		}

		// Take founder status into account, overwriting the default values
		if ($userdata['user_type'] == 3 && strpos($permission, 'a_') === 0)
		{
			$template->assign_block_vars('trace', array(
				'WHO'			=> $userdata['username'],
				'INFORMATION'	=> $user->lang['TRACE_USER_FOUNDER'],

				'S_SETTING_NO'		=> ($auth_setting == -1) ? true : false,
				'S_SETTING_YES'		=> ($auth_setting == 1) ? true : false,
				'S_SETTING_NEVER'	=> ($auth_setting == 0) ? true : false,
				'S_TOTAL_NO'		=> false,
				'S_TOTAL_YES'		=> true,
				'S_TOTAL_NEVER'		=> false)
			);

			$total = 1;
		}

		// Total value...
		$template->assign_vars(array(
			'S_RESULT_NO'		=> ($total == -1) ? true : false,
			'S_RESULT_YES'		=> ($total == 1) ? true : false,
			'S_RESULT_NEVER'	=> ($total == 0) ? true : false,
		));
	}

	/**
	* Get already assigned users/groups
	*/
	function retrieve_defined_user_groups($permission_scope, $forum_id, $permission_type)
	{
		global $db, $db_prefix, $user;

		$sql_forum_id = ($permission_scope == 'global') ? 'AND a.forum_id = 0' : ((sizeof($forum_id)) ? 'AND ' . $db->sql_in_set('a.forum_id', $forum_id) : 'AND a.forum_id <> 0');

		// Permission options are only able to be a permission set... therefore we will pre-fetch the possible options and also the possible roles
		$option_ids = $role_ids = array();

		$sql = 'SELECT auth_option_id
			FROM ' . $db_prefix . '_acl_options
			WHERE auth_option ' . $db->sql_like_expression($permission_type . $db->any_char);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$option_ids[] = (int) $row['auth_option_id'];
		}
		$db->sql_freeresult($result);

		if (sizeof($option_ids))
		{
			$sql = 'SELECT DISTINCT role_id
				FROM ' . $db_prefix . '_acl_roles_data
				WHERE ' . $db->sql_in_set('auth_option_id', $option_ids);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$role_ids[] = (int) $row['role_id'];
			}
			$db->sql_freeresult($result);
		}

		if (sizeof($option_ids) && sizeof($role_ids))
		{
			$sql_where = 'AND (' . $db->sql_in_set('a.auth_option_id', $option_ids) . ' OR ' . $db->sql_in_set('a.auth_role_id', $role_ids) . ')';
		}
		else if (sizeof($role_ids))
		{
			$sql_where = 'AND ' . $db->sql_in_set('a.auth_role_id', $role_ids);
		}
		else if (sizeof($option_ids))
		{
			$sql_where = 'AND ' . $db->sql_in_set('a.auth_option_id', $option_ids);
		}

		// Not ideal, due to the filesort, non-use of indexes, etc.
		$sql = 'SELECT DISTINCT u.id, u.username, u.clean_username, u.regdate
			FROM ' . $db_prefix . '_users u, ' . $db_prefix . "_acl_users a
			WHERE u.id = a.user_id
				$sql_forum_id
				$sql_where
			ORDER BY u.clean_username, u.regdate ASC";
		$result = $db->sql_query($sql);

		$s_defined_user_options = '';
		$defined_user_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$s_defined_user_options .= '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
			$defined_user_ids[] = $row['user_id'];
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT DISTINCT g.group_type, g.group_name, g.group_id
			FROM ' . $db_prefix . '_level_settings g, ' . $db_prefix . "_acl_groups a
			WHERE g.group_id = a.group_id
				$sql_forum_id
				$sql_where
			ORDER BY g.group_type DESC, g.group_name ASC";
		$result = $db->sql_query($sql);

		$s_defined_group_options = '';
		$defined_group_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$s_defined_group_options .= '<option' . (($row['group_type'] == 3) ? ' class="sep"' : '') . ' value="' . $row['group_id'] . '">' . (($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name']) . '</option>';
			$defined_group_ids[] = $row['group_id'];
		}
		$db->sql_freeresult($result);

		return array(
			'group_ids'			=> $defined_group_ids,
			'group_ids_options'	=> $s_defined_group_options,
			'user_ids'			=> $defined_user_ids,
			'user_ids_options'	=> $s_defined_user_options
		);
	}
}

?>
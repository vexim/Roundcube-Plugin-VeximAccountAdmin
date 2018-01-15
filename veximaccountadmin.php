<?php

/**
 * VeximAccountAdmin
 *
 * Plugin that covers the non-admin part of Vexim web interface.
 *
 * Moved to vexim-repository
 * @url https://github.com/vexim/Roundcube-Plugin-VeximAccountAdmin
 * @date 2017-12-23
 * @licence GNU GPL 2.0
 * History:
 * @date 2009-11-12
 * @author Axel Sjostedt
 * @url http://axel.sjostedt.no/misc/dev/roundcube/
 * @licence GNU GPL
 */
class veximaccountadmin extends rcube_plugin {
	public $task = 'settings';
	private $config;
	private $db;
	private $sections = array ();
	function init() {
		$rcmail = rcmail::get_instance ();
		$this->add_texts ( 'localization/', array (
				'accountadmin' 
		) );
		
		$this->register_action ( 'plugin.veximaccountadmin', array (
				$this,
				'veximaccountadmin_init' 
		) );
		$this->register_action ( 'plugin.veximaccountadmin-save', array (
				$this,
				'veximaccountadmin_save' 
		) );
		
		$this->include_script ( 'veximaccountadmin.js' );
		$this->include_stylesheet ( 'veximaccountadmin.css' );
	}
	function veximaccountadmin_init() {
		$this->add_texts ( 'localization/' );
		$this->register_handler ( 'plugin.body', array (
				$this,
				'veximaccountadmin_form' 
		) );
		
		$rcmail = rcmail::get_instance ();
		$rcmail->output->set_pagetitle ( $this->gettext ( 'accountadministration' ) );
		$rcmail->output->send ( 'plugin' );
	}
	private function _load_config() {
		$fpath_config_dist = $this->home . '/config.inc.php.dist';
		$fpath_config = $this->home . '/config.inc.php';
		
		if (is_file ( $fpath_config_dist ) and is_readable ( $fpath_config_dist ))
			$found_config_dist = true;
		if (is_file ( $fpath_config ) and is_readable ( $fpath_config ))
			$found_config = true;
		
		if ($found_config_dist or $found_config) {
			ob_start ();
			
			if ($found_config_dist) {
				include ($fpath_config_dist);
				$veximaccountadmin_config_dist = $veximaccountadmin_config;
			}
			if ($found_config) {
				include ($fpath_config);
			}
			
			$config_array = array_merge ( $veximaccountadmin_config_dist, $veximaccountadmin_config );
			$this->config = $config_array;
			ob_end_clean ();
		} else {
			raise_error ( array (
					'code' => 527,
					'type' => 'php',
					'message' => "Failed to load VeximAccountAdmin plugin config" 
			), true, true );
		}
	}
	private function _db_connect($mode) {
		$this->db = rcube_db::factory ( $this->config ['db_dsn'], '', false );
		$this->db->db_connect ( $mode );
		
		// check DB connections and exit on failure
		if ($err_str = $this->db->is_error ()) {
			raise_error ( array (
					'code' => 603,
					'type' => 'db',
					'message' => $err_str 
			), FALSE, TRUE );
		}
	}
	function veximaccountadmin_save() {
		$this->add_texts ( 'localization/' );
		$this->register_handler ( 'plugin.body', array (
				$this,
				'veximaccountadmin_form' 
		) );
		
		$rcmail = rcmail::get_instance ();
		$this->_load_config ();
		$rcmail->output->set_pagetitle ( $this->gettext ( 'accountadministration' ) );
		
		// Set variables and make them ready to be put into DB
		$user = $rcmail->user->data ['username'];
		
		$on_avscan = rcube_utils::get_input_value ( 'on_avscan', rcube_utils::INPUT_POST );
		if (! $on_avscan)
			$on_avscan = 0;
		
		$on_spamassassin = rcube_utils::get_input_value ( 'on_spamassassin', rcube_utils::INPUT_POST );
		if (! $on_spamassassin)
			$on_spamassassin = 0;
		
		$sa_tag = rcube_utils::get_input_value ( 'sa_tag', rcube_utils::INPUT_POST );
		$sa_refuse = rcube_utils::get_input_value ( 'sa_refuse', rcube_utils::INPUT_POST );
		
		$spam_drop = rcube_utils::get_input_value ( 'spam_drop', rcube_utils::INPUT_POST );
		if (! $spam_drop)
			$spam_drop = 0;
		
		$on_vacation = rcube_utils::get_input_value ( 'on_vacation', rcube_utils::INPUT_POST );
		if (! $on_vacation)
			$on_vacation = 0;
		
		$vacation = rcube_utils::get_input_value ( 'vacation', rcube_utils::INPUT_POST );
		
		$on_forward = rcube_utils::get_input_value ( 'on_forward', rcube_utils::INPUT_POST );
		if (! $on_forward)
			$on_forward = 0;
		
		$forward = rcube_utils::get_input_value ( 'forward', rcube_utils::INPUT_POST );
		
		$unseen = rcube_utils::get_input_value ( 'unseen', rcube_utils::INPUT_POST );
		if (! $unseen)
			$unseen = 0;
		
		$maxmsgsize = rcube_utils::get_input_value ( 'maxmsgsize', rcube_utils::INPUT_POST );
		
		$acts = rcube_utils::get_input_value ( '_headerblock_rule_act', rcube_utils::INPUT_POST );
		$prefs = rcube_utils::get_input_value ( '_headerblock_rule_field', rcube_utils::INPUT_POST );
		$vals = rcube_utils::get_input_value ( '_headerblock_rule_value', rcube_utils::INPUT_POST );
		
		$actswhite = rcube_utils::get_input_value ( '_headerwhite_rule_act', rcube_utils::INPUT_POST );
		$prefswhite = rcube_utils::get_input_value ( '_headerwhite_rule_field', rcube_utils::INPUT_POST );
		$valswhite = rcube_utils::get_input_value ( '_headerwhite_rule_value', rcube_utils::INPUT_POST );	
		
		$res = $this->_save ( $user, $on_avscan, $on_spamassassin, $sa_tag, $sa_refuse, $spam_drop, $on_vacation, $vacation, $on_forward, $forward, $unseen, $maxmsgsize, $acts, $prefs, $vals, $actswhite, $prefswhite, $valswhite );
		
		if (! $res) {
			$rcmail->output->command ( 'display_message', $this->gettext ( 'savesuccess-config' ), 'confirmation' );
		} else {
			$rcmail->output->command ( 'display_message', $res, 'error' );
		}
		
		$rcmail->overwrite_action ( 'plugin.veximaccountadmin' );
		
		$this->veximaccountadmin_init ();
	}
	function veximaccountadmin_form() {
		$rcmail = rcmail::get_instance ();
		$this->_load_config ();
		
		// add labels to client - to be used in JS alerts
		$rcmail->output->add_label ( 'veximaccountadmin.enterallpassfields', 'veximaccountadmin.passwordinconsistency', 'veximaccountadmin.autoresponderlong', 'veximaccountadmin.autoresponderlongnum', 'veximaccountadmin.autoresponderlongmax', 'veximaccountadmin.headerblockdelete', 'veximaccountadmin.headerblockdeleteall', 'veximaccountadmin.headerblockexists', 'veximaccountadmin.headerblockentervalue', 'veximaccountadmin.headerwhitedelete', 'veximaccountadmin.headerwhitedeleteall', 'veximaccountadmin.headerwhiteexists', 'veximaccountadmin.headerwhiteentervalue' );
		
		$rcmail->output->set_env ( 'product_name', $rcmail->config->get ( 'product_name' ) );
		
		$settings = $this->_get_configuration ();
		
		$on_avscan = $settings ['on_avscan'];
		$on_spamassassin = $settings ['on_spamassassin'];
		$sa_tag = $settings ['sa_tag'];
		$sa_refuse = $settings ['sa_refuse'];
		$spam_drop = $settings ['spam_drop'];
		$on_vacation = $settings ['on_vacation'];
		$vacation = $settings ['vacation'];
		$on_forward = $settings ['on_forward'];
		$forward = $settings ['forward'];
		$unseen = $settings ['unseen'];
		$maxmsgsize = $settings ['maxmsgsize'];
		$user_id = $settings ['user_id'];
		$domain_id = $settings ['domain_id'];
		
		if ($this->config ['testing'] == true) {
			if (! $user_id)
				$user_id = 1;
			if (! $domain_id)
				$domain_id = 1;
		}
		
		$domain_settings = $this->_get_domain_configuration ( $domain_id );
		
		$default_sa_tag = $domain_settings ['sa_tag'];
		$default_sa_refuse = $domain_settings ['sa_refuse'];
		$default_maxmsgsize = $domain_settings ['maxmsgsize'];
		$active_domain = $domain_settings ['domain'];
		
		$out .= '<p class="introtext">' . $this->gettext ( 'introtext' ) . '</p>' . "\n";
		
		if ($this->config ['show_admin_link'] == true and $settings ['admin'] == true) {
			$out .= '<p class="adminlink">';
			$out .= sprintf ( $this->gettext ( 'adminlinktext' ), '<a href="' . $this->config ['vexim_url'] . '" target="_blank">', '</a>' );
			$out .= "</p>\n";
		}
		
		// =====================================================================================================
		// Password
		$out .= '<fieldset><legend>' . $this->gettext ( 'password' ) . '</legend>' . "\n";
		$out .= '<div class="fieldset-content">';
		$out .= '<p>' . $this->gettext ( 'passwordcurrentexplanation' ) . '</p>';
		$out .= '<table class="vexim-settings" cellpadding="0" cellspacing="0">';
		
		$field_id = 'curpasswd';
		$input_passwordcurrent = new html_passwordfield ( array (
				'name' => '_curpasswd',
				'id' => $field_id,
				'class' => 'text-long',
				'autocomplete' => 'off' 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'passwordcurrent' ) ), $input_passwordcurrent->show (), '' );
		
		$field_id = 'newpasswd';
		$input_passwordnew = new html_passwordfield ( array (
				'name' => '_newpasswd',
				'id' => $field_id,
				'class' => 'text-long',
				'autocomplete' => 'off' 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'passwordnew' ) ), $input_passwordnew->show (), '' );
		
		$field_id = 'confpasswd';
		$input_passwordconf = new html_passwordfield ( array (
				'name' => '_confpasswd',
				'id' => $field_id,
				'class' => 'text-long',
				'autocomplete' => 'off' 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'passwordconfirm' ) ), $input_passwordconf->show (), '' );
		
		$out .= '</table>';
		
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Spam/Virus
		$out .= '<fieldset><legend>' . $this->gettext ( 'spamvirus' ) . '</legend>' . "\n";
		$out .= '<div class="fieldset-content">';
		$out .= '<table class="vexim-settings" cellpadding="0" cellspacing="0">';
		
		$field_id = 'on_avscan';
		$input_virusenabled = new html_checkbox ( array (
				'name' => 'on_avscan',
				'id' => $field_id,
				'value' => 1 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'virusenabled' ) ), $input_virusenabled->show ( $on_avscan ? 1 : 0 ), '<br /><span class="vexim-explanation">' . $this->gettext ( 'virusenabledexplanation' ) . '</span>' );
		
		$field_id = 'on_spamassassin';
		$input_spamenabled = new html_checkbox ( array (
				'name' => 'on_spamassassin',
				'id' => $field_id,
				'value' => 1 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'spamenabled' ) ), $input_spamenabled->show ( $on_spamassassin ? 1 : 0 ), '<br /><span class="vexim-explanation">' . $this->gettext ( 'spamenabledexplanation' ) . '</span>' );
		
		$field_id = 'sa_tag';
		$input_spamscoretag = new html_select ( array (
				'name' => 'sa_tag',
				'id' => $field_id,
				'class' => 'select' 
		) );
		
		$decPlaces = 0;
		$found_number = false;
		for($i = 1; $i <= 20; $i = $i + 1) {
			$i = number_format ( $i, $decPlaces );
			$input_spamscoretag->add ( $i, $i );
			if ($sa_tag == $i)
				$found_number = true;
		}
		for($i = 25; $i <= 100; $i = $i + 5) {
			$i = number_format ( $i, $decPlaces );
			$input_spamscoretag->add ( $i, $i );
			if ($sa_tag == $i)
				$found_number = true;
		}
		
		// If the value from database cannot be choosed among the list we present,
		// add it to the end of the list. This may happen because Vexim lets the
		// user write in a number in a textbox.
		if (! $found_number)
			$input_spamscoretag->add ( $sa_tag, $sa_tag );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'spamscoretag' ) ), $input_spamscoretag->show ( $sa_tag ), '<br /><span class="vexim-explanation">' . $this->gettext ( 'spamscoretagexplanation' ) . '. <span class="sameline">' . $this->gettext ( 'domaindefault' ) . ': ' . $default_sa_tag . '.</span></span>' );
		
		$field_id = 'sa_refuse';
		$input_spamscorerefuse = new html_select ( array (
				'name' => 'sa_refuse',
				'id' => $field_id,
				'class' => 'select' 
		) );
		
		$found_number = false;
		for($i = 1; $i <= 20; $i = $i + 1) {
			$i = number_format ( $i, $decPlaces );
			$input_spamscorerefuse->add ( $i, $i );
			if ($sa_refuse == $i)
				$found_number = true;
		}
		for($i = 25; $i <= 200; $i = $i + 5) {
			$i = number_format ( $i, $decPlaces );
			$input_spamscorerefuse->add ( $i, $i );
			if ($sa_refuse == $i)
				$found_number = true;
		}
		for($i = 300; $i <= 900; $i = $i + 100) {
			$i = number_format ( $i, $decPlaces );
			$input_spamscorerefuse->add ( $i, $i );
			if ($sa_refuse == $i)
				$found_number = true;
		}
		$i = number_format ( 999, $decPlaces );
		$input_spamscorerefuse->add ( $i, $i );
		if ($sa_refuse == $i)
			$found_number = true;
		
		// If the value from database cannot be choosed among the list we present,
		// add it to the end of the list. This may happen because Vexim lets the
		// user write in a number in a textbox.
		if (! $found_number)
			$input_spamscorerefuse->add ( $sa_refuse, $sa_refuse );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'spamscorerefuse' ) ), $input_spamscorerefuse->show ( $sa_refuse ), '<br /><span class="vexim-explanation">' . $this->gettext ( 'spamscorerefuseexplanation' ) . '. <span class="sameline">' . $this->gettext ( 'domaindefault' ) . ': ' . $default_sa_refuse . '.</span></span>' );
		
		$field_id = 'spam_drop';
		$input_spamdrop = new html_select ( array (
				'name' => 'spam_drop',
				'id' => $field_id,
				'class' => 'select' 
		) );
		$input_spamdrop->add ( $this->gettext ( 'spamdropmove' ), 0 );
		$input_spamdrop->add ( $this->gettext ( 'spamdropdrop' ), 1 );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'spamdrop' ) ), $input_spamdrop->show ( $spam_drop ? 1 : 0 ), '<br /><span class="vexim-explanation">' . str_replace ( "%italicstart", "<i>", str_replace ( "%italicend", "</i>", $this->gettext ( 'spamdropexplanation' ) ) ) );
		
		$out .= '</table>';
		
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Autoresponder
		$out .= '<fieldset><legend>' . $this->gettext ( 'autoresponder' ) . '</legend>' . "\n";
		$out .= '<div class="fieldset-content">';
		$out .= '<table class="vexim-settings" cellpadding="0" cellspacing="0">';
		
		$field_id = 'on_vacation';
		$input_autoresponderenabled = new html_checkbox ( array (
				'name' => 'on_vacation',
				'id' => $field_id,
				'value' => 1 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'autoresponderenabled' ) ), $input_autoresponderenabled->show ( $on_vacation ? 1 : 0 ), '' );
		
		$field_id = 'vacation';
		$input_autorespondermessage = new html_textarea ( array (
				'name' => 'vacation',
				'id' => $field_id,
				'class' => 'textarea' 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'autorespondermessage' ) ), $input_autorespondermessage->show ( $vacation ), '<br /><span class="vexim-explanation">' . $this->gettext ( 'autorespondermessageexplanation' ) . '</span>' );
		
		$out .= '</table>';
		
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Forward
		$out .= '<fieldset><legend>' . $this->gettext ( 'forwarding' ) . '</legend>' . "\n";
		$out .= '<div class="fieldset-content">';
		$out .= '<table class="vexim-settings" cellpadding="0" cellspacing="0">';
		
		$field_id = 'on_forward';
		$input_forwardingenabled = new html_checkbox ( array (
				'name' => 'on_forward',
				'id' => $field_id,
				'value' => 1 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'forwardingenabled' ) ), $input_forwardingenabled->show ( $on_forward ? 1 : 0 ) );
		
		$field_id = 'forward';
		$input_forwardingaddress = new html_inputfield ( array (
				'name' => 'forward',
				'id' => $field_id,
				'maxlength' => 4096,
				'class' => 'text-long' 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'forwardingaddress' ) ), $input_forwardingaddress->show ( $forward ) );
		
		$field_id = 'unseen';
		$input_forwardinglocal = new html_checkbox ( array (
				'name' => 'unseen',
				'id' => $field_id,
				'value' => 1 
		) );
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'forwardinglocal' ) ), $input_forwardinglocal->show ( $unseen ? 1 : 0 ) );
		
		$out .= '</table>';
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Header blocks (based on code from Philip Weir's sauserprefs plugin
		// http://roundcube.net/plugins/sauserprefs)
		
		$out .= '<fieldset><legend>' . $this->gettext ( 'blockbyheader' ) . '</legend>' . "\n";
		
		$out .= '<div class="fieldset-content">';
		$out .= '<p>' . $this->gettext ( 'blockbyheaderexplanation' ) . '</p>';
		
		$table = new html_table ( array (
				'class' => 'headerblockprefstable',
				'cols' => 3 
		) );
		$field_id = 'rcmfd_headerblockrule';
		$input_headerblockrule = new html_select ( array (
				'name' => '_headerblockrule',
				'id' => $field_id 
		) );
		$input_headerblockrule->add ( $this->gettext ( 'headerfrom' ), 'From' );
		$input_headerblockrule->add ( $this->gettext ( 'headerto' ), 'To' );
		$input_headerblockrule->add ( $this->gettext ( 'headersubject' ), 'Subject' );
		$input_headerblockrule->add ( $this->gettext ( 'headerxmailer' ), 'X-Mailer' );
		
		$field_id = 'rcmfd_headerblockvalue';
		$input_headerblockvalue = new html_inputfield ( array (
				'name' => '_headerblockvalue',
				'id' => $field_id,
				'style' => 'width:270px;' 
		) );
		
		$field_id = 'rcmbtn_add_address';
		$button_addaddress = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.headerblock_add',
				'type' => 'input',
				'class' => 'button',
				'label' => 'veximaccountadmin.addrule',
				'style' => 'width: 130px;' 
		) );
		
		$table->add ( null, $input_headerblockrule->show () );
		$table->add ( null, $input_headerblockvalue->show () );
		$table->add ( array (
				'align' => 'right' 
		), $button_addaddress );
		
		$delete_all = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.headerblock_delete_all',
				'type' => 'link',
				'label' => 'veximaccountadmin.deleteall' 
		) );
		
		$table->add ( array (
				'colspan' => 3,
				'id' => 'listcontrols' 
		), $delete_all );
		$table->add_row ();
		
		$address_table = new html_table ( array (
				'id' => 'headerblock-rules-table',
				'class' => 'records-table',
				'cellspacing' => '0',
				'cols' => 3 
		) );
		$address_table->add_header ( array (
				'width' => '120px' 
		), $this->gettext ( 'field' ) );
		$address_table->add_header ( null, $this->gettext ( 'value' ) );
		$address_table->add_header ( array (
				'width' => '40px' 
		), '&nbsp;' );
		
		// 1st element in address table is a template that can be cloned
		$this->_address_row ( $address_table, null, null );
		
		// Get the header rules from DB. Should probably be put in a function.
		$this->_load_config ();
		$this->_db_connect ( 'r' );
		
		$sql_result = $this->db->query ( "SELECT blockhdr, blockval
				FROM   blocklists
				WHERE  user_id = '$user_id'
				AND    domain_id = '$domain_id'
				ORDER BY block_id;" );
		
		if ($sql_result && $this->db->num_rows ( $sql_result ) > 0)
			$norules = 'display: none;';
		
		$address_table->set_row_attribs ( array (
				'style' => $norules 
		) );
		$address_table->add ( array (
				'colspan' => '3' 
		), rcube_utils::rep_specialchars_output ( $this->gettext ( 'noaddressrules' ) ) );
		
		while ( $sql_result && $sql_arr = $this->db->fetch_assoc ( $sql_result ) ) {
			$field = $sql_arr ['blockhdr'];
			$value = $sql_arr ['blockval'];
			
			$this->_address_row ( $address_table, $field, $value );
		}
		
		$table->add ( array (
				'colspan' => 3 
		), html::div ( array (
				'id' => 'headerblock-rules-cont' 
		), $address_table->show () ) );
		$table->add_row ();
		
		if ($table->size ())
			$out .= $table->show ();
		
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Header passes
		
		$out .= '<fieldset><legend>' . $this->gettext ( 'whitebyheader' ) . '</legend>' . "\n";
		
		$out .= '<div class="fieldset-content">';
		$out .= '<p>' . $this->gettext ( 'whitebyheaderexplanation' ) . '</p>';
		
		$table = new html_table ( array (
				'class' => 'headerwhiteprefstable',
				'cols' => 3 
		) );
		$field_id = 'rcmfd_headerwhiterule';
		$input_headerwhiterule = new html_select ( array (
				'name' => '_headerwhiterule',
				'id' => $field_id 
		) );
		$input_headerwhiterule->add ( $this->gettext ( 'headerfrom' ), 'From' );
		$input_headerwhiterule->add ( $this->gettext ( 'headerto' ), 'To' );
		$input_headerwhiterule->add ( $this->gettext ( 'headersubject' ), 'Subject' );
		$input_headerwhiterule->add ( $this->gettext ( 'headerxmailer' ), 'X-Mailer' );
		
		$field_id = 'rcmfd_headerwhitevalue';
		$input_headerwhitevalue = new html_inputfield ( array (
				'name' => '_headerwhitevalue',
				'id' => $field_id,
				'style' => 'width:270px;' 
		) );
		
		$field_id = 'rcmbtnwhite_add_address';
		$button_addaddress = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.headerwhite_add',
				'type' => 'input',
				'class' => 'button',
				'label' => 'veximaccountadmin.addwhiterule',
				'style' => 'width: 130px;' 
		) );
		
		$table->add ( null, $input_headerwhiterule->show () );
		$table->add ( null, $input_headerwhitevalue->show () );
		$table->add ( array (
				'align' => 'right' 
		), $button_addaddress );
		
		$delete_all = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.headerwhite_delete_all',
				'type' => 'link',
				'label' => 'veximaccountadmin.deleteall' 
		) );
		
		$table->add ( array (
				'colspan' => 3,
				'id' => 'listcontrols' 
		), $delete_all );
		$table->add_row ();
		
		$address_table = new html_table ( array (
				'id' => 'headerwhite-rules-table',
				'class' => 'records-table',
				'cellspacing' => '0',
				'cols' => 3 
		) );
		$address_table->add_header ( array (
				'width' => '120px' 
		), $this->gettext ( 'field' ) );
		$address_table->add_header ( null, $this->gettext ( 'value' ) );
		$address_table->add_header ( array (
				'width' => '40px' 
		), '&nbsp;' );
		
		// 1st element in address table is a template that can be cloned
		$this->_whiteaddress_row ( $address_table, null, null );
		
		// Get the header rules from DB. Should probably be put in a function.
		// $this->_load_config ();
		// $this->_db_connect ( 'r' );
		
		$sql_result = $this->db->query ( "SELECT whitehdr, whiteval
						FROM   whitelists
						WHERE  user_id = '$user_id'
						AND    domain_id = '$domain_id'
						ORDER BY white_id;" );
		
		if ($sql_result && $this->db->num_rows ( $sql_result ) > 0)
			$norules = 'display: none;';
		else
			$norules = '';
		
		$address_table->set_row_attribs ( array (
				'style' => $norules 
		) );
		$address_table->add ( array (
				'colspan' => '3' 
		), rcube_utils::rep_specialchars_output ( $this->gettext ( 'nowhiteaddressrules' ) ) );
		
		while ( $sql_result && $sql_arr = $this->db->fetch_assoc ( $sql_result ) ) {
			$field = $sql_arr ['whitehdr'];
			$value = $sql_arr ['whiteval'];
			
			$this->_whiteaddress_row ( $address_table, $field, $value );
		}
		
		$table->add ( array (
				'colspan' => 3 
		), html::div ( array (
				'id' => 'headerwhite-rules-cont' 
		), $address_table->show () ) );
		$table->add_row ();
		
		if ($table->size ())
			$out .= $table->show ();
		
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		// Parameters
		$out .= '<fieldset><legend>' . $this->gettext ( 'parameters' ) . '</legend>' . "\n";
		
		$out .= '<div class="fieldset-content">';
		$out .= '<table class="vexim-settings" cellpadding="0" cellspacing="0">';
		
		$field_id = 'maxmsgsize';
		$input_messagesize = new html_inputfield ( array (
				'name' => 'maxmsgsize',
				'id' => $field_id,
				'maxlength' => 8,
				'size' => 6 
		) );
		if ($default_maxmsgsize == 0)
			$default_maxmsgsize = $this->gettext ( 'unlimited' );
		else
			$default_maxmsgsize = $default_maxmsgsize . ' kb';
		
		$out .= sprintf ( "<tr><th><label for=\"%s\">%s</label>:</th><td>%s%s</td></tr>\n", $field_id, rcube_utils::rep_specialchars_output ( $this->gettext ( 'messagesize' ) ), $input_messagesize->show ( $maxmsgsize ), '<br /><span class="vexim-explanation">' . str_replace ( '%d', $active_domain, str_replace ( '%m', $default_maxmsgsize, $this->gettext ( 'messagesizeexplanation' ) ) ) . '</span>' );
		
		$out .= '</table>';
		$out .= '</div></fieldset>' . "\n\n";
		
		// =====================================================================================================
		
		$out .= html::p ( null, $rcmail->output->button ( array (
				'command' => 'plugin.veximaccountadmin-save',
				'type' => 'input',
				'class' => 'button mainaction',
				'label' => 'save' 
		) ) );
		
		$rcmail->output->add_gui_object ( 'veximform', 'veximaccountadminform' );
		
		$out = $rcmail->output->form_tag ( array (
				'id' => 'veximaccountadminform',
				'name' => 'veximaccountadminform',
				'method' => 'post',
				'action' => './?_task=settings&_action=plugin.veximaccountadmin-save' 
		), $out );
		
		$out = html::div ( array (
				'class' => 'settingsbox',
				'style' => 'margin:0 0 15px 0;' 
		), html::div ( array (
				'class' => 'boxtitle' 
		), $this->gettext ( 'accountadministration' ) ) . html::div ( array (
				'style' => 'padding:15px' 
		), $outtop . "\n" . $out . "\n" . $outbottom ) );
		
		return $out;
	}
	private function _get_configuration() {
		$this->_load_config ();
		$rcmail = rcmail::get_instance ();
		$this->_db_connect ( 'r' );
		
		$sql = 'SELECT * FROM `users` WHERE `username` = ' . $this->db->quote ( $rcmail->user->data ['username'], 'text' ) . ' ;';
		$res = $this->db->query ( $sql );
		
		if ($err = $this->db->is_error ()) {
			return $err;
		}
		$ret = $this->db->fetch_assoc ( $res );
		
		$ret ['vacation'] = quoted_printable_decode ( $ret ['vacation'] );
		
		return $ret;
	}
	private function _get_domain_configuration($domain_id) {
		$this->_load_config ();
		$rcmail = rcmail::get_instance ();
		$this->_db_connect ( 'r' );
		
		$sql = 'SELECT * FROM `domains` WHERE `domain_id` = ' . $this->db->quote ( $domain_id ) . ' ;';
		$res = $this->db->query ( $sql );
		
		if ($err = $this->db->is_error ()) {
			return $err;
		}
		$ret = $this->db->fetch_assoc ( $res );
		
		return $ret;
	}
	private function _save($user, $on_avscan, $on_spamassassin, $sa_tag, $sa_refuse, $spam_drop, $on_vacation, $vacation, $on_forward, $forward, $unseen, $maxmsgsize, $acts, $prefs, $vals, $actswhite, $prefswhite, $valswhite) {
		$rcmail = rcmail::get_instance ();
		
		$this->_load_config ();
		$this->_db_connect ( 'w' );
		$settings = $this->_get_configuration ();
		$user_id = $settings ['user_id'];
		$domain_id = $settings ['domain_id'];
		
		if ($this->config ['testing'] == true) {
			if (! $user_id)
				$user_id = 1;
			if (! $domain_id)
				$domain_id = 1;
		}
		
		$vacation = quoted_printable_encode ( $vacation );
		
		foreach ( $acts as $idx => $act ) {
			if ($act == "DELETE") {
				$result = false;
				
				$this->db->query ( "DELETE FROM blocklists
						WHERE  user_id = '$user_id'
						AND    domain_id = '$domain_id'
						AND    blockhdr = '" . $prefs [$idx] . "'
					   AND    blockval = '" . $vals [$idx] . "';" );
				$result = $this->db->affected_rows ();
				
				if (! $result)
					break;
			} elseif ($act == "INSERT") {
				$result = false;
				
				$this->db->query ( "INSERT INTO blocklists
					   (user_id, domain_id, blockhdr,blockval,color)
					   VALUES ('" . $user_id . "', '" . $domain_id . "', '" . $prefs [$idx] . "', '" . $vals [$idx] . "', 'black')" );
				
				$result = $this->db->affected_rows ();
				
				if (! $result)
					break;
			}
		}
		
		foreach ( $actswhite as $idx => $act ) {
			if ($act == "DELETE") {
				$result = false;
				
				$this->db->query ( "DELETE FROM whitelists
						WHERE  user_id = '$user_id'
						AND    domain_id = '$domain_id'
						AND    whitehdr = '" . $prefswhite [$idx] . "'
					   AND    whiteval = '" . $valswhite [$idx] . "';" );
				$result = $this->db->affected_rows ();
				
				if (! $result)
					break;
			} elseif ($act == "INSERT") {
				$result = false;
				
				$this->db->query ( "INSERT INTO whitelists
					   (user_id, domain_id, whitehdr,whiteval,color)
					   VALUES ('" . $user_id . "', '" . $domain_id . "', '" . $prefswhite [$idx] . "', '" . $valswhite [$idx] . "', 'black')" );
				
				$result = $this->db->affected_rows ();
				
				if (! $result)
					break;
			}
		}
		
		$sql = 'UPDATE `users` SET `on_avscan` = ' . $this->db->quote ( $on_avscan, 'text' ) . ', `on_spamassassin` = ' . $this->db->quote ( $on_spamassassin, 'text' ) . ', `sa_tag` = ' . $this->db->quote ( $sa_tag, 'text' ) . ', `sa_refuse` = ' . $this->db->quote ( $sa_refuse, 'text' ) . ', `on_vacation` = ' . $this->db->quote ( $on_vacation, 'text' ) . ', `vacation` = ' . $this->db->quote ( $vacation, 'text' ) . ', `on_forward` = ' . $this->db->quote ( $on_forward, 'text' ) . ', `forward` = ' . $this->db->quote ( $forward, 'text' ) . ', `unseen` = ' . $this->db->quote ( $unseen, 'text' ) . ', `maxmsgsize` = ' . $this->db->quote ( $maxmsgsize, 'text' ) . ', `spam_drop` = ' . $this->db->quote ( $spam_drop, 'text' ) . ' WHERE `username` = ' . $this->db->quote ( $user, 'text' ) . ' ;';
		
		$config_error = 0;
		$res = $this->db->query ( $sql );
		if ($err = $this->db->is_error ()) {
			$config_error = 1;
		}
		$res = $this->db->affected_rows ( $res );
		
		$curpwd = rcube_utils::get_input_value ( '_curpasswd', rcube_utils::INPUT_POST );
		$newpwd = rcube_utils::get_input_value ( '_newpasswd', rcube_utils::INPUT_POST );
		
		if ($curpwd != '' and $newpwd != '') {
			
			$trytochangepass = 1;
			$password_change_error = 0;
			
			if ($rcmail->decrypt ( $_SESSION ['password'] ) != $curpwd) {
				// Current password was not correct.
				// Note that we check against the password saved in RoundCube.
				// Alternatively we can to a:
				// if (_crypt_password($curpwd, $settings['domain_id'])
				$password_change_error = 1;
				$addtomessage .= '. ' . $this->gettext ( 'saveerror-pass-mismatch' );
			} else {
				
				$crypted_password = $this->_crypt_password ( $newpwd );
				$sql_pass = "UPDATE users SET crypt=" . $this->db->quote ( $crypted_password ) . " WHERE username=" . $this->db->quote ( $user, 'text' ) . ' ;';
				
				$res_pass = $this->db->query ( $sql_pass );
				if ($err = $this->db->is_error ()) {
					$password_change_error = 2;
					$addtomessage .= '.' . $this->gettext ( 'saveerror-pass-database' );
				} else {
					
					$res_pass = $this->db->affected_rows ( $res_pass );
					if ($res_pass == 0) {
						$password_change_error = 3;
						$addtomessage .= '. ' . $this->gettext ( 'saveerror-pass-norows' );
					} elseif ($res_pass == 1) {
						$password_change_success = 1;
						$_SESSION ['password'] = $rcmail->encrypt ( $newpwd );
					}
				}
			}
		}
		
		// This error handling is a bit messy, should be improved!
		
		// We may altso want to check for $res and $res_pass to see if changes were done or not
		
		if ($config_error == 1) {
			// Mysql error on config update. Also print any errors from password.
			return $this->gettext ( 'saveerror-config-database' ) . $addtomessage;
		}
		if ($config_error == 0 and $trytochangepass == 1 and $password_change_error == 1) {
			// Config updated, but error in password saving due to mismatch
			return $this->gettext ( 'savesuccess-config-saveerror-pass-mismatch' );
		}
		if ($config_error == 0 and $trytochangepass == 1 and $password_change_error) {
			// Config updated, but other error in password saving
			return $this->gettext ( 'savesuccess-config' ) . $addtomessage;
		}
		
		if ($config_error == 0) {
			// Best case, no trouble reported
			return false;
		}
		
		// If still here - send all error messages.
		return $this->gettext ( 'saveerror-internalerror' ) . $addtomessage;
	}
	private function _address_row($address_table, $field, $value) {
		if (! isset ( $field ))
			$address_table->set_row_attribs ( array (
					'style' => 'display: none;' 
			) );
		
		$hidden_action = new html_hiddenfield ( array (
				'name' => '_headerblock_rule_act[]',
				'value' => '' 
		) );
		$hidden_field = new html_hiddenfield ( array (
				'name' => '_headerblock_rule_field[]',
				'value' => $field 
		) );
		$hidden_text = new html_hiddenfield ( array (
				'name' => '_headerblock_rule_value[]',
				'value' => $value 
		) );
		
		switch ($field) {
			case "From" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerfrom' ) );
				break;
			case "To" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerto' ) );
				break;
			case "Subject" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headersubject' ) );
				break;
			case "X-Mailer" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerxmailer' ) );
				break;
		}
		
		$address_table->add ( 'field', $fieldtxt );
		$address_table->add ( 'email', $value );
		$del_button = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.addressrule_del',
				'type' => 'image',
				'image' => 'plugins/veximaccountadmin/delete.png',
				'alt' => 'delete',
				'title' => 'delete' 
		) );
		$address_table->add ( 'control', '&nbsp;' . $del_button . $hidden_action->show () . $hidden_field->show () . $hidden_text->show () );
		
		return $address_table;
	}
	private function _whiteaddress_row($address_table, $field, $value) {
		if (! isset ( $field ))
			$address_table->set_row_attribs ( array (
					'style' => 'display: none;' 
			) );
		
		$hidden_action = new html_hiddenfield ( array (
				'name' => '_headerwhite_rule_act[]',
				'value' => '' 
		) );
		$hidden_field = new html_hiddenfield ( array (
				'name' => '_headerwhite_rule_field[]',
				'value' => $field 
		) );
		$hidden_text = new html_hiddenfield ( array (
				'name' => '_headerwhite_rule_value[]',
				'value' => $value 
		) );
		
		switch ($field) {
			case "From" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerfrom' ) );
				break;
			case "To" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerto' ) );
				break;
			case "Subject" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headersubject' ) );
				break;
			case "X-Mailer" :
				$fieldtxt = rcube_utils::rep_specialchars_output ( $this->gettext ( 'headerxmailer' ) );
				break;
		}
		
		$address_table->add ( array (
				'class' => 'field' 
		), $fieldtxt );
		$address_table->add ( array (
				'class' => 'email' 
		), $value );
		$del_button = $this->api->output->button ( array (
				'command' => 'plugin.veximaccountadmin.whiteaddressrule_del',
				'type' => 'image',
				'image' => 'plugins/veximaccountadmin/delete.png',
				'alt' => 'delete',
				'title' => 'delete' 
		) );
		$address_table->add ( 'control', '&nbsp;' . $del_button . $hidden_action->show () . $hidden_field->show () . $hidden_text->show () );
		
		return $address_table;
	}
	
	/* crypt the plaintext password -- from Vexim */
	private function _crypt_password($clear, $salt = '') {
		// global $cryptscheme;
		$settings = $this->_get_configuration ();
		$cryptscheme = $this->config ['vexim_cryptscheme'];
		
		if ($cryptscheme === 'sha') {
			$hash = sha1 ( $clear );
			$cryptedpass = '{SHA}' . base64_encode ( pack ( 'H*', $hash ) );
		} elseif ($cryptscheme === 'clear') {
			$cryptedpass = $clear;
		} else {
			if (empty ( $salt )) {
				switch ($cryptscheme) {
					case 'des' :
						$salt = '';
						break;
					case 'md5' :
						$salt = '$1$';
						break;
					case 'sha512' :
						$salt = '$6$';
						break;
					case 'bcrypt' :
						$salt = '$2a$10$';
						break;
					default :
						if (preg_match ( '/\$[:digit:][:alnum:]?\$/', $cryptscheme )) {
							$salt = $cryptscheme;
						} else {
							die ( _ ( 'The value of $cryptscheme is invalid!' ) );
						}
				}
				$salt .= $this->_get_random_bytes ( CRYPT_SALT_LENGTH ) . '$';
			}
			$cryptedpass = crypt ( $clear, $salt );
		}
		return $cryptedpass;
	}
	
	/* Generate pseudo random bytes -- from Vexim */
	private function _get_random_bytes($count) {
		$output = base64_encode ( openssl_random_pseudo_bytes ( $count ) );
		$output = strtr ( substr ( $output, 0, $count ), '+', '.' ); // base64 is longer, so must truncate the result
		return $output;
	}
}

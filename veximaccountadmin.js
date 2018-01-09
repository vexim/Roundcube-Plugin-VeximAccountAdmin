/* Vexim interface (tab) */

if (window.rcmail) {
	rcmail
			.addEventListener(
					'init',
					function(evt) {
						// <span id="settingstabdefault"
						// class="tablink"><roundcube:button
						// command="preferences" type="link" label="preferences"
						// title="editpreferences" /></span>
						var tab = $('<span>').attr('id',
								'settingstabpluginveximaccountadmin').addClass(
								'tablink tablinkveximaccountadmin');

						var button = $('<a>').attr(
								'href',
								rcmail.env.comm_path
										+ '&_action=plugin.veximaccountadmin')
								.html(
										rcmail.gettext('accountadmin',
												'veximaccountadmin')).appendTo(
										tab);
						button.bind('click', function(e) {
							return rcmail.command('plugin.veximaccountadmin',
									this)
						});

						// add button and register commands
						rcmail.add_element(tab, 'tabs');
						rcmail.register_command('plugin.veximaccountadmin',
								function() {
									rcmail.goto_url('plugin.veximaccountadmin')
								}, true);
						rcmail
								.register_command(
										'plugin.veximaccountadmin-save',
										function() {
											var input_curpasswd = rcube_find_object('_curpasswd');
											var input_newpasswd = rcube_find_object('_newpasswd');
											var input_confpasswd = rcube_find_object('_confpasswd');
											var input_vacation = rcube_find_object('vacation');

											if (input_curpasswd
													&& input_curpasswd.value == ''
													&& input_newpasswd.value != '') {
												alert(rcmail.gettext(
														'enterallpassfields',
														'veximaccountadmin'));
												input_curpasswd.focus();
											} else if (input_curpasswd
													&& input_curpasswd.value == ''
													&& input_confpasswd.value != '') {
												alert(rcmail.gettext(
														'enterallpassfields',
														'veximaccountadmin'));
												input_curpasswd.focus();
											} else if (input_curpasswd
													&& input_curpasswd.value != ''
													&& input_newpasswd.value == '') {
												alert(rcmail.gettext(
														'enterallpassfields',
														'veximaccountadmin'));
												input_newpasswd.focus();
											} else if (input_curpasswd
													&& input_curpasswd.value != ''
													&& input_confpasswd.value == '') {
												alert(rcmail.gettext(
														'enterallpassfields',
														'veximaccountadmin'));
												input_confpasswd.focus();
											} else if (input_newpasswd.value != input_confpasswd.value
													&& input_newpasswd.value != ''
													&& input_confpasswd.value != '') {
												alert(rcmail
														.gettext(
																'passwordinconsistency',
																'veximaccountadmin'));
												input_newpasswd.focus();
											} else {
												rcmail.gui_objects.veximform
														.submit();
											}

										}, true);

						// =====================================================================================================
						// Header blocks (based on code from Philip Weir's
						// sauserprefs plugin
						// http://roundcube.net/plugins/sauserprefs)

						rcmail
								.register_command(
										'plugin.veximaccountadmin.addressrule_del',
										function(props, obj) {
											var adrTable = rcube_find_object('headerblock-rules-table').tBodies[0];
											var rowidx = obj.parentNode.parentNode.rowIndex - 1;
											var fieldidx = rowidx - 1;

											if (!confirm(rcmail.gettext(
													'headerblockdelete',
													'veximaccountadmin')))
												return false;

											if (document
													.getElementsByName('_headerblock_rule_act[]')[fieldidx].value == "INSERT") {
												adrTable.deleteRow(rowidx);
											} else {
												adrTable.rows[rowidx].style.display = 'none';
												document
														.getElementsByName('_headerblock_rule_act[]')[fieldidx].value = "DELETE";
											}

											rcmail.env.address_rule_count--;
											if (rcmail.env.address_rule_count < 1)
												adrTable.rows[1].style.display = '';

											return false;
										}, true);

						rcmail
								.register_command(
										'plugin.veximaccountadmin.headerblock_add',
										function() {
											var adrTable = rcube_find_object('headerblock-rules-table').tBodies[0];
											var input_headerblockrule = rcube_find_object('_headerblockrule');
											var selrule = input_headerblockrule.selectedIndex;
											var input_headerblockvalue = rcube_find_object('_headerblockvalue');

											if (input_headerblockvalue.value
													.replace(/^\s+|\s+$/g, '') == '') {
												alert(rcmail
														.gettext(
																'headerblockentervalue',
																'veximaccountadmin'));
												input_headerblockvalue.focus();
												return false;
											} else {
												var actions = document
														.getElementsByName('_headerblock_rule_act[]');
												var prefs = document
														.getElementsByName('_headerblock_rule_field[]');
												var addresses = document
														.getElementsByName('_headerblock_rule_value[]');
												var insHere;

												for (var i = 1; i < addresses.length; i++) {
													if (prefs[i].value == input_headerblockrule.options[selrule].value
															&& addresses[i].value == input_headerblockvalue.value
															&& actions[i].value != "DELETE") {
														alert(rcmail
																.gettext(
																		'headerblockexists',
																		'veximaccountadmin'));
														input_headerblockvalue
																.focus();
														return false;
													} else if (addresses[i].value > input_headerblockvalue.value) {
														insHere = adrTable.rows[i + 1];
														break;
													}
												}

												var newNode = adrTable.rows[0]
														.cloneNode(true);
												adrTable.rows[1].style.display = 'none';

												if (insHere)
													adrTable.insertBefore(
															newNode, insHere);
												else
													adrTable
															.appendChild(newNode);

												newNode.style.display = "";
												newNode.cells[0].className = input_headerblockrule.options[selrule].value;
												newNode.cells[0].innerHTML = input_headerblockrule.options[selrule].text;
												newNode.cells[1].innerHTML = input_headerblockvalue.value;
												actions[newNode.rowIndex - 2].value = "INSERT";
												prefs[newNode.rowIndex - 2].value = input_headerblockrule.options[selrule].value;
												addresses[newNode.rowIndex - 2].value = input_headerblockvalue.value;

												input_headerblockrule.selectedIndex = 0;
												input_headerblockvalue.value = '';

												rcmail.env.address_rule_count++;
											}
										}, true);

						rcmail
								.register_command(
										'plugin.veximaccountadmin.headerblock_delete_all',
										function(props, obj) {
											var adrTable = rcube_find_object('headerblock-rules-table').tBodies[0];

											if (!confirm(rcmail.gettext(
													'headerblockdeleteall',
													'veximaccountadmin')))
												return false;

											for (var i = adrTable.rows.length - 1; i > 1; i--) {
												if (document
														.getElementsByName('_headerblock_rule_act[]')[i - 1].value == "INSERT") {
													adrTable.deleteRow(i);
													rcmail.env.address_rule_count--;
												} else if (document
														.getElementsByName('_headerblock_rule_act[]')[i - 1].value != "DELETE") {
													adrTable.rows[i].style.display = 'none';
													document
															.getElementsByName('_headerblock_rule_act[]')[i - 1].value = "DELETE";
													rcmail.env.address_rule_count--;
												}
											}

											adrTable.rows[1].style.display = '';
											return false;
										}, true);

						rcmail
								.register_command(
										'plugin.veximaccountadmin.whiteaddressrule_del',
										function(props, obj) {
											var adrTable = rcube_find_object('headerwhite-rules-table').tBodies[0];
											var rowidx = obj.parentNode.parentNode.rowIndex - 1;
											var fieldidx = rowidx - 1;

											if (!confirm(rcmail.gettext(
													'headerwhitedelete',
													'veximaccountadmin')))
												return false;

											if (document
													.getElementsByName('_headerwhite_rule_act[]')[fieldidx].value == "INSERT") {
												adrTable.deleteRow(rowidx);
											} else {
												adrTable.rows[rowidx].style.display = 'none';
												document
														.getElementsByName('_headerwhite_rule_act[]')[fieldidx].value = "DELETE";
											}

											rcmail.env.address_rule_count--;
											if (rcmail.env.address_rule_count < 1)
												adrTable.rows[1].style.display = '';

											return false;
										}, true);

						rcmail
								.register_command(
										'plugin.veximaccountadmin.headerwhite_add',
										function() {
											var adrTable = rcube_find_object('headerwhite-rules-table').tBodies[0];
											var input_headerwhiterule = rcube_find_object('_headerwhiterule');
											var selrule = input_headerwhiterule.selectedIndex;
											var input_headerwhitevalue = rcube_find_object('_headerwhitevalue');

											if (input_headerwhitevalue.value
													.replace(/^\s+|\s+$/g, '') == '') {
												alert(rcmail
														.gettext(
																'headerwhiteentervalue',
																'veximaccountadmin'));
												input_headerwhitevalue.focus();
												return false;
											} else {
												var actions = document
														.getElementsByName('_headerwhite_rule_act[]');
												var prefs = document
														.getElementsByName('_headerwhite_rule_field[]');
												var addresses = document
														.getElementsByName('_headerwhite_rule_value[]');
												var insHere;

												for (var i = 1; i < addresses.length; i++) {
													if (prefs[i].value == input_headerwhiterule.options[selrule].value
															&& addresses[i].value == input_headerwhitevalue.value
															&& actions[i].value != "DELETE") {
														alert(rcmail
																.gettext(
																		'headerwhiteexists',
																		'veximaccountadmin'));
														input_headerwhitevalue
																.focus();
														return false;
													} else if (addresses[i].value > input_headerwhitevalue.value) {
														insHere = adrTable.rows[i + 1];
														break;
													}
												}

												var newNode = adrTable.rows[0]
														.cloneNode(true);
												adrTable.rows[1].style.display = 'none';

												if (insHere)
													adrTable.insertBefore(
															newNode, insHere);
												else
													adrTable
															.appendChild(newNode);

												newNode.style.display = "";
												newNode.cells[0].className = input_headerwhiterule.options[selrule].value;
												newNode.cells[0].innerHTML = input_headerwhiterule.options[selrule].text;
												newNode.cells[1].innerHTML = input_headerwhitevalue.value;
												actions[newNode.rowIndex - 2].value = "INSERT";
												prefs[newNode.rowIndex - 2].value = input_headerwhiterule.options[selrule].value;
												addresses[newNode.rowIndex - 2].value = input_headerwhitevalue.value;

												input_headerwhiterule.selectedIndex = 0;
												input_headerwhitevalue.value = '';

												rcmail.env.address_rule_count++;
											}
										}, true);

						rcmail
								.register_command(
										'plugin.veximaccountadmin.headerwhite_delete_all',
										function(props, obj) {
											var adrTable = rcube_find_object('headerwhite-rules-table').tBodies[0];

											if (!confirm(rcmail.gettext(
													'headerwhitedeleteall',
													'veximaccountadmin')))
												return false;

											for (var i = adrTable.rows.length - 1; i > 1; i--) {
												if (document
														.getElementsByName('_headerwhite_rule_act[]')[i - 1].value == "INSERT") {
													adrTable.deleteRow(i);
													rcmail.env.address_rule_count--;
												} else if (document
														.getElementsByName('_headerwhite_rule_act[]')[i - 1].value != "DELETE") {
													adrTable.rows[i].style.display = 'none';
													document
															.getElementsByName('_headerwhite_rule_act[]')[i - 1].value = "DELETE";
													rcmail.env.address_rule_count--;
												}
											}

											adrTable.rows[1].style.display = '';
											return false;
										}, true);

					})
}

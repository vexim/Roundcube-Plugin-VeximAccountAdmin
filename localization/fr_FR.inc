<?php

// French translation by Bertrand Cherrier

$labels = array();

$labels['accountadmin']  = 'Compte Mail';
$labels['veximaccountadmin']  = 'Administrateur du compte';
$labels['accountadministration']  = 'Administration du compte';

$labels['password']  = 'Mot de passe';
$labels['passwordcurrentexplanation']  = 'Laisser le champ vide pour conserver le mot de passe actuel.';
$labels['passwordcurrent']  = 'Mot de passe actuel';
$labels['passwordnew']  = 'Nouveau mot de passe';
$labels['passwordconfirm']  = 'Confirmer le nouveau mot de passe';

$labels['spamvirus']  = 'Filtrage Spam/Virus';
$labels['virusenabled']  = 'Activer le filtre anti-virus';
$labels['virusenabledexplanation']  = 'Supprimer tous les mails infectés';
$labels['spamenabled']  = 'Activer le filtre anti-spam';
$labels['spamenabledexplanation']  = 'Vérifier la présence de spams à l\'arrivée de nouveaux messages';
$labels['spamscoretag']  = 'Valeur de marquage du spam';
$labels['spamscoretagexplanation']  = 'Le message obtenant cette valeur sera marqué come spam potentiel mais délivré tout de même';
$labels['spamscorerefuse']  = 'Valeur de refus du spam';
$labels['spamscorerefuseexplanation']  = 'Le message obtenant cette valeur sera refusé et ne sera pas délivré';
$labels['domaindefault']  = 'Réglages par défaut';

// %italicstart et %italicend seront remplacés par <i> and </i>
$labels['spamdrop']  = 'Messages dépassant la valeur de refus du spam';
$labels['spamdropexplanation']  = 'Les messages au dessus de la valeur de refus du spam peuvent être automatiquement déplacés vers le dossier %italicstartIndésirables%italicend ou supprimer.';
$labels['spamdropmove'] = 'Déplacer';
$labels['spamdropdrop'] = 'Supprimer';

$labels['autoresponder']  = 'Répondeur Automatique';
$labels['autoresponderenabled']  = 'Activer le répondeur automatique';
$labels['autorespondermessage']  = 'Message du répondeur automatique';
$labels['autorespondermessageexplanation']  = 'Note: votre signature ne sera pas ajoutée automatiquement';

$labels['forwarding']  = 'Transferts';
$labels['forwardingenabled']  = 'Activer les transferts';
$labels['forwardingaddress']  = 'Transférer le message à';
$labels['forwardinglocal']  = 'Stocker localement le message transféré';

$labels['parameters']  = 'paramètres';
$labels['messagesize']  = 'Taille maximale du message (ko)';
$labels['messagesizeexplanation']  = 'Les messages dépassant cette taille (en kilo-octets) seront renvoyés à l\'expéditeur. Default: 0 (Utilise les réglages par défaut du domaine %d, qui sont %m).';
$labels['unlimited']  = 'Illimité';

$labels['blockbyheader']  = 'Bloquer par en-tête';
$labels['blockbyheaderexplanation']  = 'Les règles ci-dessous s\'appliqueront aux champs en-tête, les messages correspondant à ces critères seront automatiquement effacés. A noter que la correspondance doit être exacte, et non partielle.';
$labels['addrule']  = 'ajouter une règle de filtrage';
$labels['deleteall']  = 'Tout supprimer';
$labels['field']  = 'Champ En-Tête';
$labels['value']  = 'Valeur';
$labels['headerfrom']  = 'De';
$labels['headerto']  = 'A';
$labels['headersubject']  = 'Objet';
$labels['headerxmailer']  = 'X-Mailer';
$labels['noaddressrules']  = 'Pas de règle de filtrage';

$messages['headerblockdelete']  = 'Êtes-vous sûr de vouloir supprimer cette règle ?';
$messages['headerblockdeleteall']  = 'Êtes-vous sûr de vouloir supprimer toutes les règles de filtrage ?';
$messages['headerblockexists']  = 'Cette règle existe déjà';
$messages['headerblockexistsentervalue']  = 'Vous devez préciser une valeur pour cette règle';

$labels['whitebyheader']  = 'Pass by header';
$labels['whitebyheaderexplanation']  = 'The rules below will be checked against the mail header fields, and mail that matches will overwrite any blocking rule. Note that the match must be excact, not partial.';
$labels['whiteaddrule']  = 'Add pass rule';
$labels['nowhiteaddressrules']  = 'No pass rules';

$messages['headerwhitedelete']  = 'Are you sure you want to delete this rule?';
$messages['headerwhitedeleteall']  = 'Are you sure you want to delete all pass rules?';
$messages['headerwhiteexists']  = 'This rule already exists';
$messages['headerwhiteentervalue']  = 'You have to enter a value to the rule';

$labels['introtext']  = 'Ici, vous pouvez administrer vos paramètres de compte. Attention, ces paramètres sont liés au serveur de mail, pas seulement au webmail. De ce fait, les modifications effectuées sur cette page s\'appliqueront également à tout client de messagerie tiers avec lequel vous récupérez vos messages sur votre ordinateur.';
$labels['adminlinktext']  = 'Vous êtes enregistré en tant qu\'administrateur de domaine. Sur cette page, vous pouvez seulement éditer vos propres paramètres. Pour obtenir un accès administrateur pour le domaine entier (ajout/édition de comptes, alias, listes etc.) vous devez vous identifier sur %sVexim%s.';

$messages['enterallpassfields'] = 'Pour modifier votre mot de passe, vous devez remplir les trois champs.';
$messages['passwordinconsistency'] = 'Les mots de passe ne correspondent pas, veuillez réessayer.';

$messages['savesuccess-config'] = 'Configuration sauvegardée avec succès';
$messages['savesuccess-config-saveerror-pass-mismatch'] = 'Configuration sauvegardée avec succès, mais impossible de modifier le mot de passe (ancien mot de passe incorrect)';

$messages['saveerror-internalerror'] = 'Erreur pendant la sauvegarde';
$messages['saveerror-config-database'] = 'La configuration n\'a pas été sauvée à cause d\'une erreur sur la base';

$messages['savesuccess-pass'] = 'Mot de passe modifié avec succès';
$messages['saveerror-pass-mismatch'] = 'Impossible de modifier le mot de passe (ancien mot de passe incorrect)';
$messages['saveerror-pass-database'] = 'Nouveau mot de passe non définit (erreur sur la base)';
$messages['saveerror-pass-norows'] = 'Impossible de modifier le mot de passe (aucune base de données trouvée)';

?>

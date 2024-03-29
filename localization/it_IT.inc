<?php

$labels = array();

$labels['accountadmin']  = 'Amministrazione account';
$labels['veximaccountadmin']  = 'Amministrazione account';
$labels['accountadministration']  = 'Amministrazione account';

$labels['password']  = 'Password';
$labels['passwordcurrentexplanation']  = 'Lasciare vuoto per non cambiarla.';
$labels['passwordcurrent']  = 'Password attuale';
$labels['passwordnew']  = 'Nuova password';
$labels['passwordconfirm']  = 'Conferma nuova password';

$labels['spamvirus']  = 'Filtraggio Spam/Virus';
$labels['virusenabled']  = 'Filtro virus attivo';
$labels['virusenabledexplanation']  = 'Cancella ogni messaggio infetto';
$labels['spamenabled']  = 'Filtro spam attivo';
$labels['spamenabledexplanation']  = 'Esamina se i messaggi sono spam';
$labels['spamscoretag']  = 'Punteggio di marcatura';
$labels['spamscoretagexplanation']  = 'Il punteggio al quale marcare il potenziale spam, pur consegnando il messaggio';
$labels['spamscorerefuse']  = 'Punteggio di rifiuto';
$labels['spamscorerefuseexplanation']  = 'Il punteggio al quale il potenziale spam è rifiutato e non consegnato';
$labels['domaindefault']  = 'Default del dominio';

// %italicstart and %italicend will be replaced by <i> and </i>

$labels['autoresponder']  = 'Risposta automatica';
$labels['autoresponderenabled']  = 'Riposta automatica attiva';
$labels['autorespondermessage']  = 'Messaggio di risposta automatica';
$labels['autorespondermessageexplanation']  = 'Nota: la firma non è inclusa automaticamente';

$labels['forwarding']  = 'Inoltro';
$labels['forwardingenabled']  = 'Inoltro abilitato';
$labels['forwardingaddress']  = 'Inoltrare a';
$labels['forwardinglocal']  = 'Conservare localmente la posta inoltrata';

$labels['parameters']  = 'Parametri';
$labels['messagesize']  = 'Dimensione massima dei messaggi (kb)';
$labels['messagesizeexplanation']  = 'I messaggi più grandi della taglia specificata sono restituiti al mittente. Predefinito: 0 (per il dominio %d:  %m).';
$labels['unlimited']  = 'senza limite';

$labels['blockbyheader']  = 'Blocco sulle intestazioni';
$labels['blockbyheaderexplanation']  = 'I messaggi che soddisfano le regole specificate di seguito sono automaticamente cancellati. Nota: la corrispondenza è esatta, non parziale.';
$labels['addrule']  = 'Aggiungere regola di blocco';
$labels['deleteall']  = 'Cancellare tutto';
$labels['field']  = 'Campo intestazione';
$labels['value']  = 'Valore';
$labels['headerfrom']  = 'From (mittente)';
$labels['headerto']  = 'To (destinatario)';
$labels['headersubject']  = 'Subject (oggetto)';
$labels['headerxmailer']  = 'X-Mailer (client)';
$labels['noaddressrules']  = 'Nessuna regola di blocco';

$messages['headerblockdelete']  = 'Cancellare questa regola?';
$messages['headerblockdeleteall']  = 'Cancellare tutte le regole?';
$messages['headerblockexists']  = 'Regola già presente';
$messages['headerblockentervalue']  = 'Valore mancante';

$labels['whitebyheader']  = 'Pass by header';
$labels['whitebyheaderexplanation']  = 'The rules below will be checked against the mail header fields, and mail that matches will overwrite any blocking rule. Note that the match must be excact, not partial.';
$labels['whiteaddrule']  = 'Add pass rule';
$labels['nowhiteaddressrules']  = 'No pass rules';

$messages['headerwhitedelete']  = 'Are you sure you want to delete this rule?';
$messages['headerwhitedeleteall']  = 'Are you sure you want to delete all pass rules?';
$messages['headerwhiteexists']  = 'This rule already exists';
$messages['headerwhiteentervalue']  = 'You have to enter a value to the rule';

$labels['introtext']  = 'Qui si amministrano le impostazioni del suo account. Si ricordi che queste impostazioni sono legate alla sua casella in generale, e non soltanto alla webmail, pertanto ogni cambiamento in questa pagina riguarda anche eventuali altri client.';
$labels['adminlinktext']  = 'Il suo account è amministrativo, ma in questa pagina è possibile modificare solo le sue impostazioni personali. Per accedere all\'amministrazione del dominio (aggiunta modifica account, alias, liste...) si autentichi su %sVexim%s.';

$messages['enterallpassfields'] = 'Per cambiare la password tutti e tre i campi devono essere compilati.';
$messages['passwordinconsistency'] = 'Le password non corrispondono. Riprovare.';

$messages['savesuccess-config'] = 'Configurazione salvata con successo.';
$messages['savesuccess-config-saveerror-pass-mismatch'] = 'Configurazione salvata con successo, eccetto la nuova password (password vecchia errata)';

$messages['saveerror-internalerror'] = 'Errore nel salvataggio della configurazione';
$messages['saveerror-config-database'] = 'Configurazione non salvata a causa di un errore nella comunicazione con la base di dati';

$messages['savesuccess-pass'] = 'Nuova password impostata con successo';
$messages['saveerror-pass-mismatch'] = 'Nuova password non impostata (password vecchia errata)';
$messages['saveerror-pass-database'] = 'Nuova password non impostata (errore base di dati)';
$messages['saveerror-pass-norows'] = 'Nuova password non impostata (nessun cambiamento nella base di dati)';


?>

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
$labels['spammove']  = 'Spostare spam in una cartella';
$labels['domaindefault']  = 'Default del dominio';

// %italicstart and %italicend will be replaced by <i> and </i>
$labels['spammoveexplanation_part1']  = 'I messaggi marcati come spam sono automaticamente posti nelle cartelle IMAP %italicstartFilter-Spam-Low%italicend and %italicstartFilter-Spam-High%italicend, a seconda del punteggio ricevuto.';
$labels['spammoveexplanation_part2']  = 'La posta più vecchia di 90 o 30 giorni, nell\'ordine, è cancellata automaticamente.';
$labels['spammoveexplanation_part3']  = 'Se questa impostazione è attiva usando POP invece di IMAP, lo spam non è reperibile dai client.';
$labels['spamtip']  = 'Consiglio: è possibile creare la cartella %italicstartLearnAsSpam%italicend dove mettere lo spam non rilevato dal filtro. (%italicstartLearnAsHam%italicend per i falsi positivi.) Ogni notte il filtro spam analizza queste cartelle, impara dai messaggi e li cancella.';

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

<?php

$labels = array();

$labels['accountadmin']  = 'Kontoadmin';
$labels['veximaccountadmin']  = 'Kontoadministrasjon';
$labels['accountadministration']  = 'Kontoadministrasjon';

$labels['password']  = 'Passord';
$labels['passwordcurrentexplanation']  = 'La feltene stå tomme hvis du ikke ønsker å endre passordet.';
$labels['passwordcurrent']  = 'Nåværende passord';
$labels['passwordnew']  = 'Nytt passord';
$labels['passwordconfirm']  = 'Nytt passord';

$labels['spamvirus']  = 'Spam- og virusfilter';
$labels['virusenabled']  = 'Aktiver virusfilter';
$labels['virusenabledexplanation']  = 'Slett all infisert e-post';
$labels['spamenabled']  = 'Aktiver spamfilter';
$labels['spamenabledexplanation']  = 'Sjekk all inngående e-post for spam';
$labels['spamscoretag']  = 'Spamverdi for markering';
$labels['spamscoretagexplanation']  = 'Meldinger med denne spamverdien eller høyere vil bli markert som spam';
$labels['spamscorerefuse']  = 'Spamverdi for sletting';
$labels['spamscorerefuseexplanation']  = 'Meldinger med denne spamverdien eller høyere vil bli automatisk slettet';
$labels['domaindefault']  = 'Standardinnstilling';

// %italicstart and %italicend will be replaced by <i> and </i>

$labels['autoresponder']  = 'Autosvar';
$labels['autoresponderenabled']  = 'Aktiver autosvar';
$labels['autorespondermessage']  = 'Autosvarmelding';
$labels['autorespondermessageexplanation']  = 'Merk: Din signatur vil ikke bli lagt til automatisk';

$labels['forwarding']  = 'Videresending';
$labels['forwardingenabled']  = 'Aktiver videresending';
$labels['forwardingaddress']  = 'Send videre til';
$labels['forwardinglocal']  = 'Ta vare på meldingene lokalt';

$labels['parameters']  = 'Parametere';
$labels['messagesize']  = 'Maksimal størrelse (kb)';
$labels['messagesizeexplanation']  = 'Meldinger større enn dette (i kilobytes) vil bli returnert til avsender. Standardinnstilling: 0 (bruk domenetinnstillingen til %d, som er %m).';
$labels['unlimited']  = 'ubegrenset';

$labels['blockbyheader']  = 'Headerfiltere';
$labels['blockbyheaderexplanation']  = 'Reglene nedenfor vil bli sjekket mot header-feltet i meldinger du mottar, og ved treff vil meldingen bli automatisk slettet. Merk at regelverdien må være den eksakt samme som header-feltet.';
$labels['addrule']  = 'Legg til regel';
$labels['deleteall']  = 'Slett alle';
$labels['field']  = 'Headerfelt';
$labels['value']  = 'Verdi';
$labels['headerfrom']  = 'From';
$labels['headerto']  = 'To';
$labels['headersubject']  = 'Subject';
$labels['headerxmailer']  = 'X-Mailer';
$labels['noaddressrules']  = 'Ingen regler';

$messages['headerblockdelete']  = 'Er du sikker på at du vil slette denne regelen?';
$messages['headerblockdeleteall']  = 'Er du sikker på at du vil slette alle reglene?';
$messages['headerblockexists']  = 'Denne regelen finnes allerede';
$messages['headerblockentervalue']  = 'Du må skrive inn en verdi til regelen';

$labels['whitebyheader']  = 'Pass by header';
$labels['whitebyheaderexplanation']  = 'The rules below will be checked against the mail header fields, and mail that matches will overwrite any blocking rule. Note that the match must be excact, not partial.';
$labels['whiteaddrule']  = 'Add pass rule';
$labels['nowhiteaddressrules']  = 'No pass rules';

$messages['headerwhitedelete']  = 'Are you sure you want to delete this rule?';
$messages['headerwhitedeleteall']  = 'Are you sure you want to delete all pass rules?';
$messages['headerwhiteexists']  = 'This rule already exists';
$messages['headerwhiteentervalue']  = 'You have to enter a value to the rule';

$labels['introtext']  = 'Her kan du administrere dine kontoinnstillinger. Husk at disse innstillingene er knyttet til mailserveren, ikke bare webmailen. Endringer du gjør på denne siden vil derfor også påvirke andre mailprogrammer du bruker for denne adressen.';
$labels['adminlinktext']  = 'Du er oppført som domeneadministrator. Fra denne siden kan du kun endre dine egne kontoinnstillinger, du kan ikke legge til/endre konti, videresendinger, lister osv. For å få slik administratortilgang må du logge på med %sVexim%s.';

$messages['enterallpassfields'] = 'Du må fylle inn alle tre passordfeltene hvis du vil endre passordet.';
$messages['passwordinconsistency'] = 'Passordene stemmer ikke over ens, vennligst prøv igjen.';

$messages['savesuccess-config'] = 'Kontoinnstillingene er lagret';
$messages['savesuccess-config-saveerror-pass-mismatch'] = 'Kontoinnstillingene er lagret, men passordet er ikke endret (gammelt passord skrevet inn feil)';

$messages['saveerror-internalerror'] = 'Feil under lagring av kontoinnstillinger';
$messages['saveerror-config-database'] = 'Databasefeil førte til at kontoinnstillingene ikke ble lagret';

$messages['savesuccess-pass'] = 'Passordet er endret';
$messages['saveerror-pass-mismatch'] = 'Passordet er ikke endret (gammelt passord skrevet inn feil)';
$messages['saveerror-pass-database'] = 'Passordet er ikke endret (databasefeil)';
$messages['saveerror-pass-norows'] = 'Passordet er ikke endret (ingen databaserader funnet)';





?>

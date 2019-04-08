<?php
/**
 * secupay Payment Module
 *
 * Copyright (c) 2018 secupay AG
 *
 * @category  Payment
 * @author    secupay AG
 * @copyright 2018, secupay AG
 *
 * Description:
 * XTC Plugin for integration of secupay AG payment services
 *
 */

define('MODULE_PAYMENT_SPINV_TEXT_TITLE', 'Rechnungskauf');
define('MODULE_PAYMENT_SPINV_TEXT_DESCRIPTION', 'secupay Rechnungskauf - einfach.sicher.zahlen');
define('MODULE_PAYMENT_SPINV_TEXT_ERROR', 'Fehler beim Zahlvorgang!');

define('MODULE_PAYMENT_SECUPAY_INV_XTC_STATUS_DESC', 'M&ouml;chten Sie Rechnungsk&auml;ufe &uuml;ber secupay abwickeln?');
define('MODULE_PAYMENT_SECUPAY_INV_XTC_STATUS_TITLE', 'Rechnungskauf');

define('MODULE_PAYMENT_SPINV_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_SPINV_ZONE_DESC', 'F&uuml;r welche Zone soll Rechnungskauf angezeigt werden?');

define('MODULE_PAYMENT_SECUPAY_APIKEY_TITLE', 'API.key');
define('MODULE_PAYMENT_SECUPAY_APIKEY_DESC', 'Ihr secupay API.key');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ID_TITLE', 'Bestellstatus nach Daten&uuml;bermittlung');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ID_DESC', '');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ACCEPTED_ID_TITLE', 'Bestellstatus bei erfolgreichen Transaktionen');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ACCEPTED_ID_DESC', '');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_DENIED_ID_TITLE', 'Bestellstatus bei abgelehnten Transaktionen');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_DENIED_ID_DESC', '');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ISSUE_ID_TITLE', 'Bestellstatus bei Zahlungsproblemen');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_ISSUE_ID_DESC', 'z. B. R&uuml;cklastschrift, Chargeback');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_VOID_ID_TITLE', 'Bestellstatus bei stornierten Transaktionen');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_VOID_ID_DESC', '');

define('MODULE_PAYMENT_SPINV_ORDER_STATUS_AUTHORIZED_ID_TITLE', 'Bestellstatus bei vorautorisierten Transaktionen');
define('MODULE_PAYMENT_SPINV_ORDER_STATUS_AUTHORIZED_ID_DESC', '');

define('MODULE_PAYMENT_SPINV_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SPINV_SORT_ORDER_DESC', 'An wievielter Stelle soll diese Zahlungsart angezeigt werden? (kleinste Ziffer zuerst)');

define('MODULE_PAYMENT_SPINV_SIMULATION_MODE_TITLE', 'Modus');
define('MODULE_PAYMENT_SPINV_SIMULATION_MODE_DESC', 'Legen Sie hier den gew&uuml;nschten Modus fest.');

define('MODULE_PAYMENT_SPINV_LOGGING_TITLE', 'Debugmodus');
define('MODULE_PAYMENT_SPINV_LOGGING_DESC', 'Bitte aktivieren Sie diese Funktion nur nach R&uuml;cksprache mit unserem Kundendienst.');

define('MODULE_PAYMENT_SPINV_KAEUFERSCHUTZ_TITLE', 'K&auml;uferschutz');
define('MODULE_PAYMENT_SPINV_KAEUFERSCHUTZ_DESC', 'Soll der K&auml;uferschutzhinweis w&auml;hrend des Bestellprozesses angezeigt werden?');

define('MODULE_PAYMENT_SPINV_GUARANTEE_TITLE', 'Zahlungsgarantie');
define('MODULE_PAYMENT_SPINV_GUARANTEE_DESC', 'M&ouml;chten Sie die Zahlungsgarantie in Anspruch nehmen?');

define('MODULE_PAYMENT_SPINV_PREAUTH_TITLE', 'Vorautorisierung');
define('MODULE_PAYMENT_SPINV_PREAUTH_DESC', 'M&ouml;chten Sie Zahlungen vorerst nur reservieren?');

define('MODULE_PAYMENT_SPINV_SHOPNAME_TITLE', 'Shopname');
define('MODULE_PAYMENT_SPINV_SHOPNAME_DESC', 'M&ouml;chten Sie eine abweichende Shopbezeichnung im Verwendungszweck ausgeben?');

define('MODULE_PAYMENT_SPINV_MWST_TITLE', 'Mehrwertsteuer auf Versandkosten');
define('MODULE_PAYMENT_SPINV_MWST_DESC', 'M&ouml;chten Sie die MwSt auf Versandkosten extra berechnen? (evtl. notwendig bei Fehlern im Shopsystem)');

define('MODULE_PAYMENT_SPINV_BID_TITLE', 'Bidirektionalit&auml;t');
define('MODULE_PAYMENT_SPINV_BID_DESC', 'Bidirektionale Kommunikation mit secupay aktivieren');

define('MODULE_PAYMENT_SPINV_CESSION_Q_TITLE', 'Abtretungserkl&auml;rung');
define('MODULE_PAYMENT_SPINV_CESSION_Q_DESC', 'In welcher Form w&uuml;nschen Sie Ihre Kunden anzusprechen?');

define('MODULE_PAYMENT_SPINV_WARNDELIVERY_TITLE', 'Warnhinweis bei abweichender Lieferanschrift');
define('MODULE_PAYMENT_SPINV_WARNDELIVERY_DESC', 'M&ouml;chten Sie den Warnhinweis bei abweichender Lieferanschrift anzeigen lassen?');

define('MODULE_PAYMENT_SPINV_CESSION_MODE_TITLE', 'Form der Abtretungserkl&auml;ung');
define('MODULE_PAYMENT_SPINV_CESSION_MODE_DESC', 'M&ouml;chten Sie die Abtretungserkl&auml;rung pers&ouml;nlich oder gesch&auml;ftlich darstellen?');

define('MODULE_PAYMENT_SECUPAY_SPINV_TEXT_INFO', 'Sie &uuml;berweisen den Rechnungsbetrag nach Erhalt und Pr&uuml;fung der Ware.');

define('MODULE_PAYMENT_SECUPAY_INV_XTC_ALLOWED', '');
define('MODULE_PAYMENT_SECUPAY_INV_XTC_TEXT_TITLE', 'Rechnungskauf');
define('MODULE_PAYMENT_SPINV_HINT', "Hinweis");
define('MODULE_PAYMENT_SPINV_DELIVERY_HINT', "<p style='color:red;'>Der Versand erfolgt ausschlie&szlig;lich an die angegebene Rechnungsadresse.</p>");
define('MODULE_PAYMENT_SPINV_DEMO_HINT', "\n\nAchtung, Transaktion im Demo-Modus durchgefuehrt!\n");

define('MODULE_PAYMENT_SPINV_CONFIRMATION_URL', "Rechnungskauf als f&auml;llig markieren.");
define('MODULE_PAYMENT_SPINV_SHOW_QRCODE_TITLE', 'QR-Code anzeigen');
define('MODULE_PAYMENT_SPINV_SHOW_QRCODE_DESC', 'M&ouml;chten Sie den QR-Code auf der Rechnung anzeigen?');
define('MODULE_PAYMENT_SPINV_QRCODE_DESC', 'Um diese Rechnung bequem online zu zahlen, k&ouml;nnen Sie die folgende Adresse aufrufen oder den QR-Code mit einem internetf&auml;higen Ger&auml;t einscannen.');
define('MODULE_PAYMENT_SPINV_QRCODE_PDF_DESC', 'Um diese Rechnung bequem online zu zahlen, k&ouml;nnen Sie die folgende Adresse aufrufen oder den QR-Code mit einem internetf&auml;higen Ger&auml;t einscannen.');
define('MODULE_PAYMENT_SPINV_QRCODE_PDF_HINT', ' - f&uuml;r weitere Informationen siehe letzte Seite');

define('MODULE_PAYMENT_SPINV_KONTO_NR_TITLE', "Kontonummer");
define('MODULE_PAYMENT_SPINV_KONTO_NR_DESC', "Kontonummer f&uuml;r Rechnungsdruck");
define('MODULE_PAYMENT_SPINV_BLZ_TITLE', "BLZ");
define('MODULE_PAYMENT_SPINV_BLZ_DESC', "BLZ f&uuml;r Rechnungsdruck");
define('MODULE_PAYMENT_SPINV_BANKNAME_TITLE', "Bank");
define('MODULE_PAYMENT_SPINV_BANKNAME_DESC', "Bankname f&uuml;r Rechnungsdruck");
define('MODULE_PAYMENT_SPINV_IBAN_TITLE', "IBAN");
define('MODULE_PAYMENT_SPINV_IBAN_DESC', "IBAN f&uuml;r Rechnungsdruck");
define('MODULE_PAYMENT_SPINV_BIC_TITLE', "BIC");
define('MODULE_PAYMENT_SPINV_BIC_DESC', "BIC f&uuml;r Rechnungsdruck");

define('MODULE_PAYMENT_SPINV_INVOICE_TEXT', "Der Rechnungsbetrag wurde an die [recipient_legal] abgetreten. <br><b>Eine Zahlung mit schuldbefreiender Wirkung ist nur auf folgendes Konto m&ouml;glich:</b><br><br>Empf&auml;nger: ");
define('MODULE_PAYMENT_SPINV_INVOICE_TEXT_PDF', "Der Rechnungsbetrag wurde an die [recipient_legal] abgetreten. Eine Zahlung mit schuldbefreiender Wirkung ist nur auf folgendes Konto m&ouml;glich:\n\nEmpf&auml;nger: ");
define('MODULE_PAYMENT_SPINV_INVOICE_TEXT_PDF_HINT', "Der Rechnungsbetrag wurde an die [account_owner] abgetreten. Bitte zahlen Sie an folgende Bankverbindung:");
define('MODULE_PAYMENT_SPINV_INVOICE_URL_HINT', "oder verwenden Sie diesen Link:");
define('MODULE_PAYMENT_SPINV_INVOICE_PURPOSE', "Verwendungszweck");

define('MODULE_PAYMENT_SPINV_DELIVERY_DISABLE_TITLE', 'Zahlungsart deaktivieren bei abweichender Lieferanschrift.');
define('MODULE_PAYMENT_SPINV_DELIVERY_DISABLE_DESC', 'M&ouml;chten Sie die Zahlungsart bei abweichender Lieferanschrift deaktivieren? Alternativ ist es m&ouml;glich einen Hinweis anzuzeigen.');

define('MODULE_PAYMENT_SPINV_DUE_DATE_TEXT', 'F&auml;llig 10 Tage nach Lieferung.');
define('MODULE_PAYMENT_SPINV_DUE_DATE_TEXT_PDF', 'F&auml;llig 10 Tage nach Lieferung.');
define('MODULE_PAYMENT_SPINV_DUE_DATE_TITLE', 'Zahlungsfrist anzeigen');
define('MODULE_PAYMENT_SPINV_DUE_DATE_DESC', 'M&ouml;chten Sie die Zahlungsfrist auf der Rechnung anzeigen?');

define('MODULE_PAYMENT_SPINV_PAYMENTINFO_TO_COMMENT_TITLE', 'Zahlungsinformationen zu Bestellkommentar hinzuf&uuml;gen.');
define('MODULE_PAYMENT_SPINV_PAYMENTINFO_TO_COMMENT_DESC', 'Diese Option ist nicht mit allen Shopversionen kompatibel! W&auml;hlen Sie bitte die zu Ihrer Wawi passende Variante.');

define('MODULE_PAYMENT_SPINV_MIN_AMOUNT_TITLE', 'Mindestbetrag');
define('MODULE_PAYMENT_SPINV_MIN_AMOUNT_DESC', 'Mindestbetrag, ab dem die Zahlart angezeigt wird. Hinweis: Wert mit Punkt als Dezimaltrennzeichen eingeben.');

define('MODULE_PAYMENT_SPINV_MAX_AMOUNT_TITLE', 'Maximalbetrag');
define('MODULE_PAYMENT_SPINV_MAX_AMOUNT_DESC', 'Maximalbetrag, bis zu dem die Zahlart angezeigt wird. Hinweis: Wert mit Punkt als Dezimaltrennzeichen eingeben. Wert 0 steht f&uuml;r keine Begrenzung.');

define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_TITLE', 'Bestellung vor Zahlung speichern.');
define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_DESC', 'Die Bestellung wird im Shop vor dem Abschluss des Zahlvorgangs gespeichert. Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.');

define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_TITLE', 'Automatische &Uuml;bermittlung Trackinginformationen ');
define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_DESC', 'Meldet automatisch die Trackinginformationen an secupay. (Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.)');

define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_TITLE', 'Bewertung');
define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_DESC', 'Teilen Sie uns Ihre Zahlungserfahrungen mit dem Kunden mit. (Setzt eine entsprechende Freischaltung f&uuml;r den jeweiliegen Vertrag voraus. Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.)');

define('MODULE_PAYMENT_SECUPAY_RAUTOSEND_TITLE', 'Rechnungsnummer anstatt Bestellnummer &uuml;bermitteln.');
define('MODULE_PAYMENT_SECUPAY_RAUTOSEND_DESC', 'Bei aktivierter Option wird anstelle der Bestellnummer die Rechnungsnummer bei der automatischen Versandmeldung verwendet.');

define('MODULE_PAYMENT_SECUPAY_VAUTOSEND_TITLE', 'Automatische Versandmeldung Rechnungskauf');
define('MODULE_PAYMENT_SECUPAY_VAUTOSEND_DESC', 'Meldet automatisch den Versand an secupay. Die Trackingnummer sollte bereits eingetragen sein.');

define('MODULE_PAYMENT_SECUPAY_SESSION_TITLE', 'Session Zeit');
define('MODULE_PAYMENT_SECUPAY_SESSION_DESC', 'H&auml;lt die Session des Bestellers im Shop w&auml;hrend des Zahlvorgangs f&uuml;r die angegebene Zeit (in ms) aktiv. 0 deaktiviert die Funktion.');

define('MODULE_PAYMENT_SECUPAY_OWNER_TITLE', 'Empf&auml;nger');
define('MODULE_PAYMENT_SECUPAY_ADMIN_INFO_BLOCK', 'secupay Zahlungsinformationen');
define('MODULE_PAYMENT_SECUPAY_ADMIN_TANR', 'Transaktionsnummer:');
define('MODULE_PAYMENT_SECUPAY_ADMIN_STATUS', 'Payment Status:');

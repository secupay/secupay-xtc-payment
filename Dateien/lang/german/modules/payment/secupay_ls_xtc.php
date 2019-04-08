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

define('MODULE_PAYMENT_SPLS_TEXT_TITLE', 'Lastschrift');
define('MODULE_PAYMENT_SPLS_TEXT_DESCRIPTION', 'Lastschrift - einfach.sicher.zahlen');
define('MODULE_PAYMENT_SPLS_TEXT_ERROR', 'Fehler beim Zahlvorgang!');

define('MODULE_PAYMENT_SECUPAY_LS_XTC_STATUS_DESC', 'M&ouml;chten Sie Lastschriftzahlungen &uuml;ber secupay abwickeln?');
define('MODULE_PAYMENT_SECUPAY_LS_XTC_STATUS_TITLE', 'Lastschrift');

define('MODULE_PAYMENT_SPLS_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_SPLS_ZONE_DESC', 'F&uuml;r welche Zone soll Lastschrift angezeigt werden?');

define('MODULE_PAYMENT_SECUPAY_APIKEY_TITLE', 'API.key');
define('MODULE_PAYMENT_SECUPAY_APIKEY_DESC', 'Ihr secupay API.key');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ID_TITLE', 'Bestellstatus nach Daten&uuml;bermittlung');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ID_DESC', '');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ACCEPTED_ID_TITLE', 'Bestellstatus bei erfolgreichen Transaktionen');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ACCEPTED_ID_DESC', '');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_DENIED_ID_TITLE', 'Bestellstatus bei abgelehnten Transaktionen');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_DENIED_ID_DESC', '');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ISSUE_ID_TITLE', 'Bestellstatus bei Zahlungsproblemen');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_ISSUE_ID_DESC', 'z. B. R&uuml;cklastschrift, Chargeback, Warnmail');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_VOID_ID_TITLE', 'Bestellstatus bei stornierten Transaktionen');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_VOID_ID_DESC', '');

define('MODULE_PAYMENT_SPLS_ORDER_STATUS_AUTHORIZED_ID_TITLE', 'Bestellstatus bei vorautorisierten Transaktionen');
define('MODULE_PAYMENT_SPLS_ORDER_STATUS_AUTHORIZED_ID_DESC', '');

define('MODULE_PAYMENT_SPLS_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SPLS_SORT_ORDER_DESC', 'An wievielter Stelle soll diese Zahlungsart angezeigt werden? (kleinste Ziffer zuerst)');

define('MODULE_PAYMENT_SPLS_SIMULATION_MODE_TITLE', 'Modus');
define('MODULE_PAYMENT_SPLS_SIMULATION_MODE_DESC', 'Legen Sie hier den gew&uuml;nschten Modus fest.');

define('MODULE_PAYMENT_SPLS_LOGGING_TITLE', 'Debugmodus');
define('MODULE_PAYMENT_SPLS_LOGGING_DESC', 'Bitte aktivieren Sie diese Funktion nur nach R&uuml;cksprache mit unserem Kundendienst.');

define('MODULE_PAYMENT_SPLS_KAEUFERSCHUTZ_TITLE', 'K&auml;uferschutz');
define('MODULE_PAYMENT_SPLS_KAEUFERSCHUTZ_DESC', 'Soll der K&auml;uferschutzhinweis w&auml;hrend des Bestellprozesses angezeigt werden?');

define('MODULE_PAYMENT_SPLS_GUARANTEE_TITLE', 'Zahlungsgarantie');
define('MODULE_PAYMENT_SPLS_GUARANTEE_DESC', 'M&ouml;chten Sie die Zahlungsgarantie in Anspruch nehmen?');

define('MODULE_PAYMENT_SPLS_PREAUTH_TITLE', 'Vorautorisierung');
define('MODULE_PAYMENT_SPLS_PREAUTH_DESC', 'M&ouml;chten Sie Zahlungen vorerst nur reservieren?');

define('MODULE_PAYMENT_SPLS_SHOPNAME_TITLE', 'Shopname');
define('MODULE_PAYMENT_SPLS_SHOPNAME_DESC', 'M&ouml;chten Sie eine abweichende Shopbezeichnung im Verwendungszweck ausgeben?');

define('MODULE_PAYMENT_SPLS_MWST_TITLE', 'Mehrwertsteuer auf Versandkosten');
define('MODULE_PAYMENT_SPLS_MWST_DESC', 'M&ouml;chten Sie die MwSt auf Versandkosten extra berechnen? (evtl. notwendig bei Fehlern im Shopsystem)');

define('MODULE_PAYMENT_SPLS_BID_TITLE', 'Bidirektionalit&auml;t');
define('MODULE_PAYMENT_SPLS_BID_DESC', 'Bidirektionale Kommunikation mit secupay aktivieren.');

define('MODULE_PAYMENT_SPLS_CESSION_Q_TITLE', 'Abtretungserkl&auml;rung');
define('MODULE_PAYMENT_SPLS_CESSION_Q_DESC', 'In welcher Form w&uuml;nschen Sie Ihre Kunden anzusprechen?');

define('MODULE_PAYMENT_SPLS_WARNDELIVERY_TITLE', 'Warnhinweis bei abweichender Lieferanschrift');
define('MODULE_PAYMENT_SPLS_WARNDELIVERY_DESC', 'M&ouml;chten Sie den Warnhinweis bei abweichender Lieferanschrift anzeigen lassen?');

define('MODULE_PAYMENT_SPLS_CESSION_MODE_TITLE', 'Form der Abtretungserkl&auml;ung');
define('MODULE_PAYMENT_SPLS_CESSION_MODE_DESC', 'M&ouml;chten Sie die Abtretungserkl&auml;rung pers&ouml;nlich oder gesch&auml;ftlich darstellen?');

define('MODULE_PAYMENT_SECUPAY_SPLS_TEXT_INFO', 'Sie zahlen bequem per Bankeinzug.');

define('MODULE_PAYMENT_SECUPAY_LS_XTC_ALLOWED', '');
define('MODULE_PAYMENT_SECUPAY_LS_XTC_TEXT_TITLE', 'Lastschrift');

define('MODULE_PAYMENT_SPLS_HINT', "Hinweis");
define('MODULE_PAYMENT_SPLS_DELIVERY_HINT', "<p style='color:red;'>Der Versand erfolgt ausschlie&szlig;lich an die angegebene Rechnungsadresse.</p>");
define('MODULE_PAYMENT_SPLS_DEMO_HINT', "\n\nAchtung, Transaktion im Demo-Modus durchgefuehrt!\n");

define('MODULE_PAYMENT_SPLS_DELIVERY_DISABLE_TITLE', 'Zahlungsart deaktivieren bei abweichender Lieferanschrift.');
define('MODULE_PAYMENT_SPLS_DELIVERY_DISABLE_DESC', 'M&ouml;chten Sie die Zahlungsart bei abweichender Lieferanschrift deaktivieren? Alternativ ist es m&ouml;glich einen Hinweis anzuzeigen.');

define('MODULE_PAYMENT_SPLS_MIN_AMOUNT_TITLE', 'Mindestbetrag');
define('MODULE_PAYMENT_SPLS_MIN_AMOUNT_DESC', 'Mindestbetrag, ab dem die Zahlart angezeigt wird. Hinweis: Wert mit Punkt als Dezimaltrennzeichen eingeben.');

define('MODULE_PAYMENT_SPLS_MAX_AMOUNT_TITLE', 'Maximalbetrag');
define('MODULE_PAYMENT_SPLS_MAX_AMOUNT_DESC', 'Maximalbetrag, bis zu dem die Zahlart angezeigt wird. Hinweis: Wert mit Punkt als Dezimaltrennzeichen eingeben. Wert 0 steht f&uuml;r keine Begrenzung.');

define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_TITLE', 'Bestellung vor Zahlung speichern.');
define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_DESC', 'Die Bestellung wird im Shop vor dem Abschluss des Zahlvorgangs gespeichert. Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.');

define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_TITLE', 'Automatische &Uuml;bermittlung Trackinginformationen ');
define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_DESC', 'Meldet automatisch die Trackinginformationen an secupay. (Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.)');

define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_TITLE', 'Bewertung');
define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_DESC', 'Teilen Sie uns Ihre Zahlungserfahrungen mit dem Kunden mit. (Setzt eine entsprechende Freischaltung f&uuml;r den jeweiliegen Vertrag voraus. Diese Einstellung gilt f&uuml;r alle secupay Zahlarten.)');

define('MODULE_PAYMENT_SECUPAY_SESSION_TITLE', 'Session Zeit');
define('MODULE_PAYMENT_SECUPAY_SESSION_DESC', 'H&aumll;t die Session des Bestellers im Shop w&auml;hrend des Zahlvorgangs f&uuml;r die angegebene Zeit (in ms) aktiv. 0 deaktiviert die Funktion.');

define('MODULE_PAYMENT_SECUPAY_OWNER_TITLE', 'Empf&auml;nger');
define('MODULE_PAYMENT_SECUPAY_ADMIN_INFO_BLOCK', 'secupay Zahlungsinformationen');
define('MODULE_PAYMENT_SECUPAY_ADMIN_TANR', 'Transaktionsnummer:');
define('MODULE_PAYMENT_SECUPAY_ADMIN_STATUS', 'Payment Status:');

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

define('MODULE_PAYMENT_SPB2B_TEXT_TITLE', 'Invoice');
define('MODULE_PAYMENT_SPB2B_TEXT_DESCRIPTION', 'secupay invoice payment - pay simple and safe');
define('MODULE_PAYMENT_SPB2B_TEXT_ERROR', 'Error in payment process!');

define('MODULE_PAYMENT_SECUPAY_B2B_XTC_STATUS_DESC', 'Do you want to handle B2B invoice payments with secupay? (You have to assign Invoice payment B2B & Invoice payment B2C to different customer groups! A separate contract is required, please contact your customer account manager.)');
define('MODULE_PAYMENT_SECUPAY_B2B_XTC_STATUS_TITLE', 'Invoice payment B2B');

define('MODULE_PAYMENT_SPB2B_ZONE_TITLE', 'Payment zone');
define('MODULE_PAYMENT_SPB2B_ZONE_DESC', 'For which zone should Invoice payment B2B be displayed?');

define('MODULE_PAYMENT_SECUPAY_B2B_APIKEY_TITLE', 'API.key');
define('MODULE_PAYMENT_SECUPAY_B2B_APIKEY_DESC', 'Your secupay API.key');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ID_TITLE', 'Order status after order is submitted');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ID_DESC', '');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ACCEPTED_ID_TITLE', 'Order status after successful transactions');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ACCEPTED_ID_DESC', '');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_DENIED_ID_TITLE', 'Order status for denied transactions');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_DENIED_ID_DESC', '');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ISSUE_ID_TITLE', 'Order status for payment issues');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_ISSUE_ID_DESC', 'e.g. chargebacks');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_VOID_ID_TITLE', 'Order status for cancelled transactions');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_VOID_ID_DESC', '');

define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_AUTHORIZED_ID_TITLE', 'Order status for pre-authorized transactions');
define('MODULE_PAYMENT_SPB2B_ORDER_STATUS_AUTHORIZED_ID_DESC', '');

define('MODULE_PAYMENT_SPB2B_SORT_ORDER_TITLE', 'Display order');
define('MODULE_PAYMENT_SPB2B_SORT_ORDER_DESC', 'At which position should this payment method be displayed? (lower values first)');

define('MODULE_PAYMENT_SPB2B_SIMULATION_MODE_TITLE', 'Mode');
define('MODULE_PAYMENT_SPB2B_SIMULATION_MODE_DESC', 'Set operation mode here (demo/live).');

define('MODULE_PAYMENT_SPB2B_LOGGING_TITLE', 'Debug mode');
define('MODULE_PAYMENT_SPB2B_LOGGING_DESC', 'Please activate this function only after consulting our support team.');

define('MODULE_PAYMENT_SPB2B_KAEUFERSCHUTZ_TITLE', 'Buyer protection');
define('MODULE_PAYMENT_SPB2B_KAEUFERSCHUTZ_DESC', 'Should the Buyer protection hint be displayed during the order process?');

define('MODULE_PAYMENT_SPB2B_GUARANTEE_TITLE', 'Payment guarantee');
define('MODULE_PAYMENT_SPB2B_GUARANTEE_DESC', 'Do you want to take advantage of the payment guarantee?');

define('MODULE_PAYMENT_SPB2B_PREAUTH_TITLE', 'Pre-authorization');
define('MODULE_PAYMENT_SPB2B_PREAUTH_DESC', 'Do you only want to make a payment-reservation at this time?');

define('MODULE_PAYMENT_SPB2B_SHOPNAME_TITLE', 'Shop name');
define('MODULE_PAYMENT_SPB2B_SHOPNAME_DESC', 'Do you want to state a different shop name in the payment reference?');

define('MODULE_PAYMENT_SPB2B_MWST_TITLE', 'VAT for shipping costs');
define('MODULE_PAYMENT_SPB2B_MWST_DESC', 'Do you want to calculate VAT for shipping costs separately? (Useful if there are errors in the shop&#39;s system.)');

define('MODULE_PAYMENT_SPB2B_BID_TITLE', 'Bidirectionality');
define('MODULE_PAYMENT_SPB2B_BID_DESC', 'activate bidirectional communication with secupay');

define('MODULE_PAYMENT_SPB2B_CESSION_Q_TITLE', 'Declaration of assignment');
define('MODULE_PAYMENT_SPB2B_CESSION_Q_DESC', 'In which way do you wish to inform your customers?');

define('MODULE_PAYMENT_SPB2B_WARNDELIVERY_TITLE', 'Warning notice with deviating delivery address');
define('MODULE_PAYMENT_SPB2B_WARNDELIVERY_DESC', 'Do you want to display a warning notice with deviating delivery address?');

define('MODULE_PAYMENT_SPB2B_CESSION_MODE_TITLE', 'Form of the declaration of assignment');
define('MODULE_PAYMENT_SPB2B_CESSION_MODE_DESC', 'Do you want to display the declaration of assignment personally/individually or formal/on business?');

define('MODULE_PAYMENT_SECUPAY_SPB2B_TEXT_INFO', 'Pay the amount upon receipt and examination of goods.');

define('MODULE_PAYMENT_SECUPAY_B2B_XTC_ALLOWED', '');
define('MODULE_PAYMENT_SECUPAY_B2B_XTC_TEXT_TITLE', 'Invoice payment');
define('MODULE_PAYMENT_SPB2B_HINT', "Hint");
define('MODULE_PAYMENT_SPB2B_DELIVERY_HINT', "<p style='color:red;'>Shipping is exclusively to the specified billing address.</p>");
define('MODULE_PAYMENT_SPB2B_DEMO_HINT', "\n\nAttention, transaction executed in demo mode!\n");

define('MODULE_PAYMENT_SPB2B_CONFIRMATION_URL', "Mark invoice payment as payable");
define('MODULE_PAYMENT_SPB2B_SHOW_QRCODE_TITLE', 'Show QR code');
define('MODULE_PAYMENT_SPB2B_SHOW_QRCODE_DESC', 'Do you want to show a QR code on the invoice?');
define('MODULE_PAYMENT_SPB2B_QRCODE_DESC', 'For a convenient online payment you can use the following web address or just scan the QR code with a web-enabled smartphone.');
define('MODULE_PAYMENT_SPB2B_QRCODE_PDF_DESC', 'For a convenient online payment you can use the following web address or just scan the QR code with a web-enabled smartphone.');
define('MODULE_PAYMENT_SPB2B_QRCODE_PDF_HINT', ' - please see last page for additional information.');

define('MODULE_PAYMENT_SPB2B_KONTO_NR_TITLE', "Account no.");
define('MODULE_PAYMENT_SPB2B_KONTO_NR_DESC', "Account no. for invoicing");
define('MODULE_PAYMENT_SPB2B_BLZ_TITLE', "Bank code");
define('MODULE_PAYMENT_SPB2B_BLZ_DESC', "Bank code for invoicing");
define('MODULE_PAYMENT_SPB2B_BANKNAME_TITLE', "Bank name");
define('MODULE_PAYMENT_SPB2B_BANKNAME_DESC', "Bank name for invoicing");
define('MODULE_PAYMENT_SPB2B_IBAN_TITLE', "IBAN");
define('MODULE_PAYMENT_SPB2B_IBAN_DESC', "IBAN for invoicing");
define('MODULE_PAYMENT_SPB2B_BIC_TITLE', "BIC");
define('MODULE_PAYMENT_SPB2B_BIC_DESC', "BIC for invoicing");

define('MODULE_PAYMENT_SPB2B_INVOICE_TEXT', "The invoice amount was assigned to [recipient_legal]. <br><b>Payments with debt-discharging effect may only be made to the following account:</b><br><br>Account holder: ");
define('MODULE_PAYMENT_SPB2B_INVOICE_TEXT_PDF', "The invoice amount was assigned to [recipient_legal]. Payments with debt-discharging effect may only be made to the following account:\n\nAccount holder: ");
define('MODULE_PAYMENT_SPB2B_INVOICE_TEXT_PDF_HINT', "The invoice amount was assigned to [account_owner]. Please pay to the following account:");
define('MODULE_PAYMENT_SPB2B_INVOICE_URL_HINT', "or use the following link:");
define('MODULE_PAYMENT_SPB2B_INVOICE_PURPOSE', "Reference");

define('MODULE_PAYMENT_SPB2B_DELIVERY_DISABLE_TITLE', 'Deactivate payment method with deviating delivery address.');
define('MODULE_PAYMENT_SPB2B_DELIVERY_DISABLE_DESC', 'Do you want to deactivate this payment method with deviating delivery address? Alternatively, a hint can be displayed.');

define('MODULE_PAYMENT_SPB2B_DUE_DATE_TEXT', 'Due 10 days after delivery.');
define('MODULE_PAYMENT_SPB2B_DUE_DATE_TEXT_PDF', 'Due 10 days after delivery.');
define('MODULE_PAYMENT_SPB2B_DUE_DATE_TITLE', 'Show payment term');
define('MODULE_PAYMENT_SPB2B_DUE_DATE_DESC', 'Do you want to show the payment term on the invoice?');

define('MODULE_PAYMENT_SPB2B_PAYMENTINFO_TO_COMMENT_TITLE', 'Add payment information to the order comment.');
define('MODULE_PAYMENT_SPB2B_PAYMENTINFO_TO_COMMENT_DESC', 'This option is not compatible with all shop versions! Please choose the suitable option for your commodities management.');

define('MODULE_PAYMENT_SPB2B_MIN_AMOUNT_TITLE', 'Minimum order amount');
define('MODULE_PAYMENT_SPB2B_MIN_AMOUNT_DESC', 'Minimum order amount at which the payment method is displayed. Hint: Use value with dot as decimal mark.');

define('MODULE_PAYMENT_SPB2B_MAX_AMOUNT_TITLE', 'Maximum order amount');
define('MODULE_PAYMENT_SPB2B_MAX_AMOUNT_DESC', 'Maximum order amount to which the payment method is displayed. Hint: Use value with dot as decimal mark. Value 0 is for no limit.');

define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_TITLE', 'Save order before payment');
define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_DESC', 'The order will be saved in the shop system before the payment process is finished. This setting is valid for all secupay payment methods.');

define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_TITLE', 'Sending of tracking information automatically');
define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_DESC', 'The tracking information will automatically be sent to secupay. (This setting is valid for all secupay payment methods.)');

define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_TITLE', 'Rating');
define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_DESC', 'Inform us about your payment experiences with the customer. (Requires a corresponding activation for your contract. This setting is valid for all secupay payment methods.)');

define('MODULE_PAYMENT_SECUPAY_RAUTOSEND_TITLE', 'Send the invoice number instead of the order number');
define('MODULE_PAYMENT_SECUPAY_RAUTOSEND_DESC', 'Is this option activated the invoice number will be sent with the automatic shipping notification instead of the order number.');

define('MODULE_PAYMENT_SECUPAY_VAUTOSEND_TITLE', 'Automatic shipping notification for invoice payments');
define('MODULE_PAYMENT_SECUPAY_VAUTOSEND_DESC', 'The shipping notification will automatically be sent to secupay. Tracking information should already be entered.');

define('MODULE_PAYMENT_SECUPAY_SESSION_TITLE', 'Session time');
define('MODULE_PAYMENT_SECUPAY_SESSION_DESC', 'Keeps the buyer&#39;s session active in the shop during the payment process for the specified time (in ms). Value 0 deactivates this function.');

define('MODULE_PAYMENT_SPB2B_SELECT_NAME_TITLE', 'B2B Select');
define('MODULE_PAYMENT_SPB2B_SELECT_NAME_DESC', 'e.g. customer_b2b_status or customer_vat_id for tax id.');
define('MODULE_PAYMENT_SPB2B_ONEPAGE_TITLE', 'B2B Onepage');
define('MODULE_PAYMENT_SPB2B_ONEPAGE_NAME_DESC', 'activate if B2B Select should not be used e.g. to display payment methods with JS in the template.');

define('MODULE_PAYMENT_SECUPAY_OWNER_TITLE', 'Recipient');
define('MODULE_PAYMENT_SECUPAY_ADMIN_INFO_BLOCK', 'secupay payment information');
define('MODULE_PAYMENT_SECUPAY_ADMIN_TANR', 'Transaction code:');
define('MODULE_PAYMENT_SECUPAY_ADMIN_STATUS', 'Payment status:');

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

define('MODULE_PAYMENT_SPKK_TEXT_TITLE', 'Credit Card');
define('MODULE_PAYMENT_SPKK_TEXT_DESCRIPTION', "Credit card - pay simple and safe");
define('MODULE_PAYMENT_SPKK_TEXT_ERROR', 'Error in payment process!');

define('MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS_TITLE', 'Credit card');
define('MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS_DESC', 'Do you want to handle credit card payments with secupay?');

define('MODULE_PAYMENT_SPKK_ZONE_TITLE', 'Payment zone');
define('MODULE_PAYMENT_SPKK_ZONE_DESC', 'For which zone should Credit card payment be displayed?');

define('MODULE_PAYMENT_SECUPAY_APIKEY_TITLE', 'API.key');
define('MODULE_PAYMENT_SECUPAY_APIKEY_DESC', 'Your secupay API.key');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ID_TITLE', 'Order status after order is submitted');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ID_DESC', '');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID_TITLE', 'Order status after successful transactions');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID_DESC', '');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID_TITLE', 'Order status for denied transactions');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID_DESC', '');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID_TITLE', 'Order status for payment issues');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID_DESC', 'e.g. chargebacks');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID_TITLE', 'Order status for cancelled transactions');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID_DESC', '');

define('MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID_TITLE', 'Order status for pre-authorized transactions');
define('MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID_DESC', '');

define('MODULE_PAYMENT_SPKK_SORT_ORDER_TITLE', 'Display order');
define('MODULE_PAYMENT_SPKK_SORT_ORDER_DESC', 'At which position should this payment method be displayed? (lower values first)');

define('MODULE_PAYMENT_SPKK_SIMULATION_MODE_TITLE', 'Mode');
define('MODULE_PAYMENT_SPKK_SIMULATION_MODE_DESC', 'Set operation mode here (demo/live).');

define('MODULE_PAYMENT_SPKK_LOGGING_TITLE', 'Debug mode');
define('MODULE_PAYMENT_SPKK_LOGGING_DESC', 'Please activate this function only after consulting our support team.');

define('MODULE_PAYMENT_SPKK_SHOPNAME_TITLE', 'Shop name');
define('MODULE_PAYMENT_SPKK_SHOPNAME_DESC', 'Do you want to state a different shop name in the payment reference?');

define('MODULE_PAYMENT_SPKK_PREAUTH_TITLE', 'Pre-authorization');
define('MODULE_PAYMENT_SPKK_PREAUTH_DESC', 'Do you only want to make a payment-reservation at this time?');

define('MODULE_PAYMENT_SPKK_BID_TITLE', 'Bidirectionality');
define('MODULE_PAYMENT_SPKK_BID_DESC', 'activate bidirectional communication with secupay');

define('MODULE_PAYMENT_SPKK_MWST_TITLE', 'VAT for shipping costs');
define('MODULE_PAYMENT_SPKK_MWST_DESC', 'Do you want to calculate VAT for shipping costs separately? (Useful if there are errors in the shop&#39;s system.)');

define('MODULE_PAYMENT_SPKK_WARNDELIVERY_TITLE', 'Warning notice with deviating delivery address');
define('MODULE_PAYMENT_SPKK_WARNDELIVERY_DESC', 'Do you want to display a warning notice with deviating delivery address?');

define('MODULE_PAYMENT_SECUPAY_KK_XTC_ALLOWED', '');
define('MODULE_PAYMENT_SECUPAY_KK_XTC_TEXT_TITLE', 'Credit card');
define('MODULE_PAYMENT_SPKK_HINT', "<span style='color:red;'>Hint</span>");
define('MODULE_PAYMENT_SPKK_DELIVERY_HINT', "<p style='color:red;'>Shipping is exclusively to the specified billing address.</p>");
define('MODULE_PAYMENT_SPKK_DEMO_HINT', "\n\nAttention, transaction executed in demo mode!\n");

define('MODULE_PAYMENT_SECUPAY_SPKK_TEXT_INFO', 'Pay easily and securely with your credit card.');

define('MODULE_PAYMENT_SPKK_DELIVERY_DISABLE_TITLE', 'Deactivate payment method with deviating delivery address.');
define('MODULE_PAYMENT_SPKK_DELIVERY_DISABLE_DESC', 'Do you want to deactivate this payment method with deviating delivery address? Alternatively, a hint can be displayed.');

define('MODULE_PAYMENT_SPKK_MIN_AMOUNT_TITLE', 'Minimum order amount');
define('MODULE_PAYMENT_SPKK_MIN_AMOUNT_DESC', 'Minimum order amount at which the payment method is displayed. Hint: Use value with dot as decimal mark.');

define('MODULE_PAYMENT_SPKK_MAX_AMOUNT_TITLE', 'Maximum order amount');
define('MODULE_PAYMENT_SPKK_MAX_AMOUNT_DESC', 'Maximum order amount to which the payment method is displayed. Hint: Use value with dot as decimal mark. Value 0 is for no limit.');

define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_TITLE', 'Save order before payment');
define('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT_DESC', 'The order will be saved in the shop system before the payment process is finished. This setting is valid for all secupay payment methods.');

define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_TITLE', 'Sending of tracking information automatically');
define('MODULE_PAYMENT_SECUPAY_TAUTOSEND_DESC', 'The tracking information will automatically be sent to secupay. (This setting is valid for all secupay payment methods.)');

define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_TITLE', 'Rating');
define('MODULE_PAYMENT_SECUPAY_EXPERIENCE_DESC', 'Inform us about your payment experiences with the customer. (Requires a corresponding activation for your contract. This setting is valid for all secupay payment methods.)');

define('MODULE_PAYMENT_SECUPAY_SESSION_TITLE', 'Session time');
define('MODULE_PAYMENT_SECUPAY_SESSION_DESC', 'Keeps the buyer&#39;s session active in the shop during the payment process for the specified time (in ms). Value 0 deactivates this function.');

define('MODULE_PAYMENT_SECUPAY_OWNER_TITLE', 'Recipient');
define('MODULE_PAYMENT_SECUPAY_ADMIN_INFO_BLOCK', 'secupay payment information');
define('MODULE_PAYMENT_SECUPAY_ADMIN_TANR', 'Transaction code:');
define('MODULE_PAYMENT_SECUPAY_ADMIN_STATUS', 'Payment status:');

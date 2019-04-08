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

include('includes/application_top.php');

if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}

$logme = MODULE_PAYMENT_SPKK_LOGGING == "Ja";
unset($_SESSION['iframe_link']);

if ($_SESSION['uid'] == $_REQUEST['uid']) {

    // when uid matches, we check transaction status on secupay, if accepted, then everything is ok
    $data = array();
    $data['hash'] = $_SESSION['sp_hash'];
    //save transaction_id
    $order_payment_method_q = @xtc_db_query("SELECT payment_method FROM secupay_transactions WHERE `hash` = '{$data['hash']}'");
    $order_payment_method_row = @xtc_db_fetch_array($order_payment_method_q);
    $order_payment_method = $order_payment_method_row['payment_method'];
    $data['apikey'] = MODULE_PAYMENT_SECUPAY_APIKEY;
    if ($order_payment_method == 'secupay_b2b_xtc') {
        $data['apikey'] = MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
    }
    $data['amount'] = $_SESSION['sp_amount'];
    $request = array();
    $request['data'] = $data;
    $sp_api = new secupay_api($request, 'status/' . $data['hash'], 'application/json', $logme);
    $response = $sp_api->request();

    if (isset($response->data->trans_id) && !empty($response->data->trans_id)) {
        try {
            @xtc_db_query("UPDATE secupay_transaction_order SET transaction_id=" . intval($response->data->trans_id) . " WHERE hash ='" . xtc_db_input($data['hash']) . "'");
            @xtc_db_query("UPDATE secupay_transactions SET transaction_id=" . intval($response->data->trans_id) . " WHERE hash ='" . xtc_db_input($data['hash']) . "'");
        } catch (Exception $e) {
            secupay_log($logme, ' secupay_checkout_success - update trans_id - EXCEPTION: ' . $e->getMessage());
        }
    }
    // check API response
    if (isset($response->data->status) && ($response->data->status == 'accepted' || $response->data->status == 'authorized' || ($response->data->status == 'scored' && $order_payment_method == 'secupay_pp_xtc'))) {
        $_SESSION['sp_success'] = true;
        header("Location: " . xtc_href_link(FILENAME_CHECKOUT_PROCESS, "", "SSL"));
        echo("Sollten Sie nicht automatisch weitergeleitet werden, klicken sie bitte auf <a href='" . xtc_href_link(
            FILENAME_CHECKOUT_PROCESS,
            "",
                "SSL"
        ) . "'>Weiterleiten</a>");
        die();
    }
} else {
    secupay_log($logme, "Request array:");
    secupay_log($logme, $_REQUEST);
}
// attempt to display user friendly error message
if (isset($response->data->status)) {
    $_REQUEST['ERRORCODE'] = 1;
    $_REQUEST['ERROR'] = 'Failed,' . urlencode('Transaktion fehlgeschlagen: ');
}

$error = "(" . $_REQUEST['ERRORCODE'] . ") " . $_REQUEST['ERROR'];
if (!isset($_REQUEST['ERROR'])) {
    $error = urlencode('Transaktion fehlgeschlagen.');
}
$payment_error_module = $_REQUEST['payment_error'];
$payment_error_return = 'payment_error=' . $payment_error_module . '&error=' . urlencode($error);
$_SESSION['sp_success'] = false;

xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
echo("Sollten Sie nicht automatisch weitergeleitet werden, klicken sie bitte auf <a href='" . xtc_href_link(
    FILENAME_CHECKOUT_PAYMENT,
        $payment_error_return,
    "SSL"
) . "'>Weiterleiten</a>");
die();

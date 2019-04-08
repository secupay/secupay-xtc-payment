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

if (isset($order) && $order->info['payment_method'] == 'secupay_inv_xtc') {
    include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_inv_xtc.php');
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $invoice_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $invoice_hash_result = xtc_db_fetch_array($invoice_hash_query);
    if (isset($invoice_hash_result['hash'])) {
        $secupay_capture_url = SECUPAY_URL . $invoice_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">' . MODULE_PAYMENT_SPINV_CONFIRMATION_URL . '</a>
                </td>
              </tr>';
    }
}
if (isset($order) && $order->info['payment_method'] == 'secupay_b2b_xtc') {
    include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_b2b_xtc.php');
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $invoice_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $invoice_hash_result = xtc_db_fetch_array($invoice_hash_query);
    if (isset($invoice_hash_result['hash'])) {
        $secupay_capture_url = SECUPAY_URL . $invoice_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">' . MODULE_PAYMENT_SPB2B_CONFIRMATION_URL . '</a>
                </td>
              </tr>';
    }
}
if (isset($order) && $order->info['payment_method'] == 'secupay_ls_xtc') {
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $debit_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $debit_hash_result = xtc_db_fetch_array($debit_hash_query);
    if (isset($debit_hash_result['hash'])) {
        $secupay_capture_url = SECUPAY_URL . $debit_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">Capture Lastschrift</a>
                </td>
              </tr>';
    }
}
if (isset($order) && $order->info['payment_method'] == 'secupay_kk_xtc') {
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $creditcard_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $creditcard_hash_result = xtc_db_fetch_array($creditcard_hash_query);
    if (isset($creditcard_hash_result['hash'])) {
        $creditcard_capture_url = SECUPAY_URL . $creditcard_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">Capture Kreditkarte</a>
                </td>
              </tr>';
    }
}
if (isset($order) && $order->info['payment_method'] == 'secupay_sk_xtc') {
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $sofort_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $sofort_hash_result = xtc_db_fetch_array($sofort_hash_query);
    if (isset($debit_hash_result['hash'])) {
        $secupay_capture_url = SECUPAY_URL . $sofort_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">Capture Sofortueberweisung</a>
                </td>
              </tr>';
    }
}
if (isset($order) && $order->info['payment_method'] == 'secupay_pp_xtc') {
    include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_pp_xtc.php');
    include_once("../" . DIR_WS_CLASSES . 'secupay_api.php');

    $prepay_hash_query = xtc_db_query("SELECT hash AS hash FROM secupay_transaction_order WHERE ordernr = " . intval($_GET['oID']) . ";");
    $prepay_hash_result = xtc_db_fetch_array($prepay_hash_query);
    if (isset($prepay_hash_result['hash'])) {
        $secupay_capture_url = SECUPAY_URL . $prepay_hash_result['hash'] . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
        echo '<tr>
                <td class="button">
                <a href=" ' . $secupay_capture_url . '" target="_blank">' . MODULE_PAYMENT_SPPP_CONFIRMATION_URL . '</a>
                </td>
              </tr>';
    }
}

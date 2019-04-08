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

//add iFrame URL to invoice
if (isset($order) && $order->info['payment_method'] === 'secupay_inv_xtc') {
    require_once('secupay_invoice_data.php');

    $hash = secupay_get_hash(intval($_GET['oID']));
    $invoice_data = secupay_get_invoice_data($hash);

    $show_due_date = strcmp(MODULE_PAYMENT_SPINV_DUE_DATE, 'Ja') == 0;
    if ($show_due_date) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPINV_DUE_DATE_TEXT . '<br>';
    }
    $secupay_payment_info .= '<br>' . str_replace(
        '[recipient_legal]',
        utf8_decode($invoice_data->recipient_legal),
            MODULE_PAYMENT_SPINV_INVOICE_TEXT
    );
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPINV_BANKNAME_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPINV_IBAN_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
    $secupay_payment_info .= ', ' . MODULE_PAYMENT_SPINV_BIC_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
    $secupay_payment_info .= '<br><br><b>' . MODULE_PAYMENT_SPINV_INVOICE_PURPOSE . ': ';
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->purpose);
    $secupay_payment_info .= '</b><br>';

    $show_qrcode = strcmp(MODULE_PAYMENT_SPINV_SHOW_QRCODE, 'Ja') == 0;
    if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPINV_QRCODE_DESC . '<br>' . $invoice_data->payment_link;
        $secupay_payment_info_qr_code .= '<br><img alt="" style="border:0;" src="' . $invoice_data->payment_qr_image_url . '"/>';
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_pp_xtc') {
    require_once('secupay_invoice_data.php');

    $hash = secupay_get_hash(intval($_GET['oID']));
    $invoice_data = secupay_get_invoice_data($hash);

    $show_due_date = strcmp(MODULE_PAYMENT_SPPP_DUE_DATE, 'Ja') == 0;
    if ($show_due_date) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPPP_DUE_DATE_TEXT . '<br>';
    }
    $secupay_payment_info .= '<br>' . str_replace('[recipient_legal]', utf8_decode($invoice_data->recipient_legal), MODULE_PAYMENT_SPPP_INVOICE_TEXT);
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPPP_BANKNAME_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPPP_IBAN_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
    $secupay_payment_info .= ', ' . MODULE_PAYMENT_SPPP_BIC_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
    $secupay_payment_info .= '<br><br><b>' . MODULE_PAYMENT_SPPP_INVOICE_PURPOSE . ': ';
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->purpose);
    $secupay_payment_info .= '</b><br>';

    $show_qrcode = strcmp(MODULE_PAYMENT_SPPP_SHOW_QRCODE, 'Ja') == 0;
    if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPPP_QRCODE_DESC . '<br>' . $invoice_data->payment_link;
        $secupay_payment_info_qr_code .= '<br><img alt="" style="border:0;" src="' . $invoice_data->payment_qr_image_url . '"/>';
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_b2b_xtc') {
    require_once('secupay_invoice_data.php');

    $hash = secupay_get_hash(intval($_GET['oID']));
    $invoice_data = secupay_get_invoice_data($hash);

    $show_due_date = strcmp(MODULE_PAYMENT_SPB2B_DUE_DATE, 'Ja') == 0;
    if ($show_due_date) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPB2B_DUE_DATE_TEXT . '<br>';
    }
    $secupay_payment_info .= '<br>' . str_replace(
        '[recipient_legal]',
        utf8_decode($invoice_data->recipient_legal),
            MODULE_PAYMENT_SPB2B_INVOICE_TEXT
    );
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPB2B_BANKNAME_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
    $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPB2B_IBAN_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
    $secupay_payment_info .= ', ' . MODULE_PAYMENT_SPB2B_BIC_TITLE . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
    $secupay_payment_info .= '<br><br><b>' . MODULE_PAYMENT_SPB2B_INVOICE_PURPOSE . ': ';
    $secupay_payment_info .= utf8_decode($invoice_data->transfer_payment_data->purpose);
    $secupay_payment_info .= '</b><br>';

    $show_qrcode = strcmp(MODULE_PAYMENT_SPINV_SHOW_QRCODE, 'Ja') == 0;
    if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
        $secupay_payment_info .= '<br>' . MODULE_PAYMENT_SPB2B_QRCODE_DESC . '<br>' . $invoice_data->payment_link;
        $secupay_payment_info_qr_code .= '<br><img alt="" style="border:0;" src="' . $invoice_data->payment_qr_image_url . '"/>';
    }
}

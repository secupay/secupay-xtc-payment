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
    if (isset($order_info)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $show_due_date = strcmp(MODULE_PAYMENT_SPINV_DUE_DATE, 'Ja') == 0;
        if ($show_due_date) {
            $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPINV_DUE_DATE_TEXT_PDF);
        }

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . str_replace(
            '[account_owner]',
            $invoice_data->transfer_payment_data->accountowner,
                MODULE_PAYMENT_SPINV_INVOICE_TEXT_PDF_HINT
        ));
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPINV_BANKNAME_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPINV_IBAN_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
        $order_info['PAYMENT_METHOD'][1] .= ', ' . utf8_decode(MODULE_PAYMENT_SPINV_BIC_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPINV_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $order_info['PAYMENT_METHOD'][1] .= "\n";

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode(MODULE_PAYMENT_SPINV_INVOICE_URL_HINT) . ' ' . $invoice_data->payment_link;

        $order_info['PAYMENT_METHOD'][1] .= "\n" . utf8_decode(MODULE_PAYMENT_SPINV_QRCODE_PDF_HINT);
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_b2b_xtc') {
    if (isset($order_info)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $show_due_date = strcmp(MODULE_PAYMENT_SPB2B_DUE_DATE, 'Ja') == 0;
        if ($show_due_date) {
            $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPB2B_DUE_DATE_TEXT_PDF);
        }

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . str_replace(
            '[account_owner]',
            $invoice_data->transfer_payment_data->accountowner,
                MODULE_PAYMENT_SPB2B_INVOICE_TEXT_PDF_HINT
        ));
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPB2B_BANKNAME_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPB2B_IBAN_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
        $order_info['PAYMENT_METHOD'][1] .= ', ' . utf8_decode(MODULE_PAYMENT_SPB2B_BIC_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPB2B_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $order_info['PAYMENT_METHOD'][1] .= "\n";

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode(MODULE_PAYMENT_SPB2B_INVOICE_URL_HINT) . ' ' . $invoice_data->payment_link;

        $order_info['PAYMENT_METHOD'][1] .= "\n" . utf8_decode(MODULE_PAYMENT_SPB2B_QRCODE_PDF_HINT);
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_pp_xtc') {
    if (isset($order_info)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $show_due_date = strcmp(MODULE_PAYMENT_SPPP_DUE_DATE, 'Ja') == 0;
        if ($show_due_date) {
            $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPPP_DUE_DATE_TEXT_PDF);
        }

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . str_replace(
            '[account_owner]',
            $invoice_data->transfer_payment_data->accountowner,
                MODULE_PAYMENT_SPINV_INVOICE_TEXT_PDF_HINT
        ));
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPPP_BANKNAME_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bankname);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPPP_IBAN_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->iban);
        $order_info['PAYMENT_METHOD'][1] .= ', ' . utf8_decode(MODULE_PAYMENT_SPPP_BIC_TITLE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->bic);
        $order_info['PAYMENT_METHOD'][1] .= utf8_decode("\n" . MODULE_PAYMENT_SPPP_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $order_info['PAYMENT_METHOD'][1] .= "\n";

        $order_info['PAYMENT_METHOD'][1] .= utf8_decode(MODULE_PAYMENT_SPPP_INVOICE_URL_HINT) . ' ' . $invoice_data->payment_link;

        $order_info['PAYMENT_METHOD'][1] .= "\n" . utf8_decode(MODULE_PAYMENT_SPPP_QRCODE_PDF_HINT);
    }
}

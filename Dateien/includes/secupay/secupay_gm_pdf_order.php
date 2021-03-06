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
    if (isset($pdf)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $pdf->pdf_is_attachment = MODULE_PAYMENT_SPINV_TEXT_TITLE;
        $pdf->AddPage();

        $secupay_invoice_text = utf8_decode(str_replace('[recipient_legal]', $invoice_data->recipient_legal, MODULE_PAYMENT_SPINV_INVOICE_TEXT_PDF));
        $secupay_invoice_text .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_text, 0, 'L', 0);
        $secupay_invoice_account_info = utf8_decode(MODULE_PAYMENT_SPINV_BANKNAME_TITLE . ': ' . $invoice_data->transfer_payment_data->bankname);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_info, 0, 'L', 0);
        $pdf->Ln(3);
        $secupay_invoice_account_iban = utf8_decode(MODULE_PAYMENT_SPINV_IBAN_TITLE . ': ' . $invoice_data->transfer_payment_data->iban);
        $secupay_invoice_account_iban .= utf8_decode(', ' . MODULE_PAYMENT_SPINV_BIC_TITLE . ': ' . $invoice_data->transfer_payment_data->bic);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_iban, 0, 'L', 0);
        $pdf->Ln(3);

        $secupay_invoice_purpose = utf8_decode(MODULE_PAYMENT_SPINV_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_purpose);

        $show_qrcode = strcmp(MODULE_PAYMENT_SPINV_SHOW_QRCODE, 'Ja') == 0;
        if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
            $secupay_invoice_hint = utf8_decode(MODULE_PAYMENT_SPINV_QRCODE_PDF_DESC);
            $qr_code = $invoice_data->payment_qr_image_url;

            if (isset($qr_code)) {
                $qr_code_size = getimagesize($qr_code);
                $pdf->Image($qr_code, $pdf->GetX(), $pdf->GetY(), 25, 25, substr(strrchr($qr_code_size['mime'], '/'), 1));
                $pdf->Ln(3);
            }
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_hint, 0, 'L', 0);
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $invoice_data->payment_link, 0, 'L', 0);
        }
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_b2b_xtc') {
    if (isset($pdf)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $pdf->pdf_is_attachment = MODULE_PAYMENT_SPB2B_TEXT_TITLE;
        $pdf->AddPage();

        $secupay_invoice_text = utf8_decode(str_replace('[recipient_legal]', $invoice_data->recipient_legal, MODULE_PAYMENT_SPB2B_INVOICE_TEXT_PDF));
        $secupay_invoice_text .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_text, 0, 'L', 0);
        $secupay_invoice_account_info = utf8_decode(MODULE_PAYMENT_SPB2B_BANKNAME_TITLE . ': ' . $invoice_data->transfer_payment_data->bankname);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_info, 0, 'L', 0);
        $pdf->Ln(3);
        $secupay_invoice_account_iban = utf8_decode(MODULE_PAYMENT_SPB2B_IBAN_TITLE . ': ' . $invoice_data->transfer_payment_data->iban);
        $secupay_invoice_account_iban .= utf8_decode(', ' . MODULE_PAYMENT_SPB2B_BIC_TITLE . ': ' . $invoice_data->transfer_payment_data->bic);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_iban, 0, 'L', 0);
        $pdf->Ln(3);

        $secupay_invoice_purpose = utf8_decode(MODULE_PAYMENT_SPB2B_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_purpose);

        $show_qrcode = strcmp(MODULE_PAYMENT_SPB2B_SHOW_QRCODE, 'Ja') == 0;
        if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
            $secupay_invoice_hint = utf8_decode(MODULE_PAYMENT_SPB2B_QRCODE_PDF_DESC);
            $qr_code = $invoice_data->payment_qr_image_url;

            if (isset($qr_code)) {
                $qr_code_size = getimagesize($qr_code);
                $pdf->Image($qr_code, $pdf->GetX(), $pdf->GetY(), 25, 25, substr(strrchr($qr_code_size['mime'], '/'), 1));
                $pdf->Ln(3);
            }
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_hint, 0, 'L', 0);
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $invoice_data->payment_link, 0, 'L', 0);
        }
    }
}
if (isset($order) && $order->info['payment_method'] === 'secupay_pp_xtc') {
    if (isset($pdf)) {
        require_once('secupay_invoice_data.php');

        $hash = secupay_get_hash(intval($_GET['oID']));
        $invoice_data = secupay_get_invoice_data($hash);

        $pdf->pdf_is_attachment = MODULE_PAYMENT_SPPP_TEXT_TITLE;
        $pdf->AddPage();

        $secupay_invoice_text = utf8_decode(str_replace('[recipient_legal]', $invoice_data->recipient_legal, MODULE_PAYMENT_SPPP_INVOICE_TEXT_PDF));
        $secupay_invoice_text .= utf8_decode($invoice_data->transfer_payment_data->accountowner);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_text, 0, 'L', 0);
        $secupay_invoice_account_info = utf8_decode(MODULE_PAYMENT_SPPP_BANKNAME_TITLE . ': ' . $invoice_data->transfer_payment_data->bankname);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_info, 0, 'L', 0);
        $pdf->Ln(3);
        $secupay_invoice_account_iban = utf8_decode(MODULE_PAYMENT_SPPP_IBAN_TITLE . ': ' . $invoice_data->transfer_payment_data->iban);
        $secupay_invoice_account_iban .= utf8_decode(', ' . MODULE_PAYMENT_SPPP_BIC_TITLE . ': ' . $invoice_data->transfer_payment_data->bic);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_account_iban, 0, 'L', 0);
        $pdf->Ln(3);

        $secupay_invoice_purpose = utf8_decode(MODULE_PAYMENT_SPPP_INVOICE_PURPOSE) . ': ' . utf8_decode($invoice_data->transfer_payment_data->purpose);
        $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_purpose);

        $show_qrcode = strcmp(MODULE_PAYMENT_SPPP_SHOW_QRCODE, 'Ja') == 0;
        if ($show_qrcode && isset($invoice_data->payment_link) && isset($invoice_data->payment_qr_image_url)) {
            $secupay_invoice_hint = utf8_decode(MODULE_PAYMENT_SPPP_QRCODE_PDF_DESC);
            $qr_code = $invoice_data->payment_qr_image_url;

            if (isset($qr_code)) {
                $qr_code_size = getimagesize($qr_code);
                $pdf->Image($qr_code, $pdf->GetX(), $pdf->GetY(), 25, 25, substr(strrchr($qr_code_size['mime'], '/'), 1));
                $pdf->Ln(3);
            }
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $secupay_invoice_hint, 0, 'L', 0);
            $pdf->MultiCell($pdf->getInnerWidth(), $pdf->getCellHeight(), $invoice_data->payment_link, 0, 'L', 0);
        }
    }
}

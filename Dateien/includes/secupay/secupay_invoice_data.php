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

/* include api class, include path in "admin" mode differs from "shop" mode */
if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}


if (!function_exists('secupay_get_hash')) {
    /**
     * @param $oID
     *
     * @return bool
     */
    function secupay_get_hash($oID)
    {
        $invoice_transaction_query = xtc_db_query("SELECT hash FROM secupay_transaction_order WHERE ordernr = " . intval($oID) . ";");
        $invoice_transaction_result = xtc_db_fetch_array($invoice_transaction_query);

        if (isset($invoice_transaction_result['hash'])) {
            return $invoice_transaction_result['hash'];
        }
        return false;
    }
}
if (!function_exists('secupay_get_b2b_apikey')) {
    /**
     * @param $hash
     *
     * @return mixed
     */
    function secupay_get_b2b_apikey($hash)
    {
        $invoice_transaction_query = xtc_db_query("SELECT payment_method FROM secupay_transactions WHERE hash = '" . $hash . "';");
        $invoice_transaction_result = xtc_db_fetch_array($invoice_transaction_query);
        if ($invoice_transaction_result['payment_method'] == 'secupay_b2b_xtc') {
            return MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
        } else {
            return MODULE_PAYMENT_SECUPAY_APIKEY;
        }
    }
}
if (!function_exists('secupay_get_invoice_data')) {
    /**
     * @param $hash
     *
     * @return bool
     */
    function secupay_get_invoice_data($hash)
    {
        if (!empty($hash)) {
            $data = array();
            $data['hash'] = $hash;
            $data['apikey'] = secupay_get_b2b_apikey($hash);
            $request = array();
            $request['data'] = $data;
            $sp_api = new secupay_api($request, 'status');
            $response = $sp_api->request();

            if (isset($response->status) && $response->status == 'ok' && isset($response->data->opt)) {
                return $response->data->opt;
            }
        }
        return false;
    }
}
if (!function_exists('secupay_get_status_data')) {
    /**
     * @param $hash
     *
     * @return bool
     */
    function secupay_get_status_data($hash)
    {
        if (!empty($hash)) {
            $data = array();
            $data['hash'] = $hash;
            $data['apikey'] = secupay_get_b2b_apikey($hash);

            $request = array();
            $request['data'] = $data;

            $sp_api = new secupay_api($request, 'status');
            $response = $sp_api->request();

            if (isset($response->status) && $response->status == 'ok' && isset($response->data->status)) {
                return $response->data->status;
            }
        }
        return false;
    }
}

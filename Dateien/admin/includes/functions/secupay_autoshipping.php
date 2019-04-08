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

if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}
/**
 *
 */
function sendautoshipping()
{
    if (MODULE_PAYMENT_SECUPAY_TAUTOSEND || MODULE_PAYMENT_SECUPAY_VAUTOSEND) {
        $qry = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE 'dpd_tracking_id'");
        $result = xtc_db_fetch_array($qry);
        if (isset($result['Field'])) {
            $shop = 'XTCw';
        }
        if (!isset($result['Field'])) {
            $shop = 'XTC';
        }
        $qry = xtc_db_query("SHOW TABLES LIKE 'orders_parcel_tracking_codes'");
        $result = xtc_db_num_rows($qry);
        if ($result > 0) {
            $shop = 'gambio';
        }
        $qry = xtc_db_query("SHOW TABLES LIKE 'orders_tracking'");
        $result = xtc_db_num_rows($qry);
        if ($result > 0) {
            $shop = 'XTCm';
        }
        if ($shop == 'gambio') {
            $strQuery = "
        SELECT
        o.orders_id,
        secupay.`hash`,
        tc.tracking_code,
        secupay.tracking_code AS stc,
        secupay.v_send,
        o.gm_orders_code,
        secupay.payment_method,
        tc.parcel_service_name
        FROM
        " . TABLE_ORDERS . " AS o
        INNER JOIN orders_parcel_tracking_codes AS tc ON tc.order_id = o.orders_id
        INNER JOIN secupay_transactions AS secupay ON secupay.ordernr = o.orders_id
        INNER JOIN " . TABLE_ORDERS_STATUS_HISTORY . " AS c ON c.orders_id = o.orders_id
        WHERE
        secupay.`status` = 'ok' AND 
        c.orders_status_id = 3 AND
        (tc.tracking_code <> secupay.tracking_code OR secupay.tracking_code IS NULL) AND
        NOT EXISTS (SELECT *
        FROM secupay_transaction_tracking AS A WHERE A.tracking_code = tc.tracking_code AND A.`hash` = secupay.`hash`)
        ";
        }
        if ($shop == 'XTC') {
            $strQuery = "SELECT
        c.orders_id,
        secupay.`hash`,
        secupay.payment_method
        FROM
        orders_status_history AS c
        INNER JOIN secupay_transactions AS secupay ON secupay.ordernr = c.orders_id
        WHERE
        c.orders_status_id = 3 AND
        secupay.v_send = 0 AND secupay.`status` = 'ok' OR c.orders_status_id = 3 AND
        secupay.v_send IS NULL AND secupay.`status` = 'ok'";
        }
        if ($shop == 'XTCw') {
            $strQuery = "SELECT
        c.orders_id,
        c.dhl_tracking_id,
        c.dpd_tracking_id,
        c.ups_tracking_id,
        c.spi_tracking_id,
        c.gls_tracking_id,
        c.hlg_tracking_id
        secupay.`hash`,
        secupay.payment_method
        FROM
        orders_status_history AS c
        INNER JOIN secupay_transactions AS secupay ON secupay.ordernr = c.orders_id
        WHERE
        c.orders_status_id = 3 AND
        secupay.v_send = 0 AND secupay.`status` = 'ok' OR c.orders_status_id = 3 AND
        secupay.v_send IS NULL AND secupay.`status` = 'ok'";
        }
        if ($shop == 'XTCm') {
            $qry = xtc_db_query("SHOW COLUMNS FROM orders_tracking LIKE 'ortra_parcel_id'");
            $result = xtc_db_fetch_array($qry);
            if (isset($result['Field'])) {
                $strQuery = "
                SELECT
                c.orders_id,
                secupay.`hash`,
                secupay.payment_method,
                ti.carrier_name AS parcel_service_name,
                tc.ortra_parcel_id AS tracking_code
                FROM
                " . TABLE_ORDERS_STATUS_HISTORY . " AS c
                INNER JOIN secupay_transactions AS secupay ON secupay.ordernr = c.orders_id
                INNER JOIN orders_tracking AS tc ON tc.ortra_order_id = c.orders_id
                INNER JOIN carriers AS ti ON ti.carrier_id = tc.ortra_carrier_id
                WHERE
                c.orders_status_id = 3 AND
                secupay.v_send = 0 AND secupay.`status` = 'ok' OR c.orders_status_id = 3 AND
                secupay.v_send IS NULL AND secupay.`status` = 'ok'
                ";
            } else {
                $strQuery = "
                SELECT
                c.orders_id,
                secupay.`hash`,
                secupay.payment_method,
                ti.carrier_name AS parcel_service_name,
                tc.parcel_id AS tracking_code
                FROM
                " . TABLE_ORDERS_STATUS_HISTORY . " AS c
                INNER JOIN secupay_transactions AS secupay ON secupay.ordernr = c.orders_id
                INNER JOIN orders_tracking AS tc ON tc.orders_id = c.orders_id
                INNER JOIN carriers AS ti ON ti.carrier_id = tc.carrier_id
                WHERE
                c.orders_status_id = 3 AND
                secupay.v_send = 0 AND secupay.`status` = 'ok' OR c.orders_status_id = 3 AND
                secupay.v_send IS NULL AND secupay.`status` = 'ok'
                ";
            }
        }
        if (file_exists(DIR_FS_CATALOG . 'release_info.php') && $shop != 'gambio') {
            include(DIR_FS_CATALOG . 'release_info.php');
            $shop = "Gambiotc";
        }
        if ($shop == 'XTC' || $shop == 'XTCw' || $shop == 'gambio' || $shop == 'XTCm') {
            $oldhash = null;
            $resQuery = xtc_db_query($strQuery);
            while ($arr = xtc_db_fetch_array($resQuery)) {
                unset($track);
                unset($paymentmethod);
                $paymentmethod = getPayment($arr['payment_method']);
                if ($arr['payment_method'] == 'secupay_b2b_xtc') {
                    $data['apikey'] = MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
                } else {
                    $data['apikey'] = MODULE_PAYMENT_SECUPAY_APIKEY;
                }
                $track['apikey'] = $data['apikey'];
                $track['hash'] = $arr['hash'];
                $track['invoice_number'] = $arr['orders_id'];
                if ($shop == 'XTCw1') {
                    if ($arr['dhl_tracking_id']) {
                        $arr['tracking_code'] = $arr['dhl_tracking_id'];
                        $arr['parcel_service_name'] = 'DHL';
                    }
                    if ($arr['dpd_tracking_id']) {
                        $arr['tracking_code'] = $arr['dpd_tracking_id'];
                        $arr['parcel_service_name'] = 'DPD';
                    }
                    if ($arr['ups_tracking_id']) {
                        $arr['tracking_code'] = $arr['ups_tracking_id'];
                        $arr['parcel_service_name'] = 'UPS';
                    }
                    if ($arr['spi_tracking_id']) {
                        $arr['tracking_code'] = $arr['spi_tracking_id'];
                        $arr['parcel_service_name'] = 'SPI';
                    }
                    if ($arr['gls_tracking_id']) {
                        $arr['tracking_code'] = $arr['gls_tracking_id'];
                        $arr['parcel_service_name'] = 'GLS';
                    }
                    if ($arr['hlg_tracking_id']) {
                        $arr['tracking_code'] = $arr['hlg_tracking_id'];
                        $arr['parcel_service_name'] = 'Hermes';
                    }
                }
                if ($shop == 'gambio' && $arr['gm_orders_code'] && MODULE_PAYMENT_SECUPAY_RAUTOSEND) {
                    $track['invoice_number'] = $arr['gm_orders_code'];
                }
                if ($shop == 'XTC') {
                    $arr['parcel_service_name'] = 'keiner';
                    $arr['tracking_code'] = 'keiner';
                }
                $provider = getCarrier($arr['tracking_code'], $arr['parcel_service_name']);
                if ($arr['tracking_code']) {
                    $track['tracking']['provider'] = $provider;
                    $track['tracking']['number'] = $arr['tracking_code'];
                    $requestData = array();
                    $requestData['data'] = $track;
                    if (!$arr['stc'] && $oldhash != $arr['hash']) {
                        $sql = "UPDATE secupay_transactions SET tracking_code = '" . $arr['tracking_code'] . "',carrier_code = '" . $provider . "',searchcode = '" . $track['invoice_number'] . "' WHERE HASH = '" . $track['hash'] . "'";
                        xtc_db_query($sql);
                        $sp_api = new secupay_api($requestData, $paymentmethod, 'application/json', 'versandautosend');
                        $api_return = $sp_api->request();
                        if ($api_return->status == 'ok' && $paymentmethod == 'capture') {
                            xtc_db_query("UPDATE secupay_transactions SET v_send = 1,v_status='" . $api_return->data->trans_id . "' WHERE hash = '" . $track['hash'] . "';");
                        } elseif ($api_return->status == 'ok' || utf8_decode($api_return->errors[0]->code) == '0014') {
                            xtc_db_query("UPDATE secupay_transactions SET v_send = 1 WHERE hash = '" . $track['hash'] . "';");
                        }
                    } elseif ($oldhash == $arr['hash'] || $arr['stc']) {
                        $sql = "INSERT INTO secupay_transaction_tracking (hash, tracking_code,carrier_code, timestamp) VALUES ('" . $track['hash'] . "', '" . $arr['tracking_code'] . "','" . $provider . "', NOW()) ";
                        xtc_db_query($sql);
                        $sp_api = new secupay_api($requestData, 'adddata', 'application/json', 'versandautosend');
                        $api_return = $sp_api->request();
                        if ($api_return->status == 'ok' || utf8_decode($api_return->errors[0]->code) == '0014') {
                            xtc_db_query("UPDATE secupay_transaction_tracking SET v_send = 1 WHERE hash = '" . $track['hash'] . "';");
                        }
                    }
                    $oldhash = $arr['hash'];
                }
            }
            $sql = "SELECT
            secupay.`hash`,
            secupay.v_send,
            secupay.payment_method,
            secupay.tracking_code,
            secupay.carrier_code,
            secupay.searchcode
            FROM
            secupay_transactions AS secupay
            WHERE
            secupay.v_send IS NULL AND secupay.tracking_code IS NOT NULL";
            setVsend($sql, 'secupay_transactions');
            $sql = "SELECT
            secupay.`hash`,
            secupay.v_send,
            secupay.tracking_code,
            secupay.carrier_code
            FROM
            secupay_transaction_tracking AS secupay
            WHERE
            secupay.v_send IS NULL AND secupay.tracking_code IS NOT NULL";
            setVsend($sql, 'secupay_transaction_tracking');
        }
    }
}

/**
 * @param $trackingnumber
 * @param $provider
 *
 * @return string
 */
function getCarrier($trackingnumber, $provider)
{
    if (
        preg_match("/^1Z\s?[0-9A-Z]{3}\s?[0-9A-Z]{3}\s?[0-9A-Z]{2}\s?[0-9A-Z]{4}\s?[0-9A-Z]{3}\s?[0-9A-Z]$/i", $trackingnumber)) {
        $resprovider = "UPS";
    } elseif (
        preg_match("/^\d{14}$/", $trackingnumber)) {
        if ($provider == 'DPD') {
            $resprovider = "DPD";
        } elseif ($provider == 'Hermes' || $provider == 'HLG') {
            $resprovider = "Hermes";
        } else {
            $resprovider = "HLG";
        }
    } elseif (
        preg_match("/^\d{11}$/", $trackingnumber)) {
        $resprovider = "GLS";
    } elseif (
        preg_match("/[A-Z]{3}\d{2}\.?\d{2}\.?(\d{3}\s?){3}/", $trackingnumber) ||
        preg_match("/[A-Z]{3}\d{2}\.?\d{2}\.?\d{3}/", $trackingnumber) ||
        preg_match("/(\d{12}|\d{16}|\d{20})/", $trackingnumber)) {
        $resprovider = "DHL";
    } elseif (
        preg_match("/RR\s?\d{4}\s?\d{5}\s?\d(?=DE)/", $trackingnumber) ||
        preg_match("/NN\s?\d{2}\s?\d{3}\s?\d{3}\s?\d(?=DE(\s)?\d{3})/", $trackingnumber) ||
        preg_match("/RA\d{9}(?=DE)/", $trackingnumber) || preg_match("/LX\d{9}(?=DE)/", $trackingnumber) ||
        preg_match("/LX\s?\d{4}\s?\d{4}\s?\d(?=DE)/", $trackingnumber) ||
        preg_match("/LX\s?\d{4}\s?\d{4}\s?\d(?=DE)/", $trackingnumber) ||
        preg_match("/XX\s?\d{2}\s?\d{3}\s?\d{3}\s?\d(?=DE)/", $trackingnumber) ||
        preg_match("/RG\s?\d{2}\s?\d{3}\s?\d{3}\s?\d(?=DE)/", $trackingnumber)) {
        $resprovider = "DPAG";
    } else {
        $resprovider = $provider;
    }
    return $resprovider;
}

/**
 * @param $payment
 *
 * @return string
 */
function getPayment($payment)
{
    if ($payment == 'secupay_inv_xtc' || $payment == 'secupay_b2b_xtc') {
        return 'capture';
    } else {
        return 'adddata';
    }
}

/**
 * @param $sql
 * @param $table
 */
function setVsend($sql, $table)
{
    $qry = xtc_db_query("SHOW COLUMNS FROM " . $table . " LIKE 'carrier_code'");
    $result = xtc_db_fetch_array($qry);
    if (isset($result['Field'])) {
        $resQuery = xtc_db_query($sql);
        while ($arr = xtc_db_fetch_array($resQuery)) {
            unset($track);
            unset($paymentmethod);
            $paymentmethod = getPayment($arr['payment_method']);
            if ($arr['payment_method'] == 'secupay_b2b_xtc') {
                $data['apikey'] = MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
            } else {
                $data['apikey'] = MODULE_PAYMENT_SECUPAY_APIKEY;
            }
            $track['apikey'] = $data['apikey'];
            $track['hash'] = $arr['hash'];
            $track['tracking']['provider'] = $arr['carrier_code'];
            $track['tracking']['number'] = $arr['tracking_code'];
            $track['invoice_number'] = $arr['searchcode'];
            $requestData = array();
            $requestData['data'] = $track;
            $sp_api = new secupay_api($requestData, $paymentmethod, 'application/json', 'versandautosend');
            $api_return = $sp_api->request();
            if ($api_return->status == 'ok' || utf8_decode($api_return->errors[0]->code) == '0014') {
                xtc_db_query("UPDATE " . $table . " SET v_send = 1 where hash = '" . $track['hash'] . "';");
            }
        }
    } else {
        secupay_log(sp_log, 'Table not exist: ' . $table);
    }
}

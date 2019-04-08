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

/**
 * This file takes hash as request and changes the status of the order
 */
include('includes/application_top.php');

if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}

try {
    include('secupay_conf.php');

    $hash = xtc_db_input($_POST['hash']);
    $api_key = xtc_db_input($_POST['apikey']);
    $payment_status = xtc_db_input($_POST['payment_status']);
    $comment = xtc_db_input($_POST['hint']);
    $payment_type = xtc_db_input($_REQUEST['payment_type']);
    $referer = parse_url($_SERVER['HTTP_REFERER']);

    if (isset($referer['host']) && $referer['host'] === SECUPAY_HOST) {
        if (isset($api_key) && ($api_key === MODULE_PAYMENT_SECUPAY_APIKEY || $api_key === MODULE_PAYMENT_SECUPAY_B2B_APIKEY)) {
            // select from secupay_transaction_order table
            try {
                $order_nr_q = @xtc_db_query("SELECT ordernr,payment_method FROM secupay_transactions WHERE `hash` = '{$hash}'");
                $order_nr_row = @xtc_db_fetch_array($order_nr_q);
                $order_id = $order_nr_row['ordernr'];
                $in_payment_method = $order_nr_row['payment_method'];
            } catch (Exception $e) {
                secupay_log(SECUPAY_PUSH_LOG, ' status_push - get ordernr - EXCEPTION: ' . $e->getMessage());
            }

            if (!isset($order_id) || !is_numeric($order_id)) {
                $response = 'ack=Disapproved&error=no+matching+order+found+for+hash';
            } else {
                switch ($payment_type) {
                    case "debit":
                        $order_status_waiting = MODULE_PAYMENT_SPLS_ORDER_STATUS_ID;
                        $order_status_accepted = MODULE_PAYMENT_SPLS_ORDER_STATUS_ACCEPTED_ID;
                        $order_status_denied = MODULE_PAYMENT_SPLS_ORDER_STATUS_DENIED_ID;
                        $order_status_issue = MODULE_PAYMENT_SPLS_ORDER_STATUS_ISSUE_ID;
                        $order_status_void = MODULE_PAYMENT_SPLS_ORDER_STATUS_VOID_ID;
                        $order_status_authorized = MODULE_PAYMENT_SPLS_ORDER_STATUS_AUTHORIZED_ID;
                        break;
                    case "creditcard":
                        $order_status_waiting = MODULE_PAYMENT_SPKK_ORDER_STATUS_ID;
                        $order_status_accepted = MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID;
                        $order_status_denied = MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID;
                        $order_status_issue = MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID;
                        $order_status_void = MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID;
                        $order_status_authorized = MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID;
                        break;
                    case "invoice":
                        if ($in_payment_method == 'secupay_b2b_xtc') {
                            $order_status_waiting = MODULE_PAYMENT_SPB2B_ORDER_STATUS_ID;
                            $order_status_accepted = MODULE_PAYMENT_SPB2B_ORDER_STATUS_ACCEPTED_ID;
                            $order_status_denied = MODULE_PAYMENT_SPB2B_ORDER_STATUS_DENIED_ID;
                            $order_status_issue = MODULE_PAYMENT_SPB2B_ORDER_STATUS_ISSUE_ID;
                            $order_status_void = MODULE_PAYMENT_SPB2B_ORDER_STATUS_VOID_ID;
                            $order_status_authorized = MODULE_PAYMENT_SPB2B_ORDER_STATUS_AUTHORIZED_ID;
                        } else {
                            $order_status_waiting = MODULE_PAYMENT_SPINV_ORDER_STATUS_ID;
                            $order_status_accepted = MODULE_PAYMENT_SPINV_ORDER_STATUS_ACCEPTED_ID;
                            $order_status_denied = MODULE_PAYMENT_SPINV_ORDER_STATUS_DENIED_ID;
                            $order_status_issue = MODULE_PAYMENT_SPINV_ORDER_STATUS_ISSUE_ID;
                            $order_status_void = MODULE_PAYMENT_SPINV_ORDER_STATUS_VOID_ID;
                            $order_status_authorized = MODULE_PAYMENT_SPINV_ORDER_STATUS_AUTHORIZED_ID;
                        }
                        break;
                    case "prepay":
                        $order_status_waiting = MODULE_PAYMENT_SPPP_ORDER_STATUS_ID;
                        $order_status_accepted = MODULE_PAYMENT_SPPP_ORDER_STATUS_ACCEPTED_ID;
                        $order_status_denied = MODULE_PAYMENT_SPPP_ORDER_STATUS_DENIED_ID;
                        break;
                    case "sofort":
                        $order_status_waiting = MODULE_PAYMENT_SPLS_ORDER_STATUS_ID;
                        $order_status_accepted = MODULE_PAYMENT_SPLS_ORDER_STATUS_ACCEPTED_ID;
                        $order_status_denied = MODULE_PAYMENT_SPLS_ORDER_STATUS_DENIED_ID;
                        $order_status_issue = MODULE_PAYMENT_SPLS_ORDER_STATUS_ISSUE_ID;
                        $order_status_void = MODULE_PAYMENT_SPLS_ORDER_STATUS_VOID_ID;
                        $order_status_authorized = MODULE_PAYMENT_SPLS_ORDER_STATUS_AUTHORIZED_ID;
                        break;
  
                    default:
                        $response = 'ack=Disapproved&error=payment_type+not+supported';
                        break;
                }

                if (isset($order_status_accepted)) {

                    //get order status
                    try {
                        $status_query = @xtc_db_query("SELECT orders_status FROM " . TABLE_ORDERS . " WHERE `orders_id` = '{$order_id}'");
                        $status_query_row = @xtc_db_fetch_array($status_query);
                        $original_order_status_id = $status_query_row['orders_status'];

                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - original_order_status_id: ' . $original_order_status_id);
                        // get Amount Check
                        $order_total_query = @xtc_db_query("SELECT value FROM " . TABLE_ORDERS_TOTAL . " WHERE `orders_id` = '{$order_id}' and class = 'ot_total'");
                        $order_total_row = @xtc_db_fetch_array($order_total_query);
                        $original_order_total_db = $order_total_row['value'];
                        $original_order_total = (int) number_format($original_order_total_db * 100, 0, '.', '');
                        $secupay_orders_total = (int) secupay_get_status_data_amount($hash, $in_payment_method);
                        if (strcmp($original_order_total, $secupay_orders_total) !== 0) {
                            $amount_error = true;
                        }
                    } catch (Exception $e) {
                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - get orderstatus - EXCEPTION: ' . $e->getMessage());
                    }
                    if ($amount_error === true) {
                        $payment_status = 'issue';
                        $comment = $comment . 'Zahlbetrag und Order Betrag weichen ab';
                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - amount_error: ' . $amount_error);
                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - original_order_total_db: ' . $original_order_total_db);
                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - original_order_total: ' . $original_order_total);
                        secupay_log(SECUPAY_PUSH_LOG, ' status_push - secupay_orders_total: ' . $secupay_orders_total);
                    }
                    switch ($payment_status) {
                        case 'accepted':

                            if ($original_order_status_id !== $order_status_waiting) {
                                //don't overwrite, order status changed from other source
                                try {
                                    $orders_status_name_q = @xtc_db_query("SELECT orders_status_name FROM " . TABLE_ORDERS_STATUS . " WHERE orders_status_id = {$original_order_status_id} LIMIT 1");
                                    $orders_status_name_row = @xtc_db_fetch_array($orders_status_name_q);
                                    $orders_status_name = $orders_status_name_row['orders_status_name'];
                                } catch (Exception $e) {
                                    secupay_log(SECUPAY_PUSH_LOG, ' status_push - get orderstatus name - EXCEPTION: ' . $e->getMessage());
                                    $orders_status_name = "unkown";
                                }

                                $response = 'ack=Disapproved&error=order+status+not+waiting&original_status_id='.$original_order_status_id.'&original_status='.$orders_status_name;
                            } else {
                                $order_status = $order_status_accepted;
                            }
                            $order_status = $order_status_accepted;
                            break;
                        case 'denied':
                            $order_status = $order_status_denied;
                            break;
                        case 'issue':
                            $order_status = $order_status_issue;
                            break;
                        case 'void':
                            $order_status = $order_status_void;
                            break;
                        case 'authorized':
                            if ($payment_type == 'prepay') {
                                $order_status = $order_status_waiting;
                            } else {
                                $order_status = $order_status_authorized;
                            }
                            break;
                        default:
                            $response = 'ack=Disapproved&error=payment_status+not+supported';
                            break;
                    }
                }
            }

            if (isset($order_status) && is_numeric($order_status) && $order_status != 0) {
                //update order status
                try {
                    //ist status ID $order_status_accepted gesetzt gewesen
                    $status_query_history = @xtc_db_query("SELECT orders_status_id FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE `orders_id` = '{$order_id}' and `orders_status_id` = '{$order_status_accepted}'");
                    $status_query_row_history = @xtc_db_fetch_array($status_query_history);
                    $original_order_status_id_history = $status_query_row_history['orders_status_id'];

                    if ($original_order_status_id_history == $order_status_accepted && $original_order_status_id != $order_status_accepted && $original_order_status_id != $order_status_issue) {
                        $comment = "secupay status push (" . $payment_status . "): " . $comment;
                        //update order status history
                        @xtc_db_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, comments) VALUES (" . xtc_db_input($order_id) . ", " . xtc_db_input($original_order_status_id) . ", NOW(), '" . xtc_db_input($comment) . "') ");
                    } else {
                        @xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . xtc_db_input($order_status) . "' WHERE orders_id='" . xtc_db_input($order_id) . "'");
                        $comment = "secupay status push (" . $payment_status . "): " . $comment;
                        //update order status history
                        @xtc_db_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, comments) VALUES (" . xtc_db_input($order_id) . ", " . xtc_db_input($order_status) . ", NOW(), '" . xtc_db_input($comment) . "') ");
                    }
                    $response = 'ack=Approved';
                } catch (Exception $e) {
                    secupay_log(SECUPAY_PUSH_LOG, ' status_push - get orderstatus - EXCEPTION: ' . $e->getMessage());
                    $response = 'ack=Disapproved&error=order+status+not+changed';
                }
            } elseif (!isset($response)) {
                $response = 'ack=Disapproved&error=order+status+not+updated';
            }
        } else {
            $response = 'ack=Disapproved&error=apikey+invalid';
        }
    } else {
        secupay_log(SECUPAY_PUSH_LOG, ' status_push invalid Referer: ' . $_SERVER['HTTP_REFERER']);
        secupay_log(SECUPAY_PUSH_LOG, ' status_push invalid host: ' . $referer['host']);
        $response = 'ack=Disapproved&error=request+invalid';
    }
} catch (Exception $e) {
    $response = 'ack=Disapproved&error=unexpected+error';
    secupay_log(SECUPAY_PUSH_LOG, ' status_push EXCEPTION: ' . $e->getMessage());
}
secupay_log(SECUPAY_PUSH_LOG, ' status_push RESPONSE: ' . $response . '&' . http_build_query($_POST));
//append original request (post) data to response
echo $response . '&' . http_build_query($_POST);

function secupay_get_status_data_amount($hash, $in_payment_method)
{
    if (!empty($hash)) {
        $data = array();
        $data['hash'] = $hash;
        $data['apikey'] = MODULE_PAYMENT_SECUPAY_APIKEY;
        if ($in_payment_method == 'secupay_b2b_xtc') {
            $data['apikey'] = MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
        }
        $request = array();
        $request['data'] = $data;

        $sp_api = new secupay_api($request, 'status');
        $response = $sp_api->request();

        if (isset($response->status) && $response->status == 'ok' && isset($response->data->status)) {
            return $response->data->amount;
        }
    }
    return false;
}

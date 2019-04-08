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

/*include api class, include path in "admin" mode differs from "shop" mode*/
if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}
if (file_exists(DIR_FS_CATALOG . 'secupay_conf.php')) {
    require_once(DIR_FS_CATALOG . 'secupay_conf.php');
} elseif (file_exists("../" . DIR_FS_CATALOG . 'secupay_conf.php')) {
    require_once("../" . DIR_WS_CLASSES . 'secupay_conf.php');
} elseif (file_exists('secupay_conf.php')) {
    require_once('secupay_conf.php');
} else {
    require_once('../secupay_conf.php');
}

/**
 * class that handles creditcard payment through Secupay
 */
class secupay_kk_xtc
{
    /**
     * @var string
     */
    public $code;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var bool
     */
    public $enabled;
    /**
     * @var
     */
    public $iframe;
    /**
     * @var
     */
    public $history_id;
    /**
     * @var bool
     */
    public $demo;
    /**
     * @var bool
     */
    public $sp_log;
    /**
     * @var mixed
     */
    public $conf;
    /**
     * @var bool
     */
    public $order_before_payment;

    /**
     * Constructor
     */
    public function __construct()
    {
        global $order;

        $this->code = 'secupay_kk_xtc';
        $this->title = (function_exists('xtc_catalog_href_link')) ? MODULE_PAYMENT_SPKK_TEXT_TITLE . "<br/><img style='border:0;text-decoration:none;' alt='secupay logo' src='https://www.secupay.ag/sites/default/files/media/Icons/secupay_logo.png'/>" : MODULE_PAYMENT_SPKK_TEXT_TITLE;
        $this->sort_order = MODULE_PAYMENT_SPKK_SORT_ORDER;
        $pref = "INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order,";
        if (defined('MODULE_PAYMENT_SPKK_STATUS')) {
            if (MODULE_PAYMENT_SPKK_STATUS == 'JA') {
                define('MODULE_PAYMENT_SPKK_STATUS', true);
            }
            if (MODULE_PAYMENT_SPKK_STATUS == 'Nein') {
                define('MODULE_PAYMENT_SPKK_STATUS', false);
            }
            xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS', '" . MODULE_PAYMENT_SPKK_STATUS . "', '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SPKK_STATUS'");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " USING " . TABLE_CONFIGURATION . ", " . TABLE_CONFIGURATION . " AS database1 WHERE NOT configuration.configuration_id = database1.configuration_id AND configuration.configuration_id < database1.configuration_id AND configuration.configuration_key = database1.configuration_key");
        }
        $this->enabled = strcmp(MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS, 'true') == 0;
        $this->sp_log = strcmp(MODULE_PAYMENT_SPKK_LOGGING, 'Ja') == 0;
        $this->experience = strcmp(MODULE_PAYMENT_SECUPAY_EXPERIENCE, 'Ja') == 0;
        $this->tautosend = strcmp(MODULE_PAYMENT_SECUPAY_TAUTOSEND, 'Ja') == 0;
        $this->order_before_payment = strcmp(MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT, 'Ja') == 0;

        //Demo Modus
        if (strcmp(MODULE_PAYMENT_SPKK_SIMULATION_MODE, "Simulation") == 0) {
            $this->demo = true;
        } else {
            $this->demo = false;
        }

        $this->conf = get_sp_conf();

        if ((int)MODULE_PAYMENT_SPKK_ORDER_STATUS_ID > 0) {
            $this->order_status_success = MODULE_PAYMENT_SPKK_ORDER_STATUS_ID;
        }

        $this->description = MODULE_PAYMENT_SPKK_TEXT_DESCRIPTION . "<br/>Version " . $this->conf->general->modulversion .
            " - <a style='color:green;' href='" . SECUPAY_FRONTEND_URL . "/' target='_blank'>secupay Login</a>" .
            " - <a style='color:green;' href='http://www.secupay.ag/' target='_blank'>secupay Website</a>";
        $this->description .= '<iframe frameborder="0" scrolling="auto" src="' . SECUPAY_INFO_IFRAME_URL . '/shopiframe.php?vertrag_id_kk=' . MODULE_PAYMENT_SECUPAY_APIKEY . '&amp;shop=xtc&amp;shopversion=' . urlencode(PROJECT_VERSION) . '&amp;modulversion=' . $this->conf->general->modulversion . '" marginwidth="0px" marginheight="0px" name="secupay_info" style="border:0px; display:block;width:98%;margin-top:3px;margin-bottom:3px;"></iframe>';

        secupay_log($this->sp_log, 'CreditCard secupay_kk_xtc constructor php ' . PHP_VERSION);
        secupay_log($this->sp_log, "conf: " . json_encode($this->conf));
        secupay_log($this->sp_log, "Modus: " . MODULE_PAYMENT_SPKK_SIMULATION_MODE);
        secupay_log($this->sp_log, "Sort Order: " . MODULE_PAYMENT_SPKK_SORT_ORDER);
        secupay_log($this->sp_log, "Aktiv: " . MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS);
        secupay_log($this->sp_log, "Order Status erfolg: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_ID);
        secupay_log($this->sp_log, "Order Status accepted: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID);
        secupay_log($this->sp_log, "Order Status denied: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID);
        secupay_log($this->sp_log, "Order Status issue: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID);
        secupay_log($this->sp_log, "Order Status void: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID);
        secupay_log($this->sp_log, "Order Status authorized: " . MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID);

        if ($this->order_before_payment) {
            secupay_log($this->sp_log, "secupay_kk_xtc - order_before_payment activ");
            $this->tmpOrders = true;
            $this->tmpStatus = MODULE_PAYMENT_SPKK_ORDER_STATUS_ID;
            //for xtc
            $this->form_action_url = true;
        }

        if (is_object($order)) {
            $this->update_status();
        }
    }

    /**
     * Function that checks if payment_module is available for this zone
     * Function is called when displaying the available payments
     */
    public function update_status()
    {
        global $order;
        secupay_log($this->sp_log, "update_status");

        if (($this->enabled) && ((int)MODULE_PAYMENT_SPKK_ZONE > 0)) {
            $check_flag = false;

            try {
                $check_query = xtc_db_query("SELECT geo_zone_id FROM " . TABLE_ZONES_TO_GEO_ZONES . " WHERE geo_zone_id = '" . MODULE_PAYMENT_SPKK_ZONE . "' AND zone_country_id = '" . $order->billing['country']['id'] . "' ORDER BY zone_id");
                while ($check = xtc_db_fetch_array($check_query)) {
                    secupay_log($this->sp_log, "zone id check:".print_r($check, true));
                    if ($check['geo_zone_id'] == MODULE_PAYMENT_SPKK_ZONE) {
                        $check_flag = true;
                        break;
                    }
                }
            } catch (Exception $e) {
                secupay_log($this->sp_log, 'update_status EXCEPTION: ' . $e->getMessage());
            }

            if ($check_flag == false) {
                $this->enabled = false;
            }
        }

        if (($this->enabled) && $this->conf->secupay_kk_xtc->delivery_differs_disable && MODULE_PAYMENT_SPKK_DELIVERY_DISABLE == "Ja") {
            $check_delivery_differs = $this->_check_delivery_differs($order);
            if ($check_delivery_differs) {
                $this->enabled = false;
            }
        }

        if (($this->enabled) && is_numeric(MODULE_PAYMENT_SPKK_MIN_AMOUNT) && MODULE_PAYMENT_SPKK_MIN_AMOUNT > 0) {
            secupay_log($this->sp_log, "secupay_kk_xtc - update_status - check amount");
            //subtotal should not contain delivery cost
            if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
                $subtotal = $order->info['subtotal'] + $order->info['tax'];
            } else {
                $subtotal = $order->info['subtotal'];
            }
            $order_amount = number_format($subtotal, 2, '.', '');
            $check_amount = number_format(floatval(MODULE_PAYMENT_SPKK_MIN_AMOUNT), 2, '.', '');

            secupay_log($this->sp_log, "secupay_kk_xtc - update_status - order amount: " . $order_amount . " - amount set: " . $check_amount);

            if ($order_amount < $check_amount) {
                $this->enabled = false;
                secupay_log($this->sp_log, "secupay_kk_xtc - update_status - disabled because of low amount");
            }
        }
        if (($this->enabled) && is_numeric(MODULE_PAYMENT_SPKK_MAX_AMOUNT) && MODULE_PAYMENT_SPKK_MAX_AMOUNT > 0) {
            secupay_log($this->sp_log, "secupay_kk_xtc - update_status - check for max amount");
            //total should contain delivery cost
            if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
                $total = $order->info['total'] + $order->info['tax'];
            } else {
                $total = $order->info['total'];
            }
            $order_amount = number_format($total, 2, '.', '');
            $check_amount = number_format(floatval(MODULE_PAYMENT_SPKK_MAX_AMOUNT), 2, '.', '');

            secupay_log($this->sp_log, "secupay_kk_xtc - update_status - order amount: " . $order_amount . " - amount set: " . $check_amount);

            if ($order_amount >= $check_amount) {
                $this->enabled = false;
                secupay_log($this->sp_log, "secupay_kk_xtc - update_status - disabled because of high amount");
            }
        }
    }

    /**
     * Function that returns javascript code that will validate the data required from user for the payment
     *
     * @return string
     */
    public function javascript_validation()
    {
        return '';
    }

    /**
     * Function that returns what should be displayed on Available payment types page
     *
     * @return array
     */
    public function selection()
    {
        secupay_log($this->sp_log, "selection");
        global $order;
        unset($_SESSION['iframe_link']);

        //Kompatibilität mit gambio
        if (!isset($_SESSION['sp_tag'])) {
            unset($_SESSION['sp_success']);
        }
        $order = $GLOBALS['order'];
        if ($order->info['currency'] == 'EUR') {
            switch ($_SESSION['language_code']) {
                case 'de':
                case 'at':
                case 'ch':
                    $lang_logo = "de_de/";
                    break;
                case 'en':
                    $lang_logo = "en_us/";
                    break;
                /*case 'nl':
                    $lang_logo = "nl_nl/";
                    break;
                case 'fr':
                    $lang_logo = "fr_fr/";
                    break;
                case 'it':
                    $lang_logo = "it_it/";
                    break;
                case 'ru':
                    $lang_logo = "ru_ru/";
                    break;*/
                default:
                    $lang_logo = '';
            }
            $logo = "<img alt=\"" . MODULE_PAYMENT_SPKK_TEXT_DESCRIPTION . "\" style=\"border:0;\" src=\"https://www.secupay.ag/sites/default/files/media/Icons/" . $lang_logo . "secupay_creditcard.png\" align=\"middle\" height=\"38px\" />";
            $title = $this->title;

            $selection = array(
                'id' => $this->code,
                'module' => $title,
                'fields' => array()
            );

            $selection['description'] = MODULE_PAYMENT_SECUPAY_SPKK_TEXT_INFO . ' ' . $logo;

            secupay_log($this->sp_log, $selection);
            return $selection;
        } else {
            return;
        }
    }

    /**
     * Function that checks if configuration key is available in database
     */
    public function check()
    {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        secupay_log($this->sp_log, "currency Check");
        secupay_log($this->sp_log, "check($this->_check)");
        return $this->_check;
    }

    /**
     *
     */
    public function pre_confirmation_check()
    {
        secupay_log($this->sp_log, "pre_confirmation_check");
    }

    /**
     * @return array
     */
    public function confirmation()
    {
        global $order;
        secupay_log($this->sp_log, "confirmation");
        $confirmation = array('title' => $this->title, 'fields' => array());

        if ($this->conf->secupay_kk_xtc->delivery_differs_disable && MODULE_PAYMENT_SPKK_DELIVERY_DISABLE == "Hinweis" && $this->_check_delivery_differs($order)) {
            $additional_messages = array('title' => MODULE_PAYMENT_SPKK_HINT, 'field' => MODULE_PAYMENT_SPKK_DELIVERY_HINT);
            $confirmation['fields'][] = $additional_messages;
        }

        return $confirmation;
    }

    /**
     * @return bool
     */
    public function process_button()
    {
        global $order;

        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
            $total = $order->info['total'] + $order->info['tax'];
        } else {
            $total = $order->info['total'];
        }

        $_SESSION['secupay_kk_total'] = number_format($total, 2, '.', '');
        secupay_log($this->sp_log, "process_button", $_POST, "summe_aus_button: " . number_format($order->info['total'], 2, '.', ''));

        return false;
    }

    /**
     * Function that is called before payment processing
     */
    public function before_process()
    {
        global $order, $insert_id;
        secupay_log($this->sp_log, "before_process entry (insert_id: $insert_id)");
        if (!isset($_SESSION['sp_success'])) {
            secupay_log($this->sp_log, "before_process sp_success ist leer in session");
            //Daten vorbereiten

            $_mwst_bug = 0;
            if (MODULE_PAYMENT_SPKK_MWST == "Ja") {
                $_mwst_bug = number_format($order->info['shipping_cost'] * (19 / 100), 2, '.', '');
            }

            secupay_log($this->sp_log, "mwst_bug $_mwst_bug");

            $amount = $_SESSION['secupay_kk_total'] + $_mwst_bug;
            $amount = (int)round($amount * 100, 0);
            secupay_log($this->sp_log, "amount $amount");

            $data = array();
            try {
                $dob_res = xtc_db_query("SELECT customers_dob FROM " . TABLE_CUSTOMERS . " WHERE customers_id=" . $_SESSION['customer_id'] . " AND DATE(customers_dob) >= DATE('1900-01-01 00:00:00')");
                if ($dob_res && $dob_row = xtc_db_fetch_array($dob_res)) {
                    $data['dob'] = $dob_row['customers_dob'];
                }
            } catch (Exception $e) {
                secupay_log($this->sp_log, 'dob EXCEPTION: ' . $e->getMessage());
            }

            $store_name = MODULE_PAYMENT_SPKK_SHOPNAME;

            if (empty($store_name)) {
                try {
                    $res_store_name = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key='STORE_NAME'");
                    $row_store_name = xtc_db_fetch_array($res_store_name);
                    $store_name = $row_store_name['configuration_value'];
                } catch (Exception $e) {
                    secupay_log($this->sp_log, 'storename EXCEPTION: ' . $e->getMessage());
                }
            }

            $data['apikey'] = MODULE_PAYMENT_SECUPAY_APIKEY;
            $data['shop'] = "xtc";
            $data['shopversion'] = PROJECT_VERSION;
            $data['modulversion'] = $this->conf->general->modulversion;
            if (file_exists(DIR_FS_CATALOG . 'release_info.php')) {
                $gx_version = null;
                include(DIR_FS_CATALOG . 'release_info.php');
                $data['shop'] = "Gambio";
                $data['shopversion'] = $gx_version;
            }
            $data['amount'] = $amount;        // amount in cents
            $data['currency'] = $order->info['currency'];

            $data['apiversion'] = API_VERSION;

            switch ($_SESSION['language_code']) {
                case 'de':
                case 'at':
                case 'ch':
                    $data['language'] = "de_DE";
                    break;
                case 'en':
                    $data['language'] = "en_US";
                    break;
                /*case 'nl':
                    $data['language']  = "nl_NL";
                    break;
                case 'fr':
                    $data['language']  = "fr_FR";
                    break;
                case 'it':
                    $data['language']  = "it_IT";
                    break;
                case 'ru':
                    $data['language']  = "ru_RU";
                    break;*/
                default:
                    $data['language'] = "en_US";
            }

            $uid = md5(uniqid(mt_rand()));
            $_SESSION['uid'] = $uid;

            $data['url_success'] = str_replace(
                '&amp;',
                '&',
                xtc_href_link('secupay_checkout_success.php', 'payment_error=secupay_kk_xtc&uid=' . $uid, 'SSL', true, false)
            );
            $data['url_failure'] = xtc_href_link('secupay_checkout_failure.php', 'payment_error=secupay_kk_xtc', 'SSL', true, false);

            $data['purpose'] = "Bestellung vom " . date("d.m.y", time()) . "|bei " . $store_name . "|Bei Fragen TEL 035955755055";
            if ($this->experience) {
                try {
                    $experiencep_res = xtc_db_query("SELECT count(orders_id) FROM " . TABLE_ORDERS . " WHERE customers_id=" . $_SESSION['customer_id'] . " AND orders_status IN (2,3)");
                    $experiencep_row = xtc_db_fetch_array($experiencep_res);
                    $data['experience']['positive'] = $experiencep_row['count(orders_id)'];
                } catch (Exception $e) {
                    secupay_log($this->sp_log, 'positive: ' . $e->getMessage());
                }
                secupay_log($this->sp_log, 'customerid ' . $_SESSION['customer_id']);
                try {
                    $experiencen_res = xtc_db_query("SELECT count(orders_id) FROM " . TABLE_ORDERS . " WHERE customers_id=" . $_SESSION['customer_id'] . " AND orders_status IN (0,1,99)");
                    $experiencen_row = xtc_db_fetch_array($experiencen_res);
                    $data['experience']['negative'] = $experiencen_row['count(orders_id)'];
                } catch (Exception $e) {
                    secupay_log($this->sp_log, 'negative: ' . $e->getMessage());
                }
                if (empty($data['experience']['positive'])) {
                    $data['experience']['positive'] = 0;
                }
                if (empty($data['experience']['negative'])) {
                    $data['experience']['negative'] = 0;
                }
            }
            if ($this->demo) {
                $data['demo'] = 1;
            }
            switch ($order->customer['gender']) {
                case 'm':
                    $data['title'] = 'Herr';
                    break;
                case 'f':
                    $data['title'] = 'Frau';
                    break;
            }
            $data['firstname'] = $order->billing['firstname'];
            $data['lastname'] = $order->billing['lastname'];
            $data['street'] = $order->billing['street_address'];
            // DONE: Erweiterung für Straße & Hausnummer Getrennt
            if (!empty($order->billing['street_address_no'])) {
                $data['housenumber'] = $order->billing['street_address_no'];
            }
            if (!empty($order->billing['house_number'])) {
                $data['housenumber'] = $order->billing['house_number'];
            }
            $data['zip'] = $order->billing['postcode'];
            $data['city'] = $order->billing['city'];
            $data['country'] = $order->billing['country']['iso_code_2'];
            $data['email'] = $order->customer['email_address'];
            $data['company'] = $order->billing['company'];
            $data['telephone'] = $order->customer['telephone'];

            $data['ip'] = $_SERVER['REMOTE_ADDR'];

            $basketcontents = $order->products;

            $products = array();
            foreach ($basketcontents as $item) {
                $product = new stdClass();
                $product->article_number = $item['id'];
                $product->name = $item['name'];
                $product->model = $item['model'];
                $product->ean = $this->_get_product_ean($item['id']);
                $product->quantity = $item['qty'];
                $product->price = $item['price'] * 100;
                $product->total = $item['final_price'] * 100;
                $product->tax = $item['tax'];
                $products[] = $product;
            }

            $data['basket'] = $products;

            $delivery_address = new stdClass();
            $delivery_address->firstname = $order->delivery['firstname'];
            $delivery_address->lastname = $order->delivery['lastname'];
            $delivery_address->street = $order->delivery['street_address'];
            // DONE: Erweiterung für Straße & Hausnummer Getrennt
            if (!empty($order->delivery['street_address_no'])) {
                $delivery_address->housenumber = $order->delivery['street_address_no'];
            }
            if (!empty($order->delivery['housenumber'])) {
                $delivery_address->housenumber = $order->delivery['housenumber'];
            }
            $delivery_address->zip = $order->delivery['postcode'];
            $delivery_address->city = $order->delivery['city'];
            $delivery_address->country = $order->delivery['country']['iso_code_2'];
            $delivery_address->company = $order->delivery['company'];
            $data['delivery_address'] = $delivery_address;

            $data["payment_type"] = $this->conf->secupay_kk_xtc->payment_type;
            $data["payment_action"] = $this->conf->secupay_kk_xtc->payment_action;
            $data["url_push"] = xtc_href_link(
                'secupay_status_push.php',
                'payment_type=' . $this->conf->secupay_kk_xtc->payment_type,
                'SSL',
                true,
                false
            );
            foreach ($this->keys() as $value) {
                $data['module_config'][$value] = $this->get_secupay_conf($value);
            }
            $requestData = array();
            $requestData['data'] = $data;

            $sp_api = new secupay_api($requestData, 'init', 'application/json', $this->sp_log, $data['language']);
            $api_return = $sp_api->request();

            $this->history_id = $this->_prepare_trans_log(
                json_encode($requestData),
                json_encode($api_return),
                addslashes($api_return->data->hash),
                addslashes($api_return->data->transaction_id),
                '',
                addslashes($api_return->status),
                $amount
            );

            unset($_SESSION['secupay_kk_total']);

            if ($api_return->status != "ok") { //Fehler
                $error = utf8_decode($api_return->errors[0]->message);
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error);
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            } else {
                $this->iframe = $api_return->iframe_url;
                $_SESSION['sp_transaction_id'] = $api_return->data->transaction_id;
                $_SESSION['sp_hash'] = $api_return->data->hash;
                $_SESSION['iframe_link'] = stripslashes($api_return->data->iframe_url);
                $_SESSION['sp_amount'] = $amount;

                if (isset($api_return->data->hash)) {
                    $this->_insert_hash(addslashes($api_return->data->hash));
                }

                if (!$this->order_before_payment) {
                    //Kompatibilität mit gambio
                    $_SESSION['sp_tag'] = 1;
                    xtc_redirect(xtc_href_link("secupay_checkout_iframe.php", "", 'SSL', true, false));
                }
            }
            #die("Fehler aufgetreten.");
        }
        if (isset($_SESSION['sp_success']) && $_SESSION['sp_success'] == false) {
            // if request failed, then checkout again
            unset($_SESSION['sp_success']);
            secupay_log($this->sp_log, 'before_process, transaction failure: ', json_encode($_REQUEST));
            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, "", 'SSL', true, false));
        }
        secupay_log($this->sp_log, 'before_process session sp_success true');
        unset($_SESSION['sp_success']);
    }

    /**
     * redirects to iFrame for activated order_before_payment
     */
    public function payment_action()
    {
        global $insert_id, $tmp;
        secupay_log($this->sp_log, 'secupay_kk_xtc - payment_action called');
        if (!$this->order_before_payment) {
            return;
        }

        if (isset($_SESSION['sp_hash']) && isset($insert_id)) {
            try {
                //prepare for Status push
                xtc_db_query("UPDATE secupay_transaction_order SET ordernr = " . xtc_db_input($insert_id) . " WHERE hash = '" . xtc_db_input($_SESSION['sp_hash']) . "';");
                //write to log
                xtc_db_query("UPDATE secupay_transactions SET ordernr = " . xtc_db_input($insert_id) . " WHERE hash = '" . xtc_db_input($_SESSION['sp_hash']) . "';");
            } catch (Exception $e) {
                secupay_log($this->sp_log, 'secupay_transaction_order EXCEPTION: ' . $e->getMessage());
            }
        }

        $tmp = false;

        //Kompatibilität mit gambio
        $_SESSION['sp_tag'] = 1;
        secupay_log($this->sp_log, 'secupay_kk_xtc - payment_action redirect');
        xtc_redirect(xtc_href_link("secupay_checkout_iframe.php", "", 'SSL', true, false));
    }

    /**
     * function that writes to log and db
     */
    public function after_process()
    {
        global $insert_id;
        $is_demo = $this->demo;
        $is_delivery_differs = isset($_SESSION['sp_kk_delivery_differs']) && $_SESSION['sp_kk_delivery_differs'];
        secupay_log($this->sp_log, "after_process insert_id $insert_id");
        if (isset($_SESSION['sp_hash'])) {
            try {
                //prepare for Status push
                xtc_db_query("UPDATE secupay_transaction_order SET ordernr = " . xtc_db_input($insert_id) . " WHERE hash = '" . xtc_db_input($_SESSION['sp_hash']) . "';");
                //write to log
                xtc_db_query("UPDATE secupay_transactions SET ordernr = " . xtc_db_input($insert_id) . " WHERE hash = '" . xtc_db_input($_SESSION['sp_hash']) . "';");
            } catch (Exception $e) {
                secupay_log($this->sp_log, 'secupay_transaction_order EXCEPTION: ' . $e->getMessage());
            }
        }
        $comment = "";

        //Hinweis bei abweichender Lieferadresse
        if ($is_delivery_differs) {
            $comment = "Achtung: abweichende Lieferadresse!";
        }
        if ($is_demo) {
            $comment .= MODULE_PAYMENT_SPKK_DEMO_HINT;
        }
        if (!is_numeric($this->order_status_success)) {
            $this->order_status_success = 0;
        }
        try {
            if ($is_demo || $is_delivery_differs) {
                $sql = "INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, comments) VALUES ($insert_id, " . xtc_db_input($this->order_status_success) . ", NOW(), '" . xtc_db_input($comment) . "') ";
                secupay_log($this->sp_log, $sql);
                xtc_db_query($sql);
            }

            if ($this->order_status_success) {
                xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status_success . "' WHERE orders_id='" . $insert_id . "'");
            }
        } catch (Exception $e) {
            secupay_log($this->sp_log, 'after_process EXCEPTION: ' . $e->getMessage());
        }

        //Kompatibilität mit gambio
        unset($_SESSION['sp_tag']);
    }

    /**
     * Function that returns URL of error
     */
    public function get_error()
    {
        $fehler = $_GET['error'];
        secupay_log($this->sp_log, "get_error ($fehler)");
        $error = array('title' => MODULE_PAYMENT_SPKK_TEXT_ERROR, 'error' => stripslashes(urldecode($fehler)));
        return $error;
    }

    /**
     * Function that installs Secupay Creditcard payment module
     */
    public function install()
    {
        secupay_log($this->sp_log, "install");
        $pref = "INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order,";

        $vertrag_id_kk = '';
        if ($this->conf->general->apikey && is_string($this->conf->general->apikey)) {
            $vertrag_id_kk = trim($this->conf->general->apikey);
        }

        $modus = $this->conf->secupay_kk_xtc->modus == "live" ? "Produktivsystem" : "Simulation";
        $debug = $this->conf->secupay_kk_xtc->debug ? 'Ja' : 'Nein';
        $lw = $this->conf->secupay_kk_xtc->lieferanschrift_warnung ? 'Ja' : 'Nein';
        $experience = $this->conf->secupay_kk_xtc->experience ? 'Ja' : 'Nein';
        $tautosend = $this->conf->secupay_kk_xtc->tautosend ? 'Ja' : 'Nein';
        #$aut = $this->conf->secupay_kk_xtc->vorautorisierung ? 'Ja' : 'Nein';
        xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS', 'true', '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
        xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SPKK_SORT_ORDER', '0',  '6', '0' , now())");
        if (!defined('MODULE_PAYMENT_SECUPAY_APIKEY')) {
            xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SECUPAY_APIKEY', '{$vertrag_id_kk}',  '6', '0' , now()) ON DUPLICATE KEY UPDATE configuration_value = '{$vertrag_id_kk}'");
        }
        if (!defined('MODULE_PAYMENT_SECUPAY_SESSION')) {
            xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SECUPAY_SESSION', '{$this->conf->general->session}',  '6', '0' , now()) ON DUPLICATE KEY UPDATE configuration_value = '{$this->conf->general->session}'");
        }
        xtc_db_query("$pref use_function, set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_ZONE', '0',  '6', '0', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");

        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("$pref set_function, use_function, date_added) values ('MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");

        xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_SIMULATION_MODE', '$modus', '6', '0', 'xtc_cfg_select_option(array(\'Simulation\', \'Produktivsystem\'), ', now())");
        xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_MWST', 'Nein', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_LOGGING', '$debug', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        if (!defined('MODULE_PAYMENT_SECUPAY_EXPERIENCE')) {
            xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SECUPAY_EXPERIENCE','$experience', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        }
        if (!defined('MODULE_PAYMENT_SECUPAY_TAUTOSEND')) {
            xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SECUPAY_TAUTOSEND','$tautosend', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        }
        //xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_KAEUFERSCHUTZ', '$kaeuferschutz', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        //xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SPKK_BID', 'Ja', '6', '99', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now())");
        xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SPKK_SHOPNAME', '',  '6', '0' , now())");
        xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SECUPAY_KK_XTC_ALLOWED', '', '6', '0', now())");
        if (!defined('MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT')) {
            xtc_db_query("$pref set_function, date_added) values ( 'MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT','Nein', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\'), ', now()) ON DUPLICATE KEY UPDATE configuration_key = configuration_key");
        }

        if (!defined('MODULE_PAYMENT_SPKK_DELIVERY_DISABLE')) {
            xtc_db_query("$pref set_function, date_added) values ('MODULE_PAYMENT_SPKK_DELIVERY_DISABLE', 'Nein', '6', '0', 'xtc_cfg_select_option(array(\'Ja\', \'Nein\', \'Hinweis\'), ', now())");
        }

        xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SPKK_MIN_AMOUNT', '0.00',  '6', '0' , now())");

        xtc_db_query("$pref date_added) values ('MODULE_PAYMENT_SPKK_MAX_AMOUNT', '0.00',  '6', '0' , now())");
        $count = xtc_db_query("SELECT COUNT(*) AS count FROM configuration AS A JOIN configuration AS B ON ( A.configuration_key = B.configuration_key AND NOT (A.configuration_id = B.configuration_id)) ORDER BY A.configuration_key");
        $count_result = xtc_db_fetch_array($count);
        if ($count_result['count'] > 0) {
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " USING " . TABLE_CONFIGURATION . ", " . TABLE_CONFIGURATION . " AS database1 WHERE NOT configuration.configuration_id = database1.configuration_id AND configuration.configuration_id < database1.configuration_id AND configuration.configuration_key = database1.configuration_key");
        }
        //xtc_db_query("drop table if exists secupay_history_kk");
        xtc_db_query(
            "CREATE TABLE IF NOT EXISTS secupay_transactions (
            `log_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `req_data` TEXT,
            `ret_data` TEXT,
            `payment_method` VARCHAR(255) DEFAULT NULL,
            `payment_type` VARCHAR(255) DEFAULT NULL,
            `hash` CHAR(40) DEFAULT NULL,
            `transaction_id` INT(10) UNSIGNED DEFAULT NULL,
            `ordernr` INT(11) DEFAULT NULL,
            `msg` VARCHAR(255) DEFAULT NULL,
            `rank` INT(10) DEFAULT NULL,
            `status` VARCHAR(255) DEFAULT NULL,
            `amount` VARCHAR(255) DEFAULT NULL,
            `action` TEXT,
            `created` DATETIME NOT NULL,
            `timestamp` TIMESTAMP,
            `updated` TIMESTAMP,
            `v_send` INT(1) DEFAULT NULL,
            `v_status` INT(15) DEFAULT NULL,
            `tracking_code` VARCHAR(255) DEFAULT NULL,
            `carrier_code` VARCHAR(255) DEFAULT NULL,
            `searchcode` VARCHAR(255) DEFAULT NULL,
            `iframe_url_id` INT(10) DEFAULT NULL,
            PRIMARY KEY  (`log_id`))"
        );
        xtc_db_query(
            "CREATE TABLE IF NOT EXISTS secupay_transaction_order (
            `hash` CHAR(40) NOT NULL,
            `ordernr` INT(11) DEFAULT NULL,
            `transaction_id` INT(10) UNSIGNED DEFAULT NULL,
            `created` DATETIME NOT NULL,
            `timestamp` TIMESTAMP,
            PRIMARY KEY (`hash`))"
        );

        try {
            $qry = @xtc_db_query("SHOW COLUMNS FROM secupay_transaction_order LIKE 'iframe_url_id'");
            $result = xtc_db_fetch_array($qry);

            if (!isset($result['Field'])) {
                xtc_db_query("ALTER TABLE secupay_transaction_order ADD iframe_url_id INT UNSIGNED DEFAULT NULL;");
            } else {
                xtc_db_query("ALTER TABLE secupay_transaction_order CHANGE iframe_url_id iframe_url_id INT UNSIGNED DEFAULT NULL;");
            }
        } catch (Exception $e) {
            secupay_log($this->sp_log, 'ALTER secupay_transaction_order EXCEPTION: ' . $e->getMessage());
        }
        xtc_db_query(
            "CREATE TABLE IF NOT EXISTS secupay_iframe_url (
            `iframe_url_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `iframe_url` TEXT,
            PRIMARY KEY (`iframe_url_id`))"
        );
        xtc_db_query(
            "CREATE TABLE IF NOT EXISTS secupay_transaction_tracking (
            `hash` CHAR(40) NOT NULL,
            `tracking_code` VARCHAR(255) DEFAULT NULL,
            `carrier_code` VARCHAR(255) DEFAULT NULL,
            `v_send` INT(10) UNSIGNED DEFAULT NULL,
            `timestamp` TIMESTAMP)"
        );
    }

    /**
     * Function that removes payment module
     */
    public function remove()
    {
        secupay_log($this->sp_log, "remove");
        xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key IN ('" . implode(
            "', '",
                $this->keys()
        ) . "','MODULE_PAYMENT_SECUPAY_KK_XTC_ALLOWED') AND configuration_key NOT IN ('MODULE_PAYMENT_SECUPAY_APIKEY','MODULE_PAYMENT_SECUPAY_EXPERIENCE','MODULE_PAYMENT_SECUPAY_TAUTOSEND','MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT','MODULE_PAYMENT_SECUPAY_SESSION')");

        //check for other secupay payment module
        $qry = xtc_db_query("SELECT * FROM " . TABLE_CONFIGURATION . " WHERE configuration_key LIKE 'MODULE_PAYMENT_SP%_SORT_ORDER';");

        if (xtc_db_num_rows($qry) == 0) {
            //no other secupay payment module installed, remove apikey
            secupay_log($this->sp_log, "remove apikey");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_APIKEY'");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_TAUTOSEND'");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_EXPERIENCE'");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT'");
            xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_SECUPAY_SESSION'");
        }
    }

    /**
     * Function that returns an array of configuration options
     *
     * @return array
     */
    public function keys()
    {
        $keys = array(
            'MODULE_PAYMENT_SECUPAY_KK_XTC_STATUS',
            'MODULE_PAYMENT_SECUPAY_APIKEY',
            'MODULE_PAYMENT_SPKK_SORT_ORDER',
            'MODULE_PAYMENT_SPKK_SHOPNAME',
            'MODULE_PAYMENT_SPKK_SIMULATION_MODE',
            'MODULE_PAYMENT_SPKK_LOGGING',
            'MODULE_PAYMENT_SECUPAY_EXPERIENCE',
            'MODULE_PAYMENT_SECUPAY_TAUTOSEND',
            'MODULE_PAYMENT_SPKK_ZONE',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_ID',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_ACCEPTED_ID',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_DENIED_ID',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_ISSUE_ID',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_VOID_ID',
            'MODULE_PAYMENT_SPKK_ORDER_STATUS_AUTHORIZED_ID',
            'MODULE_PAYMENT_SPKK_MIN_AMOUNT',
            'MODULE_PAYMENT_SPKK_MAX_AMOUNT',
            'MODULE_PAYMENT_SPKK_MWST',
            'MODULE_PAYMENT_SECUPAY_ORDER_BEFORE_PAYMENT',
            'MODULE_PAYMENT_SECUPAY_SESSION'
        );

        if ($this->conf->secupay_kk_xtc->delivery_differs_disable) {
            $keys[] = 'MODULE_PAYMENT_SPKK_DELIVERY_DISABLE';
        }
        secupay_log($this->sp_log, "keys", $keys);
        return $keys;
    }


    /**
     * Function that inserts into the log table
     *
     * @return int - id of inserted logrecord
     */
    public function _prepare_trans_log($req_data, $ret_data, $hash, $transaction_id, $msg, $status, $amount)
    {
        try {
            $sql = "INSERT INTO secupay_transactions (req_data, ret_data,payment_method,`hash`,transaction_id, msg,status,amount,action,created)" .
                " VALUES ('" . xtc_db_input($req_data) . "','" . xtc_db_input($ret_data) . "','" . xtc_db_input($this->code) . "','" . xtc_db_input($hash) . "','" . xtc_db_input($transaction_id) . "','" . xtc_db_input($msg) . "','" . xtc_db_input($status) . "'," . xtc_db_input($amount) . ",'',NOW())";
            secupay_log($this->sp_log, $sql);
            xtc_db_query($sql);
            return xtc_db_insert_id();
        } catch (Exception $e) {
            secupay_log($this->sp_log, '_prepare_trans_log EXCEPTION: ' . $e->getMessage());
            return -1;
        }
    }

    /**
     * Function that inserts into secupay_transaction_order
     *
     * @return int - id of inserted record_id
     */
    private function _insert_hash($hash)
    {
        try {
            $sql = "INSERT INTO secupay_transaction_order (`hash`, `created`) VALUES ('" . xtc_db_input($hash) . "',NOW())";
            xtc_db_query($sql);
            return xtc_db_insert_id();
        } catch (Exception $e) {
            secupay_log($this->sp_log, '_insert_hash_log EXCEPTION: ' . $e->getMessage());
            return -1;
        }
    }

    /**
     * Function that calculates the EAN for a product
     *
     * @return string - products_ean
     */
    private function _get_product_ean($product_id)
    {
        try {
            $sql = 'SELECT products_ean FROM ' . TABLE_PRODUCTS . ' WHERE products_id = ' . intval($product_id) . ';';
            $qry = xtc_db_query($sql);

            $result = xtc_db_fetch_array($qry);

            return $result['products_ean'];
        } catch (Exception $e) {
            secupay_log($this->sp_log, '_get_product_ean EXCEPTION: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Function that checks if delivery adress differs from billing adress
     *
     * @return boolean
     */
    private function _check_delivery_differs($order)
    {
        if (isset($order->delivery)) {
            $differs = false;
            if ($order->delivery['firstname'] !== $order->billing['firstname']) {
                $differs = true;
            }
            if ($order->delivery['lastname'] !== $order->billing['lastname']) {
                $differs = true;
            }
            if ($order->delivery['company'] !== $order->billing['company']) {
                $differs = true;
            }
            if ($order->delivery['city'] !== $order->billing['city']) {
                $differs = true;
            }
            if ($order->delivery['postcode'] !== $order->billing['postcode']) {
                $differs = true;
            }
            if ($order->delivery['street_address'] !== $order->billing['street_address']) {
                $differs = true;
            }

            if ($order->delivery['country']['iso_code_2'] !== $order->billing['country']['iso_code_2']) {
                $differs = true;
            }

            return $differs;
        }
        secupay_log($this->sp_log, '_check_delivery_differs - delivery not set');
        return true;
    }
    public function get_secupay_conf($key)
    {
        $check_query = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '$key'");
        $secupay_config_value = xtc_db_fetch_array($check_query);
        return $secupay_config_value['configuration_value'];

    }
}

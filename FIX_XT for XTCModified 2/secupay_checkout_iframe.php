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

// include needed functions
require_once(DIR_FS_INC . 'xtc_calculate_tax.inc.php');
require_once(DIR_FS_INC . 'xtc_address_label.inc.php');
if (file_exists(DIR_WS_CLASSES . 'secupay_api.php')) {
    require_once(DIR_WS_CLASSES . 'secupay_api.php');
} else {
    require_once("../" . DIR_WS_CLASSES . 'secupay_api.php');
}
unset($lifetime_script);
unset($jquery_min);
if (MODULE_PAYMENT_SECUPAY_SESSION > 0) {
    if (!file_exists('templates/' . DIR_WS_CLASSES . 'javascript/jquery_min.js')) {
        $jquery_min = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>';
    }
    $lifetime_script = $jquery_min . '<script>$(document).ready( function() {
        var refreshTime = ' . MODULE_PAYMENT_SECUPAY_SESSION . '; // in milliseconds, so 10 minutes
        window.setInterval( function() {
            var url = \'index.php\';
            $.get( url );
        }, refreshTime );
    });</script>';
}
$logme = MODULE_PAYMENT_SPKK_LOGGING == "Ja";

secupay_log($logme, "iFrame Start");

if (isset($_SESSION['iframe_link']) && strlen($_SESSION['iframe_link']) > 10) {
    $iframe_url = $_SESSION['iframe_link'];
    secupay_log($logme, "iFrame " . $iframe);
} else {
    secupay_log($logme, "iFrame Bedingung 1");
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}
$smarty = new Smarty;

// include boxes
require(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

require(DIR_WS_INCLUDES . 'checkout_requirements.php');

// load selected payment module
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);

// load the selected shipping module
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

require(DIR_WS_CLASSES . 'order.php');
$order = new order();

require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total();
$order_total_modules->process();


if ($iframe_url == '') {
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_PAYMENT, xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('iframe_url', $iframe_url);
$main_content = $lifetime_script . '<iframe src="' . $iframe_url . '" width="100%" height="750" name="_top" frameborder="0"></iframe>';

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined('RM')) {
    $smarty->load_filter('output', 'note');
}
$smarty->display(CURRENT_TEMPLATE . '/index.html');
include('includes/application_bottom.php');

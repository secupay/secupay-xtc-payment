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

secupay_log($logme, "iFrame Start");

if (isset($_SESSION['iframe_link']) && strlen($_SESSION['iframe_link']) > 10) {
    $iframe = $_SESSION['iframe_link'];
    secupay_log($logme, "iFrame " . $iframe);
} else {
    secupay_log($logme, "iFrame Bedingung 1");
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
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
$smarty = new Smarty;
if (!isset($_SESSION['customer_id'])) {
    secupay_log($logme, "iFrame Bedingung 2");
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if ($_SESSION['customers_status']['customers_status_show_price'] != '1') {
    secupay_log($logme, "iFrame Bedingung 3");
    xtc_redirect(xtc_href_link(FILENAME_DEFAULT, '', ''));
}

if ((xtc_not_null(MODULE_PAYMENT_INSTALLED)) && (!isset($_SESSION['payment']))) {
    secupay_log($logme, "iFrame Bedingung 4");
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($_SESSION['cart']->cartID) && isset($_SESSION['cartID'])) {
    if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
        secupay_log($logme, "iFrame Bedingung 5");
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
}

secupay_log($logme, "iFrame Bedingungen ok");


$smarty->assign('iframe_url', $iframe);
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;

$main_content = '
    <style type="text/css">

.navLeft{
    height:630px;
    }
.iframe_wrapper{    
    margin-top:10px;
    text-align:center;
}
#iframe_wrapper_center{
border:0px solid #212121;
margin: 0 auto;
max-width: 550px;
}

div.wrap_shop div.iframe_wrapper {
    z-index: 1000;
/*
    position: absolute;
*/
	width: 550px;
}

#spiframe{
max-width:550px;
}
#fail_link a{    
font-size:normal;
text-decoration:none;
font-weight:bold;
color:white;
}
#fail_link{
background-color:#b55353;
text-align:center;
}</style>
' . $lifetime_script . '
<script>
function remove_dim_screen() {
    var secupay_screen_dim = document.getElementById(\'__dimScreen\');
    if( secupay_screen_dim && typeof secupay_screen_dim === \'object\') {
        secupay_screen_dim.parentNode.removeChild(secupay_screen_dim);
    }
}
</script>

<div class="iframe_wrapper">
    <div id="iframe_wrapper_center">
        <iframe id="spiframe" src="' . $iframe . '" width="100%" height="670px" scrolling="auto" name="_top" frameborder="0" onload="remove_dim_screen();"></iframe>
    </div>
</div>';

$coo_layout_control = MainFactory::create_object('LayoutContentControl');
$coo_layout_control->set_data('GET', $_GET);
$coo_layout_control->set_data('POST', $_POST);
$coo_layout_control->set_('coo_breadcrumb', $GLOBALS['breadcrumb']);
$coo_layout_control->set_('coo_product', $GLOBALS['product']);
$coo_layout_control->set_('coo_xtc_price', $GLOBALS['xtPrice']);
$coo_layout_control->set_('c_path', $GLOBALS['cPath']);
$coo_layout_control->set_('main_content', $main_content);
$coo_layout_control->set_('request_type', $GLOBALS['request_type']);
$coo_layout_control->proceed();

$t_redirect_url = $coo_layout_control->get_redirect_url();
if (empty($t_redirect_url) === false) {
    xtc_redirect($t_redirect_url);
} else {
    echo $coo_layout_control->get_response();
}

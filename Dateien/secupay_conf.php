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

define('SECUPAY_FRONTEND_URL', 'https://secuoffice.com');
define('SECUPAY_INFO_IFRAME_URL', 'https://connect.secupay.ag/shopiframe.php');
define('SECUPAY_PUSH_LOG', true);

/*
 * configuration for secupay payment modules
 */
if (!function_exists("get_sp_conf")) {
    function get_sp_conf()
    {
        $conf = '{
            "general": {
                "apikey": "<%SPAPIKEY%>",
                "modulversion": "3.20.6",
                "shop": "xtc",
                "session": "900000"
            },
            "secupay_ls_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "tautosend": true,
                "modul": "lastschrift xtc",
                "payment_type": "debit",
                "payment_action": "sale",
                "delivery_differs_disable": true
            },
            "secupay_kk_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "tautosend": true,
                "modul": "kreditkarte xtc",
                "payment_type": "creditcard",
                "payment_action": "sale",
                "delivery_differs_disable": true
            },
            "secupay_inv_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "vautosend": true,
                "rautosend": true,
                "tautosend": true,
                "modul": "rechnungskauf xtc",
                "payment_type": "invoice",
                "payment_action": "sale",
                "delivery_differs_disable": true
            },
            "secupay_b2b_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "vautosend": true,
                "rautosend": true,
                "tautosend": true,
                "modul": "rechnungskauf xtc",
                "payment_type": "invoice",
                "payment_action": "sale",
                "delivery_differs_disable": true,
                "select_name": "customer_b2b_status"
            },
            "secupay_pp_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "tautosend": true,
                "modul": "prepay xtc",
                "payment_type": "prepay",
                "payment_action": "sale",
                "delivery_differs_disable": true
            },
            "secupay_sk_xtc": {
                "modus": "demo",
                "debug": true,
                "experience": true,
                "tautosend": true,
                "modul": "sofortueberweisung xtc",
                "payment_type": "sofort",
                "payment_action": "sale",
                "delivery_differs_disable": true
            }
        }';
        return json_decode($conf);
    }
}

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

class SecupayOrderExtender extends SecupayOrderExtender_parent
{
    protected $invoice_view;

    public function proceed()
    {
        $orders_id = (int)$this->v_data_array['GET']['oID'];
        $order = new order($orders_id);
        if (($order->info['payment_method'] == 'secupay_inv_xtc' || $order->info['payment_method'] == 'secupay_b2b_xtc' || $order->info['payment_method'] == 'secupay_pp_xtc' || $order->info['payment_method'] == 'secupay_ls_xtc' || $order->info['payment_method'] == 'secupay_kk_xtc' || $order->info['payment_method'] == 'secupay_sk_xtc') && file_exists(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'secupay/secupay_orders.php')) {
            require_once(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'secupay/secupay_invoice_data.php');
            $hash = secupay_get_hash(intval($orders_id));
            $info_query = xtc_db_query("SELECT transaction_id,`status` FROM secupay_transactions WHERE ordernr = " . intval($orders_id) . " AND hash = '" . $hash . "';");
            $info_result = xtc_db_fetch_array($info_query);
            if (empty($info_result['status']) || $info_result['status'] == 'ok') {
                $status_tmp = secupay_get_status_data($hash);
                if ($status_tmp != 'scored' && $status_tmp != 'proceed') {
                    $info_result['status'] = $status_tmp;
                }
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_inv_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_inv_xtc.php');
                $invoice_data = secupay_get_invoice_data($hash);
                if (isset($hash)) {
                    $secupay_capture_url = SECUPAY_URL . $hash . '/capture/' . MODULE_PAYMENT_SECUPAY_APIKEY;
                    $secupay_info_link = '<a href=" ' . $secupay_capture_url . '" target="_blank">' . MODULE_PAYMENT_SPINV_CONFIRMATION_URL . '</a>';
                    $invoice_view = '<div class="grid">
												<div class="span8">
													<label>' . MODULE_PAYMENT_SECUPAY_OWNER_TITLE . ': </label>' . $invoice_data->transfer_payment_data->accountowner . '</br>
													<label>' . MODULE_PAYMENT_SPINV_BANKNAME_TITLE . ': </label>' . $invoice_data->transfer_payment_data->bankname . '</br>
													<label>' . MODULE_PAYMENT_SPINV_IBAN_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->iban . '</br>
													<label>' . MODULE_PAYMENT_SPINV_BIC_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->bic . '</br>
													<label>' . MODULE_PAYMENT_SPINV_INVOICE_PURPOSE . ' </label>: ' . $invoice_data->transfer_payment_data->purpose . '</br>
												</div>
											</div>';
                }
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_b2b_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_b2b_xtc.php');
                $invoice_data = secupay_get_invoice_data($hash);
                if (isset($hash)) {
                    $secupay_capture_url = SECUPAY_URL . $hash . '/capture/' . MODULE_PAYMENT_SECUPAY_B2B_APIKEY;
                    $secupay_info_link = '<a href=" ' . $secupay_capture_url . '" target="_blank">' . MODULE_PAYMENT_SPB2B_CONFIRMATION_URL . '</a>';
                    $invoice_view = '<div class="grid">
												<div class="span8">
													<label>' . MODULE_PAYMENT_SECUPAY_OWNER_TITLE . ': </label>' . $invoice_data->transfer_payment_data->accountowner . '</br>
													<label>' . MODULE_PAYMENT_SPB2B_BANKNAME_TITLE . ': </label>' . $invoice_data->transfer_payment_data->bankname . '</br>
													<label>' . MODULE_PAYMENT_SPB2B_IBAN_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->iban . '</br>
													<label>' . MODULE_PAYMENT_SPB2B_BIC_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->bic . '</br>
													<label>' . MODULE_PAYMENT_SPB2B_INVOICE_PURPOSE . ' </label>: ' . $invoice_data->transfer_payment_data->purpose . '</br>
												</div>
											</div>';
                }
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_pp_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_pp_xtc.php');
                $invoice_data = secupay_get_invoice_data($hash);
                if (isset($hash)) {
                    $invoice_view = '<div class="grid">
						<div class="span8">
							<label>' . MODULE_PAYMENT_SECUPAY_OWNER_TITLE . ': </label>' . $invoice_data->transfer_payment_data->accountowner . '</br>
							<label>' . MODULE_PAYMENT_SPPP_BANKNAME_TITLE . ': </label>' . $invoice_data->transfer_payment_data->bankname . '</br>
							<label>' . MODULE_PAYMENT_SPPP_IBAN_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->iban . '</br>
							<label>' . MODULE_PAYMENT_SPPP_BIC_TITLE . ' </label>: ' . $invoice_data->transfer_payment_data->bic . '</br>
							<label>' . MODULE_PAYMENT_SPPP_INVOICE_PURPOSE . ' </label>: ' . $invoice_data->transfer_payment_data->purpose . '</br>
						</div>
					</div>';
                }
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_ls_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_ls_xtc.php');
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_kk_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_kk_xtc.php');
            }
            if (isset($order) && $order->info['payment_method'] == 'secupay_sk_xtc') {
                include_once(DIR_FS_CATALOG . 'lang/' . $order->info['language'] . '/modules/payment/secupay_sk_xtc.php');
            }
            $view = '<div class="grid">
					<div class="span3">
						<label>' . MODULE_PAYMENT_SECUPAY_ADMIN_TANR . '</label>
					</div>
					<div class="span3">
						' . $info_result["transaction_id"] . '
					
				</div>';
            if (!empty($secupay_info_link)) {
                $view .= '<div class="span6">' . $secupay_info_link . '
					</div>';
            }
            $view .= '</div><br>
				<div class="grid">
					<div class="span3">
						<label>' . MODULE_PAYMENT_SECUPAY_ADMIN_STATUS . '</label>
					</div>
					<div class="span9">
						' . $info_result["status"] . '
					</div></div>';
            if (!empty($invoice_view)) {
                $view .= $invoice_view;
            }

            $this->v_output_buffer['below_order_info_heading'] = MODULE_PAYMENT_SECUPAY_ADMIN_INFO_BLOCK;
            $this->v_output_buffer['below_order_info'] = '' . $view . '';
            if (file_exists(DIR_FS_CATALOG . 'release_info.php')) {
                include(DIR_FS_CATALOG . 'release_info.php');
                if (str_replace('v', '', $gx_version) >= '2.6') {
                    $this->addContent();
                }
            }
        }
        parent::proceed();
    }
}

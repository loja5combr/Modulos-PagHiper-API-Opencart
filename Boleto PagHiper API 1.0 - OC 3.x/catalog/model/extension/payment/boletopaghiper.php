<?php
/*
* @package    PagHiper Opencart
* @version    1.0
* @license    BSD License (3-clause)
* @copyright  (c) 2018
* @link       https://www.paghiper.com/
* @dev        Bruno Alencar - Loja5.com.br
*/
class ModelExtensionPaymentBoletoPagHiper extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/boletopaghiper');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payment_boletopaghiper_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('payment_boletopaghiper_total') > 0 && $this->config->get('payment_boletopaghiper_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('payment_boletopaghiper_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'boletopaghiper',
				'title'      => $this->config->get('payment_boletopaghiper_titulo'),
				//'title'      => "<img src='caminho de sua imagem'>",
				'terms'      => '',
				'sort_order' => $this->config->get('payment_boletopaghiper_sort_order')
			);
		}

		return $method_data;
	}
}
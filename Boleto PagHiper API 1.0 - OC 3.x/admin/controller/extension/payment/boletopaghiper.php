<?php
/*
* @package    PagHiper Opencart
* @version    1.0
* @license    BSD License (3-clause)
* @copyright  (c) 2018
* @link       https://www.paghiper.com/
* @dev        Bruno Alencar - Loja5.com.br
*/
class ControllerExtensionPaymentBoletoPagHiper extends Controller {
	
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/boletopaghiper');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_boletopaghiper', $this->request->post);
			$this->response->redirect($this->url->link('extension/payment/boletopaghiper', 'salvo=true&user_token=' . $this->session->data['user_token'], true));
		}
		
		$data['campos'] = $this->getCustomFields();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['salvo_com_sucesso'] = isset($_GET['salvo'])?true:false;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['error_api_key'])) {
			$data['error_api_key'] = $this->error['error_api_key'];
		} else {
			$data['error_api_key'] = '';
		}
		
		if (isset($this->error['error_api_token'])) {
			$data['error_api_token'] = $this->error['error_api_token'];
		} else {
			$data['error_api_token'] = '';
		}
		
		if (isset($this->error['error_validade'])) {
			$data['error_validade'] = $this->error['error_validade'];
		} else {
			$data['error_validade'] = '';
		}
		
		if (isset($this->error['error_titulo'])) {
			$data['error_titulo'] = $this->error['error_titulo'];
		} else {
			$data['error_titulo'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('marketplace/extension', 'type=payment&user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/boletopaghiper', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/boletopaghiper', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'type=payment&user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->post['payment_boletopaghiper_api_key'])) {
			$data['payment_boletopaghiper_api_key'] = $this->request->post['payment_boletopaghiper_api_key'];
		} else {
			$data['payment_boletopaghiper_api_key'] = $this->config->get('payment_boletopaghiper_api_key');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_api_token'])) {
			$data['payment_boletopaghiper_api_token'] = $this->request->post['payment_boletopaghiper_api_token'];
		} else {
			$data['payment_boletopaghiper_api_token'] = $this->config->get('payment_boletopaghiper_api_token');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_titulo'])) {
			$data['payment_boletopaghiper_titulo'] = $this->request->post['payment_boletopaghiper_titulo'];
		} else {
			$data['payment_boletopaghiper_titulo'] = $this->config->get('payment_boletopaghiper_titulo');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_validade'])) {
			$data['payment_boletopaghiper_validade'] = $this->request->post['payment_boletopaghiper_validade'];
		} else {
			$data['payment_boletopaghiper_validade'] = $this->config->get('payment_boletopaghiper_validade');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_origem_cpf'])) {
			$data['payment_boletopaghiper_origem_cpf'] = $this->request->post['payment_boletopaghiper_origem_cpf'];
		} else {
			$data['payment_boletopaghiper_origem_cpf'] = $this->config->get('payment_boletopaghiper_origem_cpf');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_origem_cnpj'])) {
			$data['payment_boletopaghiper_origem_cnpj'] = $this->request->post['payment_boletopaghiper_origem_cnpj'];
		} else {
			$data['payment_boletopaghiper_origem_cnpj'] = $this->config->get('payment_boletopaghiper_origem_cnpj');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_origem_numero'])) {
			$data['payment_boletopaghiper_origem_numero'] = $this->request->post['payment_boletopaghiper_origem_numero'];
		} else {
			$data['payment_boletopaghiper_origem_numero'] = $this->config->get('payment_boletopaghiper_origem_numero');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_origem_complemento'])) {
			$data['payment_boletopaghiper_origem_complemento'] = $this->request->post['payment_boletopaghiper_origem_complemento'];
		} else {
			$data['payment_boletopaghiper_origem_complemento'] = $this->config->get('payment_boletopaghiper_origem_complemento');
		}

		if (isset($this->request->post['payment_boletopaghiper_total'])) {
			$data['payment_boletopaghiper_total'] = $this->request->post['payment_boletopaghiper_total'];
		} else {
			$data['payment_boletopaghiper_total'] = $this->config->get('payment_boletopaghiper_total');
		}

		if (isset($this->request->post['payment_boletopaghiper_order_status_id'])) {
			$data['payment_boletopaghiper_order_status_id'] = $this->request->post['payment_boletopaghiper_order_status_id'];
		} else {
			$data['payment_boletopaghiper_order_status_id'] = $this->config->get('payment_boletopaghiper_order_status_id');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_order_status_pago'])) {
			$data['payment_boletopaghiper_order_status_pago'] = $this->request->post['payment_boletopaghiper_order_status_pago'];
		} else {
			$data['payment_boletopaghiper_order_status_pago'] = $this->config->get('payment_boletopaghiper_order_status_pago');
		}
		
		if (isset($this->request->post['payment_boletopaghiper_order_status_cancelado'])) {
			$data['payment_boletopaghiper_order_status_cancelado'] = $this->request->post['payment_boletopaghiper_order_status_cancelado'];
		} else {
			$data['payment_boletopaghiper_order_status_cancelado'] = $this->config->get('payment_boletopaghiper_order_status_cancelado');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payment_boletopaghiper_geo_zone_id'])) {
			$data['payment_boletopaghiper_geo_zone_id'] = $this->request->post['payment_boletopaghiper_geo_zone_id'];
		} else {
			$data['payment_boletopaghiper_geo_zone_id'] = $this->config->get('payment_boletopaghiper_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payment_boletopaghiper_status'])) {
			$data['payment_boletopaghiper_status'] = $this->request->post['payment_boletopaghiper_status'];
		} else {
			$data['payment_boletopaghiper_status'] = $this->config->get('payment_boletopaghiper_status');
		}

		if (isset($this->request->post['payment_boletopaghiper_sort_order'])) {
			$data['payment_boletopaghiper_sort_order'] = $this->request->post['payment_boletopaghiper_sort_order'];
		} else {
			$data['payment_boletopaghiper_sort_order'] = $this->config->get('payment_boletopaghiper_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/boletopaghiper', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/boletopaghiper')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_boletopaghiper_api_key']) {
			$this->error['error_api_key'] = 'Infome a sua API Key PagHiper!';
		}
		
		if (!$this->request->post['payment_boletopaghiper_api_token']) {
			$this->error['error_api_token'] = 'Infome o seu Token PagHiper!';
		}
		
		if (!$this->request->post['payment_boletopaghiper_titulo']) {
			$this->error['error_titulo'] = 'Infome o titulo a exibir ao Cliente!';
		}
		
		if (!$this->request->post['payment_boletopaghiper_validade'] || (int)$this->request->post['payment_boletopaghiper_validade'] < 0) {
			$this->error['error_validade'] = 'Infome o prazo de validade em dias!';
		}

		return !$this->error;
	}
	
	public function getCustomFields($data = array()) {
		if (empty($data['filter_customer_group_id'])) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "custom_field` cf LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		} else {
			$sql = "SELECT * FROM " . DB_PREFIX . "custom_field_customer_group cfcg LEFT JOIN `" . DB_PREFIX . "custom_field` cf ON (cfcg.custom_field_id = cf.custom_field_id) LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND cfd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$sql .= " AND cfcg.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		$sort_data = array(
			'cfd.name',
			'cf.type',
			'cf.location',
			'cf.status',
			'cf.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cfd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>
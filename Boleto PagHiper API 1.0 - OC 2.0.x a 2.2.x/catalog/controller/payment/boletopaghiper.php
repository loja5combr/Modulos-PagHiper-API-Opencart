<?php
/*
* @package    PagHiper Opencart
* @version    1.0
* @license    BSD License (3-clause)
* @copyright  (c) 2018
* @link       https://www.paghiper.com/
* @dev        Bruno Alencar - Loja5.com.br
*/
class ControllerPaymentBoletoPagHiper extends Controller {
	
	public function index() {
		$this->language->load('payment/boletopaghiper');
		$this->load->model('checkout/order');
		//bloqueia o acesso 
		if(!isset($this->session->data['order_id'])){
			die('Ops, pedido n&atilde;o encontrado!');
		}
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['id_pedido'] = $this->session->data['order_id'];
		$data['hash'] = md5(sha1($data['id_pedido']));
		$fiscal = '';
		$cpf = $this->config->get('boletopaghiper_origem_cpf');
		$cnpj = $this->config->get('boletopaghiper_origem_cnpj');
		if(isset($order_info['custom_field'][$cpf]) && !empty($order_info['custom_field'][$cpf])){
			$fiscal = preg_replace('/\D/', '', $order_info['custom_field'][$cpf]);	
		}elseif(isset($order_info['custom_field'][$cnpj]) && !empty($order_info['custom_field'][$cnpj])){
			$fiscal = preg_replace('/\D/', '', $order_info['custom_field'][$cnpj]);	
		}
		$data['continue'] = $this->url->link('checkout/success','','SSL');
		$data['fiscal'] = $fiscal;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		if(version_compare(VERSION, '2.1.9.9', '<=')){
            return $this->load->view('default/template/payment/boletopaghiper.tpl', $data);
		}else{
            return $this->load->view('payment/boletopaghiper.tpl', $data);	
		}
	}
	
	public function getDescontos(){
		$query = $this->db->query("SELECT SUM(value) AS desconto FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND value < 0");
		if(!isset($query->row['desconto'])){
            return 0;	
		}
		$num = $query->row['desconto'];
		$num = $num <= 0 ? $num : -$num;
		return abs($num);
	}
	
	public function getFrete(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->session->data['order_id'] . "' AND code = 'shipping'");
		if(!isset($query->row['value'])){
            return 0;	
		}
		return abs($query->row['value']);
	}
	
	public function getTaxas(){
		$query = $this->db->query("SELECT SUM(value) AS taxa FROM " . DB_PREFIX . "order_total WHERE value > 0 AND order_id = '" . (int)$this->session->data['order_id'] . "' AND (code = 'handling' || code = 'tax')");
		if(isset($query->row['taxa'])){
            return abs($query->row['taxa']);
		}else{
            return 0;
		}
	}
	
	public function ipn(){
        $this->load->model('checkout/order');
		$transacao = '';
		$id_notificacao = '';
		if(isset($_POST['transaction_id'])){
			$transacao = $_POST['transaction_id'];
		}
		if(isset($_POST['notification_id'])){
			$id_notificacao = $_POST['notification_id'];
		}
        if(!empty($transacao) && !empty($id_notificacao) && $_POST['apiKey']==trim($this->config->get('boletopaghiper_api_key'))){
			
			$json = array();
			$json['token'] = trim($this->config->get('boletopaghiper_api_token'));
			$json['apiKey'] = trim($this->config->get('boletopaghiper_api_key'));
			$json['transaction_id'] = trim($transacao);
			$json['notification_id'] = trim($id_notificacao);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.paghiper.com/transaction/notification/');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Accept: application/json',
				'Content-Type: application/json'
			));
			$response = curl_exec($ch);
			$retorno = @json_decode($response,true);
			curl_close($ch);
			if(isset($retorno['status_request']['result']) && $retorno['status_request']['result']=='success'){
				$pedidos = $this->model_checkout_order->getOrder((int)$retorno['status_request']['order_id']);
				if($retorno['status_request']['status']=='paid'){
					if($pedidos['order_status_id']!=$this->config->get('boletopaghiper_order_status_pago')){
						$this->model_checkout_order->addOrderHistory((int)$retorno['status_request']['order_id'],$this->config->get('boletopaghiper_order_status_pago'),'',true);
					}
				}elseif($retorno['status_request']['status']=='canceled'){
					if($pedidos['order_status_id']!=$this->config->get('boletopaghiper_order_status_cancelado')){
						$this->model_checkout_order->addOrderHistory((int)$retorno['status_request']['order_id'],$this->config->get('boletopaghiper_order_status_cancelado'),'',true);
					}
				}
			}
        }
        echo 'IPN PagHiper';
    }
	
	private function post_pague(){
        $this->load->model('checkout/order');
		$pedidos = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		//custom
        $numero = $this->config->get('boletopaghiper_origem_numero');
		$complemento = $this->config->get('boletopaghiper_origem_complemento');
        
        //dados do boleto
        $fiscal = isset($_GET['fiscal'])?$_GET['fiscal']:'';
        $fiscal = preg_replace('/\D/', '', $fiscal);
        $json = array();
		$json['apiKey'] = trim($this->config->get('boletopaghiper_api_key'));
		$json['order_id'] = $this->session->data['order_id'];
		$json['partners_id'] = 'GYNBX5XE';
		$json['payer_email'] = $pedidos['email'];
		$json['payer_name'] = $pedidos['payment_firstname'].' '.$pedidos['payment_lastname'];
		$json['payer_cpf_cnpj'] = $fiscal;
		$json['payer_phone'] = preg_replace('/\D/', '', $pedidos['telephone']);
        $json['payer_street'] = $pedidos['payment_address_1'];
        $json['payer_district'] = $pedidos['payment_address_2'];
        $json['payer_city'] = $pedidos['payment_city'];
        $json['payer_state'] = $pedidos['payment_zone_code'];
        $json['payer_zip_code'] = preg_replace('/\D/', '', $pedidos['payment_postcode']);
        $json['payer_number'] = (isset($pedidos['payment_custom_field'][$numero]))?$pedidos['payment_custom_field'][$numero]:'*';
        $json['payer_complement'] = (isset($pedidos['payment_custom_field'][$complemento]))?$pedidos['payment_custom_field'][$complemento]:'';
		$json['notification_url'] = $this->url->link('payment/boletopaghiper/ipn','','SSL');
		$json['discount_cents'] = number_format($this->getDescontos(), 2, '', '');
		$json['shipping_price_cents'] = number_format($this->getFrete(), 2, '', '');
		$json['days_due_date'] = (int)$this->config->get('boletopaghiper_validade');
        $json['type_bank_slip'] = 'boletoA4';
        
        //produtos
		$i=1;
		foreach($this->cart->getProducts() AS $produto){
            $json['items'][$i]['item_id'] = $produto['product_id'];
            $json['items'][$i]['description'] = $produto['name'];
            $json['items'][$i]['price_cents'] = number_format($produto['price'], 2, '', '');
            $json['items'][$i]['quantity'] = $produto['quantity'];
            $i++;
		}
        $taxas = $this->getTaxas();
        if($taxas > 0){
            $json['items'][$i]['item_id'] = '1';
            $json['items'][$i]['description'] = 'Taxas e impostos';
            $json['items'][$i]['price_cents'] = number_format($taxas, 2, '', '');
            $json['items'][$i]['quantity'] = 1;
            $i++;
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.paghiper.com/transaction/create/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Content-Type: application/json'
		));
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $retorno = @json_decode($response,true);
        if(!$retorno){
            $retorno = $response;
        }
        curl_close($ch);
        return array('status'=>$httpcode,'enviado'=>$json,'retorno'=>$retorno);
    }

	public function confirm() {
        $this->load->model('checkout/order');
        $pague = $this->post_pague();
        $json = array();
        $json['original'] = $pague;
        if(($pague['status']==200 || $pague['status']==201) && isset($pague['retorno']['create_request']) && $pague['retorno']['create_request']['result']=='success'){
            
            $json['erro'] = false;
            $link = $pague['retorno']['create_request']['bank_slip']['url_slip_pdf'];
            $id = $pague['retorno']['create_request']['transaction_id'];
        
            //cria o pedido na loja
            $msg = "Transação ".$id." - <a href='".$link."' target='_blank'>Imprimir Boleto</a>";
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('boletopaghiper_order_status_id'), $msg, true);
            $json['boleto'] = $id;
            $json['boleto_hash'] = sha1($id);
			
        }elseif(isset($pague['response_message'])){
            $json['erro'] = true;
            $json['log'] = $pague['response_message'];
        }else{
            $json['erro'] = true;
            $json['log'] = 'Erro ao emitir boleto junto a PagHiper! (ver logs)';
        }
        
        //salva erros caso tenha
        if($json['erro']){
           $this->log->write('Erro PagHiper ['.$this->session->data['order_id'].']:'); 
           $this->log->write(print_r($pague,true)); 
        }
        
        echo json_encode($json);
	}
}
?>

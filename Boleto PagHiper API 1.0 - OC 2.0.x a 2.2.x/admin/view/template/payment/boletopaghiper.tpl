<!--
* @package    PagHiper Opencart
* @version    1.0
* @license    BSD License (3-clause)
* @copyright  (c) 2018
* @link       https://www.paghiper.com/
* @dev        Bruno Alencar - Loja5.com.br
-->

<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-salvar" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<?php if ($salvo_com_sucesso) { ?>
    <div class="alert alert-success"><i class="fa fa-check"></i> Dados do m&oacute;dulo salvos com sucesso!
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-salvar" class="form-horizontal">
		
	<div class="form-group">
	<div class="col-sm-12">
	<table><tbody><tr><td width='30%'><img src='https://www.paghiper.com/img/modulos/opencart/oficial-OC-2-2-x.png' style='max-width: 100%;'></td><td>
	Vers&atilde;o M&oacute;dulo
	<h2 style='font-weight: bold;margin-top: 0px;font-size: 200%;'>1.0</h2>
	</td></tr></tbody></table>
	<div  style="margin-left: 40px;">
	<h4>Para que o m&oacute;dulo funcione corretamente, siga as etapas abaixo:</h4>
	<p><br>1) Caso n&atilde;o possua uma conta PagHiper, <a href='https://www.paghiper.com/abra-sua-conta/' target='_blank-cadastro'><strong> crie a sua aqui</strong></a> <br></p>
	<p>2) Obtenha a sua apiKey e Token na <a href='https://www.paghiper.com/painel/credenciais/' target='_blank-apikey-token'><strong> pagina de credenciais</strong></a></p>
	<p>3) Verifique a exist&ecirc;ncia de uma <a href='https://www.paghiper.com/painel/GYNBX5XE/' target='_blank-GYNBX5XE'><strong> promo&ccedil;&atilde;o tarifaria </strong></a> para o m&oacute;dulo Opencart</p>
	<p><br>D&uacute;vidas? Visite a nossa <a href='https://atendimento.paghiper.com/hc/pt-br/articles/360001289133-M%C3%B3dulo-PAGHIPER-para-OpenCart' target='_blank-atendimento'><strong>central de atendimento</strong></a></p>
	</div>
	</div>
	</div>
		
			<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="Titulo a exibir ao Cliente">Titulo do M&oacute;dulo</span></label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_titulo" value="<?php echo $boletopaghiper_titulo; ?>" placeholder="Titulo a exibir ao Cliente" id="input-payable" class="form-control" />
              <?php if ($error_titulo) { ?>
              <div class="text-danger"><?php echo $error_titulo; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-payable"><span data-toggle="tooltip" title="Obtenha em sua conta PagHiper no menu Credenciais">API Key</span></label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_api_key" value="<?php echo $boletopaghiper_api_key; ?>" placeholder="API Key PagHiper" id="input-payable" class="form-control" />
              <?php if ($error_api_key) { ?>
              <div class="text-danger"><?php echo $error_api_key; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-payable"><span data-toggle="tooltip" title="Obtenha em sua conta PagHiper no menu Credenciais">API Token</span></label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_api_token" value="<?php echo $boletopaghiper_api_token; ?>" placeholder="API Token PagHiper" id="input-payable" class="form-control" />
              <?php if ($error_api_token) { ?>
              <div class="text-danger"><?php echo $error_api_token; ?></div>
              <?php } ?>
            </div>
          </div>
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-payable">Prazo de Validade (dias)</label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_validade" value="<?php echo $boletopaghiper_validade; ?>" placeholder="Prazo em dias" id="input-payable" class="form-control" />
              <?php if ($error_validade) { ?>
              <div class="text-danger"><?php echo $error_validade; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_total" value="<?php echo $boletopaghiper_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Origem CPF</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_origem_cpf" id="input-order-status" class="form-control">
              <option value="0" selected="selected">Cliente digita manual</option>
				<?php foreach ($campos as $campo) { ?>
				<?php if ($campo['custom_field_id'] == $boletopaghiper_origem_cpf) { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
				<?php } ?>
				<?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Origem CNPJ</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_origem_cnpj" id="input-order-status" class="form-control">
              <option value="0" selected="selected">Cliente digita manual</option>
				<?php foreach ($campos as $campo) { ?>
				<?php if ($campo['custom_field_id'] == $boletopaghiper_origem_cnpj) { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
				<?php } ?>
				<?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Origem N&uacute;mero Logradouro</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_origem_numero" id="input-order-status" class="form-control">
              <option value="0" selected="selected">Vai junto ao logradouro</option>
				<?php foreach ($campos as $campo) { ?>
				<?php if ($campo['custom_field_id'] == $boletopaghiper_origem_numero) { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
				<?php } ?>
				<?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Origem Complemento</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_origem_complemento" id="input-order-status" class="form-control">
              <option value="0" selected="selected">N&atilde;o requer o uso</option>
				<?php foreach ($campos as $campo) { ?>
				<?php if ($campo['custom_field_id'] == $boletopaghiper_origem_complemento) { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>" selected="selected"><?php echo $campo['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $campo['custom_field_id']; ?>"><?php echo $campo['name']; ?></option>
				<?php } ?>
				<?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Status Aguardando Pagamento</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $boletopaghiper_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Status Pago</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_order_status_pago" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $boletopaghiper_order_status_pago) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status">Status Cancelado</label>
            <div class="col-sm-10">
              <select name="boletopaghiper_order_status_cancelado" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $boletopaghiper_order_status_cancelado) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="boletopaghiper_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $boletopaghiper_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="boletopaghiper_status" id="input-status" class="form-control">
                <?php if ($boletopaghiper_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="boletopaghiper_sort_order" value="<?php echo $boletopaghiper_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
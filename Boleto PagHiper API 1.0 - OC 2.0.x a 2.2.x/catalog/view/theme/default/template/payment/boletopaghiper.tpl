<!--
* @package    PagHiper Opencart
* @version    1.0
* @license    BSD License (3-clause)
* @copyright  (c) 2018
* @link       https://www.paghiper.com/
* @dev        Bruno Alencar - Loja5.com.br
-->

<style>
@media screen and (max-width: 600px) {
  .input_100P {
	width:100% !important;
  }
}
</style>

<div class="row">
<div class="col-md-12">

<form id="boleto_form" onsubmit="return validar_fiscal();" method="post" action="javascript:void(0);" class="form-horizontal">

<div class="form-group">
<label class="col-xs-3 control-label"></label>
<div class="col-xs-3 selectContainer">
<img src="image/boletopaghiperboleto.png">
</div>
</div>

<div class="form-group">
<label class="col-xs-3 control-label">CPF/CNPJ</label>
<div class="col-xs-9">
<input type="text" onkeypress="return isNumberKey(event)" maxlength="14" style="width:40%" value="<?php echo $fiscal;?>" class="input_100P form-control" id="fiscal" name="fiscal" />
</div>
</div>

<div class="form-group buttons">
<div class="col-xs-9 col-xs-offset-3">
<div><input type="submit" class="btn btn-success" id="button-confirm" value="Confirmar Pedido"></div>
</div>
</div>
</form>

</div>
</div>

<script>
<!--
function validar_fiscal()
{
	var fiscal = $('#fiscal').val();
	var fiscal_valido = validarCpfCnpj(fiscal);
	if(!fiscal_valido){
		$('#fiscal').focus();
		alert('Digite o CPF/CNPJ correto!');
		return false;
	}
	confirmar_pedido();
	return true;
}
function confirmar_pedido()
{
	var fiscal = $('#fiscal').val();
	fiscal = (fiscal).replace(/\D/g,'');
	$.ajax({
		type: 'get',
        dataType: 'json',
		url: 'index.php?route=payment/boletopaghiper/confirm&fiscal='+fiscal,
		cache: false,
		beforeSend: function() {
			$('#button-confirm').prop('disabled', true);
		},
		complete: function() {
		},
		success: function(dados) {
            console.log(dados);
			if(dados.erro==true){
				$('#button-confirm').prop('disabled', false);
				alert(dados.log);
			}else{
				location.href = '<?php echo $continue; ?>&boleto=paghiper&fiscal='+fiscal+'&id='+dados.boleto+'&hash='+dados.boleto_hash;
			}
		}
	});
	return false;
}
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		return false;
	}
	return true;
}
function validaCPF(s) 
{
	var c = s.substr(0,9);
	var dv = s.substr(9,2);
	var d1 = 0;
	for (var i=0; i<9; i++) {
		d1 += c.charAt(i)*(10-i);
 	}
	if (d1 == 0) return false;
	d1 = 11 - (d1 % 11);
	if (d1 > 9) d1 = 0;
	if (dv.charAt(0) != d1){
		return false;
	}
	d1 *= 2;
	for (var i = 0; i < 9; i++)	{
 		d1 += c.charAt(i)*(11-i);
	}
	d1 = 11 - (d1 % 11);
	if (d1 > 9) d1 = 0;
	if (dv.charAt(1) != d1){
		return false;
	}
    return true;
}
function validaCNPJ(CNPJ) 
{
	var a = new Array();
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++){
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
	b = 0;
	for (y=0; y<13; y++) {
		b += (a[y] * c[y]);
	}
	if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		return false;
	}
	return true;
}

function validarCpfCnpj(valor) 
{
	var s = (valor).replace(/\D/g,'');
	var tam=(s).length;
	if (!(tam==11 || tam==14)){
		return false;
	}
	if (tam==11 ){
		if (!validaCPF(s)){
			return false;
		}
		return true;
	}		
	if (tam==14){
		if(!validaCNPJ(s)){
			return false;			
		}
		return true;
	}
}
//-->
</script>
# Requisitos
- Opencart 1.5.x / 2.0.x a 2.2.x / 2.3.x / 3.x
- Vqmod instalado caso use versão Opencart 1.5.x
- Conta vendedor ativada junto a PagHiper - https://paghiper.com

# Guia de instalação Módulo Boleto PagHiper Opencart

1 - Baixe os arquivos dos módulos para seu PC e escolha a versão qual deseja instalar de acordo a versão da Opencart, lembrando que a versão deve ser uma compativel, não existe retrocompatibilidade entre algumas versões de módulos Opencart.

2 - Com os arquivos baixados em sua maquina acesse os arquivos de sua loja usando um cliente FTP de sua preferência, caso não tenha um cliente FTP qual já use recomendamos o [Filezilla](https://www.homehost.com.br/blog/o-que-e-ftp-como-usar-o-filezilla/), acesse o seu servidor no diretorio principal de sua loja, após isso envie os arquivos do módulo de acordo a versão qual deseja usar, fique atento para não enviar de outras versões, somente da qual corresponde sua loja.

<i>Ps: Lembrando que os dados de acesso FTP a sua loja são fornecidos por sua hospedagem, muitos casos os dados são os mesmos de Cpanel.</i>

![Barra de Acesso](http://s.glbimg.com/po/tt/f/original/2012/09/26/filezilla01.png)

3 - Após acessado e enviado os arquivos do módulo corretamente a diretorio principal de sua loja acesse o painel administrativo de sua loja, geralmente o caminho é http://www.sualoja.com.br/admin/ e o login e senha já previamente cadastrado.

<i>Ps: Caso o admin de sua loja seja renomeado os arquivos de admin original do módulo devem ser enviados para pasta qual corresponde ser o admin em sua loja.</i>

![Admin](https://i.imgur.com/eidEAe2.png)

4 - Após acessar o Admin de sua loja vá até o menu <b>Extensões > Modificações</b> e no canto superior direito clique no botão para recarregar modificações, este processo é somente para Opencart 2.x a 3.x, para Opencart 1.5.x pule a próxima etapa.

<i>Ps: Recomendamos sempre antes fazer o backup caso sua loja possua algum customização especifica.</i>

![Recarregar modificações](https://i.imgur.com/Ljt73lX.png)

5 - Ainda no painel administrativo de sua loja acesse o menu <b>Extensções > Pagamento</b> localize e instale o módulo <b>Boleto PagHiper</b>, caso o mesmo não exiba na lista verifique se os passos anteriores foram feitos corretamente, principalmente a parte de envio dos arquivos ao servidor.

6 - Após instalado corretamente, clique em Editar a configuração do mesmo, vai exibir a tela de configuração onde vai pedir as suas credenciais junto a PagHiper, acesse sua conta PagHiper no menu [<b>Minha Conta > Credenciais</b>](https://www.paghiper.com/painel/credenciais/) ira obter os dados qual ira configurar no módulo em sua loja.

<i>Ps: Os campos customizados vai de acordo a loja do cliente, configurados somente se a mesma possuir.</i>

![Configuração](https://i.imgur.com/S7bVFo8.png)

7 - Configurado o módudo corretamente de acordo com os dados de sua conta salve as configurações, feito isso é só testar em caso de erros os logs do mesmo ficam salvos no Admin de sua loja em <b>Configurações > Ferramentas > Logs de erro</b> com o motivo do mesmo, lembrando que o módulo é API, portanto sua loja deverá manter a base de dados do cliente cadastrado corretamente.

8 - O retorno de dados é feito automaticamente quando um boleto é pago/cancelado, portanto não precisa configurar nenhuma url junto ao sistema da PagHiper, o módulo já faz o processo automaticamente.

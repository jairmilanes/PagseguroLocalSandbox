<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;Help</h4>
</div>
<div class="modal-body order">
      
      Sobre
      Como funciona
      Instalação
      Criando Virtual hosts
      COnfiguração
      Faq
      Contato
      
      Sobre o PagSeguro LocalSandBox
      	
      	Teste sua integração com as API´s V2 do PagSeguro em seu servidor local com facilidade, totalmente
		integrado com a bibliotéca php do PagSeguro, você pode criar quantas transações quiser, buscar
		transações por código ou intervalo de data, criar notificação alterando o status das transações em
		um painel simples e fácil de usar.

      		confira dados enviados
      		crie transações ilimitadas
      		envie notificações ilimitadas
      		consulta de transações por código
      		consulta de transações por intervalo de data
      		acompanhe os logs
      	
      	
      	
      	Como funciona
      	
      	A Sandbox mascara as consultas feitas para a api do PagSeguro permitindo a testar todas as consultas
      	antes de rodar testes com consultas reais já que o PagSeguro ainda não possui sua Sandbox para testes,
      	ainda assim você não teria tudo localmente.

      	Instalação
      	
      		Para utilizar a sandbox basta redirecionar a api do PagSeguro
      		para seu servidor local, fazendo com que a Sandbox responda
      		por todas as chamadas à api do PagSeguro.
      		
      		Como as chamadas feitas à API utilizam SSL você também pode
      		configurar seu ssl local caso não o tenha feito ainda para garantir uma
      		integração mais completa com a Sandbox mas isto é completamente opcional.
      		
      		A Sandbox reponde a maioria das consultas da Api do pagsguro utilizando a mesmo
      		a url, tornando mais fácil sua utilização. Para começar a
      		utilizar a Sandbox siga os passos abaixo.
      		
      		Duas opções de instalação, clone via github ou arquivo .zip.
      		Escolha uma das opções e compie os arquivos para uma pasa em
      		seu servidor local neste exemplo utilizamos "/pg_localsandbox".

      	Criando virtual hosts
      	
      		É necessário adicionar duas entradas ao seu arquivo hosts ( Windows "C:\Windows\System32\Drivers\etc" ),
      		as duas apontando para a para o localhost:
      		
      			127.0.0.1  localsandbox.pagseguro.uol.com.br
      			127.0.0.1  ws.localsandbox.pagseguro.uol.com.br
      		
      		Com isso precisamos criar duas uma entrada no arquivo vHosts do apache, a localização deste arquivo varia
      		dependendo do metodo de instalção do servidor local.
      		Segue abaixo os exemplos de entradas no virtual hosts, lembre-se que
      		estas configurações podem variar de acordo com seu ambiente.
      		
      			<VirtualHost *:80>
				    ServerName localsandbox.pagseguro.uol.com.br
					ServerAlias ws.localsandbox.pagseguro.uol.com.br
					
				    DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_localsandbox"
				    SetEnv APPLICATION_ENV "development"
				    <Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_localsandbox">
				        DirectoryIndex index.php
				        AllowOverride All
				        Order allow,deny
				        Allow from all
				    </Directory>
				</VirtualHost>
      		
      		Caso tenha ssl configurado segue abaix um exemplo de vHost para SSL:
      		
      			<VirtualHost *:443>
      			
				    ServerName localsandbox.pagseguro.uol.com.br
					ServerAlias ws.localsandbox.pagseguro.uol.com.br
				    DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox"
				    SetEnv APPLICATION_ENV "development"
					
					SSLEngine on
					SSLCertificateKeyFile E:\Servidor\Zend\Apache2\conf\certs\ada48caf-6d46-4bca-ae63-c68385c2652d.private.pem
					SSLCertificateFile E:\Servidor\Zend\Apache2\conf\certs\ada48caf-6d46-4bca-ae63-c68385c2652d.public.pem
					SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown
					
				    <Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox">
				        DirectoryIndex index.php
				        AllowOverride All
				        Order allow,deny
				        Allow from all
				    </Directory>
					
				</VirtualHost>
      		
      		Com as entradas no arquivo hosts criadas e os vHosts configurados basta reiniciar seu Apache
      		para que as alterações entrem em vigor, e você possa começar a utilizar a Sandbox.
      		
      		Acesso ao painel : localsandbox.pagseguro.uol.com.br
      		
      	
      	Configuração
      	
      		Quando acessar o painel pela primeira vez será necessário fornecer algumas informações
      		
      
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
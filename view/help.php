<div id="help">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">
			<span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;Help
		</h4>
	</div>
	<div class="modal-body">
	
		
			<div class="navigation col-xs-3 col-sm-3">
				<div id="nav_spy" data-offset="60" role="navigation">
					<ul class="nav" >
						<li class="active"><a href="#about"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Sobre</a></li>
						<li><a href="#how_works"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Como funciona</a></li>
						<li><a href="#install"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Instalação</a></li>
						<li><a href="#vhosts"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Criando Virtual hosts</a></li>
						<li><a href="#config"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Configuração</a></li>
						<li><a href="#ssl"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Ssl</a></li>
						<li><a href="#all_done"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Tudo pronto!</a></li>
						<li><a href="#contact"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Contato</a></li>
					</ul>
				</div>
			</div>
			
			
			<div id="scrollpanel" class="col-xs-9 col-sm-9" data-offset="60" data-spy="scroll" data-target="#nav_spy" style="position: relative; height: 400px; overflow-x: hidden; overflow-y: auto;">

				<div id="about" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Sobre o PagSeguro LocalSandBox</h3>
					</div>
					<div class="panel-body">
						<p><?php echo 'Teste sua integração com as API´s V2 do PagSeguro em seu servidor local '.
									  'com facilidade, integrações são complicadas por si só, e um ambiente de '.
									  'testes simples, rápido e confiavel é indispensável para obter um bom '.
									  'resultado.'; ?></p>
						<hr>
						<h5><strong>Com a Sandbox Local você pode:</strong></h5>
						<ul class="list-unstyled">
							<li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Crie transações de teste
								ilimitadas</li>
							<li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Envie
								notificações teste ilimitadas</li>
							<li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Conferir as dados
								enviados ao PagSeguro</li>
							<li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Consultar
								transações por código</li>
							<li><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Consultar
								transações por intervalo de data</li>
						</ul>
					</div>
				</div>


				<div id="how_works" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Como funciona</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'A Sandbox mascara as consultas feitas à api do PagSeguro permitindo testar todas as consultas
			      		antes de rodar testes com consultas reais já que o PagSeguro ainda não possui sua Sandbox,
			      		ainda assim você não teria tudo localmente.';
						?></p>
					</div>
				</div>


				<div id="install" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Instalação</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'Para utilizar a sandbox basta redirecionar a api do PagSeguro
			      		para seu servidor local, fazendo com que a Sandbox responda
			      		por todas as chamadas à api do PagSeguro.';
						?></p>

						<p><?php
						
echo 'Como as chamadas feitas à API utilizam SSL você também pode
			      		configurar seu ssl local caso não o tenha feito ainda para garantir uma
			      		integração mais completa com a Sandbox mas isto é completamente opcional.';
						?></p>

						<p><?php
						
echo 'A Sandbox reponde a maioria das consultas da Api do pagsguro utilizando a mesmo
			      		a url, tornando mais fácil sua utilização. Para começar a
			      		utilizar a Sandbox siga os passos abaixo.';
						?></p>

						<p><?php
						
echo 'Duas opções de instalação, clone via github ou arquivo .zip.
			      		Escolha uma das opções e compie os arquivos para uma pasa em
			      		seu servidor local neste exemplo utilizamos "/pg_localsandbox".';
						?></p>
					</div>
				</div>


				<div id="vhosts" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Criando virtual hosts</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'É necessário adicionar duas entradas ao seu arquivo hosts ( Windows C:\Windows\System32\Drivers\etc ),' . 'as duas apontando para a para o localhost:';
						?></p>
						<pre><?php echo '127.0.0.1  localsandbox.pagseguro.uol.com.br' . "\n" . '127.0.0.1  ws.localsandbox.pagseguro.uol.com.br' . "\n";?></pre>
						<p><?php echo 'Com isso precisamos criar duas uma entrada no arquivo vHosts do apache, a localização deste arquivo varia dependendo do metodo de instalção do servidor local.';?></p>
						<p><?php
						
echo 'Segue abaixo os exemplos de entradas no virtual hosts, lembre-se que
			      		estas configurações podem variar de acordo com seu ambiente.';
						?></p>
						<pre><?php echo trim (
							htmlentities (
								'<VirtualHost *:80>' . "\n"
								.'	ServerName localsandbox.pagseguro.uol.com.br'."\n"
								.'	ServerAlias ws.localsandbox.pagseguro.uol.com.br'."\n"
								.'	DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_localsandbox"' . "\n"
								.'	SetEnv APPLICATION_ENV "development"' . "\n"
								.'		<Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_localsandbox">' . "\n"
								.'			DirectoryIndex index.php' . "\n"
								.'			AllowOverride All' . "\n"
								.'			Order allow,deny' . "\n"
								.'			Allow from all' . "\n"
								.'		</Directory>' . "\n"
								.'</VirtualHost>' . "\n"
							)
						);
					?>
			  		</pre>
						<p><?php echo 'Caso tenha ssl configurado segue abaix um exemplo de vHost para SSL:';?></p>
					<pre><?php echo trim (
							htmlentities (
								'<VirtualHost *:443>' . "\n"
								.'	ServerName localsandbox.pagseguro.uol.com.br' . "\n"
								.'	ServerAlias ws.localsandbox.pagseguro.uol.com.br' . "\n"
								.'	DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox"' . "\n"
							    .'	SetEnv APPLICATION_ENV "development"' . "\n"
									
								.'	SSLEngine on' . "\n"
								.'	SSLCertificateKeyFile E:\Servidor\Zend\Apache2\conf\certs\ada48caf-6d46-4bca-ae63-c68385c2652d.private.pem' . "\n"
								.'	SSLCertificateFile E:\Servidor\Zend\Apache2\conf\certs\ada48caf-6d46-4bca-ae63-c68385c2652d.public.pem' . "\n"
								.'	SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown' . "\n"
									
								.'	<Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox">' . "\n"
								.'    	DirectoryIndex index.php' . "\n"
								.'    	AllowOverride All' . "\n"
								.'    	Order allow,deny' . "\n"
								.'    	Allow from all' . "\n"
								.'	</Directory>' . "\n"
									
								.'</VirtualHost>' . "\n"
								)
							);
						?>
						</pre>

						<p><?php
						
echo 'Com as entradas no arquivo hosts criadas e os vHosts configurados basta reiniciar seu Apache
			      		para que as alterações entrem em vigor.';
						?></p>
					</div>
				</div>


				<div id="config" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Configuração</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'Quando acessar o painel pela primeira vez será necessário fornecer algumas informações, as mesmas informações
			      		fornecidas na configuração do PagSeguro:';
						?></p>

						<ul class="list-group">
							<li class="list-group-item">
								<h4>Email</h4>
								<p>Email de authenticação no PagSeguro</p>
							</li>
							<li class="list-group-item">
								<h4>Token</h4>
								<p>Um token teste é fornecido, use este token teste mais o email
									informado em todas as requisições à SandBox.</p>
							</li>
							<li class="list-group-item">
								<h4>Domínio</h4>
								<p>O hostname local do website ou app integrando à Sandbox,
									"meusite.localhost"</p>
							</li>
							<li class="list-group-item">
								<h4>Url de notificação</h4>
								<p>Url utilizada na notificação de alteração de status, sem o
									hostname</p>
							</li>
							<li class="list-group-item">
								<h4>Redirecionamento fixo</h4>
								<p>Caso utiliza o sistema de redirecionamento fixo click no
									checkbox para ativar</p>
							</li>
							<li class="list-group-item">
								<h4>Url de redirecionamento</h4>
								<p>Se optou pelo redirecimento fixo informe a url de
									redirecionamento.</p>
							</li>
							<li class="list-group-item">
								<h4>Porta</h4>
								<p>Caso sua conexão utilize uma porta diferente da 80 informe
									aqui.</p>
							</li>
							<li class="list-group-item">
								<h4>Após confirmação</h4>
								<p><?php
								
echo 'Esta opção permite que ao invés de ser redirecionado de volta ao seu site
							na finalizaçõa do pagamento a resposta deste request seja mostrada na tela.
							Isto pode ser utilizado para analizar a resposta do seu servidor ao retorno
							da transação ( foi util para min, achei que pudesse ser util a outros então deixei ).';
								?></p>
							</li>
						</ul>

						<p>Com a configuração completa tudo está pronto para seus testes.</p>
						<p>Integre o PagSeguro normalmente, o Sandbox irá masacarar todas
							as chamadas feitas a api.</p>
					</div>
				</div>

				
				<div id="ssl" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Sandbox com ssl ( Opcional)</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'A utlização de ssl em seus testes locais podem não trazer tantos benefícios mas ajudam a
			        	garantir o funcionamento completo de sua integração, mas lembre-se o uso de ssl não é
			        	obrigatório.';
						?>' </p>
						<p><?php
						
echo 'Os passos abaixo descrevem brevemente como configurar ssl em seu servidor
			        	local, lembrando que estes passos podem variar dependendo da configuração local de cada um.';
						?></p>
					</div>
				</div>

				
				<div id="all_done" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Tudo pronto!</h3>
					</div>
					<div class="panel-body">
						<p><?php
						
echo 'Com estes passos executados você agora pode acessar o painel de transações' . '<a href="http://ws.pagseguro.uol.com.br">http:\/\/ws.pagseguro.uol.com.br</a> e começar a disparar requisições à Sandbox seguindo' . 'o fluxo normal da api do Pagseguro como descreve em sua área para desenvolvedores.';
						?></p>
					</div>
				</div>


				<div id="contact" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Contato</h3>
					</div>
					<div class="panel-body">
						<p><strong>Jair Milanes Junior</strong></p>
						<p><strong>Website:</strong>&nbsp;&nbsp;<a target="_blank" href="http://layoutz.com.br">layoutz.com.br</a></p>
						<p><strong>Email:</strong>&nbsp;&nbsp;contact@layoutz.com.br</p>
						<p><strong>Github:</strong>&nbsp;&nbsp;<a target="_blank" href="https://github.com/layoutzweb">github.com/layoutzweb</a></p>
						<p><strong>Facebook:</strong>&nbsp;&nbsp;<a target="_blank" href="https://www.facebook.com/layoutz">facebook.com/layoutz</a></p>
					</div>
				</div>

			</div>
		

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</div>
<script type="text/javascript">
setTimeout(function(){
	$('#scrollpanel').scrollspy('refresh');
	$('#help .nav a').on('click', function(e){
		e.preventDefault();
		var self = $(this);
		var container_offset = $('#scrollpanel').scrollTop();
		var offset = parseInt($(self.attr('href')).position().top);
		$('#scrollpanel').animate({
            scrollTop: ( ( container_offset + offset) - 5 )
        }, 1000);
	});
},400);
</script>
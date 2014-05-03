PagSeguro Local SandBox
===============================================================

Teste sua integração com as API´s V2 do PagSeguro em seu servidor local com facilidade, totalmente integrado com a bibliotéca php do PagSeguro, você pode criar quantas transações quiser, buscar transações por código ou intervalo de data, criar notificação alterando o status das transações em um painel simples e fácil de usar.


# Como Funciona #
Para utilizar a sandbox basta executar o passo 1, redirecionando o acesso da api para seu servidor local, mas pode também configurar seu ssl local caso não o tenha feito ainda para garantir uma integração mais completa com a Sandbox.

## Crie uma entrada no hosts ##
Crie uma entrada em seu arquivo de hosts para que sua integração não acesse mais o WS do PagSeguro e sim nossa Sandbox.
```
127.0.0.1       ws.pagseguro.uol.com.br
```

--------------------------------------------------------------------------------

--------------------------------------------------------------------------------

## Sandbox sem ssl ##
Caso queira utilizar a sandbox sem ssl siga os seguintes passos:

### Crie o vHost ###
Localize o arquivo "Apache2/conf/extra/vhost_dev.conf" e copie o código abaixo ao final do arquivo, lembrando de alterar os caminhos para sua instalação local.
```
<VirtualHost *:80>
    ServerName ws.pagseguro.uol.com.br
    DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox"
    SetEnv APPLICATION_ENV "development"
    <Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

--------------------------------------------------------------------------------

--------------------------------------------------------------------------------

## Sandbox com ssl ( Opcional) ##
A utlização de ssl em seus testes locais podem não trazer tantos benefícios mas ajudam a garantir o funcionamento completo de sua integração, mas lembre-se o uso de ssl não é obrigatório.
Os passos abaixo descrevem brevemente como configurar ssl em seu servidor local, lembrando que estes passos podem variar dependendo da configuração local de cada um.

### Gere os arquivos necessarios ###
Existem varias maneiras de gerar os certificados, eu testei algumas por linha de comando, achei um pouco complicado, fora que não consegui iniciar meu apache com os arquivos gerados, então encontrei este site:

<http://www.selfsignedcertificate.com/>

Nele você da um nome qualquer ao certificado e ele gera o .key e .cert para você, gere seu certificado e faça o download do .key e .cert.

### Salve os arquivos gerados ###

Com os arquivos baixados basta copiar os dois no seguinte caminho:            
```
CAMINHO_DO_APACHE\Apache2\conf\
```  
Substitua "CAMINHO_DO_APACHE" pelo caminho até a pasta Apache2 em seu computador normalmente localizada em:          
```
C:\Program Files (x86)\Apache2\
```       

### Enable ssl on apache ###
Abra o arquivo httpd.conf normalmente localizado em:
```
C:\Program Files (x86)\Apache2\conf\
```
mas pode variar dependendo de sua instalação.
Com httpd.conf aberto procure pela linha:
```
#LoadModule ssl_module modules/mod_ssl.so
```
e remova o "#" para abilitar o modulo ssl.
Agora procure pela linha:
```
#Include conf/extra/httpd-ssl.conf
```
e faça o mesmo que na linha anterior, remova o "#" do inicio para carregar as configurações ssl do Apache.

### Configurando os certificados ###
Abra o arquivo httpd-ssl.conf e encontre as seguintes linhas:
```
SSLCertificateFile "E:\Servidor\Zend\Apache2\conf\server.cert"
```
```
SSLCertificateKeyFile "E:\Servidor\Zend\Apache2\conf\server.key""
```
Garanta que os caminhos estajam corretos, caso contrário seu servidor não vai reiniciar.


### Criando um vHost para a sandbox ###
Encontre o arquivo responsável por conter os v-hosts ssl, no meu caso eu utilizo o ZendServer CE então os caminhos seguem comos os do exemplo abaixo, mas tenha certeza de alterar cada caminho conforme sua configuração local.
```
<VirtualHost *:443>

    ServerName ws.pagseguro.uol.com.br
    DocumentRoot "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox"
    SetEnv APPLICATION_ENV "development"
    
	SSLEngine on
	SSLCertificateKeyFile E:\Servidor\Zend\Apache2\conf\server.key
	SSLCertificateFile E:\Servidor\Zend\Apache2\conf\server.cert
	SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown
	
    <Directory "E:\Servidor\Zend\Apache2\htdocs\SANDBOXES\pg_sandbox">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
	
</VirtualHost>
```

### Tudo pronto! ###
Agora basta reiniciar seu servidor apache, se tudo foi feito corretamente você poderá acessar a sandbox com a seguinte url:    

<http://ws.pagseguro.uol.com.br>

Caso não funcione corretamente confira todos os caminhos, é a causa do problema na mairoria das vezes.


--------------------------------------------------------------------------------

--------------------------------------------------------------------------------

Caso tenha sugestões ou gostaria de contriguir para o projeto, utilize os forks e pull requests, para bugs utilise a área de "issues" aqui do github que irei analizar todos o quanto antes.



<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="currency" value="BRL" />
<input type="hidden" name="receiverEmail" value="web@layoutz.com.br" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/205x30-doar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->













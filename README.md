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

[Clique aqui para ver o tutorial de configuração do ssl em seu servidor local.](https://github.com/layoutzweb/PagseguroLocalSandbox/wiki/Configurando-SSL-no-seu-servidor-local)

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













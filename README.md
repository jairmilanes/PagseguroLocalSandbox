![PagSeguro Sandbox logo](https://github.com/layoutzweb/PagseguroLocalSandbox/blob/master/img/logo.png?raw=true)
PagSeguro Local SandBox
===============================================================

### Sobre o PagSeguro LocalSandBox

Teste sua integração com as API´s V2 do PagSeguro em seu servidor local
com facilidade, integrações são complicadas por si só, e um ambiente de
testes simples, rápido e confiavel é indispensável para obter um bom
resultado.

* * * * *

#### **Com a Sandbox Local você pode:**

-   Crie transações de teste ilimitadas
-   Envie notificações teste ilimitadas
-   Conferir as dados  enviados ao PagSeguro
-   Consultar transações por código
-   Consultar transações por intervalo de data    
    

**************************************************************************        
         
         
### Como funciona

A Sandbox mascara as consultas feitas à api do PagSeguro permitindo
testar todas as consultas antes de rodar testes com consultas reais já
que o PagSeguro ainda não possui sua Sandbox, ainda assim você não teria
tudo localmente.
    

**************************************************************************        
         
         
### Instalação


Para utilizar a sandbox basta redirecionar a api do PagSeguro para seu
servidor local, fazendo com que a Sandbox responda por todas as chamadas
à api do PagSeguro.

Como as chamadas feitas à API utilizam SSL você também pode configurar
seu ssl local caso não o tenha feito ainda para garantir uma integração
mais completa com a Sandbox mas isto é completamente opcional.

A Sandbox reponde a maioria das consultas da Api do pagsguro utilizando
a mesmo a url, tornando mais fácil sua utilização. Para começar a
utilizar a Sandbox siga os passos abaixo.

Duas opções de instalação, clone via github ou arquivo .zip. Escolha uma
das opções e compie os arquivos para uma pasa em seu servidor local
neste exemplo utilizamos “/pg\_localsandbox”.
    

**************************************************************************        
         
         
### Criando virtual hosts 

É necessário adicionar duas entradas ao seu arquivo hosts ( Windows
C:\\Windows\\System32\\Drivers\\etc ),as duas apontando para a para o
localhost:

    127.0.0.1  localsandbox.pagseguro.uol.com.br
    127.0.0.1  ws.localsandbox.pagseguro.uol.com.br

Com isso precisamos criar duas uma entrada no arquivo vHosts do apache,
a localização deste arquivo varia dependendo do metodo de instalção do
servidor local.

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

Com as entradas no arquivo hosts criadas e os vHosts configurados basta
reiniciar seu Apache para que as alterações entrem em vigor.
    

**************************************************************************        
         
         
### Configuração 

Quando acessar o painel pela primeira vez será necessário fornecer
algumas informações, as mesmas informações fornecidas na configuração do
PagSeguro:

* **Email**
  * Email de authenticação no PagSeguro


* **Token**
  * Um token teste é fornecido, use este token teste mais o email informado
em todas as requisições à SandBox.


* **Domínio**
  * O hostname local do website ou app integrando à Sandbox,
“meusite.localhost”


* **Url de notificação**
  * Url utilizada na notificação de alteração de status, sem o hostname


* **Redirecionamento fixo**
  * Caso utiliza o sistema de redirecionamento fixo click no checkbox para
ativar


* **Url de redirecionamento**
  * Se optou pelo redirecimento fixo informe a url de redirecionamento.


* **Porta**
  * Caso sua conexão utilize uma porta diferente da 80 informe aqui.


* **Após confirmação**
  * Esta opção permite que ao invés de ser redirecionado de volta ao seu
site na finalizaçõa do pagamento a resposta deste request seja mostrada
na tela. Isto pode ser utilizado para analizar a resposta do seu
servidor ao retorno da transação ( foi util para min, achei que pudesse
ser util a outros então deixei ).


Com a configuração completa tudo está pronto para seus testes.

Integre o PagSeguro normalmente, o Sandbox irá masacarar todas as
chamadas feitas a api.
    

**************************************************************************        
         
         
### Sandbox com ssl ( Opcional) 

A utlização de ssl em seus testes locais podem não trazer tantos
benefícios mas ajudam a garantir o funcionamento completo de sua
integração, mas lembre-se o uso de ssl não é obrigatório.’

Os passos abaixo descrevem brevemente como configurar ssl em seu
servidor local, lembrando que estes passos podem variar dependendo da
configuração local de cada um.
    

**************************************************************************        
         
         
### Tudo pronto! 

Com estes passos executados você agora pode acessar o painel de
transações[http:\\/\\/ws.pagseguro.uol.com.br][] e começar a disparar
requisições à Sandbox seguindoo fluxo normal da api do Pagseguro como
descreve em sua área para desenvolvedores.

  [http:\\/\\/ws.pagseguro.uol.com.br]: http://ws.pagseguro.uol.com.br

    

**************************************************************************        
         
         
### Contato 

**Jair Milanes Junior**

**Website:**  [layoutz.com.br][]

**Email:**  contact@layoutz.com.br

**Github:**  [github.com/layoutzweb][]

**Facebook:**  [facebook.com/layoutz][]


  [layoutz.com.br]: http://layoutz.com.br
  [github.com/layoutzweb]: https://github.com/layoutzweb
  [facebook.com/layoutz]: https://www.facebook.com/layoutz

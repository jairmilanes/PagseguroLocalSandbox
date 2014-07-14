<table border="0" cellpadding="0" cellspacing="0"
	summary="Parâmetros esperados pela API de Pagamentos">
	<thead>
		<tr>
			<th>PARÂMETRO</th>
			<th>DESCRIÇÃO</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>Cabeçalho HTTP:<br> <strong>charset</strong></td>
			<td>
				<p>
					<strong>Codificação de caracteres.</strong>
				</p>
				<p>Especifica a codificação de caracteres usada nos parâmetros
					enviados.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Os valores aceitos são <strong>ISO-8859-1</strong>
					e <strong>UTF-8</strong>.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>email</strong></td>
			<td>
				<p>
					<strong>E-mail da conta que chama a API.</strong>
				</p>
				<p>Especifica o e-mail associado à conta PagSeguro que está
					realizando a chamada à API.</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> um e-mail válido (p.e.,
					usuario@site.com.br), com no máximo 60 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>token</strong></td>
			<td>
				<p>
					<strong>Token da conta que chama a API.</strong>
				</p>
				<p>
					Informa o token correspondente à conta PagSeguro que está
					realizando a chamada a API. Para criar um token para sua conta
					PagSeguro, acesse a <a href="/integracao/token-de-seguranca.jhtml">página
						de configurações de pagamentos</a>.
				</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> uma sequência de 32
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">
					<strong>&lt;checkout&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Este campo é a raiz do arquivo XML e engloba os dados do
						pagamento.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>receiverEmail</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;receiver&gt;</div>
				<div class="tab3">
					<strong>&lt;email&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Especifica o e-mail que deve aparecer na tela de pagamento.</strong>
				</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> um e-mail válido (p.e.,
					usuario@site.com.br), com no máximo 60 caracteres. O e-mail
					informado deve estar vinculado à conta PagSeguro que está
					realizando a chamada à API.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>currency</strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;currency&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Moeda utilizada.</strong>
				</p>
				<p>
					Indica a moeda na qual o pagamento será feito. No momento, a única
					opção disponível é <strong>BRL</strong> (Real).
				</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Case sensitive. Somente o
					valor <strong>BRL</strong> é aceito.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;items&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Lista de itens contidos no pagamento.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">
					<strong>&lt;item&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Representa um item do pagamento.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>itemId1, itemId2, etc.</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;id&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Identificadores dos itens.</strong>
				</p>
				<p>Identificam os itens sendo pagos. Você pode escolher códigos que
					tenham significado para seu sistema e informá-los nestes
					parâmetros. O PagSeguro não realiza qualquer validação sobre esses
					identificadores, mas eles não podem se repetir em um mesmo
					pagamento.</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 100
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>itemDescription1, itemDescription2,
					etc.</strong><br> <br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;description&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Descrições dos itens.</strong>
				</p>
				<p>Descrevem os itens sendo pagos. A descrição é o texto que o
					PagSeguro mostra associado a cada item quando o comprador está
					finalizando o pagamento, portanto é importante que ela seja clara e
					explicativa.</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 100
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>itemAmount1, itemAmount2, etc.</strong><br>
				<br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;amount&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Valores unitários dos itens.</strong>
				</p>
				<p>Representam os preços unitários de cada item sendo pago. Além de
					poder conter vários itens, o pagamento também pode conter várias
					unidades do mesmo item. Este parâmetro representa o valor de uma
					unidade do item, que será multiplicado pela quantidade para obter o
					valor total dentro do pagamento.</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Decimal, com duas casas
					decimais separadas por ponto (p.e., 1234.56), maior que 0.00 e
					menor ou igual a 9999999.00.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>itemQuantity1, itemQuantity2, etc.</strong><br>
				<br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;quantity&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Quantidades dos itens.</strong>
				</p>
				<p>Representam as quantidades de cada item sendo pago. Além de poder
					conter vários itens, o pagamento também pode conter várias unidades
					do mesmo item. Este parâmetro representa a quantidade de um item,
					que será multiplicado pelo valor unitário para obter o valor total
					dentro do pagamento.</p>
				<p>
					<strong>Presença:</strong> Obrigatória.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro maior ou
					igual a 1 e menor ou igual a 999.
				</p>
			</td>
		</tr>
		<tr id="v2-item-api-de-pagamentos-parametros-api-itemShippingCost">
			<td>Parâmetro HTTP:<br> <strong>itemShippingCost1, itemShippingCost2,
					etc.</strong><br> <br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;shippingCost&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Custos de frete dos itens.</strong>
				</p>
				<p>Representam os custos de frete de cada item sendo pago. Caso este
					custo seja especificado, o PagSeguro irá assumi-lo como o custo do
					frete do item e não fará nenhum cálculo usando o peso do item.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Decimal, com duas casas
					decimais separadas por ponto (p.e., 1234.56), maior que 0.00 e
					menor ou igual a 9999999.00.
				</p>
			</td>
		</tr>
		<tr id="v2-item-api-de-pagamentos-parametros-api-itemWeight">
			<td>Parâmetro HTTP:<br> <strong>itemWeight1, itemWeight2, etc.</strong><br>
				<br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;items&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;weight&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Pesos dos itens.</strong>
				</p>
				<p>
					Correspondem ao peso (em gramas) de cada item sendo pago. O
					PagSeguro usa o peso do item para realizar o cálculo do custo de
					frete nos Correios, exceto se o custo de frete do item já for
					especificado diretamente. Veja mais sobre as <a
						href="/v2/guia-de-integracao/frete.html">regras de cálculo de
						frete</a>.
				</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro
					correspondendo ao peso em gramas do item. A soma dos pesos de todos
					os produtos não pode ultrapassar 30000 gramas (30 kg).
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>reference</strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;reference&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Código de referência.</strong>
				</p> Define um código para fazer referência ao pagamento. Este
				código fica associado à transação criada pelo pagamento e é útil
				para vincular as transações do PagSeguro às vendas registradas no
				seu sistema.
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com o limite de 200
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;sender&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Dados do comprador.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderEmail</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">
					<strong>&lt;email&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>E-mail do comprador.</strong>
				</p>
				<p>Especifica o e-mail do comprador que está realizando o pagamento.
					Este campo é opcional e você pode enviá-lo caso já tenha capturado
					os dados do comprador em seu sistema e queira evitar que ele
					preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> um e-mail válido (p.e.,
					usuario@site.com.br), com no máximo 60 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderName</strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">
					<strong>&lt;name&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Nome completo do comprador.</strong>
				</p>
				<p>Especifica o nome completo do comprador que está realizando o
					pagamento. Este campo é opcional e você pode enviá-lo caso já tenha
					capturado os dados do comprador em seu sistema e queira evitar que
					ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> No mínimo duas sequências de
					caracteres, com o limite total de 50 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">
					<strong>&lt;phone&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Dados do telefone do comprador.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderAreaCode</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">&lt;phone&gt;</div>
				<div class="tab4">
					<strong>&lt;areaCode&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>DDD do comprador.</strong>
				</p>
				<p>Especifica o código de área (DDD) do comprador que está
					realizando o pagamento. Este campo é opcional e você pode enviá-lo
					caso já tenha capturado os dados do comprador em seu sistema e
					queira evitar que ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número de 2 dígitos
					correspondente a um DDD válido.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderPhone</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">&lt;phone&gt;</div>
				<div class="tab4">
					<strong>&lt;number&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Número do telefone do comprador.</strong>
				</p>
				<p>Especifica o número do telefone do comprador que está realizando
					o pagamento. Este campo é opcional e você pode enviá-lo caso já
					tenha capturado os dados do comprador em seu sistema e queira
					evitar que ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número de 7 a 9 dígitos.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">
					<strong>&lt;documents&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Lista de documentos do comprador.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">&lt;documents&gt;</div>
				<div class="tab4">
					<strong>&lt;document&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Representa um documento do comprador.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">&lt;documents&gt;</div>
				<div class="tab4">&lt;document&gt;</div>
				<div class="tab5">
					<strong>&lt;type&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Tipo de documento do comprador.</strong>
				</p>
				<p>Especifica o tipo de documento do comprador que está realizando o
					pagamento. Este campo é opcional e você pode enviá-lo caso já tenha
					capturado os dados do comprador em seu sistema e queira evitar que
					ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Case sensitive. Somente o
					valor <strong>CPF</strong> é aceito.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderCPF</strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">&lt;documents&gt;</div>
				<div class="tab4">&lt;document&gt;</div>
				<div class="tab5">
					<strong>&lt;value&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Número do documento do comprador.</strong>
				</p>
				<p>Especifica o número do documento do comprador que está realizando
					o pagamento. Este campo é opcional e você pode enviá-lo caso já
					tenha capturado os dados do comprador em seu sistema e queira
					evitar que ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número de 11 dígitos.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>senderBornDate</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;sender&gt;</div>
				<div class="tab3">
					<strong>&lt;bornDate&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Data de nascimento do comprador.</strong>
				</p>
				<p>Especifica a data de nascimento do comprador que está realizando
					o pagamento. Este campo é opcional e você pode enviá-lo caso já
					tenha capturado os dados do comprador em seu sistema e queira
					evitar que ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Data.<br> <strong>Formato:</strong>dd/MM/yyyy (dia/mês/ano).
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;shipping&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Dados do frete.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingType</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">
					<strong>&lt;type&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Tipo de frete.</strong>
				</p>
				<p>Informa o tipo de frete a ser usado para o envio do produto. Esta
					informação é usada pelo PagSeguro para calcular, junto aos
					Correios, o valor do frete a partir do peso dos itens. A tabela
					abaixo descreve os valores aceitos e seus significados:</p>
				<table>
					<thead>
						<tr>
							<th>Código</th>
							<th>Significado</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="col_code">1</td>
							<td>Encomenda normal (PAC).</td>
						</tr>
						<tr>
							<td class="col_code">2</td>
							<td>SEDEX</td>
						</tr>
						<tr>
							<td class="col_code">3</td>
							<td>Tipo de frete não especificado.</td>
						</tr>
					</tbody>
				</table>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro de acordo
					com a tabela acima.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingCost</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">
					<strong>&lt;cost&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Valor total do frete.</strong>
				</p>
				<p>Informa o valor total de frete do pedido. Caso este valor seja
					especificado, o PagSeguro irá assumi-lo como valor do frete e não
					fará nenhum cálculo referente aos pesos e valores de entrega dos
					itens.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Decimal, com duas casas
					decimais separadas por ponto (p.e, 1234.56), maior que 0.00 e menor
					ou igual a 9999999.00.
				</p>
			</td>
		</tr>
		<tr>
			<td>Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">
					<strong>&lt;address&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Dados do endereço de envio.</strong>
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressCountry</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;country&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>País do endereço de envio.</strong>
				</p>
				<p>Informa o país do endereço de envio do produto. Este campo é
					opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> No momento, apenas o valor <strong>BRA</strong>
					é permitido.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressState </strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;state&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Estado do endereço de envio.</strong>
				</p>
				<p>Informa o estado do endereço de envio do produto. Este campo é
					opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Duas letras, em maiúsculo,
					representando a sigla do estado brasileiro correspondente.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressCity</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;city&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Cidade do endereço de envio.</strong>
				</p>
				<p>Informa a cidade do endereço de envio do produto. Este campo é
					opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre. Deve ser um nome válido
					de cidade do Brasil, com no mínimo 2 e no máximo 60 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressPostalCode</strong><br>
				<br> Elemento XML:
				<div class="tab1">
					<strong>&lt;checkout&gt;</strong>
				</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;postalCode&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>CEP do endereço de envio.</strong>
				</p>
				<p>Informa o CEP do endereço de envio do produto. Este campo é
					opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número de 8 dígitos.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressDistrict</strong><br>
				<br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;district&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Bairro do endereço de envio.</strong>
				</p>
				<p>Informa o bairro do endereço de envio do produto. Este campo é
					opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 60
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressStreet</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;street&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Nome da rua do endereço de envio.</strong>
				</p>
				<p>Informa o nome da rua do endereço de envio do produto. Este campo
					é opcional e você pode enviá-lo caso já tenha capturado os dados do
					comprador em seu sistema e queira evitar que ele preencha esses
					dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 80
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressNumber</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;number&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Número do endereço de envio.</strong>
				</p> Informa o número do endereço de envio do produto. Este campo é
				opcional e você pode enviá-lo caso já tenha capturado os dados do
				comprador em seu sistema e queira evitar que ele preencha esses
				dados novamente no PagSeguro.
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 20
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>shippingAddressComplement</strong><br>
				<br> Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;shipping&gt;</div>
				<div class="tab3">&lt;address&gt;</div>
				<div class="tab4">
					<strong>&lt;complement&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Complemento do endereço de envio.</strong>
				</p>
				<p>Informa o complemento (bloco, apartamento, etc.) do endereço de
					envio do produto. Este campo é opcional e você pode enviá-lo caso
					já tenha capturado os dados do comprador em seu sistema e queira
					evitar que ele preencha esses dados novamente no PagSeguro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre, com limite de 40
					caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>extraAmount </strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;extraAmount&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Valor extra.</strong>
				</p>
				<p>Especifica um valor extra que deve ser adicionado ou subtraído ao
					valor total do pagamento. Esse valor pode representar uma taxa
					extra a ser cobrada no pagamento ou um desconto a ser concedido,
					caso o valor seja negativo.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Decimal (positivo ou
					negativo), com duas casas decimais separadas por ponto (p.e.,
					1234.56 ou -1234.56), maior ou igual a -9999999.00 e menor ou igual
					a 9999999.00. Quando negativo, este valor não pode ser maior ou
					igual à soma dos valores dos produtos.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>redirectURL </strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;redirectURL&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>URL de redirecionamento após o pagamento.</strong>
				</p>
				<p>
					Determina a URL para a qual o comprador será redirecionado após o
					final do fluxo de pagamento. Este parâmetro permite que seja
					informado um endereço de específico para cada pagamento realizado.
					Veja mais em <a
						href="/v2/guia-de-integracao/finalizacao-do-pagamento.html#v2-item-redirecionando-o-comprador-para-uma-url-dinamica">Redirecionando
						o comprador para um endereço dinâmico</a>.
				</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Uma URL válida, com limite de
					255 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>notificationURL</strong><br> <br>
				Elemento XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;notificationURL&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>URL para envio de notificações sobre o pagamento.</strong>
				</p>
				<p>Determina a URL para a qual o PagSeguro enviará os códigos de
					notificação relacionados ao pagamento. Toda vez que houver uma
					mudança no status da transação e que demandar sua atenção, uma nova
					notificação será enviada para este endereço.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Uma URL válida, com limite de
					255 caracteres.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>maxUses </strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;maxUses&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Número máximo de usos para o código de pagamento.</strong>
				</p>
				<p>Determina o número máximo de vezes que o código de pagamento
					criado pela chamada à API de Pagamentos poderá ser usado. Este
					parâmetro pode ser usado como um controle de segurança.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro maior que 0
					e menor ou igual a 999.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>maxAge </strong><br> <br> Elemento
				XML:
				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">
					<strong>&lt;maxAge&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Prazo de validade do código de pagamento.</strong>
				</p>
				<p>Determina o prazo (em segundos) durante o qual o código de
					pagamento criado pela chamada à API de Pagamentos poderá ser usado.
					Este parâmetro pode ser usado como um controle de segurança.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro maior ou
					igual a 30 e menor ou igual a 999999999.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>metadataItemKey1, metadataItemKey2,
					etc.</strong><br>
			<br> Elemento XML:

				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;metadata&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;key&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Metadados da transação.</strong>
				</p>
				<p>Permite adicionar informações extras, agrupadas ou não, em sua
					requisição de pagamento.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Somente os valores descritos
					abaixo são aceitos.<br> <strong>Obs.:</strong> Usando HTTP existe
					uma limitação de até 100 keys por post.
				</p>
				<table>
					<thead>
						<tr>
							<th>Valor</th>
							<th>Formato</th>
							<th>Descrição</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>PASSENGER_CPF</td>
							<td>[0-9]{11}</td>
							<td>CPF do passageiro</td>
						</tr>
						<tr>
							<td>PASSENGER_PASSPORT</td>
							<td>.+</td>
							<td>Passaporte do passageiro</td>
						</tr>
						<tr>
							<td>ORIGIN_CITY</td>
							<td>.+</td>
							<td>Cidade de origem</td>
						</tr>
						<tr>
							<td>DESTINATION_CITY</td>
							<td>.+</td>
							<td>Cidade de destino</td>
						</tr>
						<tr>
							<td>ORIGIN_AIRPORT_CODE</td>
							<td>.+</td>
							<td>Código do aeroporto de origem</td>
						</tr>
						<tr>
							<td>DESTINATION_AIRPORT_CODE</td>
							<td>.+</td>
							<td>Código do aeroporto de destino</td>
						</tr>
						<tr>
							<td>GAME_NAME</td>
							<td>.+</td>
							<td>Nome do jogo</td>
						</tr>
						<tr>
							<td>PLAYER_ID</td>
							<td>.+</td>
							<td>ID do jogador</td>
						</tr>
						<tr>
							<td>TIME_IN_GAME_DAYS</td>
							<td>[0-9]+</td>
							<td>Tempo no jogo em dias</td>
						</tr>
						<tr>
							<td>MOBILE_NUMBER</td>
							<td>([0-9]{2})?([0-9]{2})([0-9]{4,5}[0-9]{4})</td>
							<td>Celular de recarga</td>
						</tr>
						<tr>
							<td>PASSENGER_NAME</td>
							<td>.+</td>
							<td>Nome do passageiro</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>metadataItemValue1,
					metadataItemValue2, etc.</strong><br>
			<br> Elemento XML:

				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;metadata&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;value&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Valores dos metadados da transação.</strong>
				</p>
				<p>Permite especificar valores para os metadados definidos em sua
					requisição de pagamento.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Texto.<br> <strong>Formato:</strong> Livre. Com limite de 100
					caracteres.<br> <strong>Obs.:</strong> Usando HTTP existe uma
					limitação de até 100 values por post.
				</p>
			</td>
		</tr>
		<tr>
			<td>Parâmetro HTTP:<br> <strong>metadataItemGroup1,
					metadataItemGroup2, etc.</strong><br>
			<br> Elemento XML:

				<div class="tab1">&lt;checkout&gt;</div>
				<div class="tab2">&lt;metadata&gt;</div>
				<div class="tab3">&lt;item&gt;</div>
				<div class="tab4">
					<strong>&lt;group&gt;</strong>
				</div>
			</td>
			<td>
				<p>
					<strong>Grupos de metadados presentes na transação.</strong>
				</p>
				<p>Permite agrupar dois ou mais metadados, como por exemplo cpf e
					nome de um mesmo passageiro.</p>
				<p>
					<strong>Presença:</strong> Opcional.<br> <strong>Tipo:</strong>
					Número.<br> <strong>Formato:</strong> Um número inteiro maior que
					zero.<br> <strong>Obs.:</strong> Usando HTTP existe uma limitação
					de até 100 groups por post.
				</p>
			</td>
		</tr>
	</tbody>

</table>
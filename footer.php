			<!--Botão para voltar ao top-->
			<div class="row hidden-print text-center button-topo">
				<a class="link-rodape" href="#topo" title="Voltar ao topo da página">
					<span class="glyphicon glyphicon-menu-up rodape-topo" aria-hidden="true"></span>
				</a>
			</div>
			
			</div>
		</div><!--Fecha div container-->

		<div id="footer">
			<div class="container">
				<div class=" col-sm-12 col-xs-12">
	
					<!--Rodape´da pagina web-->
					<div class="row hidden-print">
						<div class="col-sm-12 col-xs-12">
							<address class="text-center">
							  	<strong>Contato ECOFlow</strong><br>
							  	<abbr title="E-mail"><span class="glyphicon glyphicon-envelope" arian-hidden="true"></span></abbr> : <a class="link-rodape" href="mailto:contato@ecoflow.net.br">contato@ecoflow.net.br</a><br>
							  	<abbr title="Celular"><span class="glyphicon glyphicon-phone" arian-hidden="true"></span></abbr> :  (35) 98875-8875 <br>
							  	<abbr title="Telefone"><span class="glyphicon glyphicon-earphone" arian-hidden="true"></span></abbr> :  (35) 3622-7522 <br>
							  	<!--<abbr title="Celular"><span class="glyphicon glyphicon-phone" arian-hidden="true"></span> </abbr> : -->
							</address>	
						</div>

						<div class="row hidden-print">
							<div class="col-sm-12 col-xs-12 text-center">
								&copy;Copyright 2016<script>new Date().getFullYear()>2010&&document.write("-"+new Date().getFullYear());</script> - Ecoflow - Todos os direitos reservados.<br>
							</div>
						</div>
					</div>

					<!--Rodapé para impressão-->
					<div class="row visible-print-block">
						<div class="col-sm-12">
							<address class="text-center">
							<strong>Contato ECOFlow</strong><br>
							contato@ecoflow.net.br<br>
							Cel.: (35) 98875-8875<br>
  							Tel.: (35) 3622-7522<br>
							</address>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div><!--fecha  div tudo-->

	<!--Scroll suave para link interno-->
	<script>
    	var $doc = $('html, body');
		$('a[href^="#"]').click(function() {
		    $doc.animate({
		        scrollTop: $( $.attr(this, 'href') ).offset().top
		    }, 500);
		    return false;
		});
    </script>
	
</body>
</html>
			<!--Botão para voltar ao top-->
			<div class="row hidden-print text-center button-topo">
				<a class="link-rodape" href="#topo" title="Voltar ao topo da página">
					<span class="glyphicon glyphicon-menu-up rodape-topo" aria-hidden="true"></span>
				</a>
			</div>
		</div><!--Fecha div container-->

		<footer>
			<div class="container-fluid">
				<!--Rodape´da pagina web-->
				<div class="row hidden-print">
					<div class="col-sm-12 col-xs-12">
						<address class="text-center">
						  	<strong>Contato ECOFlow</strong><br>
						  	<a class="link-rodape" href="mailto:contato@ecoflow.net.br"><span class="glyphicon glyphicon-envelope" arian-hidden="true"></span> contato@ecoflow.net.br</a><br>
						  	<abbr title="Telefone">Tel.:</abbr> (35) 3622-7522 <br>
						  	<abbr title="Telefone">Cel.:</abbr> (35) 9 8875-8875
						</address>	
					</div>

					<div class="row hidden-print">
						<div class="col-sm-12 col-xs-12 text-center">
							<strong>ECOflow</strong> - Todos os direitos reservados.<br>
						</div>
					</div>
				</div>

				<!--Rodapé para impressão-->
				<div class="row visible-print-block">
					<div class="col-sm-12">
						<address class="text-center">
						<strong>Contato ECOFlow</strong><br>
						contato@ecoflow.net.br<br>
						Tel.: (35) 3622-7522
						Cel.: (35) 98875-8875
						</address>
					</div>
				</div>
			</div>
		</footer>

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
<?php if (defined('__ERROR__') && $showExceptions): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>brA's Painel de Controle Flux: Erro Crítico</title>
		<style type="text/css" media="screen">
			body {
				margin: 10px;
				padding: 0;
				font-family: "Lucida Grande", "Lucida Sans", sans-serif;
			}
			
			p {
				font-size: 85%;
			}
			
			pre {
				font-family: Monaco, "Lucida Console", monospace;
			}
			
			.heading {
				font-family: "Gill Sans", "Gill Sans MT", "Lucida Grande", "Lucida Sans", sans-serif;
				font-weight: normal;
				border-bottom: 1px solid #ddd;
			}
			
			.backtrace {
				font-size: 85%;
				border-spacing: 0;
				border-collapse: collapse;
				background-color: #fefefe;
			}
			
			.backtrace th, .backtrace td {
				padding: 5px;
				border: 1px solid #ccc;
			}
			
			.backtrace th {
				background-color: #eee;
			}
		</style>
	</head>
	
	<body>
		<h2 class="heading">Critical Error</h2>
		
		<p>Um erro foi encontrado durante a execução da aplicação.</p>
		<p>Isso pode ser devido a uma variedade de problemas, como por exemplo um bug na aplicação.</p>
		<p><strong>Geralmente, é normalmente causado por <em>configuação</em>.</strong></p>
		
		<h2 class="heading">Detalhes da Exceção</h2>
		<p>Erro: <strong><?php echo get_class($e) ?></strong></p>
		<p>Mensagem: <em><?php echo nl2br(htmlspecialchars($e->getMessage())) ?></em></p>
		<p>Arquivo: <?php echo $e->getFile() ?>:<?php echo $e->getLine() ?></p>
		
		<?php if (count($e->getTrace())): ?>
		<!-- Exception Backtrace -->
		<table class="backtrace">
			<tr>
				<th>Arquivo</th>
				<th>Linha</th>
				<th>Função/Método</th>
			</tr>
			<?php foreach ($e->getTrace() as $trace): ?>
			<tr>
				<td><?php echo $trace['file'] ?></td>
				<td><?php echo $trace['line'] ?></td>
				<td><?php echo isset($trace['class']) ? "$trace[class]::$trace[function]" : $trace['function'] ?>()</td>
			</tr>
			<?php endforeach ?>
		</table>
		
		<h2 class="heading">Vestígio da String da Exceção</h2>
		<pre><?php echo htmlspecialchars(preg_replace('/PDO->__construct\\((.+?)\\)/', 'PDO->__construct(*hidden*)', $e->getTraceAsString())) ?></pre>
		<?php endif ?>
	</body>
</html>
<?php else: ?>
<h2>Erro</h2>
<p>Um erro foi encontrado enquanto estávamos tentando processar o seu pedido.</p>
<p>Por favor, contate um administrador: <a href="mailto:<?php echo htmlspecialchars($adminEmail) ?>"><?php echo htmlspecialchars($adminEmail) ?></a></p>
<?php endif ?>
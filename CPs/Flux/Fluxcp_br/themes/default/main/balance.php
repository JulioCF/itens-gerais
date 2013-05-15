<?php if (!defined('FLUX_ROOT')) exit; ?>
<div class="credit-balance">
	<span class="balance-text">CRÉDITOS DE DOAÇÃO</span>
	<span class="balance-amount"><?php echo number_format((int)$session->account->balance) ?></span>
</div>
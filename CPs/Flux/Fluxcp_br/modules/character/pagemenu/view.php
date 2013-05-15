<?php
$pageMenu = array();
if (($isMine || $auth->allowedToModifyCharPrefs) && $auth->actionAllowed('character', 'prefs')) {
	$pageMenu['Modificar Preferências'] = $this->url('character', 'prefs', array('id' => $char->char_id));
}
if (($isMine || $auth->allowedToChangeSlot) && $auth->actionAllowed('character', 'changeslot')) {
	$pageMenu['Mudar Slot'] = $this->url('character', 'changeslot', array('id' => $char->char_id));
}
if (($isMine || $auth->allowedToResetLook) && $auth->actionAllowed('character', 'resetlook')) {
	$pageMenu['Resetar Aparência'] = $this->url('character', 'resetlook', array('id' => $char->char_id));
}
if (($isMine || $auth->allowedToResetPosition) && $auth->actionAllowed('character', 'resetpos')) {
	$pageMenu['Resetar Posição'] = $this->url('character', 'resetpos', array('id' => $char->char_id));
}
if ($char->partner_id && ($isMine || $auth->allowedToDivorceCharacter) && $auth->actionAllowed('character', 'divorce')) {
	$pageMenu['Divórcio'] = $this->url('character', 'divorce', array('id' => $char->char_id));
}
return $pageMenu;
?>
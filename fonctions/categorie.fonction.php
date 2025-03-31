<?php
function get_drapeau($last_message_id,$id_dernier_message)
{
	if($id_dernier_message > $last_message_id)
		return "new";
	else
		return "no_new";
}
?>
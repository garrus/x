<?php if ($total != 0) :
	if ($success == 0) {
		$class = 'error';
	} elseif ($failure == 0) {
		$class = 'success';
	} else {
		$class = 'notice';
	}
echo "<div class='flash-$class'>Assert: $total, Success: $success, Failure: $failure</div>";
endif;

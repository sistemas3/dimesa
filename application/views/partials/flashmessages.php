<?php if($this->session->userdata('message')): ?>
	<?php
		$message = $this->session->userdata('message');
		$content = $message['content'];
		$type    = $message['type'];
	?>

	<?php switch ($type) {
		case 'error': $style = 'alert-error'; break;
		case 'success': $style = 'alert-success'; break;
		case 'info': $style = 'alert-info'; break;
		default: $style = ''; break;
	}?>

	<br />
	<div class="alert <?php echo @$style; ?>">
		<?php echo $content; ?>
	</div>
	<?php $this->session->unset_userdata('message'); ?>
<?php endif; ?>
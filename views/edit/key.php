<section>
	<h2 class="title is-2 has-text-white has-text-centered">Edit Webhook</h2>

	<?php if(isset($notFound) && $notFound): ?>
	<div class="notification is-danger" id="notFound">
		<button class="delete has-text-black"></button>
		The key you have specified in the URL does not exist.<br>Please enter a valid key below!
	</div>
	<?php endif; ?>

	<form id="key-form" method="POST" action="/edit/key">
		<div class="field">
			<label class="label has-text-white">Please enter your webhook key:</label>
			<div class="control has-icons-left">
				<input required id="key" name="key" value="<?php if(isset($key)): ?><?php echo $key; ?><?php endif; ?>" class="input <?php if(isset($error)): ?> is-danger <?php endif; ?>" type="text" placeholder="Key ...">
				<span class="icon is-small is-left has-text-white">
					<i class="fas fa-lock"></i>
			    </span>
			</div>

			<?php if(isset($error)): ?>
			<p class="help is-danger"><?php echo $error; ?></p>
			<?php else: ?>
			<p class="help">The key you got when creating your webhook.<br>
				If you've lost it, contact me at <a href="mailto:jonasg.cool@gmail.com">jonasg.cool@gmail.com</a> and tell me what the webhook did.
				Do not just create a new one! I don't want inactive webhooks.</p>
			<?php endif; ?>
		</div>

		<div class="field is-grouped is-grouped-right">
			<div class="control">
				<button class="button is-link">
					<span>Continue</span>
					<span class="icon">
						<i class="fa fa-arrow-right"></i>
					</span>
				</button>
			</div>
		</div>
	</form>

	<script type="text/javascript">
		$('.notification .delete').on('click', function() {
			this.parentNode.remove();
		});
	</script>
</section>
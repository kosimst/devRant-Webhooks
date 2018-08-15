<section>
	<h2 class="title is-2 has-text-white has-text-centered">Success!</h2>

	<p class="content has-text-white has-text-centered">
		Your webhook has been successfully created!<br>
		Enjoy!
	</p>
	<hr>
	<h4 class="title is-4 has-text-white">Your Key:</h4>
	<box class="result-box box">
		<h3 class="title is-3 has-text-white"><?php echo $key; ?></h3>
	</box>
	<p class="content has-text-white">
		Store this key somewhere save! For example somewhere in your project.<br>
		This key can be used to edit/delete the webhook and also to view errors that occurred!<br>
		If you loose it, contact me at <a href="mailto:jonasg.cool@gmail.com">jonasg.cool@gmail.com</a> and tell me what the webhook did.<br>
		Do not just create a new one! I don't want inactive webhooks.
	</p>

	<hr>

	<h4 class="title is-4 has-text-white has-text-centered">
		Click here to edit your webhook:<br><br>
		<a href="/edit?key=<?php echo $key; ?>" class="button">
			<span class="icon">
				<i class="fas fa-edit"></i>
			</span>
			<span>Edit Webhook</span>
		</a>
	</h4>
</section>
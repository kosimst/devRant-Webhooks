<section>
	<h2 class="title is-2 has-text-white has-text-centered">Edit Webhook</h2>

	<?php if(count($errorLog) > 0): ?>
	<div class="notification is-danger content" id="occurredErrors">
		<button class="delete has-text-black"></button>
		There were <?php echo count($errorLog); ?> errors that occurred during execution of this webhook:
		<ul>
			<?php foreach($errorLog as $log): ?>
			<li><?php echo $log['text']; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if(isset($success) && $success): ?>
	<div class="notification is-success content" id="success">
		<button class="delete has-text-black"></button>
		Successfully updated webhook!
	</div>
	<?php endif; ?>

	<form id="edit-form" method="POST" action="/edit?key=<?php echo $key; ?>">
		<div class="field">
			<label class="label has-text-white">Event</label>
			<div class="control">
				<div class="select <?php if(isset($errors['eventType'])): ?> is-danger <?php endif; ?>">
					<select required id="eventType" name="eventType">
						<option value="none" selected>Select ...</option>
						<option value="newRant">New Rant</option>
						<option value="newCommentOnRant">New Comment on a Rant</option>
						<option value="newWeeklyTopic">New Weekly-Rant Topic</option>
					</select>
				</div>
			</div>

			<?php if(isset($errors['eventType'])): ?>
			<p class="help is-danger" id="event-help"><?php echo $errors['eventType']; ?></p>
			<?php else: ?>
			<p class="help">Select when to execute the webhook</p>
			<?php endif; ?>
		</div>

		<div id="additionalFields"></div>

		<div class="field">
			<label class="label has-text-white">
				Payload URL

				<div class="dropdown is-pulled-right is-right is-hoverable">
					<div class="dropdown-trigger">
						<button disabled class="button is-small is-static" aria-haspopup="true" aria-controls="dropdown-menu">
							<span>Add variable</span>
							<span class="icon is-small">
								<i class="fas fa-angle-down" aria-hidden="true"></i>
							</span>
						</button>
					</div>
					<div class="dropdown-menu" role="menu">
						<div class="dropdown-content">
							<a href="#" class="dropdown-item">
								Dropdown item
							</a>
							<a class="dropdown-item">
								Other dropdown item
							</a>
							<a href="#" class="dropdown-item">
								Active dropdown item
							</a>
						</div>
					</div>
				</div>

			</label>
			<div class="control has-icons-left">
				<input required id="url" name="url" value="<?php if(isset($form['url'])): ?> <?php echo $form['url']; ?> <?php endif; ?>" class="input <?php if(isset($errors['url'])): ?> is-danger <?php endif; ?>" type="url" placeholder="URL ...">
				<span class="icon is-small is-left has-text-white">
					<i class="fas fa-globe"></i>
			    </span>
			</div>

			<?php if(isset($errors['url'])): ?>
			<p class="help is-danger"><?php echo $errors['url']; ?></p>
			<?php else: ?>
			<p class="help">The URL the request goes to. Add variables with the button on the top-right!</p>
			<?php endif; ?>

		</div>

		<div class="field">
			<label class="label has-text-white">HTTP-Method</label>
			<div class="control">
				<div class="select <?php if(isset($errors['method'])): ?> is-danger <?php endif; ?>">
					<select required id="method" name="method">
						<option value="GET">GET</option>
						<option value="POST" selected>POST</option>
						<option value="DELETE">DELETE</option>
						<option value="PUT">PUT</option>
						<option value="PATCH">PATCH</option>
						<option value="OPTIONS">OPTIONS</option>
						<option value="HEAD">HEAD</option>
					</select>
				</div>
			</div>

			<?php if(isset($errors['method'])): ?>
			<p class="help is-danger"><?php echo $errors['method']; ?></p>
			<?php else: ?>
			<p class="help">The method of the request e.g. GET, POST, DELETE</p>
			<?php endif; ?>

		</div>

		<div class="field">
			<label class="label has-text-white">Content-Type</label>
			<div class="control">
				<div class="select <?php if(isset($errors['contentType'])): ?> is-danger <?php endif; ?>">
					<select id="contentType" name="contentType">
						<option value="none" selected>Select ...</option>
						<option value="application/json">application/json</option>
						<option value="application/x-www-form-urlencoded">application/x-www-form-urlencoded</option>
						<option value=">text/plain">text/plain</option>
					</select>
				</div>
			</div>

			<?php if(isset($errors['contentType'])): ?>
			<p class="help is-danger"><?php echo $errors['contentType']; ?></p>
			<?php else: ?>
			<p class="help">(Optional) The Content-Type of the body</p>
			<?php endif; ?>

		</div>

		<div class="field">
			<label class="label has-text-white">
				Body

				<div class="dropdown is-pulled-right is-right is-hoverable">
					<div class="dropdown-trigger">
						<button disabled class="button is-small is-static" aria-haspopup="true" aria-controls="dropdown-menu">
							<span>Add variable</span>
							<span class="icon is-small">
								<i class="fas fa-angle-down" aria-hidden="true"></i>
							</span>
						</button>
					</div>
					<div class="dropdown-menu" role="menu">
						<div class="dropdown-content">
							<a href="#" class="dropdown-item">
								Dropdown item
							</a>
							<a class="dropdown-item">
								Other dropdown item
							</a>
							<a href="#" class="dropdown-item">
								Active dropdown item
							</a>
						</div>
					</div>
				</div>

			</label>
			<div class="control">
				<textarea id="body" name="body" class="textarea <?php if(isset($errors['body'])): ?> is-danger <?php endif; ?>" placeholder="Body..."><?php if(isset($form['body'])): ?><?php echo $form['body']; ?><?php endif; ?></textarea>
			</div>

			<?php if(isset($errors['body'])): ?>
			<p class="help is-danger"><?php echo $errors['body']; ?></p>
			<?php else: ?>
			<p class="help">(Optional) The body of the webhook. Add variables with the button on the top-right!</p>
			<?php endif; ?>
		</div>

		<div class="field is-grouped is-grouped-right">
			<div class="control is-expanded">
				<button id="delete" class="button is-link is-danger">
					<span class="icon">
						<i class="fa fa-trash"></i>
					</span>
					<span>Delete Webhook</span>
				</button>
			</div>
			<div class="control">
				<button class="button is-link">
					<span class="icon">
						<i class="fa fa-save"></i>
					</span>
					<span>Save</span>
				</button>
			</div>
		</div>
	</form>

	<script type="text/javascript">
		var errors = <?php echo json_encode($errors); ?>;
		var previousForm = <?php echo json_encode($form); ?>;

		$('#delete').on('click', function () {
			var confirmed = confirm('Are you sure?');

			if(confirmed) {
				location.href = '/edit/delete?key=<?php echo $key; ?>';
			}
		});

		$('.notification .delete').on('click', function() {
			this.parentNode.remove();
		});

		<?php echo file_get_contents("js/form.js"); ?>
	</script>
</section>
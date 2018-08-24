var eventTypes = {
	newRant:          {
		fields:    [
			{
				id:          'byUser',
				name:        'By User',
				placeholder: 'User(s) ...',
				help:        '(Optional) Execute only when specific user(s) posts a rant. Comma-separate for multiple',
				icon:        'user'
			},
			{
				id:          'withTag',
				name:        'With Tag',
				placeholder: 'Tag(s) ...',
				help:        '(Optional) Execute only when rant has specific tag(s). Comma-separate for multiple',
				icon:        'tag'
			}
		],
		variables: {
			'Rant ID': 'id',
			'Rant Text': 'text',
			'Rant Score': 'score',
			'Rant Created Time': 'created_time',
			'Rant Comments Count': 'num_comments',
			'Rant is edited': 'edited',
			'Rant Link': 'link',
			'Ranter User ID': 'user_id',
			'Ranter Username': 'user_username',
			'Ranter Score': 'user_score'
		}
	},
	newCommentOnRant: {
		fields: [
			{
				id:          'rantID',
				name:        'Rant ID',
				placeholder: 'Rant ID ...',
				help:        'The rant ID. (You can find it in the URL)',
				icon:        'hashtag'
			},
			{
				id:          'byUser',
				name:        'By User',
				placeholder: 'User(s) ...',
				help:        '(Optional) Execute only when specific user(s) posts a comment. Comma-separate for multiple',
				icon:        'user'
			}
		],
		variables: {
			'Comment ID': 'id',
			'Rant ID': 'rant_id',
			'Comment Body': 'body',
			'Comment Score': 'score',
			'Comment Created Timestamp': 'created_time',
			'Commenter User ID': 'user_id',
			'Commenter Username': 'user_username',
			'Commenter Score': 'user_score',
			'Commenter is Supporter': 'user_dpp'
		}
	},
	newWeeklyTopic:   {
		fields: [],
		variables: {
			'Topic': 'prompt',
			'Week': 'week',
			'Amount of Rants': 'num_rants',
			'Date': 'date'
		}
	}
};

$(document).ready(function () {
	if ('eventType' in previousForm && previousForm.eventType != '') $('#eventType').val(previousForm.eventType);
	if ('method' in previousForm && previousForm.method != '') $('#method').val(previousForm.method);
	if ('contentType' in previousForm && previousForm.contentType != '') $('#contentType').val(previousForm.contentType);
	$('#eventType').trigger('change');

	$('.variables.variables-url').on('click', function(e) {
		e.preventDefault();

		if($(e.target).hasClass('notVariable'))
			return;

		$('#url').val($('#url').val() + $(e.target).attr('title'));
	});

	$('.variables.variables-body').on('click', function(e) {
		e.preventDefault();

		if($(e.target).hasClass('notVariable'))
			return;

		$('#body').append($(e.target).attr('title'));
	});
});

$('#eventType').on('change', function (event) {
	var eventType = event.currentTarget.value;

	$('#additionalFields').empty();
	$('.variables').html('<div class="notVariable dropdown-item has-text-grey">None</div>');

	if (Object.keys(eventTypes).indexOf(eventType) > -1) {
		for (var i = 0; i < eventTypes[eventType].fields.length; i++) {
			var data = eventTypes[eventType].fields[i];

			data.error = false;
			if (data.id in errors) {
				data.help = errors[data.id];
				data.error = true;
			}

			var newField = '<div class="field is-horizontal">' +
			               '  <div class="field-label is-normal">' +
			               '    <label class="label has-text-white">' + data.name + '</label>' +
			               '  </div>' +
			               '  <div class="field-body">' +
			               '    <div class="field"> ' +
			               '      <div class="control has-icons-left">' +
			               '        <input value="' + (data.id in previousForm ? previousForm[data.id] : '') + '" id="' + data.id + '" name="' + data.id + '" class="input ' + (data.error ? 'is-danger' : '') + '" type="text" placeholder="' + data.placeholder + '">' +
			               '        <span class="icon is-small is-left has-text-white">' +
			               '          <i class="fas fa-' + data.icon + '"></i>' +
			               '        </span>' +
			               '      </div>' +
			               '      <p class="help ' + (data.error ? 'is-danger' : '') + '">' + data.help + '</p>' +
			               '    </div>' +
			               '  </div>' +
			               '</div>';

			$('#additionalFields').append(newField);
		}

		if(Object.keys(eventTypes[eventType].variables).length > 0)
			$('.variables').empty();

		for (var key in eventTypes[eventType].variables) {
			var variable = '{' + eventTypes[eventType].variables[key] + '}';

			var variableItem = '<a href="#" class="dropdown-item" title="' + variable + '">' + key + '</a>';

			$('.variables').append(variableItem);
		}
	}
});
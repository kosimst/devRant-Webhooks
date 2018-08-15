var eventTypes = {
	newRant:          [
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
	newCommentOnRant: [
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
	newWeeklyTopic:   []
};

$(document).ready(function () {
	if ('eventType' in previousForm && previousForm.eventType != '') $('#eventType').val(previousForm.eventType);
	if ('method' in previousForm && previousForm.method != '') $('#method').val(previousForm.method);
	if ('contentType' in previousForm && previousForm.contentType != '') $('#contentType').val(previousForm.contentType);
	$('#eventType').trigger('change');
});

$('#eventType').on('change', function (event) {
	var eventType = event.currentTarget.value;

	$('#additionalFields').empty();

	if (Object.keys(eventTypes).indexOf(eventType) > -1) {
		for (var i = 0; i < eventTypes[eventType].length; i++) {
			var data = eventTypes[eventType][i];

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
	}
});
// Declaration with let to prevent global
let eventTypes = {
  newRant: [
    {
      id: 'byUser',
      name: 'By User',
      placeholder: 'User(s) ...',
      help:
        '(Optional) Execute only when specific user(s) posts a rant. Comma-separate for multiple',
      icon: 'user',
    },
    {
      id: 'withTag',
      name: 'With Tag',
      placeholder: 'Tag(s) ...',
      help:
        '(Optional) Execute only when rant has specific tag(s). Comma-separate for multiple',
      icon: 'tag',
    },
  ],
  newCommentOnRant: [
    {
      id: 'rantID',
      name: 'Rant ID',
      placeholder: 'Rant ID ...',
      help: 'The rant ID. (You can find it in the URL)',
      icon: 'hashtag',
    },
    {
      id: 'byUser',
      name: 'By User',
      placeholder: 'User(s) ...',
      help:
        '(Optional) Execute only when specific user(s) posts a comment. Comma-separate for multiple',
      icon: 'user',
    },
  ],
  newWeeklyTopic: [],
}

const eventType = document.getElementById('eventType')

// Vanilla implementation of $(document).ready
document.addEventListener('DOMContentLoaded', () => {
  'use strict'

  // Use getElementById -> faster and vanilla
  if ('eventType' in previousForm && previousForm.eventType != '') {
    eventType.value = previousForm.eventType
  }
  if ('method' in previousForm && previousForm.method != '') {
    document.getElementById('method').value = previousForm.method
  }
  if ('contentType' in previousForm && previousForm.contentType != '') {
    document.getElementById('contentType').value = previousForm.contentType
  }
  // Vanilly implementaion of $().trigger
  eventType.dispatchEvent(new Event('change'))
})

// Use native event listeners
eventType.addEventListener('change', event => {
  'use strict'

  // eventTypoe is already declared
  // var eventType = event.currentTarget.value

  // Vanilla $().empty
  const additionalFields = document.getElementById('additionalFields')
  additionalFields.innerHTML = ''

  // Use Array.prototype.includes
  if (Object.keys(eventTypes).includes(eventType)) {
    // Important: Always use let in for loops -> scoped!
    // TODO: Convert to for…of loop -> faster
    for (let i = 0; i < eventTypes[eventType].length; i++) {
      const data = eventTypes[eventType][i]

      data.error = false
      if (data.id in errors) {
        data.help = errors[data.id]
        data.error = true
      }

      // Use Template-String-Literal for better readabilty

      const newField = `
      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label has-text-white">${data.name}</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control has-icons-left">
              <input
                value="${data.id in previousForm ? previousForm[data.id] : ''}"
                id="${data.id}"
                name="${data.id}"
                class="input ${data.error ? 'is-danger' : ''}"
                type="text"
                placeholder="${data.placeholder}"
              >
              <span class="icon is-small is-left has-text-white">
                <i class="fas fa-${data - icon}></i>
              </span>
            </div>
            <p class="help ${data.error ? 'is-danger' : ''}">${data.help}</p>
          </div>
        </div>
      </div>
      `

      additionalFields.insertAdjacentHTML('beforeend', newField)
    }
  }
})

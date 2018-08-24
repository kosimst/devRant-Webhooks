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

  $('.variables.variables-url').on('click', function(e) {
    e.preventDefault()

    if (
      !e.target.classList.contains('dropdown-item') ||
      e.target.classList.contains('notVariable')
    ) {
      return
    }

    document.getElementById('url').value += e.target.getAttribute('title')
  })
  ;[...document.querySelectorAll('.variables.variables-body')].forEach(el =>
    el.addEventListener('click', e => {
      e.preventDefault()

      if (
        !e.target.classList.contains('dropdown-item') ||
        e.target.classList.contains('notVariable')
      ) {
        return
      }
      document
        .getElementById('body')
        .appendChild(document.createTextNode(e.target.getAttribute('title')))
    }),
  )
})

// Use native event listeners
eventType.addEventListener('change', event => {
  'use strict'

  // eventTypoe is already declared
  // var eventType = event.currentTarget.value

  // Vanilla $().empty
  const additionalFields = document.getElementById('additionalFields')
  additionalFields.innerHTML = ''

  const variables = [...document.querySelectorAll('.variables')]

  variables.forEach(varElmnt => {
    varElmnt.innerHTML =
      '<div class="notVariable dropdown-item has-text-grey">None</div>'
  })

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
                <i class="fas fa-${data.icon}></i>
              </span>
            </div>
            <p class="help ${data.error ? 'is-danger' : ''}">${data.help}</p>
          </div>
        </div>
      </div>
      `

      additionalFields.insertAdjacentHTML('', newField)
    }

    if (Object.keys(eventTypes[eventType].variables).length > 0) {
      // Replace jQuery with Array forEach
      variables.forEach(el => {
        el.innerHTML = ''
      })
    }

    // Use let over var
    for (let key in eventTypes[eventType].variables) {
      // Use template strings
      const variable = `{${eventTypes[eventType].variables[key]}}`

      const variableItem = `
        <a href="#" class="dropdown-item" title="${variable}">${key}</a>
      `

      variables.forEach(varElmnt => varElemnt.appendChild(variableItem))
    }
  }
})

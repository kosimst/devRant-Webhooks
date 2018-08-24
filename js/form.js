// Declaration with let to prevent global
const eventTypes = {
  newRant: {
    fields: [
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
      'Ranter Score': 'user_score',
    },
  },
  newCommentOnRant: {
    fields: [
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
    variables: {
      'Comment ID': 'id',
      'Rant ID': 'rant_id',
      'Comment Body': 'body',
      'Comment Score': 'score',
      'Comment Created Timestamp': 'created_time',
      'Commenter User ID': 'user_id',
      'Commenter Username': 'user_username',
      'Commenter Score': 'user_score',
      'Commenter is Supporter': 'user_dpp',
    },
  },
  newWeeklyTopic: {
    fields: [],
    variables: {
      Topic: 'prompt',
      Week: 'week',
      'Amount of Rants': 'num_rants',
      Date: 'date',
    },
  },
}

const eventTypeElement = document.getElementById('eventType')

// Vanilla implementation of $(document).ready
document.addEventListener('DOMContentLoaded', () => {
  'use strict'

  // Use getElementById -> faster and vanilla
  if ('eventType' in previousForm && previousForm.eventType != '') {
    eventTypeElement.value = previousForm.eventType
  }
  if ('method' in previousForm && previousForm.method != '') {
    document.getElementById('method').value = previousForm.method
  }
  if ('contentType' in previousForm && previousForm.contentType != '') {
    document.getElementById('contentType').value = previousForm.contentType
  }
  // Vanilly implementaion of $().trigger
  eventTypeElement.dispatchEvent(new Event('change'))
  ;[...document.querySelectorAll('.variables.variables-url')].forEach(el =>
    el.addEventListener('click', e => {
      e.preventDefault()

      if (
        !e.target.classList.contains('dropdown-item') ||
        e.target.classList.contains('notVariable')
      ) {
        return
      }

      document.getElementById('url').value += e.target.getAttribute('title')
    }),
  )
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
eventTypeElement.addEventListener('change', () => {
  'use strict'

  // Vanilla $().empty
  const additionalFields = document.getElementById('additionalFields')
  additionalFields.innerHTML = ''

  const variables = [...document.querySelectorAll('.variables')]

  variables.forEach(varElmnt => {
    varElmnt.innerHTML =
      '<div class="notVariable dropdown-item has-text-grey">None</div>'
  })

  if (eventTypeElement.value in eventTypes) {
    const {
      fields: eventTypeFields,
      variables: eventTypeVariables,
    } = eventTypes[eventTypeElement.value]
    for (const data of eventTypeFields) {
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
                <i class="fas fa-${data.icon}"></i>
              </span>
            </div>
            <p class="help ${data.error ? 'is-danger' : ''}">${data.help}</p>
          </div>
        </div>
      </div>
      `

      additionalFields.insertAdjacentHTML('beforeEnd', newField)
    }

    if (Object.keys(eventTypeVariables).length > 0) {
      // Replace jQuery with Array forEach
      variables.forEach(el => {
        el.innerHTML = ''
      })
    }

    // Use let over var
    for (const key in eventTypeVariables) {
      // Use template strings
      const variable = `{${eventTypeVariables[key]}}`

      const variableItem = `
        <a href="#" class="dropdown-item" title="${variable}">${key}</a>
      `

      variables.forEach(varElmnt =>
        varElmnt.insertAdjacentHTML('beforeEnd', variableItem),
      )
    }
  }
})

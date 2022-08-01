/**
 * Handle row click event.
 * Toggle ticking row, add/remove hidden inputs to form and display values in textarea
 *
 * @param {Element} row row of table to handle click event
 * @param {Selector} formSelector selector to find the form to add hidden input
 * @param {Selector} displaySelector selector to find the text view to display row value
 * @param rowSelector
 * @param {String} hiddenInputName name of hidden input to add/remove on row click
 * @param isTextArea
 */
const toggleRowTick = (row, formSelector, displaySelector,rowSelector, hiddenInputName, isTextArea = true) => {
    const tickIcon = row.querySelector('.tick i');

    // toggle display of tick icon
    if (tickIcon.style.display === 'none') {
        tickIcon.style.removeProperty('display');

        // add new hidden input
        addHiddenInput(row, formSelector, hiddenInputName);


        if (isTextArea){
            // add to textarea
            addToDisplayList(row, displaySelector,rowSelector);
        }else{
            addElementToDisplayList(row,displaySelector,rowSelector)
        }

    } else {
        tickIcon.style.display = 'none';

        //remove hidden input
        removeHiddenInput(row, hiddenInputName);

        if (isTextArea){
            //remove from textarea
            removeFromDisplayList(row, displaySelector,rowSelector);
        }else{
            removeElementFromDisplayList(row,displaySelector,rowSelector)
        }
    }
}

/**
 * Add hidden input to form
 *
 * @param {Element} row
 * @param {Selector} formSelector
 * @param {String} inputName
 */
const addHiddenInput = (row, formSelector, inputName) => {
    const rowId = row.querySelector('.id').innerHTML;
    let hiddenInput = document.createElement('input')
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', inputName);
    hiddenInput.setAttribute('value', rowId);
    document.querySelector(formSelector).appendChild(hiddenInput);
}

/**
 * Remove hidden input from form
 *
 * @param {Element} row
 * @param {String} inputName
 */
const removeHiddenInput = (row, inputName) => {
    const rowId = row.querySelector('.id').innerHTML;
    document.querySelector(`input[name="${inputName}"][value="${rowId}"]`).remove();
}

/**
 * Display row value (email) in a text view
 *
 * @param {Element} row
 * @param {Selector} displaySelector
 * @param rowSelector
 */
const addToDisplayList = (row, displaySelector,rowSelector) => {
    const email = row.querySelector(rowSelector).innerHTML;
    const displayElement = document.querySelector(displaySelector);
    const displayText = displayElement.innerHTML;
    if (displayText !== '') {
        displayElement.innerHTML = [displayText, email].join('\n');
    } else {
        displayElement.innerHTML = email;
    }
}

const addElementToDisplayList =  (row, displaySelector,rowSelector) => {
    const element = row.querySelector(rowSelector).innerHTML;
    let template = `<span class="btn btn-sm btn-warning disabled mx-1 ${element}">${element}</span>`;
    let node = stringToHTML(template).querySelector('span');
    document.querySelector(displaySelector).appendChild(node);
}

/**
 * Remove row value (email) from a text view
 * @param {Element} row
 * @param {Selector} displaySelector
 */
const removeFromDisplayList = (row, displaySelector,rowSelector) => {
    const emailToRemove = row.querySelector(rowSelector).innerHTML;
    const displayElement = document.querySelector(displaySelector);
    const displayText = displayElement.innerHTML;
    displayElement.innerHTML = displayText.split('\n')
        .filter(curEmail => curEmail !== emailToRemove)
        .join('\n');
}


const removeElementFromDisplayList = (row,displaySelector,rowSelector) => {
    const element = row.querySelector(rowSelector).innerHTML;
    const displayElement = document.querySelector(displaySelector);
    const node = displayElement.querySelector(`.${element}`);

    displayElement.removeChild(node);
}

/**
 * Search for rows in table by keyword (email)
 *
 * @param {String} keyword
 * @param {Selector} tableSelector
 */
const search = (keyword, tableSelector) => {
    const rows = document.querySelectorAll(`${tableSelector} tbody tr`);

    if (keyword === '') {
        rows.forEach(row => row.style.removeProperty('display'));
    } else {
        rows.forEach(row => {
            const email = row.querySelector('.email').innerHTML;
            if (!email.includes(keyword)) {
                row.style.display = 'none';
            } else {
                row.style.removeProperty('display');
            }
        });
    }
}

/**
 * Tick rows in table based on hidden inputs in form
 *
 * @param {String} hiddenInputName
 * @param {Selector} tableSelector
 */
const initializeSelectedOptions = (hiddenInputName, tableSelector) => {
    const hiddenInputValues = [];

    const hiddenInputElems = document.querySelectorAll(`input[name="${hiddenInputName}"]`);
    hiddenInputElems.forEach(elem => hiddenInputValues.push(elem.getAttribute('value')));

    if (hiddenInputValues.length > 0) {
        document.querySelectorAll(`${tableSelector} tbody tr`)
        .forEach(row => {
            const rowId = row.querySelector('td.id').innerHTML;
            if (hiddenInputValues.includes(rowId)) {
                row.querySelector('.tick i').style.removeProperty('display');
            }
        });
    }
}

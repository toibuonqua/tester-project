const removeElementsByClass = (className) => {
    document.querySelectorAll(`.${className}:not(.non-hidden)`)
        .forEach(elem => elem.remove());
}

const removeFlashMessage = (timeOut) => {
    setTimeout(() => {
        removeElementsByClass('alert');
    }, timeOut);
}

removeFlashMessage(60000);
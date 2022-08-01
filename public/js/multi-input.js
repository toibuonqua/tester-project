const stringToHTML = function (str) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(str, 'text/html');
    return doc.body;
};

const removeInput = (ele) => {
    ele.remove();
}

const addInput = () => {
    let id = 'input' + new Date().getTime();

    let input = `<div class="row" id="${id}">
                    <div class="col-sm-4">
                        <input type="text" class="form-control mb-3 " name="${inputName}[]">
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeInput(${id})">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>`;

    document.querySelector('#input-holder').append(stringToHTML(input));
}


/* get list searched student
 *
 * @param {*} requestData
 * @param {*} options
 */
const searchUserByKey = (requestData, options) => {

    const { searchKey, _token } = requestData;

    const formData = new FormData();
    formData.append("search_key", searchKey);
    formData.append("_token", _token);

    const requestOptions = {
        method: 'POST',
        body: formData,
        ...options,
    };

    return fetch(`/api/classroom/${ classId }/student/find `,requestOptions);
};

/**
 * generate string template
 * @param {string} template default html template
 * @param {Array} data
 * @returns {string} template after generate
 */
const generateTemplate = (template,data) => {

    let tbBody = "<tbody>\n";

    data.forEach((user)=>{
        let displayAttr = isSelectedStudent(user.id) ? '' : 'style="display: none"';
        let row = `<tr>
                        <td class="id">${user.id}</td>
                        <td class="email">${user.email}</td>
                        <td class="username">${user.username}</td>
                        <td class="tick" style="min-width: 40px"> <i class="fas fa-check" ${displayAttr} ></i> </td>
                   </tr>`;
        tbBody += row;
    });
    return template.replace('<tbody>',tbBody);

}

let selectedStudents = [];

const isSelectedStudent = (id)=>{
    return selectedStudents.includes(id);
}

/**
 * update selected students when click row
 * @param row
 */
const toggleStudentsData = function (row){
    const rowId = parseInt(row.querySelector('.id').innerHTML);

    if (Number.isNaN(rowId)){
        return;
    }

    if (isSelectedStudent(rowId)){
        selectedStudents.splice(selectedStudents.indexOf(rowId),1);
    }else{
        selectedStudents.push(rowId);
    }
}

const rowsClickHandler = function (e){
    let row = e.target.parentNode;

    toggleRowTick(
        row,
        "#class-create-form",
        '#student-display',
        '.email',
        'newStudents[]'
    );

    toggleStudentsData(row);
}

const addRowClickEvent = (table) =>{
    table.querySelectorAll("tbody tr").forEach(row => {
        row.removeEventListener('click',rowsClickHandler);
        row.addEventListener('click',rowsClickHandler);
    });
}

const deleteStudent =  (requestData, options) => {

    const { studentId, _token } = requestData;

    let formData = new FormData();
    formData.append("_token", _token);

    const requestOptions = {
        method: 'DELETE',
        body: formData,
        ...options,
    };

    return fetch(`/api/classroom/${ classId }/student/${ studentId }`, requestOptions);
}



const addStudentDeleteEvent = ()=>{
    let deleteRow;
    const confirmedModal = document.querySelector('#confirm-delete');

    if (confirmedModal == null){
        return;
    }

    const confirmDeleteModal = new bootstrap.Modal(confirmedModal, {
        keyboard: false
    })

    document.querySelectorAll('.students-list .delete-student').forEach(async function (ele){
        ele.addEventListener('click',async ()=>{
            deleteRow = ele;
            confirmDeleteModal.show();
        });
    })

    document.querySelectorAll('#delete-student-confirmed').forEach( function (deleteBtn) {
        deleteBtn.addEventListener('click', async ()=>{
            const _token = document.getElementsByName("_token")[0].value;
            const studentId = deleteRow.getAttribute("value");

            const result = await deleteStudent({ studentId, _token });

            confirmDeleteModal.hide();

            if (result.status !== 200) {
                return;
            }

            deleteRow.parentElement.parentElement.remove();
        });
    });

}

window.addEventListener('DOMContentLoaded', () => {

    const studentsTable = document.querySelector('#students_searched');
    const defaultTemplate = studentsTable.innerHTML;
    const userSearch = document.querySelector(`input[name=${inputName}]`);

    addStudentDeleteEvent();

    userSearch.addEventListener('input',async function(){

        if (this.value.length < 3){
            return;
        }

        const searchKey = this.value;
        const _token = document.getElementsByName("_token")[0].value;

        const result = await searchUserByKey({ searchKey, _token });

        if (result.status !== 200) {
            return;
        }

        const data = await result.json();

        const template = generateTemplate(defaultTemplate,data.data);

        // Get DOM maps
        const templateMap = createDOMMap(stringToHTML(template));
        const domMap = createDOMMap(studentsTable);

        diff(templateMap, domMap, studentsTable);

        addRowClickEvent(studentsTable);

    });

});

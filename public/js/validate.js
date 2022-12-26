function  submit_new_user() {
    let check = validate_user('#add_user')
    if (check) {
        document.querySelector('#submitNewUser').click()
    }
}

function submit_modify_user() {
    let check = validate_user('#mod_user', email=false)
    if (check) {
        document.querySelector('#submitModifyUser').click()
    }
}


function validate_user(formSelector, fieldEmail=true) {

    const form = document.querySelector(formSelector)

    let user_name = form.querySelector('[name="username"]').value
    if (fieldEmail) {
        var email = form.querySelector('[name="email"]').value
    }
    let phone_number = form.querySelector('[name="phone_number"]').value
    let department = form.querySelector('#select_department_id').value
    let role = form.querySelector('#select_role_id').value
    let workarea = form.querySelector('#select_workarea_id').value
    let code_user = form.querySelector('[name="code_user"]').value

    let val_username = /^([a-zA-Z0-9]{1,})$/i
    let val_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i
    let val_number = /^([\d]{3} [\d]{3} [\d]{3})*([\d]{3}-[\d]{3}-[\d]{3})*([\d]{3}\.[\d]{3}\.[\d]{3})*([\d]{3}[\d]{3}[\d]{3})*$/i
    let val_code_user = /^([0-9]{1,})$/i

    let emptyFieldMessage = 'Không được để trống trường này'
    let errorFormatMessage = 'Nhập dữ liệu sai định dạng'

    let checkFlag = true

    if (user_name == '') {
        showValidateMessage('#username_validate', emptyFieldMessage)
        checkFlag = false
    } else if ((user_name.match(val_username)) == null) {
        showValidateMessage('#username_validate', errorFormatMessage)
        checkFlag = false
    }

    if (fieldEmail) {
        if (email == '') {
            showValidateMessage('#email_validate', emptyFieldMessage)
            checkFlag = false
        } else if ((email.match(val_email)) == null) {
            showValidateMessage('#email_validate', errorFormatMessage)
            checkFlag = false
        }
    }

    if (phone_number == '') {
        showValidateMessage('#phone_number_validate', emptyFieldMessage)
        checkFlag = false
    } else if ((phone_number.match(val_number)) == null) {
        showValidateMessage('#phone_number_validate', errorFormatMessage)
        checkFlag = false
    }

    if (department == '') {
        showValidateMessage('#department_validate', emptyFieldMessage)
        checkFlag = false
    }

    if (role == '') {
        showValidateMessage('#role_validate', emptyFieldMessage)
        checkFlag = false
    }

    if (workarea == '') {
        showValidateMessage('#workarea_validate', emptyFieldMessage)
        checkFlag = false
    }

    if (code_user == '') {
        showValidateMessage('#code_user_validate', emptyFieldMessage)
        checkFlag = false
    } else if ((code_user.match(val_code_user)) == null) {
        showValidateMessage('#code_user_validate', errorFormatMessage)
        checkFlag = false
    }

    return checkFlag
}

function showValidateMessage(messageSelector, message, timeout=5000) {
    document.querySelector(messageSelector).innerHTML = message
    setTimeout(() => {
        document.querySelector(messageSelector).innerHTML = ''
    }, timeout);
}

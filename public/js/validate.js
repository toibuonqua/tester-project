// message validate
var emptyFieldMessage = 'Không được để trống trường này'
var errorFormatMessage = 'Dữ liệu nhập vào sai định dạng'
var oldPasswordIncorrect = 'Mật khẩu cũ không chính xác'
var oldAndNewPasswordIsTheSame = 'Mật khẩu cũ và mật khẩu mới không được trùng nhau'
var repeatNewPasswordError = 'Nhập khẩu nhập lại không khớp'

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

function submit_new_workarea() {
    let check = validate_workarea('#add_workarea')
    if (check) {
        document.querySelector('#submitNewWorkarea').click()
    }
}

function submit_modify_workarea() {
    let check = validate_workarea('#mod_workarea')
    if (check) {
        document.querySelector('#submitModifyWorkarea').click()
    }
}

async function submit_password() {
    let check = await validate_password('#changepw')
    if (check) {
        document.querySelector('#submitPassword').click()
    }
}

async function validate_password(formSelector) {

    const form = document.querySelector(formSelector)

    // get data from formInput
    let old_password = form.querySelector('#old-password').value
    let new_password = form.querySelector('#new-password').value
    let confirm_new_password = form.querySelector('#confirm-new-password').value

    // regex password
    let val_password = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/i

    // check flag
    let checkFlag = true

    // validate old password
    if (old_password == '') {
        showValidateMessage('#old-password-validate', emptyFieldMessage)
        checkFlag = false
    }
    else {
        const token = form.querySelector('[name="_token"]').value
        const result = await api.checkPasswordUser({ old_password, token })

        if (result.status == 200)
        {
            let resultData = await result.json()
            if (!resultData.data.isOldPassword) {
                showValidateMessage('#old-password-validate', oldPasswordIncorrect)
                checkFlag = false
            }
        }
    }

    // validate new password
    if (new_password == '') {
        showValidateMessage('#new-password-validate', emptyFieldMessage)
        checkFlag = false
    } else if (new_password == old_password) {
        showValidateMessage('#new-password-validate', oldAndNewPasswordIsTheSame)
        checkFlag = false
    } else if ((new_password.match(val_password)) == null) {
        showValidateMessage('#new-password-validate', errorFormatMessage)
        checkFlag = false
    }

    if (confirm_new_password == '') {
        showValidateMessage('#confirm-new-password-validate', emptyFieldMessage)
        checkFlag = false
    } else if (confirm_new_password != new_password) {
        showValidateMessage('#confirm-new-password-validate', repeatNewPasswordError)
        checkFlag = false
    } else if ((confirm_new_password.match(val_password)) == null) {
        showValidateMessage('#confirm-new-password-validate', errorFormatMessage)
        checkFlag = false
    }

    return checkFlag

}

function validate_workarea(formSelector) {

    const form = document.querySelector(formSelector)

    let workarea_code = form.querySelector('[name="work_areas_code"]').value
    let name = form.querySelector('[name="name"]').value

    let val_workarea_code = /^([a-zA-Z0-9]{1,})$/i
    let val_name = /^([a-zA-Z0-9\s]{1,})$/i

    let checkFlag = true

    if (workarea_code == '') {
        showValidateMessage('#workarea_validate', emptyFieldMessage)
        checkFlag = false
    } else if ((workarea_code.match(val_workarea_code)) == null) {
        showValidateMessage('#workarea_validate', errorFormatMessage)
        checkFlag = false
    }


    if (name == '') {
        showValidateMessage('#name_validate', emptyFieldMessage)
        checkFlag = false
    } else if ((name.match(val_name)) == null) {
        showValidateMessage('#name_validate', errorFormatMessage)
        checkFlag = false
    }

    return checkFlag

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

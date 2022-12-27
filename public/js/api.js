var api = {
    checkPasswordUser( requestData, options) {

        const formData = new FormData()

        const { old_password, token } = requestData

        formData.append('password', old_password)
        formData.append('_token', token)

        return fetch("/change_pw/user_password", {
            method: "POST",
            body: formData,
            ...options,
        });
    },
}

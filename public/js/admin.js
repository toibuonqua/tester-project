/* Sending raw file analyzing to server
 *
 * @param {*} requestData
 * @param {*} options
 */
const uploadNumberPerPage = (requestData, options) => {
    const formData = new FormData();

    const { numberPerPage, _token } = requestData;

    formData.append("numberPerPage", numberPerPage);
    formData.append("_token", _token);

    return fetch("/admin/account/update-number-per-page", {
        method: "POST",
        body: formData,
        ...options,
    });
};

async function updateNumberPerPage() {
    const numberPerPage = document.getElementsByName("numberPerPage")[0].value;
    const _token = document.getElementsByName("_token")[0].value;
    const result = await uploadNumberPerPage({ numberPerPage, _token });
    if (result.status === 200) {
        location.reload();
    }
}

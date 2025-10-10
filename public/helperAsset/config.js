function showLoader() {
    document.getElementById('loader-wrapper').style.display = 'flex';
}

function hideLoader() {
    document.getElementById('loader-wrapper').style.display = 'none';
}

function successToast(mess){
    Toastify({
        text: mess,
        className: "info",
        style: {
            background: "green",
        }
    }).showToast();
}

function  errorToast(mess){
    Toastify({
        text: mess,
        className: "info",
        style: {
            background: "red",
        }
    }).showToast();
}

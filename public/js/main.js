$(".btn-delete").click(function () {
    let that = $(this);
    Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Apakah anda yakin ingin menghapus?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
    }).then((result) => {
        if (result.value) {
            that.parent("form").submit();
        }
    });
});
function showSucc(title = "Behasil!", text) {
    Swal.fire({
        icon: "success",
        title: title,
        text: text,
    });
}
function showError(title = "Oops...", text) {
    Swal.fire({
        icon: "error",
        title: title,
        text: text,
    });
}
function sweetNotButton(icon, text) {
    Swal.fire({
        position: "center",
        icon: icon,
        title: text,
        showConfirmButton: false,
        timer: 1000,
    });
}
function validateUrl(url) {
    // Pola regex untuk URL
    var urlPattern =
        /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;

    // Validasi URL menggunakan pola regex
    return urlPattern.test(url);
}
function showConfirmButton(title, text, text2) {
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Berhasil!",
                text: text2,
                icon: "success",
            });
        }
    });
}
function formAjax(form, direct) {
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(form);
        $(this)
            .find("#language, #filee")
            .each(function () {
                if ($(this).val() === "") {
                    return showError(
                        "Missing!",
                        "Running Code Terlebih Dahulu!"
                    );
                }
            });
        $.ajax({
            url: form.action,
            method: form.method,
            data: formData,
            contentType: false, // Memastikan bahwa tipe konten tidak diatur secara otomatis
            processData: false, // Memastikan bahwa data FormData tidak diproses secara otomatis
            success: function (response) {
                sweetNotButton("success", response.success);
                setTimeout(function () {
                    window.location.href = direct;
                }, 1000);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.error) {
                        showError("Terdapat Kesalahan : " + response.error);
                        $("#error")
                            .html(
                                '<i class="bi bi-exclamation-circle"></i> Terdapat Kesalahan: ' +
                                    response.error
                            )
                            .show();
                    }
                }
            },
        });
    });
}

function formAjaxAdmin(form, direct = null, reload = null, ex) {
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            method: form.method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                sweetNotButton("success", response.success);
                ex;
                if (reload != null) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
                if (direct != null) {
                    setTimeout(function () {
                        window.location.href = direct;
                    }, 1000);
                }
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.error) {
                        showError("Terdapat Kesalahan : " + response.error);
                    }
                }
            },
        });
    });
}
function formAjaxProject(form, direct = null) {
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            method: form.method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                sweetNotButton("success", response.success);
                if (direct != null) {
                    setTimeout(function () {
                        window.location.href = direct;
                    }, 1000);
                }
            },
            error: function (xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                if (response && response.error) {
                    if (xhr.status === 422) {
                        showError("Terdapat Kesalahan : " + response.error);
                    } else if (xhr.status === 500) {
                        showError(
                            "Terjadi kesalahan pada server : " + response.error
                        );
                    } else {
                        showError("Terjadi kesalahan : " + response.error);
                    }
                }
            },
        });
    });
}
function formAjaxProjectTab(form) {
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            method: form.method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                sweetNotButton("success", response.success);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.error) {
                        showError("Terdapat Kesalahan : " + response.error);
                    }
                } else if (xhr.status === 500) {
                    showError(
                        "Terjadi kesalahan pada server : " + response.error
                    );
                } else {
                    showError("Terjadi kesalahan : " + response.error);
                }
            },
        });
    });
}

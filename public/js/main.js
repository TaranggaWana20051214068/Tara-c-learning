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
function showSucc(text) {
    Swal.fire({
        icon: "success",
        title: "Behasil!",
        text: text,
    });
}
function showError(text) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: text,
    });
}
function validateUrl(url) {
    // Pola regex untuk URL
    var urlPattern =
        /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;

    // Validasi URL menggunakan pola regex
    return urlPattern.test(url);
}

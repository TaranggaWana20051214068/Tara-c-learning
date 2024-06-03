function getVidId(url) {
    var videoId;
    if (url.includes("youtube.com")) {
        // Jika URL mengandung 'youtube.com', gunakan pendekatan dengan 'v='
        var parts = url.split("v=");
        videoId = parts[1];
    } else if (url.includes("youtu.be")) {
        // Jika URL mengandung 'youtu.be', gunakan pendekatan dengan pemisahan '/'
        videoId = url.split("/").pop();
    } else {
        // Jika URL tidak sesuai dengan format yang diharapkan, kembalikan null
        return null;
    }

    // Menghapus bagian yang tidak perlu (misalnya, parameter query setelah ID video)
    // Jika ada tanda '&' di URL, hanya ambil bagian sebelumnya
    if (videoId && videoId.indexOf("&") !== -1) {
        videoId = videoId.split("&")[0];
    }

    return videoId;
}

// Fungsi untuk menambahkan inputan link YouTube baru
function addYoutubeLinkInput(url) {
    var container = document.getElementById("youtube-links-container");
    var inputs = container.getElementsByTagName("input");
    var hiddenInput = document.getElementById("hidden-youtube-link");
    var input = document.createElement("input");

    // Hapus semua input sebelum menambahkan yang baru
    if (inputs.length > 1) {
        input.name = "youtube_links[]";
    } else {
        input.name = "ss";
    }
    input.type = "text";
    input.className = "form-control";
    input.value = url; // Memasukkan nilai URL ke dalam input
    input.readOnly = true;
    container.appendChild(input);
    hiddenInput.value = url;
}
function addYT() {
    document
        .getElementById("submit-button")
        .addEventListener("click", async function () {
            const { value: url } = await Swal.fire({
                input: "url",
                inputLabel: "URL address",
                inputPlaceholder: "Enter the URL",
                showCancelButton: true,
                preConfirm: async (url) => {
                    // Periksa apakah URL mengandung kata 'youtube' atau 'youtu.be'
                    if (url.includes("youtube") || url.includes("youtu.be")) {
                        const youtubeUrl = getVidId(url);
                        if (youtubeUrl == null) {
                            return $.SweetAlert.showErr(
                                "URL Salah Silahkan Periksa kembali"
                            );
                        } else {
                            addYoutubeLinkInput(url);
                            document.getElementById(
                                "submit-button"
                            ).style.display = "none";
                            return $.SweetAlert.showSucc(`URL Benar`);
                        }
                    } else {
                        // Tampilkan pesan kesalahan jika URL tidak valid
                        return $.SweetAlert.showErr(
                            "URL yang dimasukkan bukan merupakan URL YouTube."
                        );
                    }
                },
            });
        });
}
document.addEventListener("DOMContentLoaded", function () {
    var formFileThumbnail = document.getElementById("formFileThumnail");
    var formFileArticle = document.getElementById("formFileArticle");

    if (formFileThumbnail) {
        formFileThumbnail.addEventListener("change", function () {
            var fileInput = this;
            var file = fileInput.files[0];

            // Mengecek apakah file yang diunggah adalah gambar
            if (file.type && !file.type.startsWith("image/")) {
                // Jika bukan gambar, tampilkan pesan kesalahan
                $.SweetAlert.showErr("Thumbnail Harus Berupa Gambar");
                // Reset input file agar pengguna dapat memilih file yang lain
                fileInput.value = "";
            }
            if (file.size > 2 * 1024 * 1024) {
                $.SweetAlert.showErr(
                    "Ukuran file terlalu besar. Maksimum 2MB yang diizinkan."
                );
                // Reset input file agar pengguna dapat memilih file yang lain
                fileInput.value = "";
            }
        });
    }

    if (formFileArticle) {
        formFileArticle.addEventListener("change", function () {
            var fileInput = this;
            var file = fileInput.files[0];
            // Mengecek apakah ukuran file tidak melebihi 10MB (10 * 1024 * 1024 byte)
            if (file.size > 10 * 1024 * 1024) {
                // Jika ukuran file melebihi 10MB, tampilkan pesan kesalahan
                $.SweetAlert.showErr(
                    "Ukuran file terlalu besar. Maksimum 10MB yang diizinkan."
                );
                // Reset input file agar pengguna dapat memilih file yang lain
                fileInput.value = "";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const btnImport = document.getElementById("btnImportIWKL");
    const fileInput = document.getElementById("fileInputIWKL");

    if (btnImport && fileInput) {
        btnImport.addEventListener("click", () => fileInput.click());

        fileInput.addEventListener("change", () => {
            if (fileInput.files.length > 0) {
                Swal.fire({
                    title: "Yakin Import?",
                    text: "Data lama bisa tertimpa dengan data baru!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Import",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fileInput.closest("form").submit();
                    }
                });
            }
        });
    }
});

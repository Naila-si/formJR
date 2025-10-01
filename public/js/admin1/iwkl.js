document.addEventListener("DOMContentLoaded", function () {
    const btnImport = document.getElementById("btnImportIWKL");
    const fileInput = document.getElementById("fileInputIWKL");
    const deleteForms = document.querySelectorAll('.delete-form');

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
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah yakin?',
                text: "Data IWKL akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

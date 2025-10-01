document.addEventListener('DOMContentLoaded', function () {
    const btnImport = document.getElementById('btnImportRKCRM');
    const fileInput = document.getElementById('fileInputRKCRM');

    // Klik tombol akan membuka file picker
    btnImport.addEventListener('click', () => {
        fileInput.click();
    });

    // Preview & otomatis submit
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        // Tampilkan nama file menggunakan SweetAlert
        Swal.fire({
            title: 'Import Data RK CRM',
            html: `<p>File yang dipilih: <strong>${file.name}</strong></p>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Import',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                fileInput.closest('form').submit();
            } else {
                // Reset input jika batal
                fileInput.value = '';
            }
        });
    });
});

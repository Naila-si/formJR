document.addEventListener('DOMContentLoaded', function () {
    // Import button
    const btnImport = document.getElementById('btnImport');
    const fileInput = document.getElementById('fileInput');

    btnImport.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileInput.parentElement.submit();
        }
    });
});

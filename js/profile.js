document.getElementById("profileImage").addEventListener("change", function (event) {
    const file = event.target.files[0];

    if (file) {
        const img = new Image();
        img.src = URL.createObjectURL(file);

        img.onload = function () {
            if (img.width > 150 || img.height > 150) {
                alert("Image dimensions must not exceed 150x150 pixels.");
                event.target.value = ""; // Reset file input
            }
        };
    }
});
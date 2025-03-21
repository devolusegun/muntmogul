document.addEventListener("DOMContentLoaded", function () {
    let originalProfileData = {
        address: document.getElementById("address").value.trim(),
        city: document.getElementById("city").value.trim(),
        state: document.getElementById("state").value.trim(),
        country: document.getElementById("country").value.trim()
    };
    let saveChangesBtn = document.getElementById("saveChangesBtn");
    let transactionModal = document.getElementById("transactionPinModal");
    let confirmBtn = document.getElementById("confirmPinBtn"); // This button triggers the update
    let transactionPinInput = document.getElementById("transactionPin");

    if (!saveChangesBtn) {
        console.error("❌ ERROR: Save Changes button not found!");
        return;
    }

    if (!transactionModal) {
        console.error("❌ ERROR: Transaction PIN modal not found!");
        return;
    }

    // ✅ SHOW TRANSACTION PIN MODAL
    saveChangesBtn.addEventListener("click", function (event) {
        event.preventDefault();

        let address = document.getElementById("address").value.trim();
        let city = document.getElementById("city").value.trim();
        let state = document.getElementById("state").value.trim();
        let country = document.getElementById("country").value.trim();

        // 🛑 Check if data is the same as original
        if (
            address === originalProfileData.address &&
            city === originalProfileData.city &&
            state === originalProfileData.state &&
            country === originalProfileData.country
        ) {
            alert("⚠️ No changes detected. Update your profile before saving.");
            return;
        }

        console.log("✅ Changes detected. Showing PIN modal...");
        $("#transactionPinModal").modal("show"); // Show PIN modal properly
    });

    // ✅ SUBMIT FORM AFTER ENTERING PIN
    confirmBtn.addEventListener("click", function (event) {
        event.preventDefault();

        let transactionPin = transactionPinInput.value.trim();
        if (!transactionPin) {
            alert("⚠️ Please enter your transaction PIN.");
            return;
        }

        console.log("✅ PIN entered. Sending update request...");

        let formData = new FormData();
        formData.append("transaction_pin", transactionPin);
        formData.append("address", document.getElementById("address").value.trim());
        formData.append("city", document.getElementById("city").value.trim());
        formData.append("state", document.getElementById("state").value.trim());
        formData.append("country", document.getElementById("country").value.trim());

        fetch("update_profile.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    console.log("✅ Profile update success.");
                    $('#transactionPinModal').modal('hide'); // Close modal
                    $('.modal-backdrop').remove(); // Remove leftover overlay
                    //transactionModal.style.display = "none"; // CLOSE MODAL
                } else {
                    console.error("❌ ERROR: Profile update failed.");
                }
            })
            .catch(error => console.error("❌ ERROR: ", error));
    });
});

function validateAndShowPinModal() {
    const address = document.getElementById("address").value.trim();
    const city = document.getElementById("city").value.trim();
    const state = document.getElementById("state").value.trim();
    const country = document.getElementById("country").value.trim();

    if (!address || !city || !state || !country) {
        alert("All fields are required before continuing.");
        return;
    }

    // Show the modal
    $('#transactionPinModal').modal('show');
}
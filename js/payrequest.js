document.addEventListener("DOMContentLoaded", function () {
    const cryptoSelect = document.querySelector("select[name='crypto_type']");
    const balanceField = document.getElementById("available_balance");

    cryptoSelect.addEventListener("change", function () {
        const selectedCrypto = this.value;

        // Fetch new balance from PHP dynamically
        fetch("fetchbalance.php?crypto_type=" + selectedCrypto)
            .then(response => response.json())
            .then(data => {
                balanceField.value = data.balance + " " + selectedCrypto;
            })
            .catch(error => console.error("Error fetching balance:", error));
    });
});
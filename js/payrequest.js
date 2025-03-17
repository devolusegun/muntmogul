document.addEventListener("DOMContentLoaded", function () {
    const cryptoSelect = document.getElementById("cryptoSelect");
    const balanceField = document.getElementById("available_balance");

    function updateBalance() {
        const selectedCrypto = cryptoSelect.value;
        if (!selectedCrypto) return;

        //console.log("Selected Crypto:", selectedCrypto); // Debugging log

        fetch("fetchbalance.php?crypto_type=" + selectedCrypto)
            .then(response => response.json())
            .then(data => {
                //console.log("Fetched Balance:", data.balance); // Debugging log
                balanceField.value = data.balance + " " + selectedCrypto;
            })
            .catch(error => console.error("Error fetching balance:", error));
    }

    // Handle Nice-Select dropdown change
    if (cryptoSelect) {
        cryptoSelect.addEventListener("change", updateBalance);
    }

    // Ensure Nice-Select is initialized
    setTimeout(() => {
        $('select').niceSelect();
        $(".nice-select").on("click", ".option", function () {
            setTimeout(updateBalance, 100); // Ensure update runs after selection
        });
    }, 300);

    // Fetch initial balance on page load
    updateBalance();
});

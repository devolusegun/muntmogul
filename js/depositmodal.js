let cryptoData = {};  // Stores JSON data globally
// Load JSON Data on Page Load
fetch("assets/crypto_addresses.json")
    .then(response => response.json())
    .then(data => {
        cryptoData = data;
        updateNetworks();  // Update networks when page loads
    }).catch(error => console.error("Error loading JSON:", error)); // Debugging

function openDepositModal() {
    document.getElementById("depositModal").style.display = "block";
}

function closeDepositModal() {
    document.getElementById("depositModal").style.display = "none";
}

// Close modal when clicking outside
window.onclick = function (event) {
    var modal = document.getElementById("depositModal");
    if (event.target === modal) {
        closeDepositModal();
    }
}

function fetchDepositDetails() {
    let cryptoType = document.getElementById("cryptoType").value;
    let networkType = document.getElementById("networkType").value;

    if (cryptoData[cryptoType] && cryptoData[cryptoType]["addresses"][networkType]) {
        let depositInfo = cryptoData[cryptoType]["addresses"][networkType];
        document.getElementById("depositAddress").value = depositInfo["address"];
        document.getElementById("qrCodeImage").src = depositInfo["qr_code"];
    } else {
        document.getElementById("depositAddress").value = "Invalid Selection";
        document.getElementById("qrCodeImage").src = "";
    }
}

// Update Networks Based on Selected Crypto
function updateNetworks() {
    let cryptoType = document.getElementById("cryptoType").value;
    let networkDropdown = document.getElementById("networkType");

    // Clear existing options
    networkDropdown.innerHTML = "";

    if (cryptoData[cryptoType]) {
        // Populate networks from JSON
        cryptoData[cryptoType]["networks"].forEach(network => {
            let option = document.createElement("option");
            option.value = network;
            option.text = network;
            networkDropdown.appendChild(option);
        });

        // Auto-select first network and fetch deposit details
        fetchDepositDetails();
    }
}



function copyAddress() {
    let copyText = document.getElementById("depositAddress");
    navigator.clipboard.writeText(copyText.value);
    alert("Address copied to clipboard!");
}
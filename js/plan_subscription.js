let selectedPlan = null;
let minDeposit = 0;
let selectedCrypto = null;
let userBalances = {}; // Placeholder, will be set dynamically

// ✅ Fetch User Balances from PHP
fetch("get_user_balances.php")
    .then(response => response.json())
    .then(data => {
        userBalances = data; // Set user balances dynamically
    });

// ✅ Function to Select a Plan
function selectPlan(plan, minAmount) {
    selectedPlan = plan;
    minDeposit = minAmount;

    // ✅ Highlight selected plan
    document.querySelectorAll(".investment_content_wrapper").forEach(box => box.classList.remove("selected"));
    document.getElementById(plan).classList.add("selected");

    document.getElementById("selectedPlan").innerText = plan.charAt(0).toUpperCase() + plan.slice(1);
}

// ✅ Update Account Balance Based on Selected Crypto
function updateBalance(crypto) {
    selectedCrypto = crypto;
    document.getElementById("accountBalance").innerText = "$" + userBalances[crypto].toLocaleString();
}

// ✅ Function to Submit Subscription
function submitSubscription() {
    if (!selectedPlan) {
        alert("Please choose a plan first.");
        return;
    }
    if (!selectedCrypto) {
        alert("Please choose a payment mode.");
        return;
    }
    if (userBalances[selectedCrypto] < minDeposit) {
        alert("Insufficient balance for this plan.");
        return;
    }

    fetch("process_subscription.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ plan: selectedPlan, crypto: selectedCrypto })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            userBalances[selectedCrypto] -= minDeposit; // Deduct balance in UI
            updateBalance(selectedCrypto);
            document.getElementById("selectedPlan").innerText = selectedPlan.charAt(0).toUpperCase() + selectedPlan.slice(1);
        }
    });
}

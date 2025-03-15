let selectedPlan = null;
let minDeposit = 0;
let selectedCrypto = null;
let userBalances = {}; // Placeholder, will be set dynamically

// Fetch User Balances from PHP
fetch("get_user_balances.php")
    .then(response => response.json())
    .then(data => {
        userBalances = {
            BTC: parseFloat(data.btc_balance), 
            LTC: parseFloat(data.ltc_balance), 
            ETH: parseFloat(data.eth_balance), 
            DOGE: parseFloat(data.doge_balance)
        };
        console.log("User balances updated:", userBalances);
    })
    .catch(error => console.error("Error fetching user balances:", error));


// Function to Select a Plan
window.selectPlan = function(plan, minAmount) {
    selectedPlan = plan;
    minDeposit = minAmount;

    // Remove "selected" class from all plan buttons
    document.querySelectorAll(".choose-plan-btn").forEach(btn => {
        btn.classList.remove("selected");
    });

    // Remove "selected" class from all plan cards
    document.querySelectorAll(".investment_content_wrapper").forEach(box => {
        box.classList.remove("selected");
    });

    // Highlight the selected plan button
    const selectedButton = document.querySelector(`[data-plan='${plan}']`);
    if (selectedButton) {
        selectedButton.classList.add("selected");
    }

    // Highlight the selected plan card
    const selectedElement = document.getElementById(plan);
    if (selectedElement) {
        selectedElement.classList.add("selected");
        console.log(`Plan selected: ${plan} (Min Deposit: ${minAmount})`);
    } else {
        console.error(`Error: Plan element with ID '${plan}' not found.`);
    }

    //  Update the displayed selected plan text
    const selectedPlanElement = document.getElementById("selectedPlan");
    if (selectedPlanElement) {
        selectedPlanElement.innerText = plan.charAt(0).toUpperCase() + plan.slice(1);
    }
};




// Update Account Balance Based on Selected Crypto
function updateBalance(crypto) {
    // Check if userBalances is defined and contains the selected crypto
    if (!userBalances || !userBalances[crypto]) {
        console.error(`Error: Balance for ${crypto} is undefined.`);
        document.getElementById("accountBalance").innerText = "Balance unavailable";
        alert(`Fetching balances... Please wait a moment.`);
        return;
    }
    
    selectedCrypto = crypto;
    document.getElementById("accountBalance").innerText = "$" + userBalances[crypto].toLocaleString();
}




// Function to Submit Subscription
function submitSubscription() {
    console.log("Submitting subscription...");
    console.log("Selected Plan:", selectedPlan);
    console.log("Selected Crypto:", selectedCrypto);

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
        }
    });
}

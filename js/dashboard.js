document.addEventListener("DOMContentLoaded", function () {
    // Fetch user earnings and update UI
    fetchUserEarnings();
    fetchDepositsAndPayouts();
});


// Function to Fetch User Earnings from Backend
async function fetchUserEarnings() {
    try {
        //console.log(" DEBUG: fetchUserEarnings() is running..."); // if function runs

        let response = await fetch("../fetch_user_earnings.php");

        //console.log(" DEBUG: Raw Response:", response); // if fetch happens

        let data = await response.json();

        //console.log(" DEBUG: Earnings Data Received:", data); // Debugging earnings data

        if (!data || data.today === undefined || data.week === undefined) {
            throw new Error("Invalid earnings data received");
        }

        document.getElementById("todayInterest").innerText = `$${data.today}`;
        document.getElementById("weekInterest").innerText = `$${data.week}`;

        //console.log("Earnings successfully updated on dashboard.");
    } catch (error) {
        console.error("ERROR: Fetching earnings failed!", error);
    }
}

// Manually force running
fetchUserEarnings();


// Function to Convert Crypto Earnings to USD
function convertEarningsToUSD(earningsArray) {
    let totalUSD = 0;

    earningsArray.forEach(entry => {
        let crypto = entry.crypto_type;
        let amount = parseFloat(entry.earnings);
        let rate = cryptoPrices[crypto] || 0; // Get the latest price from live_crypto_rates.js
        totalUSD += amount * rate;
    });

    return totalUSD.toFixed(2);
}

// Function to Update Earnings Display
/*function updateEarningsDisplay(todayEarnings, weekEarnings) {
    let todayTotalUSD = convertEarningsToUSD(todayEarnings);
    let weekTotalUSD = convertEarningsToUSD(weekEarnings);

    // Update UI
    document.getElementById("todayInterest").innerText = `$${todayTotalUSD} USD`;
    document.getElementById("weekInterest").innerText = `$${weekTotalUSD} USD`;
}*/

// Recalculate earnings whenever prices update
setInterval(fetchUserEarnings, 60000); // Refresh earnings every 1 minute

// Fetch Deposits & Payouts
function fetchDepositsAndPayouts() {
    fetch("fetch_deposits_payouts.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("totalDeposit").innerText = `$${data.total_deposit} USD`;
                document.getElementById("newDeposit").innerText = `$${data.new_deposit} USD`;
                document.getElementById("totalPayouts").innerText = `$${data.total_payouts} USD`;
                document.getElementById("pendingPayouts").innerText = `$${data.pending_payouts} USD`;
            }
        })
        .catch(error => console.error("Error fetching deposits & payouts:", error));
}

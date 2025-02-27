let userBalances = {}; // Holds balances in USD
let selectedCrypto = null;

// Fetch Live Crypto Prices and User Balances
async function fetchCryptoData() {
    try {
        // Fetch live crypto prices
        const priceResponse = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,litecoin,ethereum,dogecoin&vs_currencies=usd");
        const prices = await priceResponse.json();

        // Fetch User Balances
        const balanceResponse = await fetch("get_user_balances.php");
        const userData = await balanceResponse.json();

        // Convert Crypto Balances to USD
        userBalances = {
            "BTC": (userData["btc_balance"] * prices.bitcoin.usd).toFixed(2),
            "LTC": (userData["ltc_balance"] * prices.litecoin.usd).toFixed(2),
            "ETH": (userData["eth_balance"] * prices.ethereum.usd).toFixed(2),
            "DOGE": (userData["doge_balance"] * prices.dogecoin.usd).toFixed(2)
        };

        // Update UI with New Prices & Balances
        updatePriceUI(prices);
        updateBalanceUI();
        
        console.log("Updated Prices & Balances:", prices, userBalances);
    } catch (error) {
        console.error("Error fetching live crypto prices:", error);
    }
}

// Function to Update Price UI
function updatePriceUI(prices) {
    document.getElementById("btcPrice").innerText = `$${prices.bitcoin.usd}`;
    document.getElementById("ltcPrice").innerText = `$${prices.litecoin.usd}`;
    document.getElementById("ethPrice").innerText = `$${prices.ethereum.usd}`;
    document.getElementById("dogePrice").innerText = `$${prices.dogecoin.usd}`;
}

// Function to Update Account Balance UI
function updateBalanceUI() {
    if (selectedCrypto) {
        document.getElementById("accountBalance").innerText = `$${userBalances[selectedCrypto] || "0.00"}`;
    }
}

// Function to Handle Crypto Selection
function updateBalance(crypto) {
    selectedCrypto = crypto;
    updateBalanceUI();
}

// Fetch Data on Page Load
fetchCryptoData();

// Fetch Live Prices & Update Every 60 Seconds
setInterval(fetchCryptoData, 60000);


//let userBalances = {}; // Holds balances in USD
//let selectedCrypto = null;

// Fetch Live Crypto Prices and User Balances
async function fetchCryptoData() {
    try {
        // Fetch live crypto prices
        const priceResponse = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,litecoin,ethereum,dogecoin&vs_currencies=usd");
        const prices = await priceResponse.json();

        // Fetch User Balances
        const balanceResponse = await fetch("get_user_balances.php");
        const userData = await balanceResponse.json();

        // Create a mapping between user balance keys and API response keys
        const cryptoMap = {
            "BTC": "bitcoin",
            "LTC": "litecoin",
            "ETH": "ethereum",
            "DOGE": "dogecoin"
        };

        // Convert Crypto Balances to USD
        userBalances = {};
        Object.keys(cryptoMap).forEach(crypto => {
            let apiKey = cryptoMap[crypto]; // Get the correct key from API response
            if (prices[apiKey] && prices[apiKey].usd !== undefined) {
                userBalances[crypto] = (userData[`${crypto.toLowerCase()}_balance`] * prices[apiKey].usd).toFixed(2);
            } else {
                console.warn(`⚠️ Missing price data for ${apiKey}`);
                userBalances[crypto] = "0.00"; // Default to 0 if price data is missing
            }
        });

        // Update UI
        Object.keys(userBalances).forEach(crypto => {
            const element = document.getElementById(`${crypto}_price`);
            console.log(`Checking element: ${crypto}_price`, element);

            if (element) {
                element.innerText = `$${userBalances[crypto]}`;
            } else {
                console.warn(`⚠️ Element with ID '${crypto}_price' not found.`);
            }
        });

        updateBalanceUI();
        console.log("✅ Updated Prices & Balances:", prices, userBalances);
    } catch (error) {
        console.error("❌ Error fetching live crypto prices:", error);
    }
}

// Function to Update Price UI
function updatePriceUI(crypto, price) {
    let priceElement = document.getElementById(`${crypto}_price`);
    
    if (!priceElement) {
        console.warn(`Price element for ${crypto} not found.`);
        return;
    }

    priceElement.innerText = "$" + price.toFixed(2);
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


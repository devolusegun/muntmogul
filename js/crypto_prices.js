// Fetch Live Crypto Prices and User Balances
async function fetchCryptoData() {
    try {
        // Fetch live crypto prices from CoinPaprika
        const priceResponse = await fetch("https://api.coinpaprika.com/v1/tickers");
        const priceData = await priceResponse.json();

        // Extract needed crypto prices
        const prices = {};
        const cryptoMap = {
            "BTC": "btc-bitcoin",
            "LTC": "ltc-litecoin",
            "ETH": "eth-ethereum",
            "DOGE": "doge-dogecoin"
        };

        Object.keys(cryptoMap).forEach(crypto => {
            const coinId = cryptoMap[crypto];
            const coinData = priceData.find(coin => coin.id === coinId);

            if (coinData && coinData.quotes && coinData.quotes.USD) {
                prices[crypto] = coinData.quotes.USD.price;
            } else {
                console.warn(`⚠️ Missing price data for ${crypto}`);
                prices[crypto] = 0; // Default to 0 if price data is missing
            }
        });

        // Fetch User Balances
        const balanceResponse = await fetch("get_user_balances.php");
        const userData = await balanceResponse.json();

        // Convert Crypto Balances to USD
        userBalances = {};
        Object.keys(cryptoMap).forEach(crypto => {
            if (prices[crypto] !== undefined) {
                userBalances[crypto] = (userData[`${crypto.toLowerCase()}_balance`] * prices[crypto]).toFixed(2);
            } else {
                userBalances[crypto] = "0.00"; // Default to 0 if price data is missing
            }
        });

        // Update UI
        Object.keys(userBalances).forEach(crypto => {
            const element = document.getElementById(`${crypto}_price`);

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

async function fetchCryptoPrices() {
    try {
        const response = await fetch('../fetch_crypto_prices.php'); // Adjust path

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        // Check if data contains valid prices
        if (data.prices) {
            console.log("Crypto Prices:", data);

            // Update the UI dynamically
            document.getElementById("btc-price").innerText = `$${data.prices.BTC.toFixed(2)}`;
            document.getElementById("eth-price").innerText = `$${data.prices.ETH.toFixed(2)}`;
            document.getElementById("ltc-price").innerText = `$${data.prices.LTC.toFixed(2)}`;
            document.getElementById("doge-price").innerText = `$${data.prices.DOGE.toFixed(6)}`;
        } else {
            console.error("Invalid price data received:", data);
        }

    } catch (error) {
        console.error("Error fetching crypto prices:", error);
    }
}

// Refresh every 60 seconds
setInterval(fetchCryptoPrices, 60000);
fetchCryptoPrices();

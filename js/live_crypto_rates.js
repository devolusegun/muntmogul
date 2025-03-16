async function fetchCryptoPrices() {
    try {
        const response = await fetch('../fetch_crypto_prices.php'); // Adjust path

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        console.log("Crypto Prices:", data);  // Debugging log

    } catch (error) {
        console.error("Error fetching crypto prices:", error);
    }
}

// Refresh every 60 seconds
setInterval(fetchCryptoPrices, 60000);
fetchCryptoPrices();
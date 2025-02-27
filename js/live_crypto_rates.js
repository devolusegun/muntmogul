let cryptoPrices = {}; // Store latest prices

async function fetchCryptoPrices() {
    try {
        let response = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,litecoin,ethereum,dogecoin&vs_currencies=usd");
        let data = await response.json();

        cryptoPrices = {
            BTC: data.bitcoin.usd,
            LTC: data.litecoin.usd,
            ETH: data.ethereum.usd,
            DOGE: data.dogecoin.usd
        };

        console.log("Live Crypto Prices Updated:", cryptoPrices);
    } catch (error) {
        console.error("Error fetching crypto prices:", error);
    }
}

// Fetch prices every 30 seconds to keep it updated
fetchCryptoPrices();
setInterval(fetchCryptoPrices, 30000);

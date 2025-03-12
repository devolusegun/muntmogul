document.addEventListener("DOMContentLoaded", function() {
    const newsReel = document.getElementById("newsReel");

    // Fetch news dynamically from an API (replace with actual API)
    fetch("news_api.php")
        .then(response => response.json())
        .then(data => {
            newsReel.innerHTML = "🚀 " + data.headlines.join(" | 🚀 ");
        })
        .catch(error => console.log("Error fetching news:", error));
});

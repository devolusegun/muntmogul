document.addEventListener("DOMContentLoaded", function() {
    const newsReel = document.getElementById("newsReel");

    // Fetch latest news from backend
    fetch("news_api.php")
        .then(response => response.json())
        .then(data => {
            if (data.headlines && data.headlines.length > 0) {
                newsReel.innerHTML = "🚀 " + data.headlines.join(" | 🚀 ");
            } else {
                newsReel.innerHTML = "📢 No latest news available.";
            }
        })
        .catch(error => {
            console.error("Error fetching news:", error);
            newsReel.innerHTML = "⚠️ Failed to load news.";
        });
});

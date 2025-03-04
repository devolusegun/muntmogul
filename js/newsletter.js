document.getElementById("newsletterForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent page reload

    let email = document.getElementById("emailInput").value;

    fetch("process_newsletter.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        let messageElem = document.getElementById("subscriptionMessage");
        messageElem.innerText = data.message;
        messageElem.style.color = data.success ? "green" : "red";

        if (data.success) {
            document.getElementById("emailInput").value = ""; // Clear input on success
        }
    })
    .catch(error => console.error("Error:", error));
});

function openPartnerModal() {
    document.getElementById('partnerModal').style.display = 'block';
}

function closePartnerModal() {
    document.getElementById('partnerModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    let modal = document.getElementById('partnerModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

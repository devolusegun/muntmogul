function incrementCounter(id, minIncrement, maxIncrement, interval) {
    const counterElement = document.getElementById(id);
    const storageKey = `counter_${id}`;

    // Step 1: Load from localStorage or use current text
    let currentValue = localStorage.getItem(storageKey);
    if (currentValue === null) {
        currentValue = parseInt(counterElement.innerText, 10);
        localStorage.setItem(storageKey, currentValue);
    } else {
        currentValue = parseInt(currentValue, 10);
        counterElement.innerText = currentValue;
    }

    // Step 2: Begin timed updates
    setInterval(() => {
        const increment = Math.floor(Math.random() * (maxIncrement - minIncrement + 1)) + minIncrement;
        currentValue += increment;

        counterElement.innerText = currentValue;
        localStorage.setItem(storageKey, currentValue);
    }, interval);
}

document.addEventListener('DOMContentLoaded', () => {
    incrementCounter('daysonline', 1, 3, 60000);    // Every 60 seconds
    incrementCounter('ttmembers', 1, 3, 60000);
    incrementCounter('ttdeposit', 1, 3, 60000);
    incrementCounter('ttwithdraw', 1, 3, 60000);
    //incrementCounter('ttmembersfooter', 1, 3, 60000);
    incrementCounter('ttdepositfooter', 1, 3, 60000);
})
setInterval(() => {
    document.getElementById('ttmembersfooter').innerText = document.getElementById('ttmembers').innerText;
}, 1000); // Update every 1 second;


document.querySelector('.submitForm').addEventListener('click', async function () {
    const form = document.querySelector('form');
    const data = new FormData(form);

    const responseBox = document.querySelector('.response');
    responseBox.innerHTML = 'Sending...';

    try {
        const res = await fetch('contact_form.php', {
            method: 'POST',
            body: data
        });
        const result = await res.json();

        if (result.status === 'success') {
            responseBox.style.color = 'green';
            form.reset();
        } else {
            responseBox.style.color = 'red';
        }

        responseBox.innerHTML = result.message;
    } catch (err) {
        responseBox.style.color = 'red';
        responseBox.innerHTML = 'An unexpected error occurred.';
    }
});
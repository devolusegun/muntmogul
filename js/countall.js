//incremental script
function incrementCounter(id, minIncrement, maxIncrement, interval) {
    const counterElement = document.getElementById(id);
    setInterval(() => {
        const currentValue = parseInt(counterElement.innerText, 10);
        const randomIncrement = Math.floor(Math.random() * (maxIncrement - minIncrement + 1)) + minIncrement;
        counterElement.innerText = currentValue + randomIncrement;
    }, interval);
}

document.addEventListener('DOMContentLoaded', () => {
    // Parameters: ID, Min increment, Max increment, Interval (milliseconds)
    incrementCounter('daysonline', 1, 3, 60000);           // every minute
    incrementCounter('ttmembers', 1, 3, 60000);      // every minute
    incrementCounter('ttdeposit', 1, 3, 60000);         // every minute
    incrementCounter('ttwithdraw', 1, 3, 60000);        // every minute
});


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
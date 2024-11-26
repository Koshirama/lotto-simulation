

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const inputs = document.querySelectorAll('input[type="number"]');
        let numbers = [];
        for (let input of inputs) {
            let value = parseInt(input.value);
            if (isNaN(value) || value < 1 || value > 49) {
                alert("Wszystkie liczby muszą być z zakresu od 1 do 49.");
                event.preventDefault();
                return;
            }
            if (numbers.includes(value)) {
                alert("Liczby muszą być unikalne.");
                event.preventDefault();
                return;
            }
            numbers.push(value);
            
        }
    });
});

fetch('process.php', {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then(data => {
    if (data.error) {
        document.getElementById('result').innerHTML = `<p style="color:red;">${data.error}</p>`;
        return;
    }
    let output = `
        <p>Twoje liczby: ${data.userNumbers.join(', ')}</p>
        <p>Wylosowane liczby: ${data.randomNumbers.join(', ')}</p>
        <p>Trafiłeś ${data.numberOfMatches} liczb(y): ${data.matches.join(', ')}</p>
        <p>Twoja wygrana: ${data.prize}</p>
    `;
    document.getElementById('result').innerHTML = output;
})
.catch(error => console.error('Błąd:', error));

form.addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('result').innerHTML = '<p>Przetwarzanie...</p>';
    // ... reszta kodu
});

then(data => {
    if (data.error) {
        document.getElementById('result').innerHTML = `<p style="color:red;">${data.error}</p>`;
        return;
    }
    // ... reszta kodu
})

form.addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('loader').style.display = 'block';
    document.getElementById('result').innerHTML = '';

    // ... reszta kodu

    fetch('process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loader').style.display = 'none';
        // ... reszta kodu
    })
    .catch(error => {
        document.getElementById('loader').style.display = 'none';
        console.error('Błąd:', error);
    });
});

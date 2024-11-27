document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#lottoForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Zatrzymanie domyślnego działania formularza
        document.getElementById('loader').style.display = 'block';

        const inputs = document.querySelectorAll('input[type="number"]');
        let numbers = [];
        for (let input of inputs) {
            let value = parseInt(input.value);
            if (isNaN(value) || value < 1 || value > 49) {
                alert("Wszystkie liczby muszą być z zakresu od 1 do 49.");
                document.getElementById('loader').style.display = 'none';
                return;
            }
            if (numbers.includes(value)) {
                alert("Liczby muszą być unikalne.");
                document.getElementById('loader').style.display = 'none';
                return;
            }
            numbers.push(value);
        }

        const formData = new FormData(form);

        // Wysłanie danych do serwera
        fetch('process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loader').style.display = 'none';

            if (data.error) {
                document.getElementById('result').innerHTML = `<p style="color:red;">${data.error}</p>`;
                return;
            }

            // Wyświetlanie wyników w #latestResults
            const latestResults = document.getElementById('latestResults');
            latestResults.innerHTML = `
                <p>Twoje liczby: ${data.userNumbers.join(', ')}</p>
                <p>Wylosowane liczby: ${data.randomNumbers.join(', ')}</p>
                <p>Trafiłeś ${data.numberOfMatches} z liczb(y)</p>
                <p>Twoja wygrana: ${data.prize}</p>
            `;
        })
        .catch(error => {
            document.getElementById('loader').style.display = 'none';
            console.error('Błąd:', error);
            document.getElementById('result').innerHTML = `<p style="color:red;">Wystąpił błąd: ${error.message}</p>`;
        });
    });
});

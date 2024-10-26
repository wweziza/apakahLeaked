document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const resultDiv = document.createElement('div');
    resultDiv.className = 'mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md';
    form.parentNode.insertBefore(resultDiv, form.nextSibling);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const nik = document.querySelector('input[name="nik"]').value;
        
        fetch('/check-nik', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nik: nik })
        })
        .then(response => response.json())
        .then(data => {
            if (data.found) {
                resultDiv.innerHTML = `
                    <h3 class="font-bold mb-2">Leaked Data Found:</h3>
                    <p>Name: ${data.data.name}</p>
                    <p>Birthdate: ${data.data.birthdate}</p>
                    <p>Gender: ${data.data.gender}</p>
                    <p>Address: ${data.data.address}</p>
                    <p>Religion: ${data.data.religion}</p>
                    <p>Job: ${data.data.job}</p>
                    <p>Citizenship: ${data.data.citizenship}</p>
                    <p>KK No: ${data.data.kknumber}</p>
                `;
            } else {
                resultDiv.innerHTML = '<p>No leaked data found for this NIK.</p>';
            }
            resultDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = '<p>An error occurred while checking the NIK.</p>';
            resultDiv.style.display = 'block';
        });
    });


});
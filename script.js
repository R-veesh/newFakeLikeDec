function analyzeNames() {
    const names = document.getElementById('nameList').value.trim().split('\n');
    
    if (names.length === 0) {
        alert('Please paste some names!');
        return;
    }

    fetch('analyze.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ names: names })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('result').innerHTML = `
            <h3>Results</h3>
            <p>Total Likes: ${data.total}</p>
            <p>Fake Likes: ${data.real}</p>
            <p>Real Likes: ${data.fake}</p>
            <h4>Real Names Detected:</h4>
            <ul>${data.fakeNames.map(name => `<li>${name}</li>`).join('')}</ul>
        `;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.getElementById('issue').addEventListener('change', function() {
    const solution = this.selectedOptions[0].getAttribute('data-solution');
    if (solution) {
        document.getElementById('solution-text').textContent = solution;
        document.getElementById('solution').style.display = 'block';
    } else {
        document.getElementById('solution').style.display = 'none';
    }
});

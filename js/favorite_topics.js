document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function() {
        const genreId = this.getAttribute('data-genre-id');
        const userId = this.getAttribute('data-user-id'); // Получаем user_id из атрибута

        fetch('add_to_favorites.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ genre_id: genreId, user_id: userId })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert(data);
        })
        .catch(error => console.log('Error:', error));
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    // Запрос на получение избранных жанров
    fetch('/php/get_favorite_topic.php')
    .then(response => response.json())
    .then(favoriteGenres => {
        favoriteButtons.forEach(button => {
            const genreId = button.getAttribute('data-genre-id');

            // Если жанр в избранном, меняем иконку на заполненное сердце
            if (favoriteGenres.includes(parseInt(genreId))) {
                button.querySelector('i').classList.remove('fa-regular');
                button.querySelector('i').classList.add('fa-solid');
            }
        });
    })
    .catch(error => console.log('Ошибка:', error));

    // Обработчик нажатия на кнопку добавления/удаления из избранного
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const genreId = this.getAttribute('data-genre-id');
            const userId = this.getAttribute('data-user-id');

            // Отправляем запрос на сервер для добавления или удаления из избранного
            fetch('/php/add_favorite_topic.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `genre_id=${genreId}&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Обновление UI после добавления или удаления из избранного
                    const icon = this.querySelector('i');
                    if (data.message === 'Жанр добавлен в избранное') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else if (data.message === 'Жанр удален из избранного') {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.log('Ошибка:', error));
        });
    });
});

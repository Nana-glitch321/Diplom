document.addEventListener('DOMContentLoaded', function() {
    // Загружаем любимые жанры из базы данных
    fetch('../php/favorite_genres.php')
        .then(response => response.json())
        .then(genres => {
            const favoritesContainer = document.querySelector('.favorite-genres');
            
            if (genres.length === 0) {
                favoritesContainer.innerHTML = '<p>Нет любимых жанров</p>';
                return;
            }

            genres.forEach(genre => {
                const genreItem = document.createElement('div');
                genreItem.classList.add('genre-item');
                
                // Создаем элемент с иконкой жанра
                const genreIcon = document.createElement('img');
                genreIcon.src = genre.image_url ? '../picture/' + genre.image_url : 'default_icon.png'; // Укажите путь к изображению
                genreIcon.alt = genre.name;
                genreIcon.classList.add('genre-icon');
                
                // Название жанра
                const genreName = document.createElement('span');
                genreName.classList.add('genre-name');
                genreName.textContent = genre.name;

                genreItem.appendChild(genreIcon);
                genreItem.appendChild(genreName);

                // Добавляем жанр в контейнер
                favoritesContainer.appendChild(genreItem);
            });
        })
        .catch(error => console.log('Ошибка при загрузке любимых жанров:', error));
});

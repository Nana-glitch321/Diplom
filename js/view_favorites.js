document.addEventListener('DOMContentLoaded', function() {
    if (!document.querySelector('.player-container')) {
        // Если нет, загружаем необходимые файлы для плеера
        loadAudioPlayerFiles();
    }
    loadFavorites(); // Загружаем избранные подкасты при загрузке страницы
});
function loadAudioPlayerFiles() {
    // Загружаем HTML, CSS и JavaScript для плеера через PHP
    fetch('/php/page_templates/audio_player.php')  // Путь к вашему PHP файлу
        .then(response => response.text())
        .then(html => {
            // Вставляем HTML в body
            const div = document.createElement('div');
            div.innerHTML = html;
            document.body.appendChild(div); // Добавляем HTML в body
        })
        .catch(error => console.error('Ошибка загрузки PHP для плеера:', error));
}

// Функция для загрузки избранных подкастов
function loadFavorites() {
    fetch('/php/get_favorites.php')  // Укажите правильный путь к вашему PHP файлу
        .then(response => {
            // Проверяем, что ответ от сервера — это JSON
            if (!response.ok) {
                throw new Error('Ошибка сервера: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const podcastsContainer = document.querySelector('.favorites');  // Контейнер для вывода подкастов
            podcastsContainer.innerHTML = '';  // Очищаем контейнер перед добавлением новых элементов
            console.log(data);
            data.podcasts.forEach(podcast => {
                const podcastCard = document.createElement('div');
                podcastCard.classList.add('favorite-podcast-card');

                // Создаем элемент для изображения
                const img = document.createElement('img');
                img.classList.add('cover');
                img.src = 'data:' + podcast.image_type + ';base64,' + podcast.image_data;  // Отображаем изображение с base64
                img.alt = 'Podcast Cover';

                // Создаем элемент для названия
                const title = document.createElement('div');
                title.classList.add('favorite-podcast-title');
                title.textContent = podcast.title;

                // Добавляем элементы на страницу
                podcastCard.appendChild(img);
                podcastCard.appendChild(title);
                podcastsContainer.appendChild(podcastCard);

                // Обработчик клика на карточку подкаста
                podcastCard.addEventListener('click', function() {
                    const player = document.querySelector('.player-container');
                    const audioPlayer = player.querySelector('#audio-player');  // Найти конкретный элемент audio внутри плеера
                    const coverImage = player.querySelector('.cover');  // Найти изображение внутри плеера
                    const titleElement = player.querySelector('.title');  // Найти название внутри плеера
                    const authorElement = player.querySelector(".author");

                    // Изменяем данные плеера
                    coverImage.src = 'data:' + podcast.image_type + ';base64,' + podcast.image_data;
                    audioPlayer.src = '../php/get_podcast_file.php?id=' + podcast.id + '&type=audio';
                    titleElement.textContent = podcast.title;
                    authorElement.textContent = podcast.author;

                    // Показываем плеер
                    player.classList.add('show');
                });
            });
        })
        .catch(error => {
            // Выводим ошибку в консоль
            console.error('Ошибка при загрузке подкастов:', error);
        });
}

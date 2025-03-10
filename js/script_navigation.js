document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll("nav a"); // Ссылки в меню
    const contentContainer = document.getElementById("page-content"); // Контейнер для загрузки контента

    // Загружаем стили и скрипты при первой загрузке страницы
    updateScriptsAndStyles(window.location.pathname);

    // Обработчик кликов по ссылкам
    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // Останавливаем стандартное поведение (перезагрузку страницы)

            const url = this.getAttribute("href"); // Получаем URL для загрузки
            loadContent(url); // Загружаем контент через AJAX
        });
    });

    // Обработчик для кнопки "Назад"
    window.addEventListener("popstate", function () {
        loadContent(window.location.pathname);
    });
});

// Функция загрузки контента
function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Обновляем основной контент
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const newContent = doc.querySelector("#page-content");

            if (newContent) {
                document.getElementById("page-content").innerHTML = newContent.innerHTML;

                // Вызов функции инициализации после загрузки контента
                initializePageScripts(url);
            }

            // Обновление стилей и скриптов для нового контента
            updateScriptsAndStyles(url);

            // Меняем заголовок страницы
            document.title = doc.title;

            // Меняем URL в браузере
            window.history.pushState({ path: url }, "", url);
        })
        .catch(error => {
            console.error("Ошибка при загрузке:", error);
        });
}

// Функция для инициализации скриптов на загруженной странице
function initializePageScripts(url) {
    if (url.includes('/account') || url.includes('index_account.php')) {
        // Инициализация скрипта для отображения избранных подкастов
        loadFavorites();
    }
    // Добавьте другие условия для других страниц, если необходимо
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

function insertScript(scriptSrc) {
    const scriptElement = document.createElement("script");
    scriptElement.src = scriptSrc;  // Используем атрибут src для загрузки скрипта
    scriptElement.setAttribute("data-dynamic", "true");
    document.body.appendChild(scriptElement);
}

function updateScriptsAndStyles(url) {
    document.querySelectorAll('script[data-dynamic="true"], link[data-dynamic="true"]').forEach(el => el.remove());

    let styles = [];
    let scripts = [];

    // Добавляем скрипты для ionicons, только если они еще не добавлены
    if (!document.querySelector('script[src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"]')) {
        addIoniconsScripts();
    }

    if (url.includes('/account') || url.includes('index_account.php')) {
        styles = [
            '/css/style_account.css',
            '/css/page_template_styles/style_header.css',
            '/css/page_template_styles/style_auth.css'
        ];
        scripts = [
            '/js/add_favorites.js',
            '/js/script_navigation.js',
            '/js/upload_avatar.js',
        ];
    } else if (url.includes('/theme') || url.includes('index_theme.php')) {
        styles = [
            '/css/style_theme.css',
            '/css/page_template_styles/style_header.css',
            '/css/page_template_styles/style_auth.css'
        ];
        scripts = [
            '/js/script_navigation.js',
        ];
    } else if (url.includes('/channels') || url.includes('index_channel.php')) {
        styles = [
            '/css/style_channel.css',
            '/css/page_template_styles/style_header.css',
            '/css/page_template_styles/style_auth.css'
        ];
        scripts = [
        ];
    } else if (url.includes('/popular') || url.includes('index_pop.php')) {
        styles = [
            '/css/style_pop.css',
            '/css/page_template_styles/style_header.css',
            '/css/page_template_styles/style_auth.css'
        ];
        scripts = [
            '/js/add_favorites.js',
            '/js/script_navigation.js',
        ];
    } else {
        styles = [
            '/css/style_glav.css',
            '/css/page_template_styles/style_header.css',
            '/css/page_template_styles/style_auth.css'
        ];
        scripts = [
            '/js/script_navigation.js'
        ];
    }

    styles.forEach(style => {
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = style;
        link.setAttribute("data-dynamic", "true");
        document.head.appendChild(link);
    });

    scripts.forEach(script => {
        insertScript(script); // Теперь используем insertScript для добавления скриптов
    });
}

// Функция для добавления скриптов ionicons
function addIoniconsScripts() {
    const ioniconsModuleScript = document.createElement("script");
    ioniconsModuleScript.type = "module";
    ioniconsModuleScript.src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js";
    ioniconsModuleScript.setAttribute("data-dynamic", "true");
    document.body.appendChild(ioniconsModuleScript);

    const ioniconsNomoduleScript = document.createElement("script");
    ioniconsNomoduleScript.nomodule = true;
    ioniconsNomoduleScript.src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js";
    ioniconsNomoduleScript.setAttribute("data-dynamic", "true");
    document.body.appendChild(ioniconsNomoduleScript);
}

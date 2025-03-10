document.addEventListener("DOMContentLoaded", () => {
    const audioPlayer = document.getElementById("audio-player");
    const playPauseBtn = document.getElementById("playPause");
    const progressBar = document.getElementById("progress-bar");
    const currentTimeElem = document.getElementById("current-time");
    const durationElem = document.getElementById("duration");
    const podcastCover = document.getElementById("podcast-cover");
    const podcastTitle = document.getElementById("podcast-title");
    const authorElem = document.getElementById("author");

    let isSeeking = false;

    // 🟢 Загружаем сохраненное состояние
    function loadSavedState() {
        const savedPodcast = localStorage.getItem("currentPodcast");
        if (savedPodcast) {
            const { src, currentTime, isPlaying, cover, title, author } = JSON.parse(savedPodcast);

            audioPlayer.src = src;
            audioPlayer.currentTime = currentTime || 0;
            podcastCover.src = cover || "";
            podcastTitle.textContent = title || "Название подкаста";
            authorElem.textContent = author || "Автор";

            if (isPlaying) {
                audioPlayer.play();
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
            }
        }
    }

    loadSavedState();

    // 🟢 Сохраняем состояние плеера
    function saveState() {
        localStorage.setItem(
            "currentPodcast",
            JSON.stringify({
                src: audioPlayer.src,
                currentTime: audioPlayer.currentTime,
                isPlaying: !audioPlayer.paused,
                cover: podcastCover.src,
                title: podcastTitle.textContent,
                author: authorElem.textContent,
            })
        );
    }

    // Обновляем состояние при проигрывании
    audioPlayer.addEventListener("timeupdate", () => {
        if (!isSeeking) {
            progressBar.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            currentTimeElem.textContent = formatTime(audioPlayer.currentTime);
            durationElem.textContent = formatTime(audioPlayer.duration);
            saveState();
        }
    });

    // Переключение воспроизведения
    playPauseBtn.addEventListener("click", () => {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        } else {
            audioPlayer.pause();
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        }
        saveState();
    });

    // Обработчик изменения ползунка
    progressBar.addEventListener("input", () => {
        isSeeking = true;
        audioPlayer.currentTime = (progressBar.value / 100) * audioPlayer.duration;
        currentTimeElem.textContent = formatTime(audioPlayer.currentTime);
    });

    progressBar.addEventListener("mouseup", () => {
        isSeeking = false;
        saveState();
    });

    // Функция форматирования времени
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
    }

    document.querySelectorAll(".play-podcast").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const src = btn.getAttribute("data-src");
            const title = btn.getAttribute("data-title");
            const author = btn.getAttribute("data-author");
            const cover = btn.getAttribute("data-cover");
    
            audioPlayer.src = src;
            audioPlayer.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    
            podcastCover.src = cover;
            podcastTitle.textContent = title;
            authorElem.textContent = author;
    
            saveState();
        });
    });

    // Логгирование на случай проблем с кнопкой playPause
    if (playPauseBtn) {
        console.log('Кнопка Play/Pause найдена');
    } else {
        console.log('Кнопка Play/Pause не найдена');
    }

    // Прочие обработчики событий на ссылках
    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", (e) => {
            // Проверяем, чтобы это не была ссылка на внешний ресурс
            if (link.hostname === window.location.hostname) {
                e.preventDefault();
                fetch(link.href)
                    .then((response) => response.text())
                    .then((html) => {
                        document.getElementById("page-content").innerHTML = html; // Загружаем новую страницу в #content
                        window.history.pushState({}, "", link.href); // Меняем URL
                    })
                    .catch((error) => console.error("Ошибка загрузки страницы:", error));
            }
        });
    });
});

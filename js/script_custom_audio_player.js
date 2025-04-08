document.addEventListener("DOMContentLoaded", () => {
    const players = document.querySelectorAll(".player-card"); 
    let currentAudio = null; 

    players.forEach(player => {
        const audioPlayer = player.querySelector("audio");
        const playPauseBtn = player.querySelector(".play-pause");
        const progressBar = player.querySelector(".progress-bar");
        const currentTimeElem = player.querySelector(".current-time");
        const durationElem = player.querySelector(".duration");

        let isSeeking = false;

        // Принудительно обновляем аудиофайл, добавляя уникальный параметр
        const src = audioPlayer.getAttribute("src");
        if (src) {
            audioPlayer.setAttribute("src", src + (src.includes("?") ? "&" : "?") + "t=" + new Date().getTime());
            audioPlayer.load(); // Перезагружаем аудиофайл
        }

        // Загружаем метаданные, чтобы сразу показать длительность трека
        audioPlayer.addEventListener("loadedmetadata", () => {
            durationElem.textContent = formatTime(audioPlayer.duration);
        });

        // Обновляем состояние при проигрывании
        audioPlayer.addEventListener("timeupdate", () => {
            if (!isSeeking) {
                progressBar.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
                currentTimeElem.textContent = formatTime(audioPlayer.currentTime);
            }
        });

        // Переключение воспроизведения
        playPauseBtn.addEventListener("click", () => {
            if (audioPlayer.paused) {
                if (currentAudio && currentAudio !== audioPlayer) {
                    currentAudio.pause();
                    const prevBtn = document.querySelector(".player-card .play-pause.active");
                    if (prevBtn) {
                        prevBtn.innerHTML = '<i class="fas fa-play"></i>';
                        prevBtn.classList.remove("active");
                    }
                }

                audioPlayer.play();
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                playPauseBtn.classList.add("active");

                currentAudio = audioPlayer;
            } else {
                audioPlayer.pause();
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                playPauseBtn.classList.remove("active");
            }
        });

        // Обработчик изменения ползунка
        progressBar.addEventListener("input", () => {
            isSeeking = true;
            audioPlayer.currentTime = (progressBar.value / 100) * audioPlayer.duration;
            currentTimeElem.textContent = formatTime(audioPlayer.currentTime);
        });

        progressBar.addEventListener("mouseup", () => {
            isSeeking = false;
        });

        // Остановка при окончании трека
        audioPlayer.addEventListener("ended", () => {
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
            playPauseBtn.classList.remove("active");
            progressBar.value = 0;
            currentTimeElem.textContent = "00:00";
        });

        // Функция форматирования времени
        function formatTime(seconds) {
            if (isNaN(seconds) || seconds < 0) return "00:00";
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const remainingSeconds = Math.floor(seconds % 60);

            return `${hours > 0 ? hours.toString().padStart(2, "0") + ":" : ""}${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
        }
    });
});

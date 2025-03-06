document.addEventListener("DOMContentLoaded", () => {
    const audioPlayer = document.getElementById("custom-audio-player");
    const playPauseBtn = document.getElementById("custopPlayPause");
    const progressBar = document.getElementById("custom-progress-bar");
    const currentTimeElem = document.getElementById("custom-current-time");
    const durationElem = document.getElementById("custom-duration");

    let isSeeking = false;

    // Обновляем состояние при проигрывании
    audioPlayer.addEventListener("timeupdate", () => {
        if (!isSeeking) {
            progressBar.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            currentTimeElem.textContent = formatTime(audioPlayer.currentTime);
            durationElem.textContent = formatTime(audioPlayer.duration);
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

    // Функция форматирования времени
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
    }
});

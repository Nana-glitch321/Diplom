// Получаем элементы плеера
const audioPlayer = document.getElementById("audio-player");
const playPauseBtn = document.getElementById("playPause");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
const progressBar = document.getElementById("progress-bar");
const currentTimeElem = document.getElementById("current-time");
const durationElem = document.getElementById("duration");

// Переменная для отслеживания состояния ползунка
let isSeeking = false;

// Функция для обновления времени на плеере
function updateProgress() {
    if (!isSeeking) { // Проверка, чтобы избежать обновления при изменении слайдера
        const currentTime = audioPlayer.currentTime;
        const duration = audioPlayer.duration;

        // Обновляем прогресс-бар
        progressBar.value = (currentTime / duration) * 100;

        // Обновляем время
        currentTimeElem.textContent = formatTime(currentTime);
        durationElem.textContent = formatTime(duration);
    }
}

// Форматируем время в минутах и секундах
function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = Math.floor(seconds % 60);

    if (hours > 0) {
        return `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
    } else {
        return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
    }
}


// Функция для переключения воспроизведения
function togglePlayPause() {
    if (audioPlayer.paused) {
        audioPlayer.play();
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    } else {
        audioPlayer.pause();
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    }
}

// Переключение на предыдущий трек
function prevTrack() {
    // Логика для переключения на предыдущий трек
}

// Переключение на следующий трек
function nextTrack() {
    // Логика для переключения на следующий трек
}

// Обработчики событий
audioPlayer.addEventListener("timeupdate", updateProgress);

progressBar.addEventListener("input", () => {
    // Когда ползунок изменяется, обновляем текущую позицию аудио
    const newTime = (progressBar.value / 100) * audioPlayer.duration;
    audioPlayer.currentTime = newTime;
    console.log(newTime);
    currentTimeElem.textContent = formatTime(newTime);  // Обновляем таймер при изменении ползунка
});

// Дополнительный обработчик для начала изменения слайдера
progressBar.addEventListener("mousedown", () => {
    isSeeking = true;
    audioPlayer.pause(); // Останавливаем воспроизведение, когда пользователь взаимодействует с ползунком
    playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';

});

// Дополнительный обработчик для окончания изменения слайдера
progressBar.addEventListener("mouseup", () => {
    isSeeking = false;
    audioPlayer.play(); // Возобновляем воспроизведение после изменения ползунка
    playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
});

// Обработчики для кнопок
playPauseBtn.addEventListener("click", togglePlayPause);
prevBtn.addEventListener("click", prevTrack);
nextBtn.addEventListener("click", nextTrack);

// Инициализация времени на плеере
audioPlayer.addEventListener("loadedmetadata", () => {
    durationElem.textContent = formatTime(audioPlayer.duration);
    progressBar.value = 0; // Устанавливаем начальное значение ползунка
});
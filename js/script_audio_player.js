const audioPlayer = document.getElementById("audio-player");
const playPauseBtn = document.getElementById("playPause");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
const progressBar = document.getElementById("progress-bar");
const currentTimeElem = document.getElementById("current-time");
const durationElem = document.getElementById("duration");
const volumeBar = document.getElementById("volume-bar");
let isSeeking = false;

function updateProgress() {
    if (!isSeeking) {
        const currentTime = audioPlayer.currentTime;
        const duration = audioPlayer.duration;
        progressBar.value = (currentTime / duration) * 100;
        currentTimeElem.textContent = formatTime(currentTime);
        durationElem.textContent = formatTime(duration);
    }
}

function formatTime(seconds) {
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
}

function togglePlayPause() {
    if (audioPlayer.paused) {
        audioPlayer.play();
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    } else {
        audioPlayer.pause();
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    }
}

audioPlayer.addEventListener("timeupdate", updateProgress);

progressBar.addEventListener("input", () => {
    const newTime = (progressBar.value / 100) * audioPlayer.duration;
    audioPlayer.currentTime = newTime;
    currentTimeElem.textContent = formatTime(newTime);
});

progressBar.addEventListener("mousedown", () => {
    isSeeking = true;
    audioPlayer.pause();
    playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
});

progressBar.addEventListener("mouseup", () => {
    isSeeking = false;
    audioPlayer.play();
    playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
});

playPauseBtn.addEventListener("click", togglePlayPause);

// Управление громкостью
volumeBar.addEventListener("input", () => {
    audioPlayer.volume = volumeBar.value;
});

audioPlayer.addEventListener("loadedmetadata", () => {
    durationElem.textContent = formatTime(audioPlayer.duration);
    progressBar.value = 0;
    audioPlayer.volume = volumeBar.value;
});

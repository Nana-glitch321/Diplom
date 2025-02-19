// Пример управления состоянием плеера
const playerCard = document.querySelector('.player-card');
const playPauseBtn = document.querySelector('.play-pause');
const cover = document.querySelector('.cover');

playPauseBtn.addEventListener('click', () => {
    playerCard.classList.toggle('playing');
    
    const isPlaying = playerCard.classList.contains('playing');
    playPauseBtn.innerHTML = isPlaying 
        ? '<i class="fas fa-pause"></i>' 
        : '<i class="fas fa-play"></i>';
});

// Пример смены обложки
// cover.src = 'new-cover-image.jpg';
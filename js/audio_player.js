// Speed control
const speedControl = document.getElementById('speed-control');
const speedMenu = document.querySelector('.speed-menu');
const speedOptions = document.querySelectorAll('.speed-option');
const audioPlayer = document.getElementById('audio-player');

// Toggle speed menu
speedControl.addEventListener('click', (e) => {
    e.stopPropagation();
    speedMenu.classList.toggle('show');
});

// Close menu on click outside
document.addEventListener('click', (e) => {
    if (!speedControl.contains(e.target)) {
        speedMenu.classList.remove('show');
    }
});


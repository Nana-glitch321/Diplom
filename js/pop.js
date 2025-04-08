document.addEventListener("DOMContentLoaded", function () {
    // Получаем все карточки плееров
    const players = document.querySelectorAll(".player-card");

    players.forEach(playerCard => {
        const speedControlBtn = playerCard.querySelector(".control-btn#speed-control");
        const speedMenu = playerCard.querySelector(".speed-menu");
        const audioPlayer = playerCard.querySelector("#audio-player");
        const speedValue = playerCard.querySelector("#speed-value");

        if (speedControlBtn && speedMenu && audioPlayer && speedValue) {
            // Обработчик для выбора скорости
            speedMenu.querySelectorAll(".speed-option").forEach(option => {
                option.addEventListener("click", function () {
                    const speed = parseFloat(option.getAttribute("data-speed"));
                    audioPlayer.playbackRate = speed;
                    speedValue.innerText = speed + "x";
                    speedMenu.classList.remove("active"); // Закрываем меню
                });
            });

            // Открытие/закрытие меню скорости
            speedControlBtn.addEventListener("click", function (event) {
                event.stopPropagation();
                
                // Закрываем все открытые меню перед открытием нужного
                document.querySelectorAll(".speed-menu").forEach(menu => {
                    if (menu !== speedMenu) menu.classList.remove("active");
                });

                speedMenu.classList.toggle("active");
            });
        }
    });

    // Закрытие всех меню при клике вне
    document.addEventListener("click", function (event) {
        document.querySelectorAll(".speed-menu").forEach(menu => {
            if (!menu.contains(event.target)) {
                menu.classList.remove("active");
            }
        });
    });
});

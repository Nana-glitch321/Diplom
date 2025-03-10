<body>
    <div class="custom-player-card">
        <div class="custom-cover-container">
            <img src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=image" alt="Podcast Cover" class="custom-cover">
        </div>
        <div class="custom-info-container">
            <div class="custom-title"><?php echo htmlspecialchars($podcast['title']); ?></div>
            <div class="custom-controls">
                <button class="custom-control-btn" id="prev">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="custom-control-btn custom-play-pause" id="custopPlayPause">
                    <i class="fas fa-play"></i>
                </button>
                <button class="custom-control-btn" id="next">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>
            <audio id="custom-audio-player" src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=audio" preload="metadata"></audio>
            <input type="range" class="custom-progress-bar" id="custom-progress-bar" value="0" max="100" step="1">
            <div class="custom-progress-time">
                <span class="custom-current-time" id="custom-current-time">00:00</span> / <span class="custom-duration" id="custom-duration">00:00</span>
            </div>
        </div>
        <button class="custom-add-to-wishlist" data-podcast-id="<?php echo $podcast['id']; ?>" onclick="addToFavorites(this)">
            <i class="far fa-heart"></i>
        </button>
    </div>
    <script src="/js/script_custom_audio_player.js"></script>
</body>
<body>
    <div class="player-card">
        <div class="cover-container">
            <img src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=image" alt="Podcast Cover" class="cover">
        </div>
        <div class="info-container">
            <div class="title"><?php echo htmlspecialchars($podcast['title']); ?></div>
            <div class="controls">
                <button class="control-btn" id="prev">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="control-btn play-pause" id="playPause">
                    <i class="fas fa-play"></i>
                </button>
                <button class="control-btn" id="next">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>
            <audio id="audio-player" src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=audio" preload="metadata"></audio>
            <input type="range" class="progress-bar" id="progress-bar" value="0" max="100" step="1">
            <div class="progress-time">
                <span class="current-time" id="current-time">00:00</span> / <span class="duration" id="duration">00:00</span>
            </div>
        </div>
        <button class="add-to-wishlist" data-podcast-id="<?php echo $podcast['id']; ?>" onclick="addToFavorites(this)">
            <i class="far fa-heart"></i>
        </button>
    </div>
    <script src="../js/script_audio_player.js"></script>
</body>

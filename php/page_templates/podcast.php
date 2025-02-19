<div class="podcast-item" style="display: flex; align-items: center; justify-content: space-between;">
    <img src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=image" alt="Подкаст" style="width: 50px; height: 50px; margin-right: 10px;">
    <div style="flex-grow: 1;">
        <audio controls>
            <source src="../php/get_podcast_file.php?id=<?php echo $podcast['id']; ?>&type=audio" type="audio/mpeg">
            Ваш браузер не поддерживает аудиоплеер.
        </audio>
    </div>
    <button onclick="addToFavorites(<?php echo $podcast['id']; ?>)" style="background-color: #ffcc00; border: none; padding: 10px; cursor: pointer;">
        Добавить в избранное
    </button>
</div>

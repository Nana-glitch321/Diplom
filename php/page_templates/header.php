<header>
    <div class="header-left">
        <h2 class="logo">
            <img src="../picture/logo.png" alt="Логотип PodcasterPro">
        </h2>
    </div>
    <nav class="header-right navigation" role="navigation" aria-label="Основная навигация">
        <a href="/" data-page="home">Главная</a>
        <a href="/theme" data-page="theme">Темы</a>
        <a href="/channels" data-page="channels">Каналы</a>
        <a href="/popular" data-page="popular">Популярное</a>
        
        <?php if ($user_name): ?>
            <a href="/account" class="btnAccount" id="userGreeting" data-page="account">
                Привет, <?php echo htmlspecialchars($user_name); ?>
            </a>
        <?php else: ?>
            <button class="btnLogin-popup">Войти</button>
        <?php endif; ?>

    </nav>
</header>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/php/page_templates/auth.php'; ?>

<script>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/js/script_login_register.js'; ?>
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/php/page_templates/audio_player.php'; ?>


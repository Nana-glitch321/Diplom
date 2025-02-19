<header>
    <div class="header-left">
        <h2 class="logo">
            <img src="../picture/logo.png" alt="Логотип PodcasterPro">
        </h2>
    </div>
    <nav class="header-right navigation" role="navigation" aria-label="Основная навигация">
        <a href="/">Главная</a>
        <a href="/theme">Темы</a>
        <a href="/channels">Каналы</a>
        <a href="/popular">Популярное</a>
        <?php if ($user_name): ?>
            <button class="btnLogin-popup" id="userGreeting">
                Привет, <?php echo htmlspecialchars($user_name); ?>
            </button>
        <?php else: ?>
            <button class="btnLogin-popup">Войти</button>
        <?php endif; ?>

    </nav>
</header>

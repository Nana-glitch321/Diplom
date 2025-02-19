<div class="overlay"></div> 
<section class="auth-section">
    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close-outline"></ion-icon></span>

        <div class="form-box login" aria-labelledby="loginTitle">
            <h2 id="loginTitle">Вход</h2>
            <form id="loginForm" autocomplete="on">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="text" id="loginEmail" name="email" required>
                    <label>Эл. почта</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" id="loginPassword" name="password" required>
                    <label>Пароль</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Запомнить меня</label>
                    <a href="#" class="forgotPassword">Забыли пароль?</a>
                </div>
                <button type="submit" class="btn">Войти</button>
                <div class="login-register">
                    <p>Нет аккаунта? <a href="#" class="register-link">Зарегистрироваться</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Регистрация</h2>
            <form id="registerForm" autocomplete="on">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" id="registerName" name="name" required>
                    <label>Имя</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="text" id="registerEmail" name="email" required>
                    <label>Эл. почта</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" id="registerPassword" name="password" required>
                    <label>Пароль</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Соглашаюсь с правилами сайта</label>
                </div>
                <button type="submit" class="btn">Зарегистрироваться</button>
                <div class="login-register">
                    <p><a href="#" class="login-link">Уже есть аккаунт?</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

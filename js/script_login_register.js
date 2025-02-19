document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector(".wrapper");
    const loginPopup = document.querySelector(".btnLogin-popup");
    const iconClose = document.querySelector(".icon-close");

    const loginBox = document.querySelector(".form-box.login");
    const registerBox = document.querySelector(".form-box.register");

    const loginLink = document.querySelector(".login-link");
    const registerLink = document.querySelector(".register-link");

    const loginForm = document.querySelector("#loginForm");
    const registerForm = document.querySelector("#registerForm");

    const overlay = document.querySelector(".overlay")

    if (!wrapper || !loginPopup || !loginBox || !registerBox || !loginForm || !registerForm) {
        return;
    }

    // Открытие окна (по умолчанию открывает форму входа)
    loginPopup.addEventListener("click", () => {
        if (wrapper.classList.contains("active-popup")) {
            wrapper.classList.remove("active-popup");
            overlay.classList.remove("active");
        } else {
            wrapper.classList.add("active-popup");
            loginBox.style.display = "block";
            registerBox.style.display = "none";
            overlay.classList.add("active");
        }
    });

    // Закрытие окна
    if (iconClose) {
        iconClose.addEventListener("click", function () {
            wrapper.classList.remove("active-popup");
            overlay.classList.remove("active");
        });
    }

    // Переключение на вход
    if (loginLink) {
        loginLink.addEventListener("click", function (event) {
            event.preventDefault();
            loginBox.style.display = "block";
            registerBox.style.display = "none";
        });
    }

    // Переключение на регистрацию
    if (registerLink) {
        registerLink.addEventListener("click", function (event) {
            event.preventDefault();
            loginBox.style.display = "none";
            registerBox.style.display = "block";
        });
    }

    // Проверка авторизации
    fetch("../../php/session_status.php")
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                let newButton = document.createElement("button");
                newButton.textContent = `Привет, ${data.user_name}`;
                newButton.classList.add("btnLogin-popup");
                newButton.setAttribute("aria-haspopup", "true");
                newButton.setAttribute("aria-expanded", "false");

                newButton.addEventListener("click", function () {
                    if (wrapper.classList.contains("active-popup")) {
                        wrapper.classList.remove("active-popup");
                        overlay.classList.remove("active");
                    } else {
                        window.location.href = "php/index_account.php";
                    }
                });

                loginPopup.replaceWith(newButton);
            }
        })
        .catch(error => console.error("Ошибка загрузки сессии:", error));


    // Вход пользователя
    function handleLogin(event) {
        event.preventDefault();
        let formData = new FormData(loginForm);
        fetch("php/login.php", { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "php/index_account.php"; // перенаправление на страницу аккаунта
                } else {
                    alert(data.message);
                }
            })
            .catch(error => log.error("Ошибка входа:", error));
    }
   
    // Регистрация пользователя
    function handleRegister(event) {
        event.preventDefault();
        let formData = new FormData(registerForm);
        fetch("php/register.php", { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Регистрация успешна! Теперь войдите.");
                } else {
                    alert(data.message);
                }
            })
            .catch(error => log.error("Ошибка регистрации:", error));
    }

    // Добавляем обработчики один раз
    if (loginForm && !loginForm.dataset.listenerAdded) {
        loginForm.addEventListener("submit", handleLogin);
        loginForm.dataset.listenerAdded = "true";
    }

    if (registerForm && !registerForm.dataset.listenerAdded) {
        registerForm.addEventListener("submit", handleRegister);
        registerForm.dataset.listenerAdded = "true";
    }
});

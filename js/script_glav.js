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

    if (!wrapper || !loginPopup || !loginBox || !registerBox || !loginForm || !registerForm) {
        console.error("Не найдены элементы формы. Проверь HTML.");
        return;
    }

    // Открытие окна (по умолчанию открывает форму входа)
    loginPopup.addEventListener("click", () => {
        wrapper.classList.add("active-popup");
        loginBox.style.display = "block";
        registerBox.style.display = "none";
    });

    // Закрытие окна
    if (iconClose) {
        iconClose.addEventListener("click", function () {
            wrapper.classList.remove("active-popup");
        });
    }

    // Переключение на вход
    if (loginLink) {
        loginLink.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("Переключение на вход");
            loginBox.style.display = "block";
            registerBox.style.display = "none";
        });
    }

    // Переключение на регистрацию
    if (registerLink) {
        registerLink.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("Переключение на регистрацию");
            loginBox.style.display = "none";
            registerBox.style.display = "block";
        });
    }

    // Проверка авторизации
    fetch("php/session_status.php")
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                let newButton = document.createElement("button");
                newButton.textContent = `Привет, ${data.user_name}`;
                newButton.classList.add("btnLogin-popup");
                newButton.setAttribute("aria-haspopup", "true");
                newButton.setAttribute("aria-expanded", "false");

                newButton.addEventListener("click", function () {
                    window.location.href = "php/logout.php";
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
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Ошибка входа:", error));
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
            .catch(error => console.error("Ошибка регистрации:", error));
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

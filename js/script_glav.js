// Получаем элементы
const wrapper = document.querySelector(".wrapper");
const loginLink = document.querySelector(".login-link");
const registerLink = document.querySelector(".register-link");
const btnPopup = document.querySelector(".btnLogin-popup");
const closeIcon = document.querySelector(".icon-close");

// Обработчики для переключения между формами
registerLink.addEventListener("click", () => {
    wrapper.classList.add("active");
});

loginLink.addEventListener("click", () => {
    wrapper.classList.remove("active");
});

btnPopup.addEventListener("click", () => {
    wrapper.classList.add("active-popup");
});

closeIcon.addEventListener("click", () => {
    wrapper.classList.remove("active-popup");
    wrapper.classList.remove("active");
});

// Регистрация пользователя
const registerForm = document.getElementById("registerForm");
registerForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Получаем данные регистрации
    const name = document.getElementById("registerName").value;
    const email = document.getElementById("registerEmail").value;
    const password = document.getElementById("registerPassword").value;

    // Сохраняем данные в LocalStorage
    localStorage.setItem("userEmail", email);
    localStorage.setItem("userPassword", password);

    alert("Регистрация успешна!");

    // Переключаемся на форму входа
    wrapper.classList.remove("active");
});

// Вход пользователя
const loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Получаем данные для входа
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    // Проверяем данные
    const storedEmail = localStorage.getItem("userEmail");
    const storedPassword = localStorage.getItem("userPassword");

    if (email === storedEmail && password === storedPassword) {
        // Если данные верны, перенаправляем на страницу профиля
        window.location.href = "ptofily.html";
    } else {
        alert("Неверная почта или пароль");
    }
});

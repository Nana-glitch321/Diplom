document.addEventListener("DOMContentLoaded", function () {
    const loginPopup = document.querySelector(".btnLogin-popup");

    // Проверка авторизации
    fetch("../php/session_status.php")
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                let newButton = document.createElement("button");
                newButton.textContent = `Привет, ${data.user_name}`;
                newButton.classList.add("btnLogin-popup");
                newButton.setAttribute("aria-haspopup", "true");
                newButton.setAttribute("aria-expanded", "false");

                newButton.addEventListener("click", function () {
                    window.location.href = "../php/index_account.php";
                });

                loginPopup.replaceWith(newButton);
            }
        })
        .catch(error => console.error("Ошибка загрузки сессии:", error));
    });
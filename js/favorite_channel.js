document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-btn").forEach(button => {
        button.addEventListener("click", () => {
            const userCard = button.closest(".user-card");
            const userId = userCard.dataset.id;

            fetch("../php/favorite_channel.php", { // ✅ Правильный путь
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `favorite_user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.textContent = "✅ В избранном";
                    button.disabled = true;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Ошибка:", error));
        });
    });
});
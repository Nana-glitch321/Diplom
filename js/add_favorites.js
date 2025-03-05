function addToFavorites(button) {
    const podcastId = button.getAttribute('data-podcast-id');
    const icon = button.querySelector("i");

    fetch('../php/add_to_favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: podcastId })
    })
    .then(response => response.json())  
    .then(data => {
        console.log("Ответ от сервера:", data);
        if (data.success) {
            const icon = button.querySelector("i");
            if (data.added) {  
                icon.classList.remove("far");
                icon.classList.add("fas");
            } else if (data.removed) {  
                icon.classList.remove("fas");
                icon.classList.add("far");
            }
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => console.error('Ошибка:', error));
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        const podcastId = button.getAttribute('data-podcast-id');
        const icon = button.querySelector("i");
        if (userFavorites[podcastId]) {
            icon.classList.remove("far");
            icon.classList.add("fas");
        } else {
            icon.classList.remove("fas");
            icon.classList.add("far");
        }
        });
});


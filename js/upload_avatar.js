document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0]; // Получаем выбранный файл
    if (file) {
        const reader = new FileReader();

        // После чтения файла
        reader.onload = function(event) {
            const avatarElement = document.querySelector('.avatar'); // Элемент для отображения аватара
            const avatarPlaceholder = document.querySelector('.avatar-placeholder'); // Элемент плейсхолдера

            if (avatarElement && avatarPlaceholder) {
                avatarElement.src = event.target.result; // Устанавливаем новое изображение
                avatarPlaceholder.style.display = 'none'; // Скрываем placeholder
            }

            // Автоматически отправляем форму с аватаром
            const form = document.querySelector('.avatar-upload');
            if (form) {
                const formData = new FormData(form);
                
                // Логируем форму и данные
                console.log('Отправляем данные на сервер:', formData);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Обрабатываем JSON ответ
                .then(data => {
                    console.log('Ответ от сервера:', data); // Логируем ответ от сервера
                    if (data.status === 'success') {
                        // Обновляем изображение с сервера
                        const avatarElement = document.querySelector('.avatar');
                        avatarElement.src = `../uploads/${data.avatar}?v=${new Date().getTime()}`; // Обновляем аватар

                        // Обновление страницы, чтобы отобразить изменения
                        location.reload(); // Перезагружаем страницу
                    } else {
                        alert('Ошибка при загрузке аватара');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Ошибка при загрузке аватара');
                });
            }
        };

        // Чтение файла как DataURL
        reader.readAsDataURL(file);
    }
});
// Скрипт для открытия и закрытия модального окна донатов
var modal = document.getElementById("donateModal");
var btn = document.getElementById("donateButton");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.visibility = "visible";
    modal.style.opacity = "1";
    modal.style.transition = "visibility 0s, opacity 0.3s linear";
}

span.onclick = function() {
    modal.style.visibility = "hidden";
    modal.style.opacity = "0";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.visibility = "hidden";
        modal.style.opacity = "0";
    }
}

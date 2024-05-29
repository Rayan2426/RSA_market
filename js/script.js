
function changePage(root) {
    window.location.replace(root);
}

function show() {
    let viewer = document.getElementById("viewer");
    let filterBox = document.getElementById("filter-box");

    viewer.style.display = "none";
    filterBox.style.display = "block";
}

let isSelected = false;

function showForm() {
    let form = document.getElementById("offer-form");
    let button = document.getElementById("offer-button");

    if (!isSelected) {
        button.innerHTML = "Torna Indietro";
        form.style.display = "block";
        isSelected = true;
    } else {
        button.innerHTML = "Effettua una Proposta";
        form.style.display = "none";
        isSelected = false;
    }
}


function changePage(root) {
    window.location.replace(root);
}

function show() {
    let viewer = document.getElementById("viewer");
    let filterBox = document.getElementById("filter-box");

    viewer.style.display = "none";
    filterBox.style.display = "block";
}


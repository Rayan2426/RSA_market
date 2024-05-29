<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSA Market | annuncio </title>
</head>
<body style="display: flex; align-items: center; justify-content: center;">
    <div class="sale-container">
        <h1> Qui va il nome dell'annuncio </h1>

        <div class="selected-image"></div>

        <div class="images-container">
            <img src="images/logo.jpg">
            <img src="#">
            <img src="#">
        </div>
        
        <p> 'Qui va la descrizione dell'annuncio' </p>
        <div class="user-credential">
            <img src="#" style="height:30px; width: 30px; border-radius: 15px">
            <p> Autore: 'Qui va il nome dell'utente che ha fatto l'annuncio' </p>
        </div>

        <p> Categoria: 'Qui va la categoria dell'annuncio' </p>
        <p> Annuncio pubblicato in data: 'Qui va la data di pubblicazione dell'annuncio' </p>

        <div class="redirect-container">
            <button onclick="showForm()" id="offer-button"> Effettua una proposta </button>
            <button onclick="changePage('index.php')"> Torna alla Homepage </button>
        </div>

        <form action="./offermanager.php" method="post" style="display: none" id="offer-form">
            <input type="number" name="sum" class="input-offer">
            <input type="hidden" name="saleid" value="1">
            <input type="hidden" name="method" value="create">
            <input type="submit" value="Invia Proposta">
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
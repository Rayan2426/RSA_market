<?php
    session_start();
    include_once("connectdb.php");
    include_once("credentialscheck.php");
    $conn = getConn();
    checkSessionCredentials($conn);

    $method = $_POST["method"];

    function error($msg){
        $_SESSION["offer_handler_error"] = $msg;
    }

    switch ($method) {
        case 'create':
            $sum = $_POST["sum"];
            $saleid = $_POST["saleid"];
            $email = $_SESSION["email"];
            $redpage = "./showsale.php?id=$saleid";

            if(!is_numeric($sum) || intval($sum) <= 0){
                redirect($redpage);
            }

            $sql = "SELECT count(*) AS numero FROM Proposte
                    JOIN Annunci ON Annunci.id = Proposte.annuncio_id
                    WHERE Proposte.user_email = '$email' AND Annunci.id = $saleid";

            $hasAlreadyOffered = $conn->query($sql);
            
            if($hasAlreadyOffered->fetch_assoc()["numero"] != "0"){
                error("Hai già fatto una proposta a questo annuncio");
                redirect($redpage);
            } else{
                error("L'annuncio selezionato non esiste");
            }

            $sql = "SELECT stato FROM  Annunci
                    WHERE Annunci.id = '$saleid'";
                
            $result = $conn->query($sql);
            $state = $result->fetch_assoc()["stato"];
            switch ($state) {
                case 'closed':
                    error("Impossibile effettuare la proposta: l'annuncio ha trovato un'acquirente");
                    redirect($redpage);
                    break;
                case 'deleted':
                    error("Impossibile effettuare la proposta: l'annuncio e' stato cancellato");
                    redirect($redpage);
                    break;
            }

            $sql = "INSERT INTO Proposte(valore,annuncio_id,stato,user_email)
                    VALUE($sum,$saleid,'available','$email')";

            $conn->query($sql);

            if($conn->affected_rows > 0){
                error(null);
            } else{
                error("Errore nell'inserimento dell'annuncio nel database");
            }
            redirect($redpage);
            break;
        
        default:
            echo "metodo inesistente";
    }
?>
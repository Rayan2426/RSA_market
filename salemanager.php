<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);

$method = $_POST["method"];

$redpage = "index.php";

switch ($method) {
    case 'create':
        $redpage = "newsale.php";
        $title = $_POST["titolo"];
        $category = $_POST["tipologia"];
        //description is optional
        $desc = isset($_POST["descrizione"]) ?  urlencode($_POST["descrizione"]) : null;
        $images = [$_FILES["foto1"], $_FILES["foto2"], $_FILES["foto3"]];

        //title is obligatory
        if(!isValid($title)){
            $_SESSION["sale_handler_error"] = "il titolo è obbligatorio";
            redirect($redpage);
        }
        //escapes weird characters
        $title = urlencode($title);

        if(preg_match("#[<>\"'%;(){}&./\\ `]#i", $category)){
            $_SESSION["sale_handler_error"] = "la tipologia selezionata non e' valida";
            redirect($redpage);
        }

        $sql = "insert into Annunci(nome,descrizione,tipologia,stato,user_email)
                value('$title','$desc','$category','available','{$_SESSION['email']}')";

        $conn->query($sql);

        if($conn->affected_rows < 0){
            $_SESSION["sale_handler_error"] = "si è verificato un errore durante la creazione dell'annuncio. Ricontrolla tutti i parametri!";
            redirect($redpage);
        }

        $saleid = mysqli_insert_id($conn);

        $imgcount = 0;

        foreach($images as $img){
            $outcome = "";
            //If the image isn't empty or was never uploaded
            if (!($img['error'] == 4 || ($img['size'] == 0 && $img['error'] == 0))) {
                $filepath = $img["tmp_name"];
                $filename = $img["name"];

                //Check if the file is bigger than 5 megabytes
                if ($img['size'] > 5242880) {
                    $outcome .= "Il file inserito non può essere più grande di 5MB <br>";
                    redirect($redpage);
                }

                $target_dir = "uploads/saleimgs";
                $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));


                // Allow certain file formats
                if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $outcome .= "Spiacente, solo le estensioni JPG, JPEG, PNG & GIF sono ammesse. <br>";
                }

                $imgcount++;
                //Sale products images are stored as <id>.image_extension
                $target_file = $target_dir . "/$saleid" . "/$imgcount" . "." . $imageFileType;

                if(!is_dir("uploads/saleimgs/$saleid")){
                    mkdir("uploads/saleimgs/$saleid");
                }
                
                //if there wasnt any previous error and file is successfully saved
                if (empty($outcome) && move_uploaded_file($filepath, $target_file)) {

                    $sql = "insert into Foto(urlImg,annuncio_id)
                            value('$target_file','$saleid')";

                    $conn->query($sql);

                } else {
                    $imgcount--;
                    $outcome .= "Spiacente, c'è stato un errore durante l'inserimento di una foto dell'annuncio";
                }
            }
        }

        if($imgcount == 0){
            $_SESSION["sale_handler_error"] = "deve essere caricata almeno un'immagine<br>
                                                $outcome";
            redirect($redpage); 
        }
        redirect($redpage);
        break;
    case 'delete':
        break;
    default:
        redirect($redpage);
        break;
}

?>

vade retro, non dovresti essere qui...
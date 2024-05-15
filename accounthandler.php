<?php
session_start();

include_once("connectdb.php");

$method = $_POST["method"];

function redirect($page)
{
    header("Location: ./$page");
    exit();
}

if (!isValid($method)) {
    $_SESSION["login_error"] = "Il metodo '$method' selezionato non e' valido!";
    redirect("login.php");
}

include_once ("./connectdb.php");

$conn = getConn();

switch ($method) {
    case 'login':
        $userinfo = $_POST["userinfo"];
        $password = $_POST["password"];
        $errormessage = "L'email o la password sono invalide! Prova di nuovo.";
        
        if (!isValid($userinfo) || !isValid($password)) {
            $_SESSION["login_error"] = $errormessage;
            redirect("login.php");
        }
        
        $sql = "select email,username,nome,cognome,datanascita,password from Users where username = '$userinfo' or email = '$userinfo'";
        $result = $conn->query($sql);
        
        if (mysqli_affected_rows($conn) < 0) {
            $_SESSION["login_error"] = $errormessage;
            redirect("login.php");
        }
        
        $row = $result->fetch_assoc();
        
        $password = hash('sha256', $password);
        if ($password == $row["password"]) {
            $_SESSION["email"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["nome"] = $row["nome"];
            $_SESSION["cognome"] = $row["cognome"];
            $_SESSION["datanascita"] = $row["datanascita"];
            $_SESSION["password"] = $password;
            $_SESSION["profileimg"] = isValid($row["fotoprofilo"]) ? $row["fotoprofilo"] : null;
            $_SESSION["register_error"] = "";
            $_SESSION["login_error"] = "";
            $sql = "insert into UserLogs(User_email) value('{$row['email']}')";
            $conn->query($sql);
            if($conn->affected_rows < 0){
                echo $conn->error;
            }
            redirect("index.php");
        } else {
            $_SESSION["login_error"] = $errormessage;
            redirect("login.php");
        }
        break;
    case 'register':
        $email = $_POST["email"];
        $name = $_POST["nome"];
        $surname = $_POST["cognome"];
        $datanascita = $_POST["datanascita"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["confirmpassword"];

        if (!isValid($email) ||
            !isValid($name) ||
            !isValid($surname) ||
            !isValid($username) ||
            !isValid($password) ||
            !isValid($cpassword) ||
            !isValid($datanascita)) {
            $_SESSION["register_error"] = "Campi invalidi! Tenta di nuovo";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&/\\ `]#i", $email)) {
            $_SESSION["register_error"] = "L'email non puo' contenere i seguenti caratteri: # [] <> \" ' % ; () & / \\ o spazi";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&./\\ `]#i", $username)) {
            $_SESSION["register_error"] = "L'username non puo' contenere i seguenti caratteri: # [] <> \" ' % ; () & / . \\ o spazi";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&.\\/`]#i", $name)) {
            $_SESSION["register_error"] = "Il nome non puo' contenere i seguenti caratteri: # [] <> \" ' % ; () & / . \\";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&.\\/`]#i", $surname)) {
            $_SESSION["register_error"] = "Il cognome non può contenere i seguenti caratteri: # [] <> \" ' % ; () & / . \\";
            redirect("register.php");
        }

        $datanascita = explode("-",$datanascita);

        if(count($datanascita) !== 3){
            $_SESSION["register_error"] = "Formato data non valido!";
            redirect("register.php");
        }

        if(!is_numeric($datanascita[0]) || !is_numeric($datanascita[1]) || !is_numeric($datanascita[2])){
            $_SESSION["register_error"] = "Tutti i campi della data dovrebbero essere numerici!";
            redirect("register.php");
        }

        $datanascita = $datanascita[0] . "-" . $datanascita[1] . "-" . $datanascita[2];

        $password = hash('sha256', $password);
        $cpassword = hash('sha256', $cpassword);
        if($password === $cpassword){
            $sql = "insert into Users (email,nome,cognome,username,datanascita,password)
            value ('$email','$name','$surname','$username','$datanascita','$password')";

            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION["register_error"] = "";
                $_SESSION["login_error"] = "";
                redirect("login.php");
            } else {
                $_SESSION["register_error"] = "Esiste gia' un account con queste credenziali! ";
                redirect("register.php");
            }
        } else{
            $_SESSION["register_error"] = "Le due password non coincidono!";
            redirect("register.php");
        }
        
        break;
    case 'logout':
        session_unset();
        $_SESSION["login_error"] = "sessione eliminata";
        redirect("login.php");
        break;
    case 'changecreds':


        $outcome = "";
        
        $newprofileimg = $_FILES['profileimg'];
        //CHANGING PROFILE IMAGE IF A NEW IMAGE WAS UPLOADED
        if (!($newprofileimg['error'] == 4 || ($newprofileimg['size'] == 0 && $newprofileimg['error'] == 0))) {
            $filepath = $newprofileimg["tmp_name"];
            $filename = $newprofileimg["name"];

            //Check if the file is bigger than 5 megabytes
            if ($newprofileimg['size'] > 5242880) {
                $outcome .= "image uploaded cannot be bigger than 5 megabytes <br>";
                redirect($indexpage);
                ;
            }

            $target_dir = "uploads/profileimgs/";
            $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            //Profile images are stored as <username>.image_extension
            $target_file = $target_dir . $_SESSION["username"] . "." . $imageFileType;

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $outcome .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. <br>";
            }

            if (empty($outcome) && move_uploaded_file($filepath, $target_file)) {

                //User's old profile image url
                $urlimg = $_SESSION["profileimg"];

                // Check and deletes old user's profile image
                if ($urlimg) {
                    unlink($urlimg);
                }

                $sql = "update utente
                        set urlimmagine = '$target_file'
                        where username = '$username'";

                $conn->query($sql);

                if ($conn->affected_rows > 0)
                    echo "profile image updated successfully";
                else
                    $outcome .= "couldn't update profile image";
            } else {
                $outcome .= "Sorry, there was an error uploading your file.";
            }
        }


        //GETTING ALL THE POST DATA
        $newemail = $_POST["email"];
        $newname = $_POST["nome"];
        $newsurname = $_POST["cognome"];
        $newusername = $_POST["username"];
        $oldpass = $_POST["vecchiapassword"];
        $newpass = $_POST["nuovapassword"];

        //CURRENT SESSION CREDENTIALS
        $currentemail = $_SESSION["email"];
        $currentusername = $_SESSION["username"];
        $currentpass = $_SESSION["password"];
        $currentname = $_SESSION["nome"];
        $currentsurname = $_SESSION["cognome"];

        //REDRIRECTING IF ANY OF THE ESSENTIAL POST DATA IS INVALID
        if (!isValid($newemail) || !isValid($newname) || !isValid($newsurname) || !isValid($newusername)) {
            $_SESSION["cred_change_status"] = "Campi non validi! Prova di nuovo.";
            redirect("account.php");
        }


        //IF THE USER WANTS TO CHANGE EMAIL
        if ($currentemail != $newemail) {
            $sql = "SELECT * FROM Users WHERE email = '$newemail'";
            $result = $conn->query($sql);

            //IF THE EMAIL IS ALREADY ASSOCIATED TO ANY ACCOUNT
            if (mysqli_affected_rows($conn) > 0) {
                $outcome = "La nuova e-mail inserita e' gia' utilizzata da un'altro account!<br>";
            } else {//CHANGE CURRENT USER EMAIL TO THE NEW ONE
                $sql = "UPDATE Users SET email = '$newemail' WHERE email = '$currentemail'";

                $conn->query($sql);
                if (mysqli_affected_rows($conn) > 0) {
                    $_SESSION["email"] = $newemail;
                    $outcome .= "E-mail cambiata con successo!<br>";
                } else {
                    $outcome .= "Non e' stato possibile trovare un account con questa email!<br>";
                }
            }
        }

        //IF THE USER WANTS TO CHANGE USERNAME
        if ($currentusername != $newusername) {
            $sql = "SELECT * FROM Users WHERE username = '$newusername'";
            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "Il nuovo username inserito e' gia' utilizzato da un altro account!<br>";
            } else {
                //CHANGE CURRENT USER USERNAME TO THE NEW ONE
                $sql = "UPDATE Users SET username = '$newusername' WHERE email = '$currentemail'";

                $_SESSION["username"] = $newusername;

                $conn->query($sql);

                if (mysqli_affected_rows($conn) > 0) {
                    $outcome .= "Username cambiato con successo!<br>";
                    $_SESSION["username"] = $newusername;
                } else {
                    $outcome .= "Non e' stato possibile trovare un account con questo username!<br>";
                }
            }
        }

        //IF THE USER WANTS TO CHANGE NAME
        if ($currentname != $newname) {

            $sql = "UPDATE Users SET nome = '$newname' WHERE email = '$currentemail'";

            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "Nome cambiato con successo!<br>";
                $_SESSION["name"] = $newname;
            } else {
                $outcome .= "Non e' stato possibile trovare un account con questo nome!<br>";
            }
        }

        //IF THE USER WANTS TO CHANGE SURNAME
        if ($currentsurname != $newsurname) {
            $sql = "UPDATE Users SET cognome = '$newsurname' WHERE email = '$currentemail'";

            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "Cognome cambiato con successo!<br>";
                $_SESSION["surname"] = $newsurname;
            } else {
                $outcome .= "Non e' stato possibile trovare un account con questo cognome!<br>";
            }
        }

        //IF THE USER WANTS TO CHANGE PASSWORD
        if (isValid($newpass) && isValid($oldpass)) {
            $currentpass = $row["password"];
            $newpass = hash('sha256', $newpass);
            $oldpass = hash('sha256', $oldpass);

            if ($oldpass != $currentpass) {
                $outcome .= "Inserisci la password corretta!";
            } else {
                //CHANGE CURRENT USER PASSWORD TO THE NEW ONE
                $sql = "UPDATE Users SET password = '$newpass' WHERE email = '$currentemail'";

                $_SESSION["password"] = $newpass;

                $conn->query($sql);

                if (mysqli_affected_rows($conn) > 0) {
                    $outcome .= "Password inserita con successo!<br>";
                    $_SESSION["password"] = $newpass;
                } else {
                    $outcome .= "Non e' stato possibile trovare un account con questa password!<br>";
                }
            }
        } else if (isValid($newpass) != isValid($oldpass)) {
            $outcome .= "Inserisci tutti i campi per cambiare la password corrente!<br>";
        }

        $_SESSION["cred_change_status"] = $outcome;
        redirect("account.php");
        break;
    default:
        redirect("index.php");
        break;
}
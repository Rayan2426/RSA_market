<?php
session_start();
$method = $_POST["method"];

function redirect($page)
{
    header("Location: ./$page");
    exit();
}

function isValid($var)
{
    return isset($var) && !empty($var);
}

if (!isValid($method)) {
    $_SESSION["login_error"] = "il metodo '$method' selezionato non e' valido!";
    redirect("login.php");
}

include_once ("./connectdb.php");

$conn = getConn();

switch ($method) {
    case 'login':
        $userinfo = $_POST["userinfo"];
        $password = $_POST["password"];
        $errormessage = "email or password are invalid! try again";
        
        if (!isValid($userinfo) || !isValid($password)) {
            $_SESSION["login_error"] = $errormessage;
            redirect("login.php");
        }
        
        $sql = "select email,username,nome,cognome,datanascita,password from users where username = '$userinfo' or email = '$userinfo'";
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
            $_SESSION["register_error"] = "";
            $_SESSION["login_error"] = "";
            
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

        if (!isValid($email) ||
            !isValid($name) ||
            !isValid($surname) ||
            !isValid($username) ||
            !isValid($password) ||
            !isValid($datanascita)) {
            $_SESSION["register_error"] = "invalid fields, please check again for errors!";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&/\\ ]#i", $email)) {
            $_SESSION["register_error"] = "email cannot contain # [] <> \" ' % ; () & / \\ or spaces";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&./\\ ]#i", $username)) {
            $_SESSION["register_error"] = "username cannot contain # [] <> \" ' % ; () & / . \\ or spaces";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&.\\/]#i", $name)) {
            $_SESSION["register_error"] = "name cannot contain # [] <> \" ' % ; () & / . \\";
            redirect("register.php");
        }

        if (preg_match("#[<>\"'%;(){}&.\\/]#i", $surname)) {
            $_SESSION["register_error"] = "surname cannot contain # [] <> \" ' % ; () & / . \\";
            redirect("register.php");
        }

        $datanascita = explode("-",$datanascita);

        if(count($datanascita) !== 3){
            $_SESSION["register_error"] = "invalid date format";
            redirect("register.php");
        }

        if(!is_numeric($datanascita[0]) || !is_numeric($datanascita[1]) || !is_numeric($datanascita[2])){
            $_SESSION["register_error"] = "all date fields must be numeric";
            redirect("register.php");
        }

        $datanascita = $datanascita[0] . "-" . $datanascita[1] . "-" . $datanascita[2];

        $password = hash('sha256', $password);
        $sql = "insert into users (email,nome,cognome,username,datanascita,password)
            value ('$email','$name','$surname','$username','$datanascita','$password')";

        $conn->query($sql);

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION["register_error"] = "";
            $_SESSION["login_error"] = "";
            redirect("login.php");
        } else {
            $_SESSION["register_error"] = "an account with the chosen email or username already exists! " . $conn->error;
            redirect("register.php");
        }
        break;
    case 'logout':
        session_unset();
        $_SESSION["login_error"] = "sessione eliminata";
        redirect("login.php");
        break;
    case 'changecreds':
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
            $_SESSION["cred_change_status"] = "invalid fields, please check again for errors!";
            redirect("account.php");
        }

        $outcome = "";


        //IF THE USER WANTS TO CHANGE EMAIL
        if ($currentemail != $newemail) {
            $sql = "SELECT * FROM users WHERE email = '$newemail'";
            $result = $conn->query($sql);

            //IF THE EMAIL IS ALREADY ASSOCIATED TO ANY ACCOUNT
            if (mysqli_affected_rows($conn) > 0) {
                $outcome = "the new inserted email is already taken<br>";
            } else {//CHANGE CURRENT USER EMAIL TO THE NEW ONE
                $sql = "UPDATE users SET email = '$newemail' WHERE email = '$currentemail'";

                $conn->query($sql);
                if (mysqli_affected_rows($conn) > 0) {
                    $_SESSION["email"] = $newemail;
                    $outcome .= "email changed successfully<br>";
                } else {
                    $outcome .= "couldn't find user's account while changing email<br>";
                }
            }
        }

        //IF THE USER WANTS TO CHANGE USERNAME
        if ($currentusername != $newusername) {
            $sql = "SELECT * FROM users WHERE username = '$newusername'";
            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "the new inserted username is already taken<br>";
            } else {
                //CHANGE CURRENT USER USERNAME TO THE NEW ONE
                $sql = "UPDATE users SET username = '$newusername' WHERE email = '$currentemail'";

                $_SESSION["username"] = $newusername;

                $conn->query($sql);

                if (mysqli_affected_rows($conn) > 0) {
                    $outcome .= "username changed successfully<br>";
                    $_SESSION["username"] = $newusername;
                } else {
                    $outcome .= "couldn't find user's account while changing username<br>";
                }
            }
        }

        //IF THE USER WANTS TO CHANGE NAME
        if ($currentname != $newname) {

            $sql = "UPDATE users SET nome = '$newname' WHERE email = '$currentemail'";

            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "name changed successfully<br>";
                $_SESSION["name"] = $newname;
            } else {
                $outcome .= "couldn't find user's account while changing name<br>";
            }


        }

        //IF THE USER WANTS TO CHANGE SURNAME
        if ($currentsurname != $newsurname) {
            $sql = "UPDATE users SET cognome = '$newsurname' WHERE email = '$currentemail'";

            $conn->query($sql);

            if (mysqli_affected_rows($conn) > 0) {
                $outcome .= "surname changed successfully<br>";
                $_SESSION["surname"] = $newsurname;
            } else {
                $outcome .= "couldn't find user's account while changing surname<br>";
            }
        }

        //IF THE USER WANTS TO CHANGE PASSWORD
        if (isValid($newpass) && isValid($oldpass)) {
            $currentpass = $row["password"];
            $newpass = hash('sha256', $newpass);
            $oldpass = hash('sha256', $oldpass);

            if ($oldpass != $currentpass) {
                $outcome .= "please insert the correct password";
            } else {
                //CHANGE CURRENT USER PASSWORD TO THE NEW ONE
                $sql = "UPDATE users SET password = '$newpass' WHERE email = '$currentemail'";

                $_SESSION["password"] = $newpass;

                $conn->query($sql);

                if (mysqli_affected_rows($conn) > 0) {
                    $outcome .= "password changed successfully<br>";
                    $_SESSION["password"] = $newpass;
                } else {
                    $outcome .= "couldn't find user's account while changing password<br>";
                }
            }
        } else if (isValid($newpass) != isValid($oldpass)) {
            $outcome .= "insert all fields of new and old password to change it<br>";
        }

        $_SESSION["cred_change_status"] = $outcome;
        redirect("account.php");
        break;
    default:
        redirect("index.php");
        break;
}

<?php
$name = $_GET['name'];
$usermail = $_GET['email'];
$subjeck = $_GET['subject']; 
$messege = $_GET['message'];
$link = $_GET['link'];
$pesan_replace = $_GET['pesan_replace'];


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
// require 'autoload.php';

// $mail = new PHPMailer(true);                              // Passing `true` enables exceptions


    error_reporting(E_ALL);
    require 'PHPMailer/src/PHPMailer.php' ;
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    $mail =  new PHPMailer\PHPMailer\PHPMailer();
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'rafihanif86@gmail.com';                 // SMTP username
    $mail->Password = 'Glacier86';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('rafihanif86@gmail.com', '');
    $mail->addAddress($usermail,$name);                   // Add a recipient        

 
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subjeck;
    $mail->Body    = $messege;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($mail->Send()){
        echo "<script>alert('$pesan_replace')
                location.replace('$link')</script>"; 
       }else{
        echo "<script>alert('Gagal Mengirim Email')
                location.replace('$link')</script>";
       }
    
} catch (Exception $e) {
    // echo 'Message could not be sent.';
    // echo 'Mailer Error: ' . $mail->ErrorInfo;
    echo "<script>alert('Maaf ada sebuah kesalahan pada sistem kami.')
                location.replace('$link')</script>";
}
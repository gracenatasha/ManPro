<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require 'phpmailer/src/Exception.php';
 require 'phpmailer/src/PHPMailer.php';
 require 'phpmailer/src/SMTP.php';

 if(isset($_POST["submit"])){
   //echo $_POST['email'];
   // foreach($_POST["email"] as $key => $value){
   //    echo $_POST["email"][$key];

      $mail = new PHPMailer(true);

       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com';
       $mail->SMTPAuth = true;
       $mail->Username= 'manprodonordarah@gmail.com';
       $mail->Password = 'ngwymhnbemqcusaz';
       $mail->SMTPSecure = 'ssl';
       $mail->Port = 465;

       $mail->setFrom('manprodonordarah@gmail.com');
         foreach($_POST['email'] as $key => $value ){
            echo $value;
            $mail->addAddress($value);
         }

       $mail->isHTML(true);
       $mail->Subject = $_POST["subject"];
       $mail->Body = $_POST["message"];

       $mail->send();

       echo
      "
       <script>
         alert('sent succesfully');
       document.location.href = 'table-broadcast.php';
      </script>

       ";
};
   // };
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$errors = [];
$errorMessage = ' ';
$successMessage = ' ';

if (!empty($_POST))
{
  $name = $_POST['firstName'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  if (empty($name)) {
      $errors[] = 'Name is empty';
  }

  if (empty($email)) {
      $errors[] = 'Email is empty';
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Email is invalid';

  }

  if (empty($message)) {
      $errors[] = 'Message is empty';
  }

  if (!empty($errors)) {
      $allErrors = join ('<br/>', $errors);
      $errorMessage = "<p style='color: red; '>{$allErrors}</p>";
      header("Location: contact.html?error=" . urlencode($allErrors));
      exit;
  } else {
      $fromEmail = 'hello@musicintheneighbourhood.com';
      $emailSubject = 'Hello from the Music in the Neighbourhood Society!';

      // Create a new PHPMailer instance
      $mail = new PHPMailer(exceptions: true);

      try {
            // Configure the PHPMailer instance
            // Initialize and configure the PHPMailer instance
            $mail->isSMTP();
            $mail->Host = 'live.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'api';
            $mail->Password = 'b3c10492b779df1b1afb02c066e94eea';

            // Set the sender, recipient, subject, and body of the message 
            $mail->setFrom($fromEmail, 'Music in the Neighbourhood');  // Set the sender email and name
            $mail->addAddress($email);  // The recipient’s email address

            $mail->Subject = $emailSubject;
            $mail->isHTML(true);  // Corrected syntax for isHTML
            $mail->Body = "<p>Hey {$name},</p><p>Thanks for contacting us! A member of our team will be in touch with you soon.</p>";
         
            // Send the message
            $mail->send () ;
            $successMessage = "<p style='color: green; '>Thank you for contacting us :) A member of our team will be in touch with you shortly.</p>";
      } catch (Exception $e) {
            $errorMessage = "<p style='color: red; '>Oops, something went wrong. Please try again later</p>";
            echo $errorMessage;
  }
}



}

?>
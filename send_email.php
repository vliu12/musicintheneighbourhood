<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$errors = [];
$errorMessage = ' ';
$successMessage = ' ';
echo 'Your email is sending ...';
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
  } else {
      $fromEmail = 'musicintheneighbourhood@gmail.com';
      $emailSubject = 'New Message from Contact Form';

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
            $mail->Body = "<p>Name: {$name}</p><p>Email: {$email}</p><p>Message: {$message}</p>";

            $mail->SMTPDebug = 2; // Detailed debug output
            $mail->Debugoutput = 'html'; // Output as HTML


         
            // Send the message
            $mail->send () ;
            $successMessage = "<p style='color: green; '>Thank you for contacting us :)</p>";
      } catch (Exception $e) {
            $errorMessage = "<p style='color: red; '>Oops, something went wrong. Please try again later</p>";
            echo $errorMessage;
  }
}
}

?>
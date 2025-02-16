<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path ke autoload Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan sanitasi data dari form
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $budget = htmlspecialchars(trim($_POST['budget']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validasi email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);

        try {
            // Pengaturan server email
            $mail->isSMTP();                                            // Gunakan SMTP
            $mail->Host       = 'smtp.example.com';                     // Alamat SMTP server
            $mail->SMTPAuth   = true;                                   // Aktifkan autentikasi SMTP
            $mail->Username   = 'farhanabdilah204@gmail.com';               // Alamat email SMTP
            $mail->Password   = 'Farhan2003';                  // Password email SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Aktifkan enkripsi TLS
            $mail->Port       = 587;                                    // TCP port untuk TLS

            // Pengaturan penerima dan pengirim
            $mail->setFrom($email, $name);                              // Alamat email pengirim
            $mail->addAddress('farhanabdilah204@gmail.com');            // Alamat email penerima

            // Konten email
            $mail->isHTML(false);                                       // Mengatur format email ke Plain Text
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\nBudget: $budget\n\nMessage:\n$message";

            // Kirim email
            $mail->send();
            echo 'Message sent successfully!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid email address.";
    }
} else {
    echo "Invalid request method.";
}
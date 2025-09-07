<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database configuration
$host = "localhost";
$user = "root";     // your MySQL username
$pass = "";         // your MySQL password
$dbname = "portfolio";

// Create DB connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into DB
    $sql = "INSERT INTO messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // ✅ Email notification
        $to = "your-email@example.com";   // change this to your real email
        $mail_subject = "New Contact Form Message: " . $subject;
        $mail_body = "You have received a new message from your portfolio site:\n\n"
                   . "Name: $name\n"
                   . "Email: $email\n"
                   . "Subject: $subject\n"
                   . "Message:\n$message\n\n"
                   . "Sent on: " . date("Y-m-d H:i:s");

        $headers = "From: noreply@yourdomain.com\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $mail_subject, $mail_body, $headers)) {
            echo "<script>alert('Message sent successfully! You will get a confirmation soon.'); window.location.href='index.html#contact';</script>";
        } else {
            echo "<script>alert('Message saved, but email could not be sent.'); window.location.href='index.html#contact';</script>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

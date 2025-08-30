<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['newsletter_email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?newsletter=invalid");
        exit;
    }

    $to = "tirupatiaquatech@yahoo.com";  // or your preferred email
    $subject = "New Newsletter Subscription";
    $body = "A new user subscribed with email: $email";
    $headers = "From: no-reply@yourdomain.com\r\nReply-To: no-reply@yourdomain.com";

    if (mail($to, $subject, $body, $headers)) {
        header("Location: index.html?newsletter=success");
    } else {
        header("Location: index.html?newsletter=failed");
    }
    exit;
}
?>

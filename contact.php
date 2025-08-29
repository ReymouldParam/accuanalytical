<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $number = htmlspecialchars(trim($_POST['number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $organization = htmlspecialchars(trim($_POST['organization']));
    $testing_type = htmlspecialchars(trim($_POST['testing_type']));
    $message = htmlspecialchars(trim($_POST['message']));

    $to1 = "sales@tirupatiaquatech.in";
    $to2 = "tirupatiaquatech@yahoo.com";
    $subject = "Enquiry from AquaSite Website";

    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Number: $number\n";
    $body .= "Organization: $organization\n";
    $body .= "Testing Required: $testing_type\n";
    $body .= "Message: $message\n";

    $headers = "From: $email\r\nReply-To: $email";

    // Send email to both addresses
    $mail1 = mail($to1, $subject, $body, $headers);
    $mail2 = mail($to2, $subject, $body, $headers);

    if ($mail1 || $mail2) {
        header("Location: contact.html?emailSuccess=true");
    } else {
        header("Location: contact.html?emailSuccess=false");
    }
    exit;
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize helper
    function clean($value)
    {
        return htmlspecialchars(trim($value));
    }

    // Basic fields from your form
    $full_name = clean($_POST['full_name'] ?? "");
    $email = clean($_POST['email'] ?? "");
    $phone = clean($_POST['phone'] ?? "");
    $organization = clean($_POST['organization'] ?? "");
    $message = clean($_POST['message'] ?? "");

    // NMR tests (checkbox array: tests[])
    $tests = isset($_POST['tests']) && is_array($_POST['tests']) ? $_POST['tests'] : [];
    $tests_list = !empty($tests) ? implode(", ", array_map('clean', $tests)) : "No tests selected";

    // Sample details (sample 1–4)
    $sample_output = "";
    for ($i = 1; $i <= 4; $i++) {

        $sample_name = clean($_POST["sample_name_$i"] ?? "");
        $solvent = clean($_POST["solvent_$i"] ?? "");
        $test_req = clean($_POST["test_for_sample_$i"] ?? "");
        $structure = clean($_POST["structure_$i"] ?? "");

        if ($sample_name || $solvent || $test_req || $structure) {
            $sample_output .= "Sample $i:\n";
            $sample_output .= "  Name / Code: $sample_name\n";
            $sample_output .= "  Solvent: $solvent\n";
            $sample_output .= "  Test Required: $test_req\n";
            $sample_output .= "  Structure / Formula: $structure\n\n";
        }
    }

    // Recipients
    $to1 = "naresh.narnapati@reymould.com";
    $to2 = "reymould.social@gmail.com";

    $subject = "Accu Analytical – NMR Request Form Submission";

    // Email body
    $body = "NMR Requisition Form Submission\n\n";
    $body .= "Full Name: $full_name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Organization: $organization\n\n";
    $body .= "Selected NMR Tests:\n$tests_list\n\n";
    $body .= "Sample Details:\n$sample_output\n";
    $body .= "Message:\n$message\n";

    // Headers
    $headers = "From: $email\r\nReply-To: $email";

    // Send mail
    $mail1 = mail($to1, $subject, $body, $headers);
    $mail2 = mail($to2, $subject, $body, $headers);

    // Redirect
    if ($mail1 || $mail2) {
        header("Location: contact.html?emailSuccess=true");
    } else {
        header("Location: contact.html?emailSuccess=false");
    }
    exit;
}
?>
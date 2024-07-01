<?php
// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $subject = trim($_POST["subject"]);
    $phone = trim($_POST["phone"]);

    // Validate input
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid input
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Recipient email
    $recipient = "key2contentadvertising@gmail.com"; // CHANGE THIS

    // Email subject
    $email_subject = "New contact from $name";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Success
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Server error
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
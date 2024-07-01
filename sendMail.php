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

    // Email Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: $email " . "\r\n";
    $recipient = "key2contentadvertising@gmail.com"; // CHANGE THIS
    $email_subject = "New Enquiry from $name";
    $email_content = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
            .container { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
            h2 { color: #333; }
            .info { margin-bottom: 20px; }
            .info p { margin: 0; margin-bottom: 10px; }
            .info label { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Contact Message</h2>
            <div class='info'>
                <p><label>Name:</label> $name</p>
                <p><label>Email:</label> $email</p>
                <p><label>Phone:</label> $phone</p>
                <p><label>Subject:</label> $subject</p>
            </div>
            <div class='message'>
                <label>Message:</label>
                <p>$message</p>
            </div>
        </div>
    </body>
    </html>";
    if(mail($recipient, $email_subject, $email_content, $headers)) {
    http_response_code(200);
    echo "Thank You! Your message has been sent.";

    header('Location: index.html?emailSent=true');
    exit;
} else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
}
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
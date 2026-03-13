<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 🛑 1. PUT YOUR CLIENT'S EMAIL HERE 🛑
    $to = "client-email@gmail.com"; 

    // Collect form data (Matching the 'name' attributes in your HTML)
    $name         = strip_tags(trim($_POST['username']));
    $email        = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone        = strip_tags(trim($_POST['phone']));
    $user_subject = strip_tags(trim($_POST['subject']));
    $message      = strip_tags(trim($_POST['message']));

    $subject = "New Website Inquiry: " . $user_subject;

    // Email content
    $body = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Subject:</strong> $user_subject</p>
    <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
    ";

    // Headers
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    
    // 🛑 2. AVOID SPAM FILTERS ON BIGROCK 🛑
    // Using a domain email prevents Gmail/Yahoo from blocking the message
    $headers .= "From: $email\r\n";  // info@hspl.in.net this email id was there, replaced $email
    
    // This allows your client to hit 'Reply' and email the user directly
    $headers .= "Reply-To: $email\r\n";

    // Send mail and output JavaScript for the alert box
    if (mail($to, $subject, $body, $headers)) {
        // Success: Show alert and send them back to the contact page
        // Note: Using document.referrer sends them back to the exact page they came from
        echo "<script>
                alert('Message sent successfully!'); 
                window.location.href = document.referrer;
              </script>";
    } else {
        // Failure: Show alert and let them try again
        echo "<script>
                alert('Message failed to send. Please try again later.'); 
                window.history.back();
              </script>";
    }
}

?>
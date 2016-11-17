---
layout: php
permalink: /php/contact.php
---

<?php

    // Just return to homepage if no actual from send
    if (!isset($_POST["send"])) {
        header('Location: {{ site.baseurl }}');
        die();
    }

    // Check for Spambot. Just do nothing.
    if (isset($_POST["_gotcha"]) and !empty($_POST["_gotcha"])) {
        die();
    }

    if (!isset($_POST["name"]) or empty($_POST["name"])) {
        header('Location: {{ site.contact["missing"] | prepend: site.baseurl | prepend: site.url}}');
        die();
    }

    if (!isset($_POST["mail"]) or empty($_POST["mail"])) {
        header('Location: {{ site.contact["missing"] | prepend: site.baseurl | prepend: site.url}}');
        die();
    }

    if (!isset($_POST["message"]) or empty($_POST["message"])) {
        header('Location: {{ site.contact["missing"] | prepend: site.baseurl | prepend: site.url}}');
        die();
    }

    $name = $_POST["name"];
        $email = $_POST["mail"];
        $content = $_POST["message"];
   
    
    $to = "{{ site.contact['to'] }}";
    $subject = "{{ site.contact['subject'] }}";

    $headers   = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=utf-8";
    $headers[] = "From: {{ site.contact['from'] }}";
    // falls Bcc benötigt wird
    $headers[] = "Reply-To: {$email}";
    $headers[] = "Subject: {{ site.contact['subject'] }}";
    $headers[] = "X-Mailer: PHP/".phpversion();


    $message = "
Name: $name \n
Mail: $email \n
Message:\n
$content
    ";


    if (@mail($to, $subject, $message, implode("\r\n",$headers))) {
        header('Location: {{ site.contact["success"] | prepend: site.baseurl | prepend: site.url}}');
        die();
    } else {
        header('Location: {{ site.contact["error"] | prepend: site.baseurl | prepend: site.url}}');
        die();
    }

    
?> 
<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $web = trim($_POST["web"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($phone) OR empty($web) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Por favor completa el formulario e intentalo de nuevo.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "ventas_1@rizav.com.mx";

        // Set the email subject.
        $subject = "Nuevo mensaje desde www.rizav.com de $name";

        // Build the email content.
        $email_content = "Nombre: $name\n";
        $email_content .= "Correo: $email\n\n";
        $email_content .= "Telefono: $phone\n\n";
        $email_content .= "WEB: $web\n\n";
        $email_content .= "Mensaje:\n$message\n";

        // Build the email headers.
        $email_headers = "De: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Gracias! tu mensaje ha sido enviado.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Algo salio mal. No se pudo enviar tu mensaje";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Hubo un problema con tu solicitus, por favor intentalo de nuevo.";
    }

?>
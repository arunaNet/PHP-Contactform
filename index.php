<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>arunaNet - PHP - Kontaktformular</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/libs/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <h1 class="display-4 text-center">Kontaktformular</h1>
    <form action="" method="post">
        <input name="security" type="hidden" value="secure">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="SelectGender">Anrede</label>
                <select name="gender" class="form-control" id="SelectGender">
                    <option value="Herr">Herr</option>
                    <option value="Frau">Frau</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="InputName">Name</label>
                <input name="name" type="text" class="form-control" id="InputName">
            </div>
            <div class="form-group col-md-6">
                <label for="InputEmail">E-Mail-Adresse <span class="req">Pflichtfeld</span></label>
                <input name="email" type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="form-group">
            <label for="TextareaMessage">Nachricht <span class="req">Pflichtfeld</span></label>
            <textarea name="message" class="form-control" id="TextareaMessage" rows="3" required></textarea>
        </div>
        <div class="form-check">
            <input type="hidden" name="optin" value="0">
            <input type="checkbox" id="opt-in" name="optin" value="1" class="form-check-input" required>
            <label for="opt-in">
                <strong>HINWEIS</strong> <span class="req">Pflichtfeld</span><br>Ich habe die Hinweise in der <a href="#">Datenschutzerklärung</a> verstanden und stimme diesen hiermit zu.
            </label>
        </div>

        <?php
            error_reporting(0);
            if (isset($_POST['sendform']) && ($_POST['security'] == 'secure')) :
                if (!empty($_POST['email'])) :
                    if (!empty($_POST['optin'])) :

                        $gender = htmlspecialchars($_POST['gender']);
                        $name = htmlspecialchars($_POST['name']);
                        $email = htmlspecialchars($_POST['email']);
                        $message = htmlspecialchars($_POST['message']);

                        $formmail = 'deineEmail@adresse.de';

                        if (preg_match("/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) :

                            $subject = 'Eine neue Kontaktformularanfrage ist eingetroffen.';
                            $message = "
                                <html>
                                <head>
                                <title>Neue Anfrage</title>
                                </head>
                                  <body>
                                    <p>Eine neue Anfrage von " . $gender . " " . $name . " ist eingegangen.</p>
                                    <p>Die hinterlegte E-Mail-Adresse lautet: " . $email . ".</p>
                                    <p><strong>Nachricht:</strong> <br> " . $message . "</p>
                                  </body>
                                </html>
                            ";

                            $userSubject = 'Ihre Anfrage bei DeinName.';
                            $userMessage = '
                                <html>
                                <head>
                                 <title>Deine Überschrift in der E-Mail</title>
                                </head>
                                  <body>
                                    <p>Vielen Dank für Ihre Anfrage. <br>
                                    Sie bekommen schnellstmöglich eine Antwort von uns.</p>
                                  </body>
                                </html>
                            ';

                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= "From: <' . $formmail . '>" . "\r\n";

                            mail($email, $userSubject, $userMessage, $headers);

                            if(mail($formmail, $subject, $message, $headers)) :
                                echo '
                                    <div class="alert alert-success" role="alert">
                                        Anfrage erfolgreich versendet!
                                    </div>
                                ';
                            else :
                                echo '
                                    <div class="alert alert-danger" role="alert">
                                        Anfrage nicht versendet!
                                    </div>
                                ';
                            endif;

                        else :
                            echo '
                                <div class="alert alert-danger" role="alert">
                                    Bitte eine korrekte E-Mail-Adresse eingeben.
                                </div>
                            ';
                        endif;

                    else :
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Haben Sie die Datenschutzerklärung gelesen? Dann bitte bestätigen.
                            </div>
                        ';
                    endif;

                else :
                    echo '
                        <div class="alert alert-danger" role="alert">
                            Bitte eine E-Mail-Adresse eingeben.
                        </div>
                    ';
                endif;
            endif;
        ?>
        <button type="submit" name="sendform" class="btn btn-dark">Absenden</button>
    </form>
</div>

</body>
</html>
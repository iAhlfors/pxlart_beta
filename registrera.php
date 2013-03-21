<?php 
    session_start();
    if (isset($_SESSION['user_id']))
    {
        header('Location: index.php');
        exit();
    }

    include 'PasswordHash.php';

    $title = "PXLART";
    include "header.php"; 

/**
 * Don't use mysql_ functions. These are for MySQL 4.x and have been deprecated
 * since 2004. MySQLi is fine if you know you'll only be using MySQL databases.
 * PDO doesn't tie you to a specific RDBMS.
 */

// Create an array to catch any errors in the registration form.
$errors = array();

/**
 * Make sure the form has been submitted before trying to process it. This is
 * single most common cause of 'undefined index' notices.
 */
if (!empty($_POST))
{
    // First check that required fields have been filled in.
    if (empty($_POST['username']))
    {
        $errors['username'] = "Username cannot be empty.";
    }

    // OPTIONAL
    // Restrict usernames to alphanumeric plus space, dot, dash, and underscore.
    /*
    if (preg_match('/[^a-zA-Z0-9 .-_]/', $_POST['username']))
    {
        $errors['username'] = "Username contains illegal characters.";
    }
    */

    if (empty($_POST['password']))
    {
        $errors['password'] = "Password cannot be empty.";
    }

    /**
     * Note there's no upper limit to password length.
     */
    if (strlen($_POST['password']) < 8)
    {
        $errors['password'] = "Password must be at least 8 charcaters.";
    }

    // OPTIONAL
    // Force passwords to contain at least one number and one special character.
    /*
    if (!preg_match('/[0-9]/', $_POST['password']))
    {
        $errors['password'] = "Password must contain at least one number.";
    }
    if (!preg_match('/[\W]/', $_POST['password']))
    {
        $errors['password'] = "Password must contain at least one special character.";
    }
    */

    if (empty($_POST['password_confirm']))
    {
        $errors['password_confirm'] = "Please confirm password.";
    }

    if ($_POST['password'] != $_POST['password_confirm'])
    {
        $errors['password'] = "Passwords do not match.";
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email)
    {
        $errors['email'] = "Not a valid email address.";
    }

    /**
     * Escape the data we're going to use in our query. Never trust user input.
     */
    $username = $sql->real_escape_string($_POST['username']);
    $email    = $sql->real_escape_string($email);

    /**
     * Check that the username and email aren't already in our database.
     *
     * Note also the absence of SELECT *
     * Grab the columns you need, nothing more.
     */
    $query  = "SELECT username, email
               FROM pxlart_usrz
               WHERE username = '{$username}' OR email = '{$email}'";
    $result = $sql->query($query);

    /**
     * There may well be more than one point of failure, but all we really need
     * is the first one.
     */
    $existing = $result->fetch_object();

    if ($existing)
    {
        if ($existing->username == $_POST['username'])
        {
            $errors['username'] = "That username is already in use.";
        }
        if ($existing->email == $email)
        {
            $errors['email'] = "That email address is already in use.";
        }
    }
}

/**
 * If the form has been submitted and no errors were detected, we can proceed
 * to account creation.
 */
if (!empty($_POST) && empty($errors))
{
    /**
     * Hash password before storing in database
     */
    $hasher = new PasswordHash(8, FALSE);
    $password = $hasher->HashPassword($_POST['password']);

    $query = "INSERT INTO pxlart_usrz (username, password, email, created)
              VALUES ('{$username}', '{$password}', '{$email}', NOW())";
    $success = $sql->query($query);

    if ($success)
    {
        $message = "Account created.";
    }
    else
    {
        $errors['registration'] = "Account could not be created. Please try again later.";
    }
}

?>
        <div id="canvas">
            <div id="registrera">
                <div class="medlemsInfo">
                    <h1>Registrering</h1>
                    <p>Välkommen! För att kunna spara och redigera dina PXLar måste du ha ett konto på PXLART. Registreringen tar inte mer än 30 sekunder och du är genast igång! Har du redan ett konto kan du <a href="index.php">logga in här</a>.</p>
                    <?php if (isset($message)): ?>
                        <p class="success"><?php echo $message; ?></p>
                    <?php endif; ?>
                    <?php if (isset($errors['registration'])): ?>
                        <p class="error"><?php echo $errors['registration']; ?></p>
                    <?php endif; ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="padding:0px 15px 0px 0px;">
                            <label for="username">Användarnamn: </label>
                            <input type="text" id="username" name="username" value="<?php if (isset($errors)) { echo $_POST['username']; } ?>" />
                            <span class="error">
                                <?php echo isset($errors['username']) ? $errors['username'] : ''; ?>
                            </span><br />

                            <label for="email">E-post: </label>
                            <input type="text" id="email" name="email" value="<?php if (isset($errors)) { echo $_POST['email']; } ?>"/>
                            <span class="error">
                                <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                            </span><br />

                            <label for="password">Lösenord: </label>
                            <input type="password" id="password" name="password" />
                            <span class="error">
                                <?php echo isset($errors['password']) ? $errors['password'] : ''; ?>
                            </span><br />

                            <label for="password_confirm">Lösenord igen: </label>
                            <input type="password" id="password_confirm" name="password_confirm" />
                            <span class="error">
                                <?php echo isset($errors['password_confirm']) ? $errors['password_confirm'] : ''; ?>
                            </span><br />

                            <input type="submit" value="Registrera!" />
                    </form>
                </div>
                <div class="loginreg">
                    <h1>Det finstilta</h1>
                    <p>Använd sunt förnuft, denna tjänst är öppen för alla.<br /><br />Ditt konto kan raderas när som helst.</p>
                </div>
            </div>
        </div>
    <?php include "footer.php"; ?>
</body>
</html>
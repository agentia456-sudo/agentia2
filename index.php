<?php
session_start();

$project_url = "https://xrsebcwlbekugvpwqcii.supabase.co";

$api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhyc2ViY3dsYmVrdWd2cHdxY2lpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIwNTkxNzksImV4cCI6MjA4NzYzNTE3OX0.laxq2_POjoitWv8J0RQNo5SiBXvs2yzmtAaoxWje7Vo";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $url = $project_url . "/rest/v1/login?select=*";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $api_key",
        "Authorization: Bearer $api_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (is_array($data)) {
        foreach ($data as $user) {

            if ($user["email"] === $email && $user["password"] === $password) {

                $_SESSION["student_id"] = $user["Matricule"];
                $_SESSION["email"] = $user["email"];

                header("Location: ask_question.php");
                exit();
            }
        }
    }

    $error = "❌ Email ou mot de passe incorrect";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Connexion Étudiant</h2>

<?php if (isset($error)) echo "<p>$error</p>"; ?>

<form method="POST">

    Email:<br>
    <input type="email" name="email" required><br><br>

    Mot de passe:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>

</form>

</body>
</html>
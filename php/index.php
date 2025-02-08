<?php
session_start();

// Connexion à la base de données
$host = "localhost";
$dbname = "newsletter";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Traitement de la connexion
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $stmt = $conn->prepare("SELECT * FROM proprietaires WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['message'] = "Bienvenue, vous êtes connecté!";
        // Rediriger vers la page de gestion des articles
        header("Location: manage_news.php");
        exit();
    } else {
        $_SESSION['error'] = "Identifiants incorrects. Veuillez vérifier votre email et votre mot de passe.";
    }
}
?>

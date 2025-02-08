<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root'; 
$password = 'root'; 
$dbname = 'newsletter'; 

// Créer une connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

session_start(); // Démarrer la session pour utiliser $_SESSION

// Lors de la connexion de l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Assainir les entrées
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Requête préparée pour vérifier l'existence de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM proprietaires WHERE email = ?");
    $stmt->bind_param("s", $email); // 's' signifie que c'est une chaîne
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Comparaison du mot de passe saisi avec le mot de passe dans la base de données
        if (strcmp($password, $row['mot_de_passe']) === 0) {
            // Si les mots de passe sont égaux
            echo "Connexion réussie !";
            // Sauvegarder les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];

            // Redirection vers la page d'accueil ou tableau de bord
            header("Location: newsmod.php");
            exit(); // Toujours utiliser exit() après une redirection pour empêcher l'exécution du reste du script
        } else {
            // Si le mot de passe est incorrect
            echo "<h3>Le mot de passe que vous avez saisi est incorrect.</h3>";
        }
    } else {
        echo "<h3>Aucun utilisateur trouvé avec cet email. essayer de s'enregistrer</h3>";
        echo "<form method='get' action='../html/contact.php#registerForm'>
            <button type='submit'>Aller à la Page contact pour s'enregistrer</button>
            </form>";
    }
}
?>

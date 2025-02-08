<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root'; 
$password = 'root'; 
$dbname = 'newsletter';

$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $name = $conn->real_escape_string($name);
    $surname = $conn->real_escape_string($surname);
    $email = $conn->real_escape_string($email);

    // Vérifier si l'email est déjà pris
    $stmt = $conn->prepare("SELECT * FROM internaute WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>Cet email est déjà pris. Veuillez en choisir un autre.</h3>";
    } else {

        // Insérer l'utilisateur dans la base de données
        $stmt = $conn->prepare("INSERT INTO internaute (nom, prenom, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $surname, $email);

        if ($stmt->execute()) {
            // Rediriger vers une page de choix après une inscription réussie
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }

    $stmt->close();
}

$conn->close();
?>

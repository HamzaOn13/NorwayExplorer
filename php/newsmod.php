<?php
// Connexion à la base de données
$host = 'localhost';
$username = 'root'; 
$password = 'root'; 
$dbname = 'newsletter';

$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Ajouter une nouvelle news
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $summary = $_POST['summary']; // Résumé de la news
    $content = $_POST['content'];
    $date_publication = date('Y-m-d H:i:s'); // Date de publication actuelle

    // Assainir les entrées pour éviter les injections SQL
    $title = $conn->real_escape_string($title);
    $summary = $conn->real_escape_string($summary);
    $content = $conn->real_escape_string($content);

    // Insérer la nouvelle dans la base de données
    $stmt = $conn->prepare("INSERT INTO news (titre, resume, contenu, date_publication) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $summary, $content, $date_publication);

    if ($stmt->execute()) {
        // Rediriger vers la même page pour éviter la soumission multiple du formulaire
        header("Location: newsmod.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout de la nouvelle.";
    }
}

// Modifier une news
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_news'])) {
    $id = $_POST['news_id'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];

    // Assainir les entrées pour éviter les injections SQL
    $title = $conn->real_escape_string($title);
    $summary = $conn->real_escape_string($summary);
    $content = $conn->real_escape_string($content);

    // Correction de la ligne bind_param()
    $stmt = $conn->prepare("UPDATE news SET titre = ?, resume = ?, contenu = ? WHERE news_id = ?");
    $stmt->bind_param("sssi", $title, $summary, $content, $id);

    if ($stmt->execute()) {
        echo "Nouvelle mise à jour avec succès!";
    } else {
        echo "Erreur lors de la mise à jour de la nouvelle.";
    }
}

// Supprimer une news
if (isset($_GET['delete_news'])) {
    $id = $_GET['delete_news'];

    $stmt = $conn->prepare("DELETE FROM news WHERE news_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Nouvelle supprimée avec succès!";
    } else {
        echo "Erreur lors de la suppression de la nouvelle.";
    }
}

// Récupérer toutes les nouvelles
$result = $conn->query("SELECT * FROM news");

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Nouvelles</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            height: 100%;
            width: 100%;
        }

        h1 {
            color: #1e3a5f;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        h2 {
            color: #1e3a5f;
            font-size: 1.8em;
            margin: 20px 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
            color: #555;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        .a{
            width: 30%;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            background-color: #5b92e5;
            border: none;
            padding: 12px 20px;
            color: white;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s ease;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #4a7fb6;
            transform: scale(1.05);
        }

        form input, form textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            background-color: #f7f7f7;
            color: #333;
        }

        textarea{
            height: 100px;
        }

        form input:focus, form textarea:focus {
            border-color: #5b92e5;
            outline: none;
        }

        form input[type="text"], form textarea {
            resize: vertical;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 1em;
            color: #7d8b97;
        }

        footer span {
            display: block;
            padding: 10px 0;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 15px 0;
        }

        a {
            color: #c22f34;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions a {
            color: #c22f34;
            text-decoration: none;
            font-weight: bold;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            h2 {
                font-size: 1.5em;
            }

            button {
                width: 100%;
            }

            table {
                font-size: 0.9em;
            }
        }

    </style>
</head>

<body>
    <h1>Gestion des Nouvelles</h1>

    <!-- Formulaire pour ajouter une nouvelle -->
    <h2>Ajouter une Nouvelle</h2>
    <form method="POST" action="newsmod.php">
        <input type="text" name="title" placeholder="Titre" required><br>
        <input type="text" name="summary" placeholder="Résumé" required><br>
        <textarea name="content" placeholder="Contenu" required></textarea><br>
        <button type="submit" name="add_news">Ajouter</button>
    </form>

    <hr>

    <h2>Liste des Nouvelles</h2>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Résumé</th>
                <th>Contenu</th>
                <th>Date de Publication</th>
                <th class="a">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['titre']); ?></td>
                    <td><?php echo htmlspecialchars($row['resume']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['contenu'])); ?></td>
                    <td><?php echo htmlspecialchars($row['date_publication']); ?></td>
                    <td class="actions">
                        <!-- Formulaire pour modifier une nouvelle -->
                        <form method="POST" action="newsmod.php" style="display:inline;">
                            <input type="hidden" name="news_id" value="<?php echo $row['news_id']; ?>">
                            <input type="text" name="title" value="<?php echo htmlspecialchars($row['titre']); ?>" required><br>
                            <input type="text" name="summary" value="<?php echo htmlspecialchars($row['resume']); ?>" required><br>
                            <textarea name="content" required><?php echo htmlspecialchars($row['contenu']); ?></textarea><br>
                            <button type="submit" name="update_news">Mettre à jour</button>
                        </form>
                        <br>
                        <a href="newsmod.php?delete_news=<?php echo $row['news_id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette nouvelle ?');">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <form method="get" action="../html/contact.php">
        <button type="submit">Aller à la Page contact</button>
    </form>
    
    <form method="get" action="../html/index.html">
        <button type="submit">Aller à l'accueil</button>
    </form>

    <footer>
        <span>&copy; 2024 Gestion des Nouvelles</span>
    </footer>
</body>

</html>

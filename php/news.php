<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous Les News</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            padding: 15px;
            overflow-x: hidden;
        }

        h2, h3 {
            color: #1e3a5f;
        }

        h3 {
            font-size: 1.6em;
            margin: 10px 0;
            font-weight: bold;
        }

        small {
            font-size: 0.9em;
            color: #7d8b97;
        }

        p {
            font-size: 1.1em;
            margin: 12px 0;
            line-height: 1.6;
        }

        a {
            color: #c22f34;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .open-iframe-button {
            background-color: #5b92e5;
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            text-align: center;
            transition: background-color 0.3s;
        }

        .open-iframe-button:hover {
            background-color: #4a7fb6;
        }

        div {
            background-color: #fff;
            padding: 18px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            border-left: 5px solid #e49e44;  /* Accent color inspired by Norwegian autumn */
        }

        div a {
            color: #1e3a5f;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #1e3a5f;
            border-radius: 5px;
            margin: 8px 0;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }

        div a:hover {
            background-color: #1e3a5f;
            color: #fff;
        }

        div a:active {
            background-color: #4a7fb6;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 15px 0;
        }

        button {
            background-color: #5b92e5;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4a7fb6;
        }

        button:focus {
            outline: none;
        }

        iframe {
            width: 100%;
            border: none;
            height: 100vh;
        }

        a, a:focus, a:hover {
            color: inherit;
            text-decoration: none;
        }

    </style>
</head>
<body>

<?php
// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=newsletter", "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Vérifier si un ID de news est passé dans l'URL
if (isset($_GET['id'])) {
    $news_id = intval($_GET['id']); // Sécuriser l'entrée

    // Récupérer les détails de la news
    $stmt = $conn->prepare("SELECT * FROM News WHERE news_id = :news_id");
    $stmt->execute([':news_id' => $news_id]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($news) {
        // Afficher les détails de la news
        echo "<h2>" . htmlspecialchars($news['titre']) . "</h2>";
        echo "<p><strong>Date de publication :</strong> " . htmlspecialchars($news['date_publication']) . "</p>";
        echo "<p><strong>Résumé :</strong> " . htmlspecialchars($news['resume']) . "</p>";
        echo "<p><strong>Contenu :</strong> " . nl2br(htmlspecialchars($news['contenu'])) . "</p>";
    } else {
        echo "<p>News non trouvée.</p>";
    }

    // Lien de retour à la liste des news
    echo "<a href='news.php'>Retour à la liste des news</a>";

} elseif (isset($_GET['view']) && $_GET['view'] == 'all') {
    // Afficher toutes les news avec pagination
    $news_per_page = 10;  // Nombre de news par page
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start = ($page - 1) * $news_per_page;

    // Récupérer les news pour la page courante
    $stmt = $conn->prepare("SELECT * FROM News ORDER BY date_publication DESC LIMIT :start, :limit");
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $news_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculer le nombre total de pages
    $total_news = $conn->query("SELECT COUNT(*) FROM News")->fetchColumn();
    $total_pages = ceil($total_news / $news_per_page);

    echo "<h2>Liste de toutes les news</h2>";

    foreach ($news_list as $news) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($news['titre']) . "</h3>";
        echo "<p>" . htmlspecialchars($news['resume']) . "</p>";
        echo "<small>Date : " . htmlspecialchars($news['date_publication']) . "</small><br>";
        echo "<a href='news.php?id=" . $news['news_id'] . "'>Cliquez ici pour plus de détail</a>";
        echo "</div><hr>";
    }

    // Pagination
    echo "<div>";
    if ($page > 1) {
        echo "<a href='news.php?view=all&page=" . ($page - 1) . "'>Page précédente</a> ";
    }
    if ($page < $total_pages) {
        echo "<a href='news.php?view=all&page=" . ($page + 1) . "'>Page suivante</a>";
    }
    echo "</div>";

    // Lien de retour à l'accueil
    echo "<a href='news.php'>Retour à l'accueil</a>";

} else {
    // Par défaut, afficher seulement les 3 premières news
    $stmt = $conn->query("SELECT * FROM News ORDER BY date_publication DESC LIMIT 3");
    $news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Dernières news</h2>";
    echo "</br>";

    foreach ($news_list as $news) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($news['titre']) . "</h3>";
        echo "<small>Date : " . htmlspecialchars($news['date_publication']) . "</small><br>";
        echo "<a href='news.php?id=" . $news['news_id'] . "'>Cliquez ici pour plus de détail</a>";
        echo "</div><hr>";
    }

}
?>

<!-- Bouton pour ouvrir une iframe dans la modale -->
<button class="open-iframe-button" onclick="window.parent.openIframe()">Tous Les News</button>

</body>
</html>
<?php
// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=localhost;dbname=newsletter", "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Récupérer toutes les news depuis la base de données
$stmt = $conn->query("SELECT * FROM News ORDER BY date_publication DESC"); 
$news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des News</title>

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
            margin: 15px 0;
            font-weight: bold;
        }

        small {
            font-size: 1em;
            color: #7d8b97;
        }

        p {
            font-size: 1.1em;
            margin: 12px 0;
            line-height: 1.6;
        }

        .news-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .news-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #e49e44;  /* Accent couleur inspirée de la Norvège */
        }

        .news-item p {
            font-size: 1em;
        }

        button {
            background-color: #5b92e5;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 30px;
            display: block;
            text-align: center;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #4a7fb6;
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

        a, a:focus, a:hover {
            color: inherit;
            text-decoration: none;
        }

    </style>
</head>
<body>

    <h1>Liste des News</h1>

    <div class="news-container">
        <?php if ($news_list): ?>
            <?php foreach ($news_list as $news): ?>
                <div class="news-item">
                    <h2><?php echo htmlspecialchars($news['titre']); ?></h2>
                    <small><strong>Date de publication : </strong><?php echo htmlspecialchars($news['date_publication']); ?></small>
                    <p><strong>Résumé : </strong><?php echo nl2br(htmlspecialchars($news['resume'])); ?></p>
                    <p><strong>Contenu : </strong><?php echo nl2br(htmlspecialchars($news['contenu'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune news disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <button onclick="window.parent.closeIframe();">Retour à la page principale</button>

    <footer>
        <span>Copyright 2024-2025 - News Company</span>
    </footer>

</body>
</html>

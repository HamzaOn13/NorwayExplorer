<?php
try {
    // a executer une seule fois 
    //il faut d'abord crée la base de donnees et les tables 
    //db name = newsletter
    //tableuax names = internaute, news, proprietaires
    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=newsletter", "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tableau des données à insérer
    $news = [
        [
            'news_id' => 1,
            'titre' => 'Football : Erling Haaland',
            'resume' => 'Erling Haaland, l\'attaquant vedette norvégien, continue de briller en Premier League avec Manchester City, consolidant sa réputation parmi les meilleurs buteurs européens.',
            'contenu' => 'Haaland continue d\'être une figure centrale dans les matchs de Premier League, attirant l\'attention mondiale grâce à ses performances exceptionnelles.',
            'date_publication' => '2024-11-26'
        ],
        [
            'news_id' => 2,
            'titre' => 'Ski de fond : Saison hivernale',
            'resume' => 'La saison hivernale approche, et les athlètes norvégiens se préparent activement pour les compétitions internationales.',
            'contenu' => 'Les Norvégiens cherchent à maintenir leur domination historique en ski de fond, une discipline où ils ont excellé pendant des décennies.',
            'date_publication' => '2024-11-25'
        ],
        [
            'news_id' => 3,
            'titre' => 'Festival de Jazz d\'Oslo',
            'resume' => 'Le Festival de Jazz d\'Oslo a récemment célébré sa 25e édition, attirant des artistes de renommée mondiale.',
            'contenu' => 'Cet événement majeur de la scène musicale norvégienne continue de réunir des amateurs de jazz de tous horizons.',
            'date_publication' => '2024-11-20'
        ],
        [
            'news_id' => 4,
            'titre' => 'Littérature : Jo Nesbø',
            'resume' => 'Les romans policiers norvégiens continuent de gagner en popularité sur la scène internationale.',
            'contenu' => 'Des auteurs comme Jo Nesbø dominent les ventes, renforçant l\'image de la Norvège comme un centre de littérature de suspense.',
            'date_publication' => '2024-11-18'
        ],
        [
            'news_id' => 5,
            'titre' => 'Reconnaissance de l\'État de Palestine',
            'resume' => 'Le 22 mai 2024, la Norvège a officiellement reconnu l\'État de Palestine.',
            'contenu' => 'Le Premier ministre norvégien, Jonas Gahr Støre, a affirmé le droit des Palestiniens à l\'autodétermination et a soutenu une solution à deux États.',
            'date_publication' => '2024-05-22'
        ],
        [
            'news_id' => 6,
            'titre' => 'Élections locales de 2023',
            'resume' => 'Les élections locales tenues le 11 septembre 2023 ont vu une participation accrue.',
            'contenu' => 'Les débats ont été centrés sur le climat, l\'économie et les services publics, reflétant les préoccupations des citoyens norvégiens.',
            'date_publication' => '2023-09-11'
        ],
    ];

    // Requête d'insertion
    $stmt = $conn->prepare("INSERT INTO News (news_id, titre, resume, contenu, date_publication) VALUES (:news_id, :titre, :resume, :contenu, :date_publication)");

    // Boucle pour insérer chaque news
    foreach ($news as $new) {
        $stmt->execute([
            ':news_id' => $new['news_id'],
            ':titre' => $new['titre'],
            ':resume' => $new['resume'],
            ':contenu' => $new['contenu'],
            ':date_publication' => $new['date_publication']
        ]);
    }

    echo "Les données ont été ajoutées avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Grenze+Gotisch:wght@100..900&family=Rubik+Wet+Paint&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/contact.css">
    <title>Contact</title>
    <nav class="banniere">
        <p>Velkommen til Norges vakreste landskap!</p>
    </nav>
    <nav class="nav">
        <div class="nav1">
            <img src="../images/drapeau.png" alt="">
            <p>VELKOMMEN <br>TIL NORGE</p>
        </div>
        <div class="nav2">
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="plansite.html">Plan de site</a></li>
                <li><a href="quisommesnous.html">Qui sommes nous ?</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>
</head>

<body>
    <div class="aa">
        <ul>
            <li><a href="sites.html">Sites et Monuments</a></li>
            <li><a href="ville.html">Index des villes</a></li>
            <li><a href="map.html">Google map</a></li>
            <li><a href="liens.html">Liens utiles</a></li>
        </ul>
    </div>

    <div class="right-sidebar hidden" id="sidebar">
        <iframe src="https://www.youtube.com/embed/pdueqhNqwrs" frameborder="2" allowfullscreen class="ifr"></iframe>
        <iframe src="../php/news.php" frameborder="2" class="iframephp" class="ifr1" height="310px"></iframe>

        

    <!-- Modale contenant l'iframe -->
    <div id="iframeModal">
        <iframe id="modalIframe" src=""></iframe>
    </div>

    <script>
        // Fonction pour ouvrir l'iframe dans la modale
        function openIframe() {
            document.getElementById("iframeModal").style.display = "block";  // Afficher la modale
            document.getElementById("modalIframe").src = "../php/tousnews.php"; // Charger le contenu de l'iframe
        }

        function closeIframe() {
            document.getElementById("iframeModal").style.display = "none";  // Cacher la modale
            document.getElementById("modalIframe").src = ""; // Supprimer le contenu de l'iframe
        }

        document.getElementById('modalIframe').style.width = '760px';
        document.getElementById('modalIframe').style.height = '400px';



    </script>
    </div>
    <button id="toggleButton" class="toggle-button"><</button>

    <div class="container">
        <!-- Formulaire de connexion -->
        <form id="loginForm" class="form active" method="POST" action="../php/login.php">
            <h2>Connexion</h2>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="login" class="btn">Se connecter</button>
            <p>Vous n'avez pas de compte ? <a href="#" onclick="showRegisterForm()">S'inscrire</a></p>
        </form>

        <!-- Formulaire d'enregistrement -->
        <form id="registerForm" class="form hidden1" method="POST" action="../php/register.php">
            <h2>Enregistrement</h2>
            <input type="text" name="name" placeholder="Nom" required>
            <input type="text" name="surname" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" name="register" class="btn">S'enregistrer</button>
            <p>Vous avez déjà un compte ? <a href="#" onclick="showLoginForm()">Se connecter</a></p>
        </form>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('registerForm').classList.add('active');
        }

        function showLoginForm() {
            document.getElementById('registerForm').classList.remove('active');
            document.getElementById('loginForm').classList.add('active');
        }

        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById("toggleButton");
            const sidebar = document.getElementById("sidebar");

            toggleButton.addEventListener("click", () => {
                const isHidden = sidebar.classList.contains("hidden");
                if (isHidden) {
                    sidebar.classList.remove("hidden");
                    toggleButton.innerHTML = ">";
                } else {
                    sidebar.classList.add("hidden");
                    toggleButton.innerHTML = "<";
                }
            });
        });
    </script>

    <footer>
        <span>Suggestions</span>
        <span>Conditions d'utilisation</span>
        <span>Copyright 2024-2025</span>
    </footer>
</body>

</html>
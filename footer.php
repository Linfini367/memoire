<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Division Provinciale de l'Économie Nationale - Sud-Kivu/Bukavu</title>
    <link rel="shortcut icon" href="home.png">
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.css">
    <script src="./bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="./bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Index.css">
</head>
  <footer class="mt-5">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Division Provinciale de l'Economie Nationale</h3>
                    <p>La division pronvinciale de l'économie nationale est une institution publique des prestations des services qui œuvrent dans le secteur économique avec comme cibles potentiels les opérateurs économique, producteurs et commerçants et les consommateurs finaux sur le marché.</p>
                </div>
                <div class="footer-section">
                    <h3>Liens Rapides</h3>
                    <a href="#">Accueil</a>
                    <a href="#">Produits</a>
                    <a href="#">Marchés</a>
                    <a href="#">Statistiques</a>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Division Provinciale de l'Économie Nationale</p>
                    <p>Bukavu, Sud-Kivu</p>
                    <p>République Démocratique du Congo</p>
                    <p>Email: info@economiebukavu.cd</p>
                    <p>Tél: +243 99 080 80 17</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Division Provinciale de l'Économie Nationale - Bukavu. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <script>
  // Carrousel d'images en background de la section .hero
  const images = [
    "exposition-sur-le-marche-des-fruits-frais.jpg",
    "marche-de-rue-la-nuit.jpg",
    "plan-moyen-mere-et-enfant-au-marche.jpg",
    "beau-marche-de-rue-au-coucher-du-soleil.jpg"
  ];
  let index = 0;
  const hero = document.querySelector(".hero");

  function changeBackground() {
    hero.style.backgroundImage = `url('${images[index]}')`;
    hero.style.backgroundSize = "cover";
    hero.style.backgroundPosition = "center";
    hero.style.backgroundRepeat = "no-repeat";
    index = (index + 1) % images.length;
  }
  // Afficher la première image
  changeBackground();
  // Changer toutes les 10 secondes
  setInterval(changeBackground, 10000);
</script>
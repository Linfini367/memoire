<!DOCTYPE html>
<html lang="fr">
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
    <link rel="stylesheet" href="new.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="home.png" alt="logo" width="60" height="60">
                <div class="logo-text">
                    <h1>Suivi des variations du Prix</h1>
                    <span>Division Provinciale de l'Économie Nationale</span>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accuel</a></li>
                        <li><a href="Apropos.php">A Propos</a></li>
                        <li><a href="Contact.php">Conctactez-nous</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2 class="page-title">Contactez la Division Provinciale de l'Économie Nationale</h2>
        
        <div class="contact-container">
            <div class="contact-info">
                <h2>Informations de contact</h2>
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <h3>Adresse</h3>
                        <p>La division provinciale de l’économie nationale du Sud-Kivu se situe en République Démocratique du Congo<br>
                           Province du Sud-Kivu<br>
                           Ville de Bukavu, Avenue Bobozo au n° 5, quartier Labotte, commune d’Ibanda, derrière le palais de Justice.</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div class="info-content">
                        <h3>Téléphone</h3>
                        <p>+243 999 999 999<br>
                           +243 888 888 888</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">✉️</div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p>economie.bukavu@gouv.cd<br>
                           contact@economiebukavu.cd</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">🕒</div>
                    <div class="info-content">
                        <h3>Heures de travail</h3>
                        <p>Du Lundi - Vendredi : 8h00 - 16h00<br>
                           Samedi : Fermé<br>
                           Dimanche : Fermé</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h2>Envoyez-nous un message</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" class="form-control" placeholder="Votre nom complet" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" class="form-control" placeholder="Votre adresse email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Sujet du message</label>
                        <input type="text" id="subject" class="form-control" placeholder="Sujet de votre message" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" class="form-control" placeholder="Votre message..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn">Envoyer le message</button>
                </form>
            </div>
        </div>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4082601.691198434!2d26.43096254896476!3d-2.512363312553518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19c5f5d633c00001%3A0x8d258e1b4e8b4c12!2sBukavu%2C%20R%C3%A9publique%20d%C3%A9mocratique%20du%20Congo!5e0!3m2!1sfr!2sfr!4v1648566603123!5m2!1sfr!2sfr" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>À propos de nous</h3>
                    <p>La division pronvinciale de l'économie nationale est une institution publique des prestations des services qui œuvrent dans le secteur économique avec comme cibles potentiels les opérateurs économique, producteurs et commerçants et les consommateurs finaux sur le marché.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    
                    <p><a href="#" style="color: white;">Accueil</a></p>
                    <p><a href="#" style="color: white;">Marchés de Bukavu</a></p>
                    <p><a href="#" style="color: white;">Rapports économiques</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>📞 +243 99 080 80 17</p>
                    <p>✉️ economie.bukavu@gouv.cd</p>
                    <p>📍 Avenue de la Justice, Bukavu</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 Division Provinciale de l'Économie Nationale - Bukavu. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupération des données du formulaire
            const name = encodeURIComponent(document.getElementById('name').value);
            const email = encodeURIComponent(document.getElementById('email').value);
            const subject = encodeURIComponent(document.getElementById('subject').value);
            const message = encodeURIComponent(document.getElementById('message').value);
            
            // Construction du message formaté pour WhatsApp
            const formattedMessage = 
                `*Nouveau message de contact*%0A%0A` +
                `👤 *Nom:* ${name}%0A` +
                `📧 *Email:* ${email}%0A` +
                `📝 *Sujet:* ${subject}%0A` +
                `💬 *Message:* ${message}`;
            
            // Numéro WhatsApp de laDivision  (remplacer par le bon numéro)
            const phoneNumber = "243981301683";
            
            // Création du lien WhatsApp
            const whatsappURL = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${formattedMessage}`;
            
            // Ouverture de WhatsApp dans un nouvel onglet
            window.open(whatsappURL, '_blank');
            
            // Message de confirmation
            alert('Vous allez être redirigé vers WhatsApp pour envoyer votre message.');
            
            // Réinitialisation du formulaire
            this.reset();
        });
    </script>
</body>
</html>
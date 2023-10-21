// Sélectionnez les liens et le conteneur du contenu
const lien1 = document.getElementById('lien1');
const lien2 = document.getElementById('lien2');
const lien3 = document.getElementById('lien3');
const lien4 = document.getElementById('lien4');


const contenu = document.getElementById('contenu');

// Ajoutez des gestionnaires d'événements pour les liens

lien1.addEventListener('click', () => {
    fetch('menu.php') // Remplacez 'lien1.php' par le chemin vers votre script PHP
    .then(response => response.text())
    .then(data => {
        contenu.innerHTML = data;
    });
});

lien2.addEventListener('click', () => {
    fetch('client.php') // Remplacez 'lien1.php' par le chemin vers votre script PHP
    .then(response => response.text())
    .then(data => {
        contenu.innerHTML = data;
    });
});

lien3.addEventListener('click', () => {
    fetch('cles.php') // Remplacez 'lien1.php' par le chemin vers votre script PHP
    .then(response => response.text())
    .then(data => {
        contenu.innerHTML = data;
    });
});

lien4.addEventListener('click', () => {
    fetch('settings.php') // Remplacez 'lien1.php' par le chemin vers votre script PHP
    .then(response => response.text())
    .then(data => {
        contenu.innerHTML = data;
    });
});
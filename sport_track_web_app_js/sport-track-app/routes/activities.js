var express = require('express');
var calculDistanceTrajet = require('../utils/fonctions');
var router = express.Router();

/**
 * Gère la requête GET pour afficher la page affichant les activités de l'utilisateur.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si ce n'est pas le cas, elle redirige l'utilisateur vers la page d'accueil car 
 * il y a eu une tentative de connexion sans passer par la page de connexion.
 * Sinon, elle récupère les activités de l'utilisateur à partir de la base de données
 * et formate les données pour chaque activité afin de les afficher dans un tableau.
 * 
 * @async
 * @function
 * @name getActivities
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.get('/', async function(req, res, next) {
    if (req.session.identifiant == null) {
        res.redirect('/');
    } else {
        const dbModule = await import('sport-track-db');
        const userID = req.session.identifiant;
        let table = [];
        const activities = await dbModule.activity_model.findAll({ where: { idUser: userID } });
        for (const currentActivity of activities) {
            let aFormatter = currentActivity.dateActivity;
            let [annee, jour, mois] = aFormatter.split('-');
            let laDate = `${jour}/${mois}/${annee}`;

            let lesDonnees = await dbModule.activity_entry_model.findAll({ where: { idActivity: currentActivity.idActivity } });
            let debut = lesDonnees[0].timeActivityEntry;
            let fin = lesDonnees[lesDonnees.length - 1].timeActivityEntry;
            let leJour = new Date().toISOString().split('T')[0];
            let leDebut = new Date(`${leJour}T${debut}`);
            let laFin = new Date(`${leJour}T${fin}`);
            let laDifference = laFin - leDebut;
            let secondes = Math.floor((laDifference / 1000) % 60);
            let minutes = Math.floor((laDifference / (1000 * 60)) % 60);
            let heures = Math.floor((laDifference / (1000 * 60 * 60)) % 24);
            let dureeParcours = `${String(heures).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secondes).padStart(2, '0')}`;

            let lesDonneesGPS = [];
            for (const laDonnee of lesDonnees) {
                let formatDonneesGPS = { latitude: laDonnee.latitudeActivityEntry, longitude: laDonnee.longitudeActivityEntry };
                lesDonneesGPS.push(formatDonneesGPS);
            }
            let distanceParcourue = calculDistanceTrajet(lesDonneesGPS);
            
            let lesDonneesCardiologiques = [];
            for (const laDonnee of lesDonnees) {
                lesDonneesCardiologiques.push(laDonnee.cardioActivityEntry);
            }
            let cardioMin = Math.min(...lesDonneesCardiologiques);
            let cardioMax = Math.max(...lesDonneesCardiologiques);
            let sommeCardio = lesDonneesCardiologiques.reduce((acc, curr) => acc + curr, 0);
            let quantiteCardio = lesDonneesCardiologiques.length;
            let cardioMoy = sommeCardio / quantiteCardio;

            table.push([
                currentActivity.descriptionActivity,
                laDate,
                lesDonnees[0].timeActivityEntry,
                dureeParcours,
                distanceParcourue,
                cardioMin,
                cardioMax,
                cardioMoy
            ]);
        }
        res.render('activities', { maTable: table } );
    }
});

module.exports = router;
var express = require('express');
var formidable = require('formidable');
var fs = require('fs');
var path = require('path');
var router = express.Router();

/**
 * Gère la requête GET pour afficher la page du formulaire de téléversement.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si c'est le cas, elle affiche la page du formulaire de téléversement.
 * Sinon, elle redirige l'utilisateur vers la page d'accueil car 
 * il y a eu une tentative de connexion sans passer par la page de connexion.
 * 
 * @function
 * @name getUpload
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.get('/', function(req, res, next) {
    if (req.session.identifiant == null) {
        res.redirect('/');
    } else {
        if (req.session.prenom) {
            res.render('upload_form', { title: req.session.prenom });
        } else {
            res.render('upload_form', { title: "ERROR" });
        }
    }
  });

/**
 * Gère la requête POST pour afficher la page du formulaire de téléversement.
 * La fonction récupère les données fournies dans le fichier JSON passé en paramètre au formulaire
 * et enrengistre des activités et des données associées à ses activités dans la base de données 
 * pour l'utilisateur actuellement connecté puis recharge la page du formulaire de téléversement.
 * Si une erreur (pas de fichier, mauvais format, etc) est rencontrée, la page du formulaire
 * de téléversement est rechargée avec le message adéquat et n'enrengistre pas les activités
 * et les données associées à ses activités dans la base de données pour l'utilisateur actuellement
 * connecté.
 * 
 * @async
 * @function
 * @name postConnect
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.post('/', async function(req, res, next) {
    let dbModule = await import('sport-track-db');
    let form = new formidable.IncomingForm();
    form.parse(req, (err, fields, files) => {
        if (err) {
            res.render('upload_form', { title: req.session.prenom, resultatTraitement: "Erreur lors du parsage du fichier" });
        }
        if (files.JSON !== undefined) {
            let fichier = files.JSON[0];
            if (fichier && path.extname(fichier.originalFilename) === '.json') {
                let cheminFichier = fichier.filepath;
                fs.readFile(cheminFichier, 'utf8', async (err, data) => {       
                    if (err) {
                        res.render('upload_form', { title: req.session.prenom, resultatTraitement: "Erreur lors de la lecture du fichier" });
                    }
                    try {
                        let donneesJSON = JSON.parse(data);
                        let activityDate = donneesJSON.activity?.date;
                        let activityDescription = donneesJSON.activity?.description;

                        let maxActivityID = await dbModule.activity_model.max('idActivity');
                        let newActivityID = maxActivityID ? maxActivityID + 1 : 1;

                        await dbModule.activity_model.create({
                            idActivity: newActivityID,
                            dateActivity: activityDate,
                            descriptionActivity: activityDescription,
                            idUser: req.session.identifiant
                        });

                        let activityEntryData = donneesJSON.data;
                        for (let currentEntry of activityEntryData) {
                            let maxActivityEntryID = await dbModule.activity_entry_model.max('idActivityEntry');
                            let newActivityEntryID = maxActivityEntryID ? maxActivityEntryID + 1 : 1;

                            let activityEntryTime = currentEntry.time;
                            let activityEntryCardioFrequency = currentEntry.cardio_frequency;
                            let activityEntryLatitude = currentEntry.latitude;
                            let activityEntryLongitude = currentEntry.longitude;
                            let activityEntryAltitude = currentEntry.altitude;
                            await dbModule.activity_entry_model.create({
                                idActivityEntry: newActivityEntryID,
                                timeActivityEntry: activityEntryTime,
                                cardioActivityEntry: activityEntryCardioFrequency,
                                latitudeActivityEntry: activityEntryLatitude,
                                longitudeActivityEntry: activityEntryLongitude,
                                altitudeActivityEntry: activityEntryAltitude,
                                idActivity: newActivityID
                            });
                        };
                        res.render('upload_form', { title: req.session.prenom, resultatTraitement: "Réussite de l'envoi" });
                    } catch (error) {
                        res.render('upload_form', { title: req.session.prenom, resultatTraitement: "Echec de l'envoi, données erronées" });
                    }
                });
            } else {
                res.render('upload_form', { title: req.session.prenom, resultatTraitement: "Echec de l'envoi, format du fichier invalide" });
            }
        }
    });
});

module.exports = router;
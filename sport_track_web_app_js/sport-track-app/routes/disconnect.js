var express = require('express');
var router = express.Router();

/**
 * Gère la requête GET pour la page de déconnexion.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si c'est le cas, elle affiche la page de déconnexion.
 * Sinon, elle redirige l'utilisateur vers la page d'accueil car 
 * il y a eu une tentative de connexion sans passer par la page de connexion.
 * 
 * @function
 * @name getDisconnect
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.get('/', function(req, res, next) {
  if (req.session.identifiant == null) {
    res.redirect('/');
  } else {
    res.render('disconnect_form');
  }
});

module.exports = router;

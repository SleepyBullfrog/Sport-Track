var express = require('express');
var router = express.Router();

/**
 * Gère la requête GET pour la page d'accueil.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si c'est le cas, elle le détruit et elle efface le cookie de session.
 * Ensuite, elle affiche la page d'accueil avec le titre "Sport-Track".
 * 
 * @function
 * @name getIndex
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.get('/', function(req, res, next) {
  if (req.session.identifiant != null) {
    req.session.destroy();
    res.clearCookie('sessionCookie');
  }
  res.render('index', { title: 'Sport-Track' });
});

module.exports = router;

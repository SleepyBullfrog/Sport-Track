var bcrypt = require('bcrypt');
var express = require('express');
var router = express.Router();

/**
 * Gère la requête GET pour la page de connexion.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si c'est le cas, elle le détruit et elle efface le cookie de session.
 * Ensuite, elle affiche la page de connexion.
 * 
 * @function
 * @name getConnect
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
  res.render('connect_form');
});

/**
 * Gère la requête POST pour la page de connexion.
 * La fonction permet de chercher dans la base de données un utilisateur 
 * existant dans la base de données et correspondant aux données passées 
 * en paramètre au formulaire.
 * Si un utilisateur est trouvé dans la base de données, elle affiche une
 * page de validation de connexion permettant d'accepter la connexion après 
 * avoir créé un identifiant de session et associé un prénom à cette session.
 * Sinon, elle affiche la page de validation de connexion avec un message d'erreur
 * relatant que les données fournies sont invalides.
 * L'état de réussite ou d'échec est représenté par buttonState.
 * Si buttonState == true alors réussite, sinon échec.
 * En effet, la valeur de buttonState détermine ce qui est montré par connect_form_valid.pug
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
  const dbModule = await import('sport-track-db');
  const { email, passwd } = req.body;
  try {
    /* Manipulation sur la base de données */
    const existingUser = await dbModule.user_model.findOne({ where: { emailUser: email } });
    if (existingUser !== null) {
      const userpasswd = await existingUser.get("passwordUser");
      bcrypt.compare(passwd, userpasswd, function(err, isMatch) {
        if (err) {
          res.render('connect_form_valid', { buttonState: false });
        } else if (isMatch) {
          req.session.identifiant = existingUser.get("idUser");
          req.session.prenom = existingUser.get("firstNameUser");
          res.render('connect_form_valid', { buttonState: true });
        } else {
          res.render('connect_form_valid', { buttonState: false });
        }
      });
    } else {
      res.render('connect_form_valid', { buttonState: false });
    }
  } catch (error) {
    console.error(error);
    res.render('connect_form_valid', { buttonState: false });
  }
});

module.exports = router;
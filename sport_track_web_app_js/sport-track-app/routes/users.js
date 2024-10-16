var bcrypt = require('bcrypt');
var express = require('express');
var router = express.Router();

/**
 * Gère la requête GET pour la page d'inscription.
 * La fonction vérifie si l'identifiant de session est défini.
 * Si c'est le cas, elle le détruit et elle efface le cookie de session.
 * Ensuite, elle affiche la page d'inscription.
 * 
 * @function
 * @name getUsers
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
  res.render('user_form_create');
});

/**
 * Gère la requête POST pour la page d'inscription.
 * La fonction permet de créer un compte utilisateur et de l'enrengistrer 
 * dans une base de données.
 * Si une erreur est rencontrée, elle affiche la page d'inscription avec 
 * le message d'erreur adéquat et n'enrengistre pas le compte utilisateur.
 * Sinon, elle affiche la page d'inscription avec un message invitant à 
 * se connecter après avoir enrengistrer le compte utilisateur.
 * 
 * @async
 * @function
 * @name postUsers
 * @param {Object} req - L'objet de requête Express
 * @param {Object} res - L'objet de réponse Express
 * @param {Function} next - La fonction pour passer au middleware suivant
 * @returns {void}
 */
router.post('/', async function(req, res, next) {
  const dbModule = await import('sport-track-db');
  const { nom, prenom, birth, gender, height, weight, email, passwd, 'passwd-confirm': passwdConfirm } = req.body;
  if (passwd !== passwdConfirm) {
    res.render('user_form_valid', { message: "Les mots de passe ne correspondent pas, vérifiez à ce qu'ils soient les mêmes!" });
  }
  try {
    // Manipulation de la base de données
    const existingUser = await dbModule.user_model.findOne({ where: { emailUser: email } });
    if (existingUser !== null) {
      res.render('user_form_valid', { message: "L'adresse e-mail utilisée existe déjà, utilisez une autre!" });
    }
    const hashedPassword = await bcrypt.hash(passwd, 10);

    const maxID = await dbModule.user_model.max('idUser');
    const newID = maxID ? maxID + 1 : 1;

    await dbModule.user_model.create({
      idUser: newID,
      emailUser: email,
      nameUser: nom,
      firstNameUser: prenom,
      birthdateUser: birth,
      genderUser: gender,
      heightUser: height,
      weightUser: weight,
      passwordUser: hashedPassword
  });
    res.render('user_form_valid', { message: "L'utilisateur a été créé! Vous pouvez vous y connecter via la page de connexion." });
  } catch (error) {
    console.error(error);
    res.render('user_form_valid', { message: "Un problème a été rencontré lors de la manipulation de la base de données!" });
  }
});

module.exports = router;

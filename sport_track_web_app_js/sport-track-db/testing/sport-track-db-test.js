import { Sequelize } from 'sequelize';
import { user_model, activity_model, activity_entry_model } from '../index.js'; 
const sequelize = new Sequelize({
    dialect: 'sqlite'
});

(async () => {
    try {
        // Création d'un utilisateur
        const user = await user_model.create({
            emailUser: "nathan.guheneuf@gmail.com",
            nameUser: "Guhéneuf-Le Brec",
            firstNameUser: "Nathan",
            birthdateUser: "2006-06-04",
            genderUser: "Homme",
            heightUser: 187,
            weightUser: 80,
            passwordUser: "6dcd4ce23d88e2ee9568ba546c007c63d62f5e320c77d53d588f4d80f2f964b"
        });
        console.log("Nouveau utilisateur créé", user.toJSON());
        
        // Création d'une activité pour l'utilisateur
        const activity = await activity_model.create({
            dateActivity: "1900-01-01",
            descriptionActivity: "TEST",
            idUser: user.idUser
        });
        console.log("Nouvelle activitée créée", activity.toJSON());

        // Création d'un jeu de données pour l'activité
        const activityEntry = await activity_entry_model.create({
            timeActivityEntry: "12:00:00",
            cardioActivityEntry: 80,
            latitudeActivityEntry: 50,
            longitudeActivityEntry: 50,
            altitudeActivityEntry: 50,
            idActivity: activity.idActivity
        });
        console.log("Nouveau jeu de données créé", activityEntry.toJSON());

        // On récupère tous les utilisateurs de la base de données
        const users = await user_model.findAll();
        console.log("L'ensemble des utilisateurs dans la base de données:", JSON.stringify(users, null, 2));

        // On récupère toutes les activités de la base de données
        const activities = await activity_model.findAll();
        console.log("L'ensemble des activitées de la base de données:", JSON.stringify(activities, null, 2));

        // On recupère tous les jeux de données de la base de données
        const activityEntries = await activity_entry_model.findAll();
        console.log("L'ensemble des jeux de données de la base de données:", JSON.stringify(activityEntries, null, 2));

        // On récupère un unique utilisateur
        const foundUser = await user_model.findByPk(user.idUser);
        console.log("L'unique utilisateur sélectionné dans la base de données:", foundUser.toJSON());

        // On récupère une unique activité
        const foundActivity = await activity_model.findByPk(activity.idActivity);
        console.log("L'unique activité sélectionnée dans la base de données:", foundActivity.toJSON());

        // On récupère un unique jeu de données
        const foundActivityEntry = await activity_entry_model.findByPk(activityEntry.idActivityEntry);
        console.log("L'unique jeu de données sélectionné dans la base de données:", foundActivityEntry.toJSON());

        // Mise à jour de l'utilisateur
        await user.update({
            emailUser: "error.error@error.error",
            nameUser: "ERROR",
            firstNameUser: "ERROR",
            birthdateUser: "1900-01-01",
            genderUser: "Autre",
            heightUser: 1,
            weightUser: 1,
            passwordUser: "00000000"
        });
        console.log("Utilisateur modifié avec succès:", user.toJSON());

        // Mise à jour de l'activité
        await activity.update({
            descriptionActivity: "EMPTY"
        });
        console.log("Activitée modifiée avec succès:", activity.toJSON());

        // Mise à jour du jeu de données
        await activityEntry.update({
            timeActivityEntry: "00:00:00",
            cardioActivityEntry: 1
        });
        console.log("Jeu de données modifié avec succès:", activityEntry.toJSON());

        // Les effacements sont effectués dans cet ordre pour éviter de déclencher l'option d'effacement en cascade de nos tables

        // Effacement du jeu de données
        await activityEntry.destroy();
        console.log("Jeu de données effacé");

        // Effacement de l'activité
        await activity.destroy();
        console.log("Activitée effacée");

        // Effacement de l'utilisateur
        await user.destroy();
        console.log("Utilisateur effacé");

    } catch (error) {
        console.error("Une erreur s'est produite", error);
    } finally {
        await sequelize.close();
        console.log("Connexion à la base de données fermée")
    }
})();
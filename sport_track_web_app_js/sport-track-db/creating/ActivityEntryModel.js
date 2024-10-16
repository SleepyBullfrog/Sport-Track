import { Sequelize, DataTypes, Model } from 'sequelize';
const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database/sport-track.sqlite'
});

class ActivityEntry extends Model {}

ActivityEntry.init(
    {
        idActivityEntry: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true
        },
        timeActivityEntry: {
            // pas de type "heure" en sequelize, on va avoir besoin de créer des fonctions pour vérifier la donnée stockée sous forme de string
            type: DataTypes.STRING,
            allowNull: false,
            validate: {
                // format de la chaîne de caractères
                isCorrectTimeFormat(value) {
                    const regex = /^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
                    // Heures : [0-1]|0-9]|2[0-3] gère de 00 à 19 OU de 20 à 23
                    // Minutes : [0-5][0-9] gère de 00 à 59
                    // Secondes : [0-5][0-9] gère de 00 à 59
                    if (!regex.test(value)) {
                        throw new Error("L'horaire doit être stocké au format HH:MM:SS");
                    }
                },
                // contenu de la chaîne de caractères
                isValidTimeRange(value) {
                    const chaine = value.split(':');
                    // deuxième paramètre de parseInt est 10 car on convertit la chaîne en base 10
                    const heures = parseInt(chaine[0], 10);
                    const minutes = parseInt(chaine[1], 10);
                    const secondes = parseInt(chaine[2], 10);
                    if (heures < 0 || heures > 23 || minutes < 0 || minutes > 59 || secondes < 0 || secondes > 59) {
                        throw new Error("L'horaire doit être situé entre 00:00:00 et 23:59:59");
                    }
                }
            }
        },
        cardioActivityEntry: {
            type: DataTypes.INTEGER,
            allowNull: false,
            validate: {
                min: 1
            }
        },
        latitudeActivityEntry: {
            type: DataTypes.REAL,
            allowNull: false
        },
        longitudeActivityEntry: {
            type: DataTypes.REAL,
            allowNull: false
        },
        altitudeActivityEntry: {
            type: DataTypes.INTEGER,
            allowNull: false
        },
        idActivity: {
            type: DataTypes.INTEGER,
            allowNull: false,
            references: {
                model: 'Activity',
                key: 'idActivity'
            },
            onDelete: 'CASCADE'
        }
    },
    {
        sequelize,
        modelName: 'ActivityEntry',
        tableName: 'ActivityEntry',
        timestamps: false
    }
);

await sequelize.authenticate();
await sequelize.sync();
export default ActivityEntry;

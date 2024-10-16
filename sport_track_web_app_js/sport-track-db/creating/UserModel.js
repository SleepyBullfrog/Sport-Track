import { Sequelize, DataTypes, Model } from 'sequelize';
const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database/sport-track.sqlite'
});

class User extends Model {}

User.init(
    {
        idUser: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true
        },
        emailUser: {
            type: DataTypes.STRING,
            allowNull: false,
            unique: true,
            validate: {
                isEmail: true
            }
        },
        nameUser: {
            type: DataTypes.STRING,
            allowNull: false
        },
        firstNameUser: {
            type: DataTypes.STRING,
            allowNull: false
        },
        birthdateUser: {
            type: DataTypes.DATEONLY,
            allowNull: false,
            validate: {
                isDate: true,
                isAfter: "1899-12-31",
                isBefore: new Date().toISOString().split('T')[0]
            }
        },
        genderUser: {
            type: DataTypes.STRING,
            allowNull: false,
            validate: {
                isIn: [["Homme", "Femme", "Autre", "Ne souhaite pas partager"]]
            }
        },
        heightUser: {
            type: DataTypes.INTEGER,
            allowNull: false,
            validate: {
                min: 1
            }
        },
        weightUser: {
            type: DataTypes.INTEGER,
            allowNull: false,
            validate: {
                min: 1
            }
        },
        passwordUser: {
            type: DataTypes.STRING,
            allowNull: false,
            validate: {
                len: [8]
            }
        }
    },
    {
        sequelize,
        modelName: 'User',
        tableName: 'User',
        timestamps: false
    }
);

await sequelize.authenticate();
await sequelize.sync();
export default User;

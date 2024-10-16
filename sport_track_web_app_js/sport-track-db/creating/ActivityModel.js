import { Sequelize, DataTypes, Model } from 'sequelize';
const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database/sport-track.sqlite'
});

class Activity extends Model {}

Activity.init(
    {
        idActivity: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true
        },
        dateActivity: {
            type: DataTypes.DATEONLY,
            allowNull: false,
            validate: {
                isDate: true,
                isAfter: "1899-12-31",
                isBefore: new Date().toISOString().split('T')[0]
            }
        },
        descriptionActivity: {
            type: DataTypes.STRING,
            allowNull: false,
            validate: {
                len: [1, 250]
            }
        },
        idUser: {
            type: DataTypes.INTEGER,
            allowNull: false,
            references: {
                model: 'User',
                key: 'idUser'
            },
            onDelete: 'CASCADE'
        },
    },
    {
        sequelize,
        modelName: 'Activity',
        tableName: 'Activity',
        timestamps: false
    }
);

await sequelize.authenticate();
await sequelize.sync();
export default Activity;

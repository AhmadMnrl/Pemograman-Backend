import { DataTypes } from "sequelize";
import sequelize from "../config/database.js";

const Student = sequelize.define("User",{
    username : {
        type: DataTypes.STRING,
        allowNull: false
    },
    email : {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    },
    password : {
        type: DataTypes.STRING,
        allowNull: false,
    },
});

try {
    await Student.sync();
    console.log("The table user was Created")
} catch (error) {
    console.error("Cannot Create Table: ", error)
}

export default Student;

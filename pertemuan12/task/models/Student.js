import sequelize from "../config/database.js";
import { DataTypes } from "sequelize";

const Student = sequelize.define("Student",{
    nama : {
        type: DataTypes.STRING,
        allowNull: false
    },
    nim : {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    },
    email : {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    },
    jurusan : {
        type: DataTypes.STRING,
        allowNull: false
    }
});

try {
    await Student.sync();
    console.log("The table student was Created")
} catch (error) {
    console.error("Cannot Create Table: ", error)
}

export default Student;
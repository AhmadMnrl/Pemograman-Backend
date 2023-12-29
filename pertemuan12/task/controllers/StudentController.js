import Student from "../models/Student.js";
import { validationResult } from 'express-validator';

class StudentController {
    async index(req, res) {
        const students = await Student.findAll();

        const data = {
        message: "Menampilkkan semua students" ,
        data: students,
        };

        res. json(data);
    }
    async store(req, res) {
        try {
            const errors = validationResult(req);
            if (!errors.isEmpty()) {
              return res.status(400).json({ errors: errors.array() });
            }
            const { nama, nim, email, jurusan } = req.body;
            const newStudent = await Student.create({
                nama,
                nim,
                email,
                jurusan,
            });
        
            const data = {
                message: "Menambahkan data student",
                data: newStudent,
            };
        
            res.json(data);
            } catch (error) {
            console.error("Error while creating student:", error);
            res.status(500).json({ error: "Internal Server Error" });
            }
    }
      
}

export default new StudentController;
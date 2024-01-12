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
    async update (req, res) {
        try {
          const { id } = req.params;
      
          const student = await Student.findByPk(id);
      
          if (student) {
            const condition = {
              where: {
                id: id,
              },
            };
      
            const Student = await Student.update(req.body, condition);
      
            const data = {
              message: "Mengedit data student",
              data: Student,
            };
      
            res.status(200).json(data);
          } else {
            const data = {
              message: "Student not found",
            };
            res.status(404).json(data);
          }
        } catch (error) {
          console.error("Error in update Student:", error);
          res.status(500).json({ message: "Internal Server Error" });
        }
    }
    async destroy(req, res) {
        try {
          const { id } = req.params;
      
          const student = await Student.findByPk(id);
      
          if (student) {
            const condition = {
              where: {
                id: id,
              },
            };
      
            await Student.destroy(condition);
      
            const data = {
              message: "Menghapus data student",
            };
      
            res.status(200).json(data);
          } else {
            const data = {
              message: "Student not found",
            };
            
            return res.status(404).json(data);
          }
        } catch (error) {
          console.error("Error in destroy:", error);
          res.status(500).json({ message: "Internal Server Error" });
        }
    }
    async show(req, res) {
        try {
          const { id } = req.params;
      
          const student = await Student.findByPk(id);
      
          if (student) {
            const data = {
              message: "Detail student",
              data: student,
            };
      
            res.status(200).json(data);
          } else {
            const data = {
              message: "Student not found",
            };
      
            res.status(404).json(data);
          }
        } catch (error) {
          console.error("Error in show:", error);
          res.status(500).json({ message: "Internal Server Error" });
        }
    }
        
      
}

export default new StudentController;
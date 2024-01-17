import { Op } from "sequelize";
import Student from "../models/Student.js";

class StudentController {
    async index(req, res) {
      try {
        // Mendapatkan query parameters
        const { nama, jurusan, sort, order, page = 1, pageSize = 10 } = req.query;

        // Membuat objek yang akan digunakan untuk konfigurasi sorting
        const orderConfig = sort && order ? [[sort, order.toUpperCase()]] : [];

        // Membuat objek yang akan digunakan untuk konfigurasi filtering
        const whereConfig = {};
        if (nama) {
            whereConfig.nama = { [Op.like]: `%${nama}%` };
        }
        if (jurusan) {
            whereConfig.jurusan = jurusan;
        }

        // Menghitung offset berdasarkan halaman dan jumlah data per halaman
        const offset = (page - 1) * pageSize;

        // Mengambil data students dengan konfigurasi sorting, filtering, dan paginasi
        const students = await Student.findAndCountAll({
            where: whereConfig,
            order: orderConfig,
            offset: offset,
            limit: parseInt(pageSize),
        });

        const totalPages = Math.ceil(students.count / pageSize);

        const data = {
            message: "Menampilkan semua students",
            data: students.rows,
            page: parseInt(page),
            pageSize: parseInt(pageSize),
            totalData: students.count,
            totalPages: totalPages,
        };

        res.json(data);
      } catch (error) {
          console.error("Error fetching students: ", error);
          return res.status(500).json({ message: "Internal Server Error" });
      }
    }
    async store(req, res) {
        try {
            const { nama, nim, email, jurusan } = req.body;

            if (!nama || !nim || !email || !jurusan) {
              const data = {
              message: "Semua data harus dikirim",
            };
            return res.status(422). json(data);
            }
            const student = await Student.create(req.body);

            const data = {
              message: "Menambahkan data student",
              data: student,
            };
            return res.status(201). json(data);
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
      
            const student = await Student.update(req.body, condition);
      
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
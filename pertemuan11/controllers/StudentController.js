import studentModel from '../models/student.js';

class StudentController {
    // TODO 4: Tampilkan data students
    index(req, res) {
      const data = studentModel.getAllStudents();
      res.json({ message: "Menampilkan semua Student", data });
    }
  
    // TODO 5: Tambahkan data students
    store(req, res) {
      const { name } = req.body;
      studentModel.addStudent(name);
      res.json({ message: `Menambahkan data Student: ${name}`, data: studentModel.getAllStudents() });
    }
  
    // TODO 6: Update data students
    update(req, res) {
      const { id } = req.params;
      const { newName } = req.body;
      const success = studentModel.editStudent(id, newName);
      if (success) {
        res.json({ message: `Mengedit Student dengan id ${id}, nama menjadi ${newName}`, data: studentModel.getAllStudents() });
      } else {
        res.status(404).json({ message: "Student tidak ditemukan" });
      }
    }
  
    // TODO 7: Hapus data students
    destroy(req, res) {
      const { id } = req.params;
      const success = studentModel.deleteStudent(id);
      if (success) {
        res.json({ message: `Menghapus Student dengan id ${id}`, data: studentModel.getAllStudents() });
      } else {
        res.status(404).json({ message: "Student tidak ditemukan" });
      }
    }
  }

const studentController = new StudentController();
export default studentController;

import express from 'express';
import studentController from '../controllers/StudentController.js';

const router = express.Router();

// TODO 4: Tampilkan data students
router.get("/students", studentController.index);

// TODO 5: Tambahkan data students
router.post("/students", studentController.store);

// TODO 6: Update data students
router.put("/students/:id", studentController.update);

// TODO 7: Hapus data students
router.delete("/students/:id", studentController.destroy);

export default router;
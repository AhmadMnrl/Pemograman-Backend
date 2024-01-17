import express from "express";
import StudentController from '../controllers/StudentController.js';
import AuthController from '../controllers/AuthController.js';
import auth from '../middleware/auth.js';

const router = express.Router()

router.use((req, res, next) => {
    res.status(404).json({ message: "Not Found" });
});

router.use('/students', auth);

router.get('/students', StudentController.index);
router.get('/students/:id', StudentController.show);
router.post('/students', StudentController.store);
router.put('/students/:id', StudentController.update);
router.delete('/students/:id', StudentController.destroy);

router.post('/register', AuthController.register);
router.post('/login', AuthController.login);
export default router;

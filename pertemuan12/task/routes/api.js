import  express  from "express"
const router = express.Router()


import StudentController from '../controllers/StudentController.js'
router.get('/students',StudentController.index);
router.get('/students/:id',StudentController.show);
router.post('/students',StudentController.store);
router.put('/students/:id',StudentController.update);
router.delete('/students/:id',StudentController.destroy);

export default router;
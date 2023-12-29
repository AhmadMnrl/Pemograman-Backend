import  express  from "express"
const router = express.Router()


import StudentController from '../controllers/StudentController.js'
router.get('/students',StudentController.index);
router.post('/students',StudentController.store);

export default router;
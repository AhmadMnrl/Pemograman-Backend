import express from "express";
import StudentController from '../controllers/StudentController.js';
import AuthController from '../controllers/AuthController.js';
import auth from '../middleware/auth.js';

const app = express();

app.use('/students', auth);

app.get('/students', StudentController.index);
app.get('/students/:id', StudentController.show);
app.post('/students', StudentController.store);
app.put('/students/:id', StudentController.update);
app.delete('/students/:id', StudentController.destroy);

app.post('/register', AuthController.register);
app.post('/login', AuthController.login);
export default app;

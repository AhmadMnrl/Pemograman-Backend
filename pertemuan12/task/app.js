import express from "express";
import routes from "./routes/api.js";
import dotenv from 'dotenv';

dotenv.config();

const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(routes);

const port = process.env.APP_PORT;
app.listen(port, () => {
    console.log("Server Berjalan di http://localhost:" + port);
});

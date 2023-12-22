import express from "express";
import routes from "./routes/studentRoute.js";

const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.use(routes);

app.listen(port, () => {
    console.log(`Server Berjalan di http://localhost:${port}`);
});

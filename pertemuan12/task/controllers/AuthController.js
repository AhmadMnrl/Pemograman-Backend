import jwt from "jsonwebtoken";
import bcrypt from "bcrypt";
import User from "../models/User.js";

class AuthController {
    async register(req, res){
        try {
            const { username, email, password } = req.body;
              // Validasi: Periksa apakah username, email, dan password ada
            if (!username || !email || !password) {
                return res.status(422).json({ message: "Please provide username, email, and password" });
            }

            // Validasi: Periksa panjang username minimal 3 karakter
            if (username.length < 3) {
                return res.status(422).json({ message: "Username must be at least 3 characters long" });
            }

            // Validasi: Periksa apakah email memiliki format yang valid
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return res.status(422).json({ message: "Please provide a valid email address" });
            }

            // Validasi: Periksa panjang password minimal 6 karakter
            if (password.length < 5) {
                return res.status(422).json({ message: "Password must be at least 5 characters long" });
             }
            const hash = await bcrypt.hash(password, 10);
            
            const newUser = await User.create({
                username: username,
                email: email,
                password: hash,
            });

            const response = {
                message: "User created successfully",
                data: newUser,
            };

            return res.status(201).json(response);
        } catch (error) {
        console.error("Error creating user: ", error);
        return res.status(500).json({ message: "Internal Server Error" });
        }
    }
    async login(req, res){
        try {
            const { username, password } = req.body;

            const user = await User.findOne({ where: { username: username } });
            const match = await bcrypt.compare(password, user.password);
            
            if (!user || !match) {
                const response = {
                message: "Authentication Failed",
                };
                return res.status(401).json(response);
            }

            const payload = {
                id: user.id,
                username: user.username,
            };
            
            const secret = process.env.TOKEN_SECRET;
            const token = jwt.sign(payload, secret, { expiresIn: "1h" });
            
            const response = {
                message: "Login Success",
                data: {
                token: token,
                },
            };
            
            return res.status(200).json(response);
        } catch (error) {
          console.error("Error Authentication: ", error);
          return res.status(500).json({ message: "Internal Server Error" });
        }
        
    }
}

const auth = new AuthController();
export default auth;
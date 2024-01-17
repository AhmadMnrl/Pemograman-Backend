import jwt from 'jsonwebtoken';

const auth = (req, res, next) => {
  const authorization = req.get("Authorization");

  const token = authorization && authorization.split(" ")[1];

  if (!authorization) {
    const response = {
      message: "Please Provide Token",
    };
    return res.status(401).json(response);
  }

  try {
    const decoded = jwt.verify(token, process.env.TOKEN_SECRET);
    req.user = decoded;
    next();
  } catch (error) {
    const response = {
      message: "Authentication Failed",
    };
    res.status(401).json(response);
  }
};

export default auth;

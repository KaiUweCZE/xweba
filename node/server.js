const express = require("express");
const session = require("express-session");
const bodyParser = require("body-parser");

const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.json());
app.use(
  session({
    secret: "mysecretkey",
    resave: false,
    saveUninitialized: true,
  })
);

app.use((req, res, next) => {
  if (!req.session.users) {
    req.session.users = [];
    req.session.nextId = 1;
  }
  next();
});

// get all users
app.get("/get", (req, res) => {
  res.json(req.session.users);
});

// get specific user
app.get("/get/:id", (req, res) => {
  const user = req.session.users.find((u) => u.id === parseInt(req.params.id));
  if (!user) {
    return res.status(404).json({ error: "User not found" });
  }
  res.json(user);
});

// POST /post - uloží uživatele
app.post("/post", (req, res) => {
  console.log("Received POST request to /post");
  console.log("Request body:", req.body);

  const { id, name, surname } = req.body;
  if (!id || !name || !surname) {
    console.log("Validation failed: missing id, name or surname");
    return res.status(400).json({ error: "Id, name and surname are required" });
  }

  const newUser = {
    id: parseInt(id),
    name,
    surname,
  };

  req.session.users.push(newUser);
  console.log("Current users in session:", req.session.users);
  res.status(201).json(newUser);
});

// update specific user
app.post("/update/:id", (req, res) => {
  const { name, surname } = req.body;
  const userId = parseInt(req.params.id);

  if (!name || !surname) {
    return res.status(400).json({ error: "Name and surname are required" });
  }

  const userIndex = req.session.users.findIndex((u) => u.id === userId);
  if (userIndex === -1) {
    return res.status(404).json({ error: "User not found" });
  }

  req.session.users[userIndex] = {
    id: userId,
    name,
    surname,
  };

  res.json(req.session.users[userIndex]);
});

// DELETE /delete/:id - smaže uživatele s daným id
app.delete("/delete/:id", (req, res) => {
  const userId = parseInt(req.params.id);
  const userIndex = req.session.users.findIndex((u) => u.id === userId);

  if (userIndex === -1) {
    return res.status(404).json({ error: "User not found" });
  }

  req.session.users.splice(userIndex, 1);
  res.status(204).send();
});

app.listen(port, () => {
  console.log(`Server běží na portu ${port}`);
});

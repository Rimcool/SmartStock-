const express = require('express');
const app = express();
const port = 5000; // Change to port 5000 or any other available port



// Basic route
app.get('/', (req, res) => {
    res.send('Hello World!');
});

// Start the server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
    console.log("Server started successfully!");
  });
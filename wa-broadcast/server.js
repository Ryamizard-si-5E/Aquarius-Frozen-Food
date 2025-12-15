const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.send('Hello dari Node.js');
});

app.listen(3000, '0.0.0.0', () => {
    console.log('Node.js server running on http://localhost:3000');
});
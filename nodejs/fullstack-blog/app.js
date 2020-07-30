const express = require('express');
const path = require('path');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const keys = require('./keys');
const postRouter = require('./routes/post');

const port = process.env.PORT || 5000;
const clientPath = path.join(__dirname, 'client');
const app = express();

mongoose.connect(keys.mongoURI)
	.then(() => {
		console.log('Mongo is connected');
	})
	.catch(err => {
		console.error(err)
	})

app.use(bodyParser.json())
app.use('/api/post', postRouter);
app.use(express.static(clientPath));

app.listen(port, () => {
	console.log(`Server started at port ${port}`);
});



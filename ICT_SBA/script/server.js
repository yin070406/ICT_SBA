const express = require('express');
const mongoose = require('mongoose');

mongoose.connect('mongodb://localhost:27017/code_editor', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
});

const codeSchema = new mongoose.Schema({
    code: String,
});

const Code = mongoose.model('Code', codeSchema);

const app = express();

app.use(express.static('public'));

app.use(express.json());

app.post('/code', (req, res) => {
    const code = new Code({ code: req.body.code });
    code.save()
        .then(() => {
            res.sendStatus(200);
        })
        .catch(() => {
            res.sendStatus(500);
        });
});

app.get('/code', (req, res) => {
    Code.findOne()
        .then(code => {
            res.json({ code: code ? code.code : '' });
        })
        .catch(() => {
            res.sendStatus(500);
        });
});

const port = 8888;
app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});
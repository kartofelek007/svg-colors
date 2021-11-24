const express = require('express');
const app = express();
const fs = require("fs");
const htmlColors = require("./html-colors");

function checkColor(text) {
    if (!text) return false;

    if (/^[abcdef0-9]{6}$/i.test(text)) {
        return '#' + text;
    }
    if (/^[abcdef0-9]{3}$/i.test(text)) {
        return '#' + text;
    }
    if (/^.+$/.test(text) && htmlColors.includes(text)) {
        return text;
    }

    return false;
}

app.get("/", async (req, res) => {
    res.sendFile(__dirname + '/index.html');
});

app.get("/images/:image", async (req, res) => {
    let c =  checkColor(req.query.c);
    let to = checkColor(req.query.to);
    let {image} = req.params;
    const replaceColors = [];

    if (c && to) {
        replaceColors.push({c, to});
    }

    for (let i=2; i<=100; i++) {
        const c = checkColor(req.query[`c${i}`]);
        const to = checkColor(req.query[`to${i}`]);

        if (c && to) {
            replaceColors.push({
               c, to
            });
        }
    }

    const url = `${__dirname}/images/${image}`;

    if (fs.existsSync(url)) {
        res.setHeader('Content-Type', 'image/svg+xml');

        if (replaceColors.length) {
            fs.readFile(url, 'utf8', (err, data) => {
                for (let el of replaceColors) {
                    const reg = new RegExp(`${el.c}`, "g")
                    data = data.replace(reg, el.to);
                }
                res.send(data);
            });
        } else {
            res.sendFile(url);
        }
    } else {
        res.sendStatus(404);
    }
});

app.listen(3333, function () {
    console.log('Listening on http://localhost:3333')
});
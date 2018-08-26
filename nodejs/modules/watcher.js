var chokidar = require('chokidar');
var watcher = chokidar.watch('../xmls/', {
    persistent: true,
    ignoreInitial: true,
});
var allow_noti = true;

function countdown() {
    allow_noti = true;
}

//var log = console.log.bind(console);
watcher.on('add', (event, path) => {
    if (!allow_noti)
        return false;

    allow_noti = false;
//    console.log(event);

    setTimeout(function () {
        const MongoClient = require('mongodb').MongoClient;
        const assert = require('assert');
        const url = 'mongodb://localhost:27017';
        const dbName = 'ebxml';
        MongoClient.connect(url, function (err, client) {
            assert.equal(null, err);
            console.log("Connected successfully to server");
            const db = client.db(dbName);
            const c_Joblist = db.collection('Joblist');
            c_Joblist.count({FlagStatus: 'OPEN'}, function (err, count) {
                if (err)
                    throw err;
                console.log("docs count: " + count);
                socket.emit('noti_new_order', {
                    count_open_jobs: count
                });
            });
        });
        countdown();
    }, 10000);

//    setTimeout(countdown, 1000);
});

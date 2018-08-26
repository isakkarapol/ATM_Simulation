// Normally NodeJS : node app.js
// How to user DEBUG : set DEBUG=socket.io* & node app.js

var io = require('socket.io').listen(3000, function () {
    debug('listening');
});
var fs = require('fs');
var debug = require('debug')('socket.io')
        , name = 'ebXML';

debug('booting %o', name);

var utils = require('./helpers/utils');

// Start web socket
io.sockets.on('connection', function (socket) {

//    console.log('New Connect.');
//    console.log(socket.id);

    var dir = __dirname + '/modules/';
    fs.readdir(dir, function (err, files) {
        if (err)
            throw err;
        files.forEach(function (file) {
            var name = dir + file;
            if (fs.statSync(name).isDirectory()) {
                // If is directory
            } else {
                eval(fs.readFileSync(name).toString() + ' ');
            }
        });
    });

    socket.on('disconnect', function () {
//        console.log('Have Disconnect.');
    });

});

// END OF FILE;
'use strict';

var response = require('./res');
var connection = require('./conn');

exports.nasabah = function(req, res) {
    connection.query('SELECT * FROM nasabah', function (error, rows, fields){
        if(error){
            console.log(error)
        } else{
            response.ok(rows, res)
        }
    });
};

exports.findNoKartu = function(req, res) {
    
    var no_kartu = req.body.no_kartu;
    
    connection.query('SELECT * FROM nasabah WHERE no_kartu = ?',
    [ no_kartu ], 
    function (error, rows, fields){
        if(error){
            console.log(error)
        } else{
            if (isAccountFound(rows)) {
                response.ok({"not_found": "false"}, res)
            } else {
                response.ok({"not_found": "true"}, res)
            }
        }
    });
};

exports.updateNoKartu = function(req, res) {
    
    var no_kartu = req.body.no_kartu;
    var username = req.body.username;
    
    connection.query('UPDATE nasabah SET no_kartu = ? WHERE username = ?',
    [ no_kartu, username ],
    function (error, rows, fields){
        if(error){
            console.log(error)
        } else{
            response.ok("true", res)
        }
    });
};

var isAccountFound = function (result) {
    if (result == undefined) {
        return false
    } else {
        return result.length != 0
    }
};

var createResponse = function(bool, mesg) {
    var data = {
        'success': bool,
        'result': mesg
    };
    return data;
}

exports.transaksi = function(req, res) {
    var no_pengirim = req.body.no_pengirim
    var no_penerima = req.body.no_penerima
    var jumlah = req.body.jumlah
    var mesg
    var errmesg = "500: Transaction error"
    
    //Validate account
    connection.query('SELECT * FROM nasabah WHERE no_kartu = ?',
    [ no_penerima ], 
    function (error, rows, fields){
        if(error){
            response.ok(createResponse(false, errmesg), res)
        } else{
            if (!isAccountFound(rows)) {
                mesg = "Receiver Account: ".concat(no_penerima, " not found");
                response.ok(createResponse(false, mesg), res)
            } else {
                connection.query('SELECT * FROM nasabah WHERE no_kartu = ?',
                [ no_pengirim ], 
                function (error, rows, fields){
                    if(error){
                        response.ok(createResponse(false, errmesg), res)
                    } else{
                        if (!isAccountFound(rows)) {
                            mesg = "Sender Account: ".concat(no_pengirim, " not found")
                            response.ok(createResponse(false, mesg), res)
                        } else {
                            //INSERT NEW TRANSACTION
                            if (rows[0].saldo >= jumlah) {
                                console.log("Updating saldo ... Sender: " + no_pengirim + " Receiver: " + no_penerima + " Jumlah: " + jumlah);
                                
                                
                                connection.query('UPDATE nasabah SET saldo = saldo - ? WHERE no_kartu=?',
                                [ jumlah, no_pengirim ]);

                                connection.query('UPDATE nasabah SET saldo = saldo + ? WHERE no_kartu=?',
                                [ jumlah, no_penerima ]);
                                
                                connection.query('INSERT INTO transaksi VALUES(?, ?, ?, NOW())', 
                                [ no_pengirim, no_penerima, jumlah ],
                                function (error, rows) {
                                    if (error) {
                                        response.ok(createResponse(false, errmesg), res)
                                    } else {
                                        mesg = "Transaction success!"
                                        response.ok(createResponse(true, mesg), res)
                                    }
                                });
                            } else {
                                mesg = "Saldo is insufficient."
                                response.ok(createResponse(false, mesg), res)
                            }
                        }
                    }
                });
            }
        }
    });
}

exports.index = function(req, res) {
    response.ok("Hello from the Pro-book Book Webservice!", res)
};
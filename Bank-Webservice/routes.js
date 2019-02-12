'use strict';

module.exports = function(app) {
    var todoList = require('./controller');

    app.route('/')
        .get(todoList.index);

    app.route('/nasabah')
        .get(todoList.nasabah);

    app.route('/nasabah')
        .post(todoList.findNoKartu);

    app.route('/update')
        .post(todoList.updateNoKartu);
        
    app.route('/transaksi')
        .post(todoList.transaksi);
};
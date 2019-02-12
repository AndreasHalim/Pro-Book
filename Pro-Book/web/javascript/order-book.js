//AJAX Order Book
function orderBook(book_id, price) {
    showLoadingScreen();
    var qty = document.getElementById('dropdown-order').value;
    var url = "../book_order/transaction.php";
    var params = 'book_id=' + book_id + '&qty=' + qty + '&price=' + price;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', url, true);
    //Send the proper header information along with the request
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('loading-gif').style.visibility = "hidden";
            document.getElementById('show-modal').innerHTML = this.response;
        }
    };
    xmlhttp.send(params);
}

//Order Modal
function closeModal(elmtID) {
    document.getElementById(elmtID).remove();
    document.getElementById('modal-container').style.visibility = "hidden";
}

function showLoadingScreen() {
    document.getElementById('modal-container').style.visibility = "visible";
    document.getElementById('loading-gif').style.visibility = "visible";
}
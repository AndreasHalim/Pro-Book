function IsEmptyInputSearch() {
    return document.getElementById('inputSearch').value === "";
}


function trySubmitSearch() {
    if (IsEmptyInputSearch()) {
        document.getElementById("warning-empty-input").style.display = 'table';
    } else {
        document.getElementById('searchForm').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('inputSearch').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            trySubmitSearch();
        }
    });
}, false);
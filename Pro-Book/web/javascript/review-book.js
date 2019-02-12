
const STARPATH = "../svgIcon/";
const FULL_STAR = STARPATH + "star-filled.png";
const STAR = STARPATH + "star.png";

function ratingClick(starValue) {
    for (idx = 1; idx <= 5; idx++) {
        if (idx <= starValue) {
            document.getElementById("star"+idx).src = FULL_STAR;
        } else {
            document.getElementById("star"+idx).src = STAR;
        }
    }
    document.getElementById("rating-given").value = starValue;
    document.getElementById("rating-area").style.display = 'none';
}

function hoverStar(starValue) {
    for (idx = 1; idx <= 5; idx++) {
        if (idx <= starValue) {
            document.getElementById("star"+idx).src = FULL_STAR;
        }
    }
}

function noHoverStar(starValue) {
    var rating = document.getElementById("rating-given").value;
    for (idx = 1; idx <= 5; idx++) {
        if (idx <= starValue && idx > rating) {
            document.getElementById("star"+idx).src = STAR;
        }
    }
}

function isEmptyCommentBar() {
    return document.getElementById('comment').value === "";
}

function isEmptyRating() {
    return document.getElementById("rating-given").value == 0;
}

function trySubmitSearch() {
    var valid = true;
    if (isEmptyCommentBar()) {
        document.getElementById("comment-area").style.display = 'table';
        valid = false;
    } else {
        document.getElementById("comment-area").style.display = 'none';
    }
    if (isEmptyRating()) {
        document.getElementById("rating-area").style.display = 'table';
        valid = false;
    } else {
        document.getElementById("rating-area").style.display = 'none';
    }
    return valid;
}
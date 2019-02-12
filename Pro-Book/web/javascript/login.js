const BLANK_SPACE_REGEX = /^\s*$/;

function isValidated(){
    var validation = true;
    validation &= validateBlankInput("username");
    validation &= validateBlankInput("password");

    if (validation != 1) {
        alert("All fields must be filled.");
    }
    return validation == 1;
}

function validateBlankInput(inputID) {
    var value = document.getElementById(inputID).value;
    if (value == "" || BLANK_SPACE_REGEX.test(value)) {
        showInvalidInput(inputID);
        return false;
    } else {
        hideInvalid(inputID);
        return true;
    }
}

function showInvalidInput(inputID) {
    highlightInvalid(inputID);
}

function hideInvalid(inputID) {
    var border = document.getElementById(inputID).style.border;
    if (border == "2px solid red") {
        document.getElementById(inputID).style.border = "";
    }
}

function highlightInvalid(inputID) {
    var border = document.getElementById(inputID).style.border;
    if (border == "") {
        document.getElementById(inputID).style.border = "2px solid red";
    }
}
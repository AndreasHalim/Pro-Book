const BLANK_FIELD = "field must be filled.";
const INVALID_EMAIL_FORMAT = "invalid email format.";
const INVALID_NAME_LENGTH = "name exceeded 20 characters.";
const INVALID_PHONENUMBER_FORMAT = "please enter numbers only.";
const INVALID_PHONENUMBER_LENGTH = "please enter valid phone number (9 - 12 digits).";
const UNMATCHED_PASSWORD = "unmatched password and confirmed password.";
const EMAIL_REGEX = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
const BLANK_SPACE_REGEX = /^\s*$/
const NUMBER_REGEX = /^[0-9]*$/

function getFieldValue(inputID) {
    return document.getElementById(inputID).value;
}

function validateBlankInput(inputID) {
    var value = getFieldValue(inputID);
    if (value == "" || BLANK_SPACE_REGEX.test(value)) {
        showInvalidInput(inputID + BLANK_FIELD, inputID);
        return false;
    } else {
        hideInvalidInput(inputID);
        return true;
    }
}

function validateBlankPassword() {
    var validation = true;
    validation &= validateBlankInput("password-input");
    validation &= validateBlankInput("confpassword-input");
    return validation == 1;
}

//Match password and confirmed password
function validateAllPasswords() {
    var pass = document.forms["registrationform"]["password"].value;
    var conf_pass = document.forms["registrationform"]["conf_password"].value;
    if (validateBlankPassword()) {
        if (pass != conf_pass) {
            alert(UNMATCHED_PASSWORD);
            highlightInvalidInput("password-input");
            highlightInvalidInput("confpassword-input");
            return false;
        } else {
            hideInvalidInput("password-input");
            hideInvalidInput("confpassword-input");
            return true;
        }
    } else {
        return false;
    }
}

function validateName() {
    if (validateBlankInput("name-input")) {
        if (getFieldValue("name-input").length > 20) {
            showInvalidInput(INVALID_NAME_LENGTH, "name-input");
            return false;
        } else {
            hideInvalidInput("name-input");
            return true;
        }
    } else {
        return false;
    }
}

function validatePhoneNumber() {
    if (validateBlankInput("phonenumber-input")) {
        if (NUMBER_REGEX.test(getFieldValue("phonenumber-input"))) {
            var getLength = getFieldValue("phonenumber-input").length;
            if (getLength >= 9 && getLength <= 12) {
                hideInvalidInput("phonenumber-input");
                return true;
            } else {
                showInvalidInput(INVALID_PHONENUMBER_LENGTH, "phonenumber-input");
                return false;
            }
        } else {
            showInvalidInput(INVALID_PHONENUMBER_FORMAT, "phonenumber-input");
        }
    } else {
        return false;
    }
}

function validateUsername() {
    if (validateBlankInput("username-input")) {
        return validateAvailability("username");
    } else {
        return false;
    }
}

function validateEmail() {
    if (validateBlankInput("email-input")) {
        re = EMAIL_REGEX;
        var checkFormat = re.test(String(getFieldValue("email-input")).toLowerCase());
        if (!checkFormat) {
            showInvalidInput(INVALID_EMAIL_FORMAT, "email-input");
            return false;
        }
        else {
            return validateAvailability("email");
        }
    } else {
        return false;
    }
}

function validateAddress() {
    if (validateBlankInput("address-input")) {
        return true;
    } else {
        return false;
    }
}

function validateAvailability(input) {
    var checkTick = document.getElementById("validate_" + input).innerHTML;
    if (checkTick == "") {
        showInvalidInput(input + " is unavailable!", input+"-input");
        return false;
    } else {
        hideInvalidInput(input+"-input");
        return true;
    }
}

function validateBankAccount() {
    var str = document.getElementById("bank-account").value;

    if (str.length < 1 || str.length > 5) {
        showInvalidInput("Panjang karakter harus di antara 1 dan 5. Silakan coba lagi!", "bank-account");
        return false;
    } else {
        const http = new XMLHttpRequest();
        const url = "/registration/checkbank.php";
        const param = "no_kartu=" + str;

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.response == "false") {
                    // Pencarian kartu NEGATIF tidak ditemukan
                    hideInvalidInput("bank-account");
                    return true;
                } else {
                    // Pencarian kartu POSITIF tidak ditemukan
                    showInvalidInput("Nomor kartu tidak terdaftar! Silakan coba nomor kartu lain.", "bank-account");
                    return false;
                }
            }
        };

        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send(param);
    }
}

function submitValidation() {
    var validation = true;
    validation &= validateName();
    validation &= validateUsername();
    validation &= validateEmail();
    validation &= validateAllPasswords();
    validation &= validateAddress();
    validation &= validatePhoneNumber();
    validation &= validateBankAccount();
    return validation == 1;
}

// AJAX Check availability
function checkUserAvailability(input, str) {
    var inputID = 'validate_' + input;
    if (str.length < 1) {
        document.getElementById(inputID).innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(inputID).innerHTML = this.response;
            }
        };
        xmlhttp.open("GET", "registration/checkaccount.php?type=" + input + "&q=" + str, true);
        xmlhttp.send();
    }
}

function showInvalidInput(message, inputID) {
    var message = message.replace(/-input/, " ");
    var message = message.replace(/conf/, "confirmed ");
    alert(message);
    highlightInvalidInput(inputID);
}

function highlightInvalidInput(inputID) {
    var border = document.getElementById(inputID).style.border;
    if (border == "") {
        document.getElementById(inputID).style.border = "2px solid red";
    }
}

function hideInvalidInput(inputID) {
    //document.getElementById("address-input").style.visibility = "hidden";
    var border = document.getElementById(inputID).style.border;
    if (border == "2px solid red") {
        document.getElementById(inputID).style.border = "";
    }
}
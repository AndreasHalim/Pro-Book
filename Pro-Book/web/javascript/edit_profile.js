function validateForm(){
    //alert('Here 2');
    pp = document.getElementById("profpict").value;
    name = document.getElementById("name").value;
    address = document.getElementById("address").value;
    phone = document.getElementById("phone").value;
    // alert(pp+' '+name+' '+address+' '+phone);
    unchanged = "";
    if (name== def[1]){
        unchanged += "Name unchanged. ";
    }
    if (address==def[2]){
        unchanged += "Address unchanged. ";
    }
    if (phone==def[3]){
        unchanged += "Phone unchanged.";
    }
    empty = "";
    isNameEmpty = false;
    isAddressEmpty = false;
    isPhoneEmpty = false;
    isPhoneNotValid = false;
    isPhoneDigitNotValid = false;
    isNameTooLong = false;
    if (name == ""){
        empty += "Name ";
        isNameEmpty = true;
    }
    if (address == ""){
        empty += "Address ";
        isAddressEmpty = true;
    }
    if (phone == ""){
        empty += "Phone ";
        isPhoneEmpty = true;
    }
    empty += "empty."
    isnum = /^[0-9]*$/gm.test(phone);
    $ret = true;
    if (empty != "empty."){
        // alert(empty);
        $ret = $ret & false;
    }
    if (name.length > 20){
        // alert("Name exceed maximum. Please enter not more than 20 characters.");
        $ret = $ret & false;
        isNameTooLong = true;
    } 
    if (!isnum){
        // alert("Please enter valid phone number (only numbers).");
        $ret = $ret & false;
        isPhoneNotValid = true;
    } 
    if (phone.length < 9 || phone.length > 12){
        // alert("Please enter valid phone number (9 - 12 digits).");
        $ret = $ret & false;
        isPhoneDigitNotValid = true;
    }
    if (pp=="" ){
        alert("Profile picture unchanged.");
        // $ret = $ret & false;
    }
    if (unchanged != ""){
        alert(unchanged);
        // $ret = $ret & false;
    } 
    if ($ret == true){
        // alert(true);
        return true;
    } else{
        // alert(false);
        if (isNameEmpty == true){
            document.getElementById("warning-1").style.visibility = 'visible';
        } else if (isNameTooLong == true){
            document.getElementById("warning-1").style.visibility = 'visible';
            document.getElementById("warning-1").innerHTML = 'Name must be under 20 characters.';
        }
        if (isAddressEmpty == true){
            document.getElementById("warning-2").style.visibility = 'visible';
        }
        if (isPhoneEmpty == true){
            document.getElementById("warning-3").style.visibility = 'visible';
        } else if (isPhoneDigitNotValid == true){
            document.getElementById("warning-3").style.visibility = 'visible';
            document.getElementById("warning-3").innerHTML = 'Phone number must be between 9 - 12 digits.';
        } else if (isPhoneNotValid == true){
            document.getElementById("warning-3").style.visibility = 'visible';
            document.getElementById("warning-3").innerHTML = 'Phone number must be numbers.';
        }
        return false;
    }
}

function getDefault() {
    pp = document.getElementById("profpict").value;
    name = document.getElementById("name").value;
    address = document.getElementById("address").value;
    phone = document.getElementById("phone").value;
    result = Array(pp, name, address, phone);
    return result;
}

function showname(){
     var name =  document.getElementById('profpict').files[0].name;
     document.getElementById("profpict_dummy").value = name;
}

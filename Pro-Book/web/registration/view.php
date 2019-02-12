<?php

    echo "<html>";
    printHeader();
    printBody();
    echo '</html>';

    function printHeader() {
        $header = '<head>
                    <meta charset="utf-8">
                    <title>Registration Page</title>
                    <link rel="stylesheet" href="../css/login.css">
                    <link rel="stylesheet" href="../css/registration.css">
                </head>';
        echo $header;
    }
    
    function printScript() {
        echo '<script type="text/javascript" src="../javascript/validation.js"></script>';
    }

    function printBody() {
        $body= '<div class = "out_container">
                    <div class = "in_container">
                        <div class="content">'.
                        getForm() .
                        '</div>
                    </div>
                </div>';

        echo '<body>';
        echo $body;
        printScript();
        echo '</body>';
    }

    function getForm() {
        $form= '<h1>REGISTER</h1>
                <form id="registrationform" action="registration/register.php" onsubmit="return submitValidation()" method = "POST">
                '. getTable().
                '<p id="account_existence"><a href="../login">Already have an account?</a></p>
                <input id="submit_button" type="submit" value="REGISTER">
            </form>
        ';
        return $form;
    }
    function getTable() {
        return '<table class="form-input" align="center">
                    <tr>
                        <td>Name</td>
                        <td><input id="name-input" type="text" size="25" name="name"></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>
                            <div id="validate_form"><input id="username-input" type="text" size="21" name="username" onkeyup="checkUserAvailability(\'username\', this.value)"> </div>
                            <!--<div id="validate_icon"><img src="../svgIcon/tick.png"></div>-->
                            <span id="validate_username"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <div id="validate_form"><input id="email-input" type="text" size="21" name="email" onkeyup="checkUserAvailability(\'email\', this.value)"></div> 
                            <span id="validate_email"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input id="password-input" type="password" size="25" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input id="confpassword-input" type="password" size="25" name="conf_password"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><textarea id="address-input" name="address" rows="3" cols="28"></textarea></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><input id="phonenumber-input" type="text" size="25" name="phonenumber"></td>
                    </tr>
                    <tr>
                        <td>Bank Account</td>
                        <td><input id="bank-account" type="text" size="25" name="no_kartu"></td>
                    </tr>
                </table>';
    }
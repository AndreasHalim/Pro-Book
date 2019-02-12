<?php 
    echo "<html>";
    require_once ("../autoload.php");
    echo Header::generateHeadWithJS("Login", "login", "login");    
    $print =
    '<body>
            <div class = "out_container">
                <div class = "in_container">
                    <div class="content">
                        <h1>LOGIN</h1>
                        <form action="../login/login.php" onsubmit="return (isValidated())" method = "POST">
                            <p>Username <input id="username" type="text" name="username" ></p>
                            <p>Password <input id="password" type="password" name="password" ></p>
                            <p id="account_existence"><a href="/registration">Don\'t have an account?</a></p>
                            <input id="submit_button" type="submit" value="LOGIN">
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    echo $print;
?>
    
<?php 
    require_once ("../autoload.php");
    include("controller.php");
    if (!isset($_COOKIE["login"])){
        $user_token = NULL;
    } else{
        $user_token = $_COOKIE["login"];
    }

    if ($user_token != NULL){
        $user_id = getUserIDbyToken($user_token);
    } else{
        $user_id = 0;
    }
    echo "<html>";

    echo Header::generateHeadWithJS("edit_profile", "edit_profile", "edit_profile");
    echo Header::headerLogin(getUsername($user_token));
    echo Header::headerMenu(Header::PROFILE);
    
    $user_profile = getUserProfile($user_id);
    $user_pp = $user_profile['profile_picture'];
    $user_name = $user_profile['name'];
    $user_address = $user_profile['address'];
    $user_phone = $user_profile['phone'];
    $user_no_kartu = $user_profile['no_kartu'];
    
    echo "<body onload=\"def = getDefault();\">";
    echo '<form action="../edit_profile/edit_profile.php" enctype="multipart/form-data" onsubmit="return (validateForm())"method = "POST">'   ;

    echo "<div class=\"cols\">" ;

    echo "<h1>Edit Profile</h1>"    ;

    echo "<div class = \"rows1\">"  ;
    echo "<div class=\"left\">" ;
    if (!fileProcessing::isExistProfileImage($user_pp)){
        $user_pp = "../images/tayo.jpg";
    }
    echo "<img class=\"pp\" src=\"../uploads/$user_pp\" alt=\"Profile Picture\">"  ;
    echo "</div>";

    echo "<div class=\"right\">"    ;
    echo "<p>Update profile picture</p>"    ;

    echo '
        <div class="flex-container">
            <input id="profpict_dummy" class="profpict_dummy"type="text" name="profile_picture2" readonly>
            <div class="upload-btn-wrapper">
                <button class="btn">Browse...</button>
                <input id="profpict" type="file" name="profile_picture" accept="image/png, image/jpg, image/jpeg" onchange="showname()" >
            </div>   
        </div>
    ';

    echo "</div>"   ;
    echo "</div>"   ;

    echo "<div class=\"rows2\">"    ;
    echo "<p class=\"left2\">Name</p>"  ;
    echo "<div class=\"right2\">"   ;
    echo '<p id="warning-1" class="red-theme alert-box text-size-20 add-nunito-font c-round">Input can\'t be empty</p>';
    echo "<input type=\"text\" id = \"name\" name=\"name\" value=\"$user_name\">"   ;
    echo "</div>"   ;
    echo "</div>"   ;

    echo "<div class=\"rows\">" ;
    echo "<p class=\"left2\">Address</p>"   ;
    echo "<div class=\"right2\">"   ;
    echo '<p id="warning-2" class="red-theme alert-box text-size-20 add-nunito-font c-round">Input can\'t be empty</p>';
    echo "<textarea name=\"address\" id = \"address\" rows=\"5\" cols=\"1\">$user_address</textarea>"   ;
    echo "</div>"   ;
    echo "</div>"   ;

    echo "<div class=\"rows2\">"    ;
    echo "<p class=\"left2\">Phone number</p>"  ;
    echo "<div class=\"right2\">"   ;
    echo '<p id="warning-3" class="red-theme alert-box text-size-20 add-nunito-font c-round">Input can\'t be empty</p>';
    echo "<input type=\"text\" id = \"phone\" name=\"phone\" value=\"$user_phone\">" ;
    echo "</div>"   ;
    echo "</div>"   ;

    echo "<div class=\"rows2\">"    ;
    echo "<p class=\"left2\">Card number</p>"  ;
    echo "<div class=\"right2\">"   ;
    echo '<p id="warning-4" class="red-theme alert-box text-size-20 add-nunito-font c-round">Input can\'t be empty</p>';
    echo "<input type=\"text\" id = \"no_kartu\" name=\"no_kartu\" value=\"$user_no_kartu\">" ;
    echo "</div>"   ;
    echo "</div>"   ;
    echo "</div>"   ;

    echo "<div class=\"row_button\">";
    echo "<div class=\"left_button\">";
    echo "<button id=\"back\" type=\"button\" name=\"back\" value=\"BACK\" onclick=\"location.href = '../profile'\">Back</button>";
    echo "</div>";
    echo "<div class=\"right_button\">";
    echo "<input id=\"submit\" type=\"submit\" name = \"submit\"value =\"SAVE\">";
    echo "</div>";
    echo "</div>";

    echo "</form>"  ;
    echo "</body>";
    echo "</html>";
?>

    

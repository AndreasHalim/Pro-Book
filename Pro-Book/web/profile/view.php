<?php

require ('../autoload.php');

function viewProfile (array $params) {
    echo Header::generateHead('Profile', 'profile');
    $userData = '
        <div class="flex-profile-header">
            <div class="flex-1"></div>
            <div class="flex-2">
                <img class="profile-photo margin-20" src="/uploads/'.$params['profile_picture'].'">
                <div id="username" class="text-size-50">'.$params['name'].'</div>
            </div>
            <a class="flex-container add-flex-end-justify flex-1 " href="edit_profile">
                <img src="../svgIcon/pencil-alt.svg" id="edit-profile-button" >
            </a>
        </div>

        <div id="my-profile-label-div" class="orange-text text-size-80">
            <label id="label-text-my-profile" >My Profile</label>
        </div>

        <div class="text-size-30" id="profile-data-table">
            <div class="flex-container align-items-flex-center">
                <object class="icon-profile" type="image/svg+xml" data="../svgIcon/user.svg">
                    Your browser does not support SVG
                </object>
                <div class="flex-1">Username</div>
                <div class="dont-break-out flex-2">@'.$params['username'].'</div>
            </div>
            <div class="flex-container align-items-flex-center">
                <object class="icon-profile" type="image/svg+xml" data="../svgIcon/mail.svg">
                    Your browser does not support SVG
                </object>
                <div class="flex-1">Email</div>
                <div class="dont-break-out flex-2">'.$params['email'].'</div>
            </div>
            <div class="flex-container align-items-flex-center">
                <object class="icon-profile" type="image/svg+xml" data="../svgIcon/home.svg">
                    Your browser does not support SVG
                </object>            
                <div class="flex-1">Address</div>
                <div class="dont-break-out flex-2">'.$params['address'].'</div>
            </div>
            <div class="flex-container align-items-flex-center">
                <object class="icon-profile" type="image/svg+xml" data="../svgIcon/phone.svg">
                    Your browser does not support SVG
                </object>
                <div class="flex-1">Phone Number</div>
                <div class="dont-break-out flex-2">'.$params['phone']. '</div>
            </div>
            <div class="flex-container align-items-flex-center">
                <object class="icon-profile" type="image/svg+xml" data="../svgIcon/card.svg">
                    Your browser does not support SVG
                </object>
                <div class="flex-1">Bank Account</div>
                <div class="dont-break-out flex-2">' . $params['no_kartu'] . '</div>
            </div>
        </div>
    ';
    Body::outputInBody(
        Header::headerLogin($params['username']).
        Header::headerMenu(Header::PROFILE).
        $userData
    );

}
<?php
require ('view.php');

class profileController {
    public static function showProfileController() {
        if (isLogin()) {
            $user_token = getTokenLogin();
            $params = getUserInfo(getUserIDbyToken($user_token));
            if (!fileProcessing::isExistProfileImage($params['profile_picture'])){
                $params['profile_picture'] = fileProcessing::PROFILE_DEFAULT;
            }
            viewProfile($params);
        } else {
            $login = '../login';
            header('Location: '.$login);
        }
    }
}
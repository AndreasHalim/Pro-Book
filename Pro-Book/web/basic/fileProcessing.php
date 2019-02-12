<?php

class fileProcessing {

    public const PROFILE_DEFAULT = 'default.jpg';
    public static function isExistBookImage ($name): bool {
        return file_exists('../images/books_picture/'.$name.'.jpg');
    }

    public static function isExistProfileImage ($name): bool {
        return file_exists('../uploads/'.$name);
    }

    public static function getImageBookPathFromRoot (string $name): string {
        return 'images/books_picture/'.$name.'.jpg';
    }

    public static function getImageProfilePathFromRoot (string $name): string {
        return 'images/profiles_picture/'.$name.'.jpg';
    }
}

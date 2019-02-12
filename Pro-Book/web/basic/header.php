<?php
 
 
class Header {
    public const BROWSE = 1;
    public const HISTORY = 2;
    public const PROFILE = 3;
    public const URL_BROWSE = '/browse';
    public const URL_HISTORY = '/history';
    public const URL_PROFILE = '/profile';


    public static function generateHead($pageName, $cssName){
        return '
            <head>
                <meta charset="utf-8">
                <title>'.$pageName.' Page</title>
                <link rel="stylesheet" type="text/css" href="../css/header.css">
                <link rel="stylesheet" type="text/css" href="../css/color-lib.css">
                <link rel="stylesheet" type="text/css" href="../css/basic.css">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../css/'.$cssName.'.css">
            </head>
        ';
    }
    public static function generateHeadWithJS($pageName, $cssName, $jsName){
        return '
            <head>
                <meta charset="utf-8">
                <title>'.$pageName.' Page</title>
                <link rel="stylesheet" type="text/css" href="../css/header.css">
                <link rel="stylesheet" type="text/css" href="../css/color-lib.css">
                <link rel="stylesheet" type="text/css" href="../css/basic.css">
                <link rel="stylesheet" href="../css/'.$cssName.'.css">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="../javascript/'.$jsName.'.js"></script>
            </head>
        ';
    }
    public static function headerLogin(string $name): string {
        return '
            <div class="flex-container-header">
                <div class="logoName white-text">
                    <span class="yellow-text">Pro</span>-Book
                </div>
                <div class="flex-item-header">
                    <div class="text-size-20 white-text flex-item-center add-nunito-font">
                        <div class="c-border-bottom">
                            Hi, '.$name.'
                        </div>
                    </div>
                    <a  href="/logout" class="flex-item-header orange-background" >
                        <img src="../svgIcon/power-button.svg" class="turn-off-button">
                    </a>
                </div>
            </div> 
        ';
    }

    public static function headerMenu(int $tab): string {
        switch ($tab) {
            case self::BROWSE:
                return self::headerMenuBrowse();
                break;
            case self::HISTORY:
                return self::headerMenuHistory();
                break;
            case self::PROFILE:
                return self::headerMenuProfile();
                break;
        }
    }

    private static function headerMenuHistory(): string {
        return '<div class="flex-container-menu">
            <div class="flex-1 ">
                <a href="'.self::URL_BROWSE.'">                
                    <div>
                        <span class="text-size-40">B</span>ROWSE
                    </div>
                </a>
            </div>
            <div class="left-right-border orange-background flex-1 ">
                <a href="'.self::URL_HISTORY.'">                
                    <div>
                        <span class="text-size-40">H</span>ISTORY
                    </div>
                </a>
            </div>
            <div class="flex-1 ">
                <a href="'.self::URL_PROFILE.'">                
                    <div>
                        <span class="text-size-40">P</span>ROFILE
                    </div>
                </a>
            </div>
        </div>';
    }

    private static function headerMenuBrowse(): string {
        return '
        <div class="flex-container-menu">
            <div class="orange-background flex-1 ">
                <a href="'.self::URL_BROWSE.'">                
                    <div>
                        <span class="text-size-40">B</span>ROWSE
                    </div>
                </a>
            </div>
            <div class="left-right-border flex-1 ">
                <a href="'.self::URL_HISTORY.'">                
                    <div>
                        <span class="text-size-40">H</span>ISTORY
                    </div>
                </a>
            </div>
            <div class="flex-1 ">
                <a href="'.self::URL_PROFILE.'">                
                    <div>
                        <span class="text-size-40">P</span>ROFILE
                    </div>
                </a>
            </div>
        </div>';
    }

    private static function headerMenuProfile(): string {
        return '
        <div class="flex-container-menu">
            <div class="flex-1 ">
                <a href="'.self::URL_BROWSE.'">                
                    <div>
                        <span class="text-size-40">B</span>ROWSE
                    </div>
                </a>
            </div>
            <div class="left-right-border flex-1 ">
                <a href="'.self::URL_HISTORY.'">                
                    <div>
                        <span class="text-size-40">H</span>ISTORY
                    </div>
                </a>
            </div>
            <div class="orange-background flex-1 ">
                <a href="'.self::URL_PROFILE.'">                
                    <div>
                        <span class="text-size-40">P</span>ROFILE
                    </div>
                </a>
            </div>
        </div>';
    }
}

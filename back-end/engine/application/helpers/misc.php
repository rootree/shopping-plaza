<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @author Ivan Chura
 */
class misc_Core {

    static function getExt($fileName){
        preg_match('~(?:\.(.{3}))?$~',$fileName, $match_ext);
        return isset($match_ext[1]) ? $match_ext[1]: '';
    }

    static public function getMimeType($file_extension){

        $file_extension = strtolower($file_extension);

        //This will set the Content-Type to the appropriate setting for the file
        switch( $file_extension ) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            case "mp3": $ctype="audio/mpeg"; break;
            case "wav": $ctype="audio/x-wav"; break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype="video/mpeg"; break;
            case "mov": $ctype="video/quicktime"; break;
            case "avi": $ctype="video/x-msvideo"; break;

            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":
            case "html":
            case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;
            default: $ctype="application/force-download";
        }
        return $ctype;
    }


}

?>

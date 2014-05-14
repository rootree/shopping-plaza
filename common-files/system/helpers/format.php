<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Format helper class.
 *
 * $Id: format.php 4070 2009-03-11 20:37:38Z Geert $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class format_Core {

    /**
     * Formats a phone number according to the specified format.
     *
     * @param   string  phone number
     * @param   string  format string
     * @return  string
     */
    public static function phone($phoneBase = '', $convert = false, $trim = false)
    {
        // If we have not entered a phone number just return empty
        if (empty($phoneBase)) {
            return '';
        }

        // Strip out any extra characters that we do not need only keep letters and numbers
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phoneBase);

        // Do we want to convert phone numbers with letters to their number equivalent?
        // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
        if ($convert == true) {
            $replace = array('2'=>array('a','b','c'),
                             '3'=>array('d','e','f'),
                             '4'=>array('g','h','i'),
                             '5'=>array('j','k','l'),
                             '6'=>array('m','n','o'),
                             '7'=>array('p','q','r','s'),
                             '8'=>array('t','u','v'), '9'=>array('w','x','y','z'));

            // Replace each letter with a number
            // Notice this is case insensitive with the str_ireplace instead of str_replace
            foreach($replace as $digit=>$letters) {
                $phone = str_ireplace($letters, $digit, $phone);
            }
        }

        // If we have a number longer than 11 digits cut the string down to only 11
        // This is also only ran if we want to limit only to 11 characters
        if ($trim == true && strlen($phone)>11) {
            $phone = substr($phone, 0, 11);
        }

        // Perform phone number formatting here
        if (strlen($phone) == 7) {
            $phoneBase = preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})/", "$1-$2-$3", $phone);
        } elseif (strlen($phone) == 10) {
            $phoneBase = preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})/", "($1) $2-$3-$4", $phone);
        } elseif (strlen($phone) == 11) {
            $phoneBase = preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{2})([0-9a-zA-Z]{2})/", "$1 ($2) $3-$4-$5", $phone);
        }

        // Return original phone if not 7, 10 or 11 digits long

        if(substr($phoneBase,0,1) == '7'){
            $phoneBase = '+'.$phoneBase;
        }
        if(substr($phoneBase,0,1) == '('){
            $phoneBase = ' '.$phoneBase;
        }
 
        return $phoneBase;

    }

    /**
     * Formats a URL to contain a protocol at the beginning.
     *
     * @param   string  possibly incomplete URL
     * @return  string
     */
    public static function url($str = '')
    {
        // Clear protocol-only strings like "http://"
        if ($str === '' OR substr($str, -3) === '://')
            return '';

        // If no protocol given, prepend "http://" by default
        if (strpos($str, '://') === FALSE)
            return 'http://'.$str;

        // Return the original URL
        return $str;
    }


    /**
     * // For Mod_Rewrite
     * @param <string> $url URL для очистки левых символов
     * @return <string>
     */
    function erase_http_trash($url) {
        $url = htmlspecialchars_decode(trim($url));
        $trash = array('"', '#', '%',  '&',  "'",  '*',  ',', ':', ';',  '<',   '>', '?', '[',   '^',   '`',   '{',  '|',   '}', '+', '.', '/');
        $url = str_replace($trash, "", $url);
        return $url;
    }

    function do_latin($str) {

        $latin_equivalent = array(
            32 => '_',
            95 => '_',
            168 => 'YO',
            184 => 'yo',
            192 => 'A',
            193 => 'B',
            194 => 'V',
            195 => 'G',
            196 => 'D',
            197 => 'E',
            198 => 'ZH',
            199 => 'Z',
            200 => 'I',
            201 => 'Y',
            202 => 'K',
            203 => 'L',
            204 => 'M',
            205 => 'N',
            206 => 'O',
            207 => 'P',
            208 => 'R',
            209 => 'S',
            210 => 'T',
            211 => 'U',
            212 => 'F',
            213 => 'KH',
            214 => 'TS',
            215 => 'CH',
            216 => 'SH',
            217 => 'SHCH',
            218 => '',
            219 => 'Y',
            220 => '',
            221 => 'E',
            222 => 'U',
            223 => 'YA',
            224 => 'a',
            225 => 'b',
            226 => 'v',
            227 => 'g',
            228 => 'd',
            229 => 'e',
            230 => 'zh',
            231 => 'z',
            232 => 'i',
            233 => 'y',
            234 => 'k',
            235 => 'l',
            236 => 'm',
            237 => 'n',
            238 => 'o',
            239 => 'p',
            240 => 'r',
            241 => 's',
            242 => 't',
            243 => 'u',
            244 => 'f',
            245 => 'kh',
            246 => 'ts',
            247 => 'ch',
            248 => 'sh',
            249 => 'shch',
            250 => '',
            251 => 'y',
            252 => '',
            253 => 'e',
            254 => 'u',
            255 => 'ya',
            185 => 'N'
        );

        if ( ( $enc_str = iconv( 'UTF-8', 'CP1251', $str ) ) !== false ) {
            $str = $enc_str;
            unset( $enc_str );
        }

        $out = "";
        for( $i = 0; $i < strlen( $str ); $i++ ) {
            if( array_key_exists( ord( $str[ $i ]), $latin_equivalent ) ) {
                $out .= $latin_equivalent[ ord( $str[ $i ] ) ];
            } else {
                $out .= $str[ $i ];
            }
        }

        if(class_exists('format')) { return format::erase_http_trash($out); }
        return format_Core::erase_http_trash($out);
    }


} // End format
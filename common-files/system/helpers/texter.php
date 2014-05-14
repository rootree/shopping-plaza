<?php defined('SYSPATH') OR die('No direct access allowed.');

class texter_Core {

    public static function ru($variants, $numeric)
    {

        if (!is_array($variants)) {
            return  sprintf($variants, $numeric);;
        }


        $numeric = (int) abs($numeric);

        if ( ($numeric % 100 == 1 || $numeric % 100 > 20) && ( $numeric % 10 == 1 ) && isset($variants[1])){
            if(!empty($select)){

                return sprintf($variants[1], sprintf($select, $numeric));
            } else {
                return sprintf($variants[1], $numeric);
            }
        }

        if ( ($numeric % 100 == 2 || $numeric % 100 > 20) && ( $numeric % 10 == 2 )  && isset($variants[2])) $variant = $variants[2];

        if ( ($numeric % 100 == 3 || $numeric % 100 > 20) && ( $numeric % 10 == 3 )  && isset($variants[2])) $variant = $variants[2];

        if ( ($numeric % 100 == 4 || $numeric % 100 > 20) && ( $numeric % 10 == 4 )  && isset($variants[2])) $variant = $variants[2];

        if(!empty($variant)) {
            if(!empty($select) ){
                return sprintf($variant, sprintf($select, $numeric));
            } else {
                return sprintf($variant, $numeric);
            }
        }


        $variant = $variants[0];

        if(!empty($select)){

            return sprintf($variant, sprintf($select, $numeric));
        } else {
            return sprintf($variant, $numeric);
        }
 
    }

} // End text
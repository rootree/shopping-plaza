<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Validation helper class.
 *
 * $Id: valid.php 4367 2009-05-27 21:23:57Z samsoir $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class valid_Core {

    /**
     * Validate email, commonly used characters only
     *
     * @param   string   email address
     * @return  boolean
     */
    public static function email($email)
    {
        return (bool) (preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', (string) $email) && self::emailOnMailServer($email));



    }

    /**
     * Validate the domain of an email address by checking if the domain has a
     * valid MX record.
     *
     * @param   string   email address
     * @return  boolean
     */
    public static function email_domain($email)
    {
        // If we can't prove the domain is invalid, consider it valid
        // Note: checkdnsrr() is not implemented on Windows platforms
        if ( ! function_exists('checkdnsrr'))
            return TRUE;

        // Check if the email domain has a valid MX record
        return (bool) checkdnsrr(preg_replace('/^[^@]+@/', '', $email), 'MX');
    }

    /**
     * Validate email, RFC compliant version
     * Note: This function is LESS strict than valid_email. Choose carefully.
     *
     * @see  Originally by Cal Henderson, modified to fit Kohana syntax standards:
     * @see  http://www.iamcal.com/publish/articles/php/parsing_email/
     * @see  http://www.w3.org/Protocols/rfc822/
     *
     * @param   string   email address
     * @return  boolean
     */
    public static function email_rfc($email)
    {
        $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
        $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
        $atom  = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
        $pair  = '\\x5c[\\x00-\\x7f]';

        $domain_literal = "\\x5b($dtext|$pair)*\\x5d";
        $quoted_string  = "\\x22($qtext|$pair)*\\x22";
        $sub_domain     = "($atom|$domain_literal)";
        $word           = "($atom|$quoted_string)";
        $domain         = "$sub_domain(\\x2e$sub_domain)*";
        $local_part     = "$word(\\x2e$word)*";
        $addr_spec      = "$local_part\\x40$domain";

        return (bool) preg_match('/^'.$addr_spec.'$/D', (string) $email);
    }

    /**
     * Validate URL
     *
     * @param   string   URL
     * @return  boolean
     */
    public static function url($url)
    {
        $pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
        return preg_match($pattern, $url);

        // return (bool) filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    /**
     * Validate IP
     *
     * @param   string   IP address
     * @param   boolean  allow IPv6 addresses
     * @param   boolean  allow private IP networks
     * @return  boolean
     */
    public static function ip($ip, $ipv6 = FALSE, $allow_private = TRUE)
    {
        // By default do not allow private and reserved range IPs
        $flags = FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
        if ($allow_private === TRUE)
            $flags =  FILTER_FLAG_NO_RES_RANGE;

        if ($ipv6 === TRUE)
            return (bool) filter_var($ip, FILTER_VALIDATE_IP, $flags);

        return (bool) filter_var($ip, FILTER_VALIDATE_IP, $flags | FILTER_FLAG_IPV4);
    }

    /**
     * Validates a credit card number using the Luhn (mod10) formula.
     * @see http://en.wikipedia.org/wiki/Luhn_algorithm
     *
     * @param   integer       credit card number
     * @param   string|array  card type, or an array of card types
     * @return  boolean
     */
    public static function credit_card($number, $type = NULL)
    {
        // Remove all non-digit characters from the number
        if (($number = preg_replace('/\D+/', '', $number)) === '')
            return FALSE;

        if ($type == NULL)
        {
            // Use the default type
            $type = 'default';
        }
        elseif (is_array($type))
        {
            foreach ($type as $t)
            {
                // Test each type for validity
                if (valid::credit_card($number, $t))
                    return TRUE;
            }

            return FALSE;
        }

        $cards = Kohana::config('credit_cards');

        // Check card type
        $type = strtolower($type);

        if ( ! isset($cards[$type]))
            return FALSE;

        // Check card number length
        $length = strlen($number);

        // Validate the card length by the card type
        if ( ! in_array($length, preg_split('/\D+/', $cards[$type]['length'])))
            return FALSE;

        // Check card number prefix
        if ( ! preg_match('/^'.$cards[$type]['prefix'].'/', $number))
            return FALSE;

        // No Luhn check required
        if ($cards[$type]['luhn'] == FALSE)
            return TRUE;

        // Checksum of the card number
        $checksum = 0;

        for ($i = $length - 1; $i >= 0; $i -= 2)
        {
            // Add up every 2nd digit, starting from the right
            $checksum += $number[$i];
        }

        for ($i = $length - 2; $i >= 0; $i -= 2)
        {
            // Add up every 2nd digit doubled, starting from the right
            $double = $number[$i] * 2;

            // Subtract 9 from the double where value is greater than 10
            $checksum += ($double >= 10) ? $double - 9 : $double;
        }

        // If the checksum is a multiple of 10, the number is valid
        return ($checksum % 10 === 0);
    }

    /**
     * Checks if a phone number is valid.
     *
     * @param   string   phone number to check
     * @return  boolean
     */
    public static function phone($number, $lengths = NULL)
    {
        if ( ! is_array($lengths))
        {
            $lengths = array(7,10,11);
        }

        // Remove all non-digit characters from the number
        $number = preg_replace('/\D+/', '', $number);

        // Check if the number is within range
        return in_array(strlen($number), $lengths);
    }

    /**
     * Tests if a string is a valid date string.
     *
     * @param   string   date to check
     * @return  boolean
     */
    public static function date($str)
    {
        return (strtotime($str) !== FALSE);
    }

    /**
     * Checks whether a string consists of alphabetical characters only.
     *
     * @param   string   input string
     * @param   boolean  trigger UTF-8 compatibility
     * @return  boolean
     */
    public static function alpha($str, $utf8 = FALSE)
    {
        return ($utf8 === TRUE)
                ? (bool) preg_match('/^\pL++$/uD', (string) $str)
                : ctype_alpha((string) $str);
    }

    /**
     * Checks whether a string consists of alphabetical characters and numbers only.
     *
     * @param   string   input string
     * @param   boolean  trigger UTF-8 compatibility
     * @return  boolean
     */
    public static function alpha_numeric($str, $utf8 = FALSE)
    {
        return ($utf8 === TRUE)
                ? (bool) preg_match('/^[\pL\pN]++$/uD', (string) $str)
                : ctype_alnum((string) $str);
    }

    /**
     * Checks whether a string consists of alphabetical characters, numbers, underscores and dashes only.
     *
     * @param   string   input string
     * @param   boolean  trigger UTF-8 compatibility
     * @return  boolean
     */
    public static function alpha_dash($str, $utf8 = FALSE)
    {
        return ($utf8 === TRUE)
                ? (bool) preg_match('/^[-\pL\pN_]++$/uD', (string) $str)
                : (bool) preg_match('/^[-a-z0-9_]++$/iD', (string) $str);
    }

    /**
     * Checks whether a string consists of digits only (no dots or dashes).
     *
     * @param   string   input string
     * @param   boolean  trigger UTF-8 compatibility
     * @return  boolean
     */
    public static function digit($str, $utf8 = FALSE)
    {
        return ($utf8 === TRUE)
                ? (bool) preg_match('/^\pN++$/uD', (string) $str)
                : ctype_digit((string) $str);
    }

    /**
     * Checks whether a string is a valid number (negative and decimal numbers allowed).
     *
     * @see Uses locale conversion to allow decimal point to be locale specific.
     * @see http://www.php.net/manual/en/function.localeconv.php
     *
     * @param   string   input string
     * @return  boolean
     */
    public static function numeric($str)
    {
        // Use localeconv to set the decimal_point value: Usually a comma or period.
        $locale = localeconv();
        return (bool) preg_match('/^-?[0-9'.$locale['decimal_point'].']++$/D', (string) $str);
    }

    /**
     * Checks whether a string is a valid text. Letters, numbers, whitespace,
     * dashes, periods, and underscores are allowed.
     *
     * @param   string   text to check
     * @return  boolean
     */
    public static function standard_text($str)
    {
        // pL matches letters
        // pN matches numbers
        // pZ matches whitespace
        // pPc matches underscores
        // pPd matches dashes
        // pPo matches normal puncuation
        return (bool) preg_match('/^[\pL\pN\pZ\p{Pc}\p{Pd}\p{Po}]++$/uD', (string) $str);
    }

    /**
     * Checks if a string is a proper decimal format. The format array can be
     * used to specify a decimal length, or a number and decimal length, eg:
     * array(2) would force the number to have 2 decimal places, array(4,2)
     * would force the number to have 4 digits and 2 decimal places.
     *
     * @param   string   input string
     * @param   array    decimal format: y or x,y
     * @return  boolean
     */
    public static function decimal($str, $format = NULL)
    {
        // Create the pattern
        $pattern = '/^[0-9]%s\.[0-9]%s$/';

        if ( ! empty($format))
        {
            if (count($format) > 1)
            {
                // Use the format for number and decimal length
                $pattern = sprintf($pattern, '{'.$format[0].'}', '{'.$format[1].'}');
            }
            elseif (count($format) > 0)
            {
                // Use the format as decimal length
                $pattern = sprintf($pattern, '+', '{'.$format[0].'}');
            }
        }
        else
        {
            // No format
            $pattern = sprintf($pattern, '+', '+');
        }

        return (bool) preg_match($pattern, (string) $str);
    }


    public static function URLBYUser($url){
        return (bool) preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }


    /**
     * Проверка на существования электронного адреса на почтовом серверере
     * @param string $email
     * @return bool
     */
    public static function emailOnMailServer($email)
    {

        $validator=new ValidateEmailOnServer();

        /* how many seconds to wait before each attempt to connect to the
     destination e-mail server */
        $validator->timeout=10;
        /* how many seconds to wait for data exchanged with the server.
    set to a non zero value if the data timeout will be different
    than the connection timeout. */
        $validator->data_timeout=0;
        /* user part of the e-mail address of the sending user
    (info@phpclasses.org in this example) */
        $validator->localuser="chura";
        /* domain part of the e-mail address of the sending user */
        $validator->localhost="wellpay.ru";
        /* Set to 1 if you want to output of the dialog with the
     destination mail server */
        $validator->debug=0;
        /* Set to 1 if you want the debug output to be formatted to be
    displayed properly in a HTML page. */
        $validator->html_debug=0;
        $validator->exclude_address="";

        if (($result=$validator->ValidateEmailBox($email))<0)
        {
            // It was not possible to determine if $email is a valid deliverable e-mail box address
            return false;
        }
        else
        {
            return ($result ? true : false);
        }
    }


} // End







/*
* email_validation.php
*
* @(#) $Header: /home/mlemos/cvsroot/emailvalidation/email_validation.php,v 1.26 2009/09/03 00:30:43 mlemos Exp $
*
*/
class ValidateEmailOnServer
{
    var $email_regular_expression="^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~]+\\.)+[a-zA-Z]{2,6}\$";
    var $timeout=0;
    var $data_timeout=0;
    var $localhost="";
    var $localuser="";
    var $debug=0;
    var $html_debug=0;
    var $exclude_address="";
    var $getmxrr="GetMXRR";
    var $next_token="";
    var $preg;
    var $last_code="";
    Function Tokenize($string,$separator="")
    {
        if(!strcmp($separator,""))
        {
            $separator=$string;
            $string=$this->next_token;
        }
        for($character=0;$character<strlen($separator);$character++)
        {
            if(GetType($position=strpos($string,$separator[$character]))=="integer")
                $found=(IsSet($found) ? min($found,$position) : $position);
        }
        if(IsSet($found))
        {
            $this->next_token=substr($string,$found+1);
            return(substr($string,0,$found));
        }
        else
        {
            $this->next_token="";
            return($string);
        }
    }
    Function OutputDebug($message)
    {
        $message.="\n";
        if($this->html_debug)
            $message=str_replace("\n","<br />\n",HtmlEntities($message));
        echo $message;
        flush();
    }
    Function GetLine($connection)
    {
        for($line="";;)
        {
            if(@feof($connection))
                return(0);
            $line.=@fgets($connection,100);
            $length=strlen($line);
            if($length>=2
               && substr($line,$length-2,2)=="\r\n")
            {
                $line=substr($line,0,$length-2);
                if($this->debug)
                    $this->OutputDebug("S $line");
                return($line);
            }
        }
    }
    Function PutLine($connection,$line)
    {
        if($this->debug)
            $this->OutputDebug("C $line");
        return(@fputs($connection,"$line\r\n"));
    }
    Function ValidateEmailAddress($email)
    {
        return(preg_match('/'.str_replace('/', '\\/', $this->email_regular_expression).'/', $email));
    }
    Function ValidateEmailHost($email,&$hosts)
    {
        if(!$this->ValidateEmailAddress($email))
            return(0);
        $user=$this->Tokenize($email,"@");
        $domain=$this->Tokenize("");
        $hosts=$weights=array();
        $getmxrr=$this->getmxrr;
        if(function_exists($getmxrr)
           && $getmxrr($domain,$hosts,$weights))
        {
            $mxhosts=array();
            for($host=0;$host<count($hosts);$host++)
                $mxhosts[$weights[$host]]=$hosts[$host];
            KSort($mxhosts);
            for(Reset($mxhosts),$host=0;$host<count($mxhosts);Next($mxhosts),$host++)
                $hosts[$host]=$mxhosts[Key($mxhosts)];
        }
        else
        {
            if(strcmp($ip=@gethostbyname($domain),$domain)
               && (strlen($this->exclude_address)==0
                   || strcmp(@gethostbyname($this->exclude_address),$ip)))
                $hosts[]=$domain;
        }
        return(count($hosts)!=0);
    }
    Function VerifyResultLines($connection,$code)
    {
        while(($line=$this->GetLine($connection)))
        {
            $this->last_code=$this->Tokenize($line," -");
            if(strcmp($this->last_code,$code))
                return(0);
            if(!strcmp(substr($line, strlen($this->last_code), 1)," "))
                return(1);
        }
        return(-1);
    }
    Function ValidateEmailBox($email)
    {
        if(!$this->ValidateEmailHost($email,$hosts))
            return(0);
        if(!strcmp($localhost=$this->localhost,"")
           && !strcmp($localhost=getenv("SERVER_NAME"),"")
           && !strcmp($localhost=getenv("HOST"),""))
            $localhost="localhost";
        if(!strcmp($localuser=$this->localuser,"")
           && !strcmp($localuser=getenv("USERNAME"),"")
           && !strcmp($localuser=getenv("USER"),""))
            $localuser="root";
        for($host=0;$host<count($hosts);$host++)
        {
            $domain=$hosts[$host];
            if(preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$domain))
                $ip=$domain;
            else
            {
                if($this->debug)
                    $this->OutputDebug("Resolving host name \"".$hosts[$host]."\"...");
                if(!strcmp($ip=@gethostbyname($domain),$domain))
                {
                    if($this->debug)
                        $this->OutputDebug("Could not resolve host name \"".$hosts[$host]."\".");
                    continue;
                }
            }
            if(strlen($this->exclude_address)
               && !strcmp(@gethostbyname($this->exclude_address),$ip))
            {
                if($this->debug)
                    $this->OutputDebug("Host address of \"".$hosts[$host]."\" is the exclude address");
                continue;
            }
            if($this->debug)
                $this->OutputDebug("Connecting to host address \"".$ip."\"...");
            if(($connection=($this->timeout ? @fsockopen($ip,25,$errno,$error,$this->timeout) : @fsockopen($ip,25))))
            {
                $timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
                if($timeout
                   && function_exists("socket_set_timeout"))
                    socket_set_timeout($connection,$timeout,0);
                if($this->debug)
                    $this->OutputDebug("Connected.");
                if($this->VerifyResultLines($connection,"220")>0
                   && $this->PutLine($connection,"HELO $localhost")
                   && $this->VerifyResultLines($connection,"250")>0
                   && $this->PutLine($connection,"MAIL FROM: <$localuser@$localhost>")
                   && $this->VerifyResultLines($connection,"250")>0
                   && $this->PutLine($connection,"RCPT TO: <$email>")
                   && ($result=$this->VerifyResultLines($connection,"250"))>=0)
                {
                    if($result)
                    {
                        if($this->PutLine($connection,"DATA"))
                            $result=($this->VerifyResultLines($connection,"354")!=0);
                    }
                    if(!$result)
                    {
                        if(strlen($this->last_code)
                           && !strcmp($this->last_code[0],"4"))
                            $result=-1;
                    }
                    if($this->debug)
                        $this->OutputDebug("This host states that the address is ".($result ? ($result>0 ? "valid" : "undetermined") : "not valid").".");
                    @fclose($connection);
                    if($this->debug)
                        $this->OutputDebug("Disconnected.");
                    return($result);
                }
                if($this->debug)
                    $this->OutputDebug("Unable to validate the address with this host.");
                @fclose($connection);
                if($this->debug)
                    $this->OutputDebug("Disconnected.");
            }
            else
            {
                if($this->debug)
                    $this->OutputDebug("Failed.");
            }
        }
        return(-1);
    }
};



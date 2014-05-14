<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Money helper class.
 *
 * $Id: arr.php 4346 2009-05-11 17:08:15Z zombor $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2012 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class money_Core {

    /**
     * Return a callback array from a string, eg: limit[10,20] would become
     * array('limit', array('10', '20'))
     *
     * @param   string  callback string
     * @return  array
     */
    public static function ru($key)
    {
        if($key == 0){
            //return '-';
        }
        $money = number_format($key, 2, '.', ' ');
        if(substr($money, -2) != '00'){
            $money = str_replace(".", "<sup>", $money).'</sup>';
        }else{
            $money = substr($money, 0, -3);
        }
        $money .= ' р.';
        return $money;
    }
 
//  print write_price_in_words(21.11);
  //цена прописью

//конец вставки для отображения кода

  static function writePrice($price)
  {
    $price = number_format($price, 2, '.', '');
    $point = strpos($price, '.');
    //отделяем рубли от копеек
    if(!empty($point))
    {
      $rub = substr($price, 0, $point);
      $kop = substr($price, $point + 1);
    }
    //преобразуем рубли
    $str = self::write_number_in_words($rub) ;
    //пишем рублей(ь,я)
    $word = " рублей";
    //последнее число
    $last_digit = $rub[(strlen($rub) - 1)];
    //предпоследнее число
    $pred_last_digit = $rub[(strlen($rub) - 2)];
    if($last_digit == '1' && $pred_last_digit != '1')
      $word = " рубль";
    elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1')
      $word = " рубля";
    $str .= $word;
    //преобразуем копейки
    if(!empty($kop))
    {

      $str .= self::write_number_in_words($kop, 'femininum') ;
      //пишем копейка (и, ек)
      $word = " копеек";
      //последнее число
      $last_digit = $kop[(strlen($kop) - 1)];
      //предпоследнее число
      $pred_last_digit = $kop[(strlen($kop) - 2)];
      if($last_digit == '1' && $pred_last_digit != '1')
           $word = " копейка";
         elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1' )
           $word = " копейки";
      $str .= $word;
    }
    setlocale(LC_ALL, 'ru_RU.cp1251');
    return ucfirst($str);
  }

  //допустимый диапазон чисел 0 .. 999999
  //число прописью
  static function write_number_in_words ($num, $genus = 'masculinum')
  {
    //разряд: единицы, десятки, сотни, тысячи
    $cur_order = "единицы";
    $cur_thousands_order = "единицы";
    if($num == 0)
      return " 00";
    $num = strval($num);
    $limit = strlen($num) - 1;
    $next_digit = '0';
      $str = '';
    for($i = $limit; $i >= 0; $i--)
    {
      //тысячный разряд
      if($cur_order == "тысячи")
      {
        //сотни
        if($cur_thousands_order == "сотни")
        {
          $str = self::write_units_hundreds($num[$i]).$str;
        }
        //десятки
        if($cur_thousands_order == "десятки")
        {
          $str = self::write_units_tens($num[$i], $next_digit).$str;
          $cur_thousands_order = "сотни";
          $next_digit = '0';
        }
        //единицы
        if($cur_thousands_order == "единицы")
        {
          if ($i>0) {
           if($num[$i-1] == "1")
           {
             $next_digit = $num[$i];
             $str = " тысяч".$str;
           }
           else {
             $str = self::write_units_thousands_units($num[$i]).$str;
             $next_digit = '0';
           }
          }
          else {$str = self::write_units_thousands_units($num[$i]).$str; $next_digit = '0';}
          $cur_thousands_order = "десятки";
        }
      }
      //сотни
      if($cur_order == "сотни")
      {
        $str = self::write_units_hundreds($num[$i]).$str;
        $cur_order = "тысячи";
      }
      //десятки
      if($cur_order == "десятки")
      {
        $next_d = ($next_digit)?$next_digit:'';
        $str = self::write_units_tens($num[$i], $next_d).$str;
        $cur_order = "сотни";
        $next_digit = '0';
      }
      //единицы
      if($cur_order == "единицы")
      {
        if($num[$i-1] == "1")
          $next_digit = $num[$i];
        else
          $str = self::write_units($num[$i], $genus);
        $cur_order = "десятки";
      }
    }
    return($str);
  }

    //принадлежит функции write_number_in_words
    //преобразует десятки
    static function write_units_tens ($tens, $next_digit)
    {
      $str_tens="";
      $tens .= $next_digit;
      if($tens == 2) $str_tens = " двадцать";
      if($tens == 3) $str_tens = " тридцать";
      if($tens == 4) $str_tens = " сорок";
      if($tens == 5) $str_tens = " пятьдесят";
      if($tens == 6) $str_tens = " шестьдесят";
      if($tens == 7) $str_tens = " семьдесят";
      if($tens == 8) $str_tens = " восемьдесят";
      if($tens == 9) $str_tens = " девяносто";
      if($tens == 10) $str_tens = " десять";
      if($tens == 11) $str_tens = " одиннадцать";
      if($tens == 12) $str_tens = " двенадцать";
      if($tens == 13) $str_tens = " тринадцать";
      if($tens == 14) $str_tens = " четырнадцать";
      if($tens == 15) $str_tens = " пятнадцать";
      if($tens == 16) $str_tens = " шестнадцать";
      if($tens == 17) $str_tens = " семнадцать";
      if($tens == 18) $str_tens = " восемнадцать";
      if($tens == 19) $str_tens = " девятнадцать";
      return($str_tens);
    }

    //принадлежит функции write_number_in_words
    //преобразует сотни
    static function write_units_hundreds ($hundreds)
    {
      $str_hundreds="";
      if($hundreds == 1) $str_hundreds = " сто";
      if($hundreds == 2) $str_hundreds = " двести";
      if($hundreds == 3) $str_hundreds = " триста";
      if($hundreds == 4) $str_hundreds = " четыреста";
      if($hundreds == 5) $str_hundreds = " пятьсот";
      if($hundreds == 6) $str_hundreds = " шестьсот";
      if($hundreds == 7) $str_hundreds = " семьсот";
      if($hundreds == 8) $str_hundreds = " восемьсот";
      if($hundreds == 9) $str_hundreds = " девятьсот";
      return($str_hundreds);
    }

    //принадлежит функции write_number_in_words
    //преобразует единицы тысячного разряда
    static function write_units_thousands_units ($hundreds)
    {
      $str_hundreds="";
      if($hundreds == 0) $str_hundreds = " тысяч";
      if($hundreds == 1) $str_hundreds = " одна тысяча";
      if($hundreds == 2) $str_hundreds = " две тысячи";
      if($hundreds == 3) $str_hundreds = " три тысячи";
      if($hundreds == 4) $str_hundreds = " четыре тысячи";
      if($hundreds == 5) $str_hundreds = " пять тысяч";
      if($hundreds == 6) $str_hundreds = " шесть тысяч";
      if($hundreds == 7) $str_hundreds = " семь тысяч";
      if($hundreds == 8) $str_hundreds = " восемь тысяч";
      if($hundreds == 9) $str_hundreds = " девять тысяч";
      return($str_hundreds);
    }

    //принадлежит функции write_number_in_words
    //преобразует единицы
    static function write_units ($units, $genus='masculinum')
    {
      $str_units="";
      if($genus == 'masculinum')
      {
           if($units == 1) $str_units = " один";
           if($units == 2) $str_units = " два";
      }
      if($genus == 'femininum')
      {
           if($units == 1) $str_units = " одна";
           if($units == 2) $str_units = " две";

      }
      if($units == 3) $str_units = " три";
      if($units == 4) $str_units = " четыре";
      if($units == 5) $str_units = " пять";
      if($units == 6) $str_units = " шесть";
      if($units == 7) $str_units = " семь";
      if($units == 8) $str_units = " восемь";
      if($units == 9) $str_units = " девять";
      return($str_units);
    }



} // End arr

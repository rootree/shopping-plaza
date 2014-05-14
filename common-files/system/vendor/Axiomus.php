<?php
/**
 * Взаимодействие с axiomus
 * User: Ivan
 * Date: 16.05.12
 * Time: 23:42
 */
 
class Axiomus{

    static $URL = "http://axiomus.ru/hydra/api_xml.php";
    static $ukey = "******";
    static $uid = "1";

    private $XML;

	function __construct(){

		if($GLOBALS['runningOn'] == '1'){
			Axiomus::$URL = 'http://axiomus.ru/test/api_xml_test.php';
			Axiomus::$ukey = '******';
			Axiomus::$uid = '1';
		}
	}

    private function sendRequest(){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Axiomus::$URL); // set url to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
        curl_setopt($ch, CURLOPT_POST, 1); // set POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".urlencode($this->XML)); // add POST fields
        $result = curl_exec($ch); // run the whole process
curl_close($ch);
        return $result; //show result on screen



    }

    function newOrder($content, $toMCAD = false, & $total = 0){


        $ukey = Axiomus::$ukey;

        $cash = 'no';
        $cheque = ($content->item->payment == 'Оплата наличными' ? 'yes' : 'no');;
        $selsize = 'no';

        $checksum = md5('');

        //   'uid'.'кол-во наименований'.'кол-во товаров'.'сумма для клиента полностью (с учетом incl_deliv_sum)'.'дата и время начала доставки'.'cash/payments/selsize'

        // пример на php <? $checksum = md5(Axiomus::$uid.'3'.'6'.'1741.25'.'2009-06-25 12:00'.'yes/no/no');


        $b_time = !empty($content->deliveryInfo->deliveryTimeFrom) ? $content->deliveryInfo->deliveryTimeFrom : 10;
        $e_time = !empty($content->deliveryInfo->deliveryTimeTo) ? $content->deliveryInfo->deliveryTimeTo : 15;

        $d_date = (!empty($content->deliveryInfo->deliveryDate) ? $content->deliveryInfo->deliveryDate : date('Y-m-d', strtotime('+24 hour')));


        $orderContent = '';
        $conter = 0;
        $conterItem = 0;


        $totalSum=0;
        foreach ($content->items as $itemT){

            $costDD = (empty($itemT->costerFM)) ? $itemT->price : $itemT->costerFM;

            $conterItem++;
            $conter += $itemT->counteS;

            $totalSum += ($itemT->counteS * $costDD);

            $art = $this->itemArticule($itemT->arcitule);
            $title = $this->itemTitle($itemT);

            $orderContent .= '<item bundling="1" name="'.$title.' (Артикул '.$art.')"  weight="1" quantity="'.$itemT->counteS.'" price="'.$costDD.'" />'."\n";

        }

        if($toMCAD){
            $distance = (isset($content->deliveryInfo->distance) &&
                         !empty($content->deliveryInfo->distance) ? $content->deliveryInfo->distance : 5);
            if($distance <= 5){
                $delivery_cost = 300 + 50;
            }elseif($distance <= 10){
                $delivery_cost = 300 + 100;
            }else{
                $delivery_cost = 300 + $distance * 15;
            }
        }else{
            $delivery_cost = $content->item->delivery_cost;
        }

        $totalSum += $delivery_cost;

		  $total = $totalSum;
        $inner_id = $content->item->id;
        $checksum = md5(Axiomus::$uid.$conterItem.$conter.$totalSum.$d_date.' '.$b_time.''.$cash.'/'.$cheque.'/'.$selsize.'');

        $from_mkad = ($toMCAD) ? ((isset($content->deliveryInfo->distance) &&
                                   !empty($content->deliveryInfo->distance) ? $content->deliveryInfo->distance : 5)) : 0;


        $q = 'г. '.($toMCAD ? $content->deliveryInfo->metro : $content->firm->city). ', ул. ' . $content->deliveryInfo->street . ', д.' . $content->deliveryInfo->house .
             (!empty($content->deliveryInfo->houseAddOn) ? ', cтр./кор.' . $content->deliveryInfo->houseAddOn : '') .
             (!empty($content->deliveryInfo->podiezd) ? ', подъезд.' . $content->deliveryInfo->podiezd : '') .
             (!empty($content->deliveryInfo->floor) ? ', эт.' . $content->deliveryInfo->floor : '') .
             (!empty($content->deliveryInfo->apr) ? ', кв.' . $content->deliveryInfo->apr : '')
        ;
        $phone = format::phone($content->deliveryInfo->phone);
        $name = ($content->deliveryInfo->name);
        $comment = ($content->deliveryInfo->comment);



        $this->XML = <<< XML
<?xml version='1.0' standalone='yes'?>
<singleorder>
<mode>new</mode>
<auth ukey="{$ukey}" checksum="{$checksum}" />
<order inner_id="{$inner_id}" name="{$name}"  address="{$q}" from_mkad="{$from_mkad}" d_date="{$d_date}" b_time="{$b_time}" e_time="{$e_time}" incl_deliv_sum="{$delivery_cost}" places="{$conter}" city="0" >
   <contacts>{$phone}</contacts>
   <description>{$comment}</description>
   <services cash="{$cash}" cheque="{$cheque}" selsize="{$selsize}" />
   <items>
        {$orderContent}
   </items>
</order>
</singleorder>


XML;
 
        return $this->sendRequest();
        /*
       <?xml version="1.0" encoding="utf-8"?>
       <response>
       <request>new</request>
       <auth objectid="300352">02308514a2f2911fcab573671e595974</auth>
       <status price="290.20" code="0">запрос обработан и выполнен успешно</status>
       </response>
        */
    }



/*
NEW_ORDER.XML

* - необязательные атрибуты и элементы
<auth>
ukey - ключ, я пришлю (вместе с номером пользователя uid)
checksum - контрольная сумма - hash md5, вычисляется как 'uid'.'кол-во наименований'.'кол-во товаров'.'сумма для клиента полностью (с учетом incl_deliv_sum)'.'дата b_date'.'cash/payments'

пример на php <? $checksum = md5('232'.'3'.'6'.'1741.25'.'2009-06-25'.'yes/no'); ?>
<order>
* inner_id - Ваш внутренний номер заказа (tinytext(255))
b_date, e_date - время хранения самовывоза с .. до .. (в формате ISO (date Y-m-d), дата не ранее сегодня)
* incl_deliv_sum - включить в сумму заказа стоимость доставки (в т.ч. отдельной строкой в бланке)
office (enum: 0 - Москва-Север, 1 - Москва-Юг, 2 - Санк-Петербург)
places - количество мест в заказе (int)
</order>

<contacts> - контактная информация (text(64k))
*<description> - пояснения, комментарии к заказу (text(64k))

* <services> - дополнительные услуги:
*cash="yes" - наложенный платеж	('yes'/'no')
*cheque="yes" - чек по агентскому договору (включает в себя cash)	('yes'/'no')


<item> - товар
name - название товара (tinytext(255))
weight - вес, положительное число (double(9,3))
quantity - кол-во, минимум 1 (int)
price - цена, м.б. равна 0, если не требуется прием денег от клиентов (float(9,2))
* bundling="1" - распоряжение на комплектацию заказа





    */
    function newCarryOut($content, & $total = 0){

        $ukey = Axiomus::$ukey;

        $cash = 'no';
        $cheque = 'yes';
        // $cheque = ($content->item->payment == 'Оплата наличными' ? 'yes' : 'no');

 
        $b_date = (!empty($content->deliveryInfo->deliveryDate) ? $content->deliveryInfo->deliveryDate : date('Y-m-d', strtotime('+24 hour')));
        $e_date = date('Y-m-d', strtotime("+" . (24*3)." hour", strtotime($b_date)));

        $orderContent = '';
        $conter = 0;
        $conterItem = 0;


        $totalSum=0;
        foreach ($content->items as $itemT){

            $costDD = (empty($itemT->costerFM)) ? $itemT->price : $itemT->costerFM;

            $conterItem++;
            $conter += $itemT->counteS;

            $totalSum += ($itemT->counteS * $costDD);

            $art = $this->itemArticule($itemT->arcitule);
            $title = $this->itemTitle($itemT);
//DVR-127 (кория 55555)

            $orderContent .= '<item bundling="1" name="'.$title.' (Артикул '.$art.')"  weight="1" quantity="'.$itemT->counteS.'" price="'.$costDD.'" />'."\n";

        }

        $delivery_cost = $content->item->delivery_cost;
        $totalSum += $delivery_cost;
		 $total = $totalSum;
        $inner_id = $content->item->id;
        $checksum = md5(Axiomus::$uid.$conterItem.$conter.$totalSum.$b_date.''.$cash.'/'.$cheque.'');

// checksum - контрольная сумма - hash md5, вычисляется как 'uid'.'кол-во наименований'.'кол-во товаров'.'сумма для клиента полностью (с учетом incl_deliv_sum)'.'дата b_date'.'cash/payments'

// пример на php <? $checksum = md5('232'.'3'.'6'.'1741.25'.'2009-06-25'.'yes/no');  

        $from_mkad = 0;
 
        $phone = format::phone($content->deliveryInfo->phone);
        $name = ($content->deliveryInfo->name);
        $comment = '';

        $this->XML = <<< XML
<?xml version='1.0' standalone='yes'?>
<singleorder>
<mode>new_carry</mode>
<auth ukey="{$ukey}" checksum="{$checksum}" />
<order inner_id="{$inner_id}" name="{$name}" office="0" b_date="{$b_date}" e_date="{$e_date}" incl_deliv_sum="{$delivery_cost}" places="{$conter}">
   <contacts>{$phone}</contacts>
   <description>{$comment}</description>
   <services cash="{$cash}" cheque="{$cheque}" />
   <items>
        {$orderContent}
   </items>
</order>
</singleorder>


XML;

        return $this->sendRequest();
/*

 <?xml version='1.0' standalone='yes'?>
<singleorder>
<mode>new_carry</mode>
<auth ukey="XXcd208495d565ef66e7dff9f98764XX" checksum="712053f3ff57bac1878fa9cfd8e34bd1" />
<order inner_id="самовыв. 111" name="Петр" office="0" b_date="2011-03-10" e_date="2011-03-15" incl_deliv_sum="200.15" places="1">
   <contacts>тел. (499) 222-33-22</contacts>
   <description>осторожно - хрупкий товар</description>
   <services cash="yes" cheque="no" />
   <items>
		<item name="Крем для лица"  weight="0.400" quantity="1" price="155.00" />
		<item name="Крем для тела"  weight="0.340" quantity="3" price="235.00" />
		<item name="Крем для рук"  weight="1.000" quantity="2" price="340.55" />
   </items>
</order>
</singleorder>

 */
    }


    
/*
NEW_POST.XML

* - необязательные атрибуты и элементы
<auth>
ukey - ключ, я пришлю (вместе с номером пользователя uid)
checksum - контрольная сумма - hash md5, вычисляется как 'uid'.'кол-во наименований'.'кол-во товаров'.'сумма для клиента полностью (с учетом incl_deliv_sum)'.'дата b_date'.'valuation/fragile/cod'

пример на php <? $checksum = md5('232'.'3'.'6'.'1741.25'.'2009-06-25'.'yes/no/no'); ?>
<order>
* inner_id - Ваш внутренний номер заказа (tinytext(255))
name - ФИО получателя
b_date - дата отправки заказа (в формате ISO (date Y-m-d), дата не ранее сегодня)
* incl_deliv_sum - включить в сумму заказа стоимость доставки (в т.ч. отдельной строкой в бланке)
places - количество мест в заказе (int)
post_type - тип отправления (enum: 1 - Посылка, 2 - Бандероль 1 класс)
</order>

<address>
index - индекс получателя (tinytext(255))
* region - регион получателя (tinytext(255))
* area - город / район получателя (tinytext(255))
p_address - адрес получателя (tinytext(255))
</address>
<contacts> - телефон (text(64k))

*<services> - дополнительные услуги:
*valuation="yes" - объявленная стоимость ('yes'/'no')
*fragile="yes" - хрупкий груз! ('yes'/'no')
*cod="yes" - наложенный платеж ('yes'/'no')

<items>
<item> - товар
name - название товара (tinytext(255))
weight - вес, положительное число (double(9,3))
quantity - кол-во, минимум 1 (int)
price - цена, м.б. равна 0, если не требуется прием денег от клиентов (float(9,2))
* bundling="1" - распоряжение на комплектацию заказа
</items>



    */


    private function itemArticule($art){
        if(preg_match("/копия/ms", $art)){ 
            $art = substr($art, 0, strpos($art, '('));
        }
        return trim($art);
    }

    private function itemTitle($item){

        $title = '';
        if($item->cat_id == 53){
            $title = 'Автомобильный видеорегистратор '.$item->catTitle;
        }else{
            $title = $item->title;
        }
        return trim($title);
    }


    function newPost($content, & $total = 0){
 
        $ukey = Axiomus::$ukey;
/*
        *valuation="yes" - объявленная стоимость ('yes'/'no')
*fragile="yes" - хрупкий груз! ('yes'/'no')
*cod="yes" - наложенный платеж ('yes'/'no')
                */
        $valuation = 'yes';
        $fragile = 'no';
        $cod = 'no';


        if($content->item->payment == 'Наложенный платёж'){
            $cod = 'yes';
        }
 
        $checksum = md5('');

        $d_date = date('Y-m-d', strtotime("+24 hour"));

        $orderContent = '';
        $conter = 0;
        $conterItem = 0;


        $totalSum=0;
        foreach ($content->items as $itemT){

            $costDD = (empty($itemT->costerFM)) ? $itemT->price : $itemT->costerFM;

            $conterItem++;
            $conter += $itemT->counteS;

            $totalSum += ($itemT->counteS * $costDD);

            $art = $this->itemArticule($itemT->arcitule);
            $title = $this->itemTitle($itemT);

            $orderContent .= '<item bundling="1" name="'.$title.' (Артикул '.$art.')"  weight="1" quantity="'.$itemT->counteS.'" price="'.$costDD.'" />'."\n";

        }

        $delivery_cost = $content->item->delivery_cost;
        $totalSum += $delivery_cost;
		 $total = $totalSum;
        $inner_id = $content->item->id;
        $string = Axiomus::$uid.$conterItem.$conter.$totalSum.$d_date.$valuation.'/'.$fragile.'/'.$cod;


// checksum - контрольная сумма - hash md5, вычисляется как
        // 'uid'.'кол-во наименований'.'кол-во товаров'.'сумма для клиента полностью (с учетом incl_deliv_sum)'.'дата b_date'.'valuation/fragile/cod'

// пример на php <? $checksum = md5('232'.'3'.'6'.'1741.25'.'2009-06-25'.'yes/no/no');

        $checksum = md5($string);
 
        $q =  'ул. '.
                             $content->deliveryInfo->street . ', д.' . $content->deliveryInfo->house .
								(!empty($content->deliveryInfo->houseAddOn) ? ', cтр./кор.' . $content->deliveryInfo->houseAddOn : '') .
							 (!empty($content->deliveryInfo->podiezd) ? ', подъезд.' . $content->deliveryInfo->podiezd : '') .
							 (!empty($content->deliveryInfo->floor) ? ', эт.' . $content->deliveryInfo->floor : '') .
							 (!empty($content->deliveryInfo->apr) ? ', кв.' . $content->deliveryInfo->apr : '')  ;

;
        $phone = format::phone($content->deliveryInfo->phone);
        $name = ($content->deliveryInfo->soname.' '.$content->deliveryInfo->name.' '.$content->deliveryInfo->thirdName);
        $comment = ($content->deliveryInfo->comment);

        $index = ($content->deliveryInfo->index);
        $region = ($content->deliveryInfo->region);
        $area = ($content->deliveryInfo->city);
        $p_address = $q;


        $this->XML = <<< XML
<?xml version='1.0' standalone='yes'?>
<singleorder>
<mode>new_post</mode>
<auth ukey="{$ukey}" checksum="{$checksum}" />
<order inner_id="{$inner_id}" name="{$name}"  address="{$q}" b_date="{$d_date}" incl_deliv_sum="{$delivery_cost}" places="{$conter}" post_type="1" >
    <address index="{$index}" region="{$region}" area="{$area}" p_address="{$p_address}" />
   <contacts>{$phone}</contacts>
   <description>{$comment}</description>
   <services valuation="{$valuation}" fragile="{$fragile}" cod="{$cod}" />
   <items>
        {$orderContent}
   </items>
</order>
</singleorder>


XML;
// echo $this->XML; exit();
       return  $this->sendRequest(); 
/*

 <?xml version='1.0' standalone='yes'?>
<singleorder>
<mode>new_post</mode>
<auth ukey="XXcd208495d565ef66e7dff9f98764XX" checksum="712053f3ff57bac1878fa9cfd8e34bd1" />
<order inner_id="почта 333" name="Петр Петров G" b_date="2011-03-10" incl_deliv_sum="200.15" places="1" post_type="1">
   <address index="127322" region="Камчатский край" area="Петропавловск Камчатский" p_address="ул. Солнечная д.70, кв. 30" />
   <contacts>(111) 222-3322</contacts>
   <services valuation="yes" fragile="no" cod="no" />
   <items>
		<item name="Крем для лица"  weight="0.400" quantity="1" price="155.00" />
		<item name="Крем для тела"  weight="0.340" quantity="3" price="235.00" bundling="1" />
		<item name="Крем для рук"  weight="1.000" quantity="2" price="340.55" />
   </items>
</order>
</singleorder>

 */
    }
}
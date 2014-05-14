<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Вывод сообщений об ошибках
 *
 * @author Ivan Chura
 */
class status_Core {

    public static function admin($code){

        switch ($code) {
            case ACCESS_GUEST:      return 'Ждёт исполнения';
            case ACCESS_ADMIN:  return 'Выполняеться...';
            case ACCESS_MODER:    return 'Завершена';
            case ACCESS_VIEWER: return 'Отменена';

            default:                     return 'O.o';
        }
    }

    public static function orderStatus($code){

        switch ($code) {
            case ORDER_STATUS_NEW:      return 'Новый';
            case ORDER_STATUS_CANCEL:   return 'Отменённый';
            case ORDER_STATUS_VIEWED:    return 'Просмотреный';
            case ORDER_STATUS_PROCEEDED: return 'Обработанный';
            case ORDER_STATUS_DELIVERED: return 'Доставлен';
            case ORDER_STATUS_PAYED: return 'Оплаченый';

            default:                     return 'O.o';
        }
    }
}

?>
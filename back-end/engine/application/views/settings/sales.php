<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <input type="hidden" value="1" name="ped"/> 

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить">
                    <a href="/dashboard" class="cancelBtn"  >Отмена</a>
                    <a target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>

        <tr >
            <td class="label">Режим продажи:</td>
            <td class="elements view">

                <label><input type="radio" name="sales" value="1" <?php echo ($this->firm->sales == 1) ? 'checked="checked"' : "" ?>> Товарных остатков</label><br/>
                 
                <div class="smallInfo">
                    На странице редактирования продукции вы можете указать количество каждой позиции товара.
                 </div><br/>
                  <div class="smallInfo">
                      К примеру, если вы указали что у вас на складе 5-ть пачек макарон, и их всех уже заказали,
                    то в этом режиме новые покупатели не смогут заказать макароны больше.
                </div><br/>
                  <div class="smallInfo">
                      Этот режим подходит для магазинов, у которых закупка нового товара происходит достаточно долго.
                      Не каждый покупатель будет ждать свою покупку длительное время.
                </div>
<br/>
                <label><input type="radio" name="sales" value="2" <?php echo ($this->firm->sales == 2) ? 'checked="checked"' : "" ?>> Товарных остатков и по предзаказу</label><br/>

                <div class="smallInfo">
                    В данном режиме покупатели смогут оставить заявку на покупку товара.
                 </div><br/>
                 <div class="smallInfo">
                     К примеру, если товар закончился, покупатель сможет заказать, закончившейся на складе, товар,
                     но будет предупреждён, что он его получит
                    с некоторой задержкой, так как его сейчас товара нет в наличии.
                </div><br/>
                <div class="smallInfo">
                      Этот режим подходит для магазинов, закупка нового товара для которых происходит достаточно быстро.
                      Чтобы не терять потенциальных клиентов, они оставят заявку на
                    получение товара как только он будет на складе.
                </div>
            </td>
        </tr>

		<tr >
            <td class="label"></td>
            <td class="elements bottomHandler">
                <input type="submit" value="Сохранить">
                <a href="/dashboard" class="cancelBtn"  >Отмена</a>
                <a target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
            </td>
        </tr>
			 
        </table>

    </form>

</center>
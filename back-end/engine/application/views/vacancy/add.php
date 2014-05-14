<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

    <form action="./" method="post">

        <table class="form">
 
 		<tr >
                <td class="label"></td>
                <td class="elements topHandler">
				<input type="submit" value="Создать"> 
				<a href="/vacancy" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			
            <tr>
                <td class="label">Должность:</td>
                <td class="elements">
                    <input title="Укажите название вакансии" name="vacancy[title]"  class="text" value="<?php echo @html::specialchars($_POST['vacancy']['title']) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Обязанности', $this->errorFields)){ ?>errorField<? } ?>">Обязанности:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" id="vacancy_responsibilities" name="vacancy[responsibilities]"><?php
                        echo @html::specialchars($_POST['vacancy']['responsibilities'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Опишите, что будет требоваться от нового сотрудника.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Требования', $this->errorFields)){ ?>errorField<? } ?>">Требования:</td>
                <td class="elements">

                    <textarea rows="3" cols="2" id="vacancy_requirements"  name="vacancy[requirements]"><?php
                        echo @html::specialchars($_POST['vacancy']['requirements'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Какими навыками, умениями и способнастями должен обладать новый сотрудник.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Условия', $this->errorFields)){ ?>errorField<? } ?>">Условия:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" id="vacancy_conditions" name="vacancy[conditions]"><?php
                        echo @html::specialchars($_POST['vacancy']['conditions'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    
                    <div class="smallInfo">
                         Укажите условия, на которых вы собираетесь нанять сотрудника.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Тип занятости', $this->errorFields)){ ?>errorField<? } ?>">Тип занятости:</td>
                <td class="elements">

                    <select name="vacancy[employment_type]">

					<option value="0">
						-
					</option>
					
                            <?php

                            foreach ($GLOBALS['VACANCY_EMPL_TYPE'] as $key => $champEntry) { ?>


                                <option value="<?php echo $key ?>"
                                    <? if(isset($_POST['vacancy']['employment_type']) && $_POST['vacancy']['employment_type'] == $key) {
                                        echo 'selected="selected"';
                                    } ?>
                                        >
							<?php echo $champEntry  ?>
						</option>

                            <?php } ?>

                    </select>
 
                </td>
            </tr>
 
            <tr>
                <td class="label <? if(in_array('Уровень зарплаты', $this->errorFields)){ ?>errorField<? } ?>">Уровень зарплаты:</td>
                <td class="elements">
                    <input title="Можете указать число, диапазон зарплаты, или оставить поле пустым, если зарплата по согласованию" name="vacancy[wage_level]"  class="text" value="<?php echo @html::specialchars($_POST['vacancy']['wage_level']) ?>" />
                    <div class="smallInfo">
                        Укажите уровень заработной платы.
                    </div>
                </td>
            </tr>


            <tr>
                <td class="label <? if(in_array('Требуемый опыт работы', $this->errorFields)){ ?>errorField<? } ?>">Требуемый опыт работы:</td>
                <td class="elements">

                    <select name="vacancy[experience_required]">

                            <option value="0">
                                -
                            </option>
                        
                            <?php
 
                            foreach ($GLOBALS['VACANCY_XP'] as $key => $champEntry) { ?>

                                <option value="<?php echo $key ?>"
                                    <? if(isset($_POST['vacancy']['experience_required']) && $_POST['vacancy']['experience_required'] == $key) {
                                        echo 'selected="selected"'; 
                                    } ?>
                                        >
                                    <?php echo $champEntry  ?>
                                </option>

                            <?php } ?>
 
                    </select>
 
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Телефон для справок', $this->errorFields)){ ?>errorField<? } ?>">Телефон для справок:</td>
                <td class="elements">
                    <input name="vacancy[tel]"  class="text" value="<?php echo @html::specialchars($_POST['vacancy']['tel']) ?>" />
                    <div class="smallInfo">
                        Укажите контактный телефон, по которому кандидаты могут узнать более подробно о даннной вакансии.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('E-mail', $this->errorFields)){ ?>errorField<? } ?>">E-mail:</td>
                <td class="elements">
                    <input name="vacancy[mail]"  class="text" value="<?php echo @html::specialchars($_POST['vacancy']['mail']) ?>" />

                </td>
            </tr>
 
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Создать"> 
				<a href="/vacancy" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
 
        </table>
    </form>
</center>
 
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input name="fieldsedit[title]" class="text" value="<?php echo @(isset($_POST['fieldsedit']['title'])) ? html::specialchars($_POST['fieldsedit']['title']) : html::specialchars($user->title) ?>" />
 
                </td>
            </tr>
 
            <? if($cats->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Позиция перед', $this->errorFields)){ ?>errorField<? } ?>">Позиция перед:</td>
                    <td class="elements">
                        <select name="fieldsedit[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;
 
                            $len = count($cats);
                            $possDetected = false;

                            for ($i = 0; $i < $len; $i ++) {   $counter ++;

                                $champEntry = $cats[$i];
                                $lastSort = $champEntry->sort;
                                
                                ?>

                                <option value="<?php echo $champEntry->sort ?>"
                                    <?=(($champEntry->field_id == $user->field_id) ? 'disabled="disabled"' : '') ?>
                                    <? if(isset($cats[$i - 1]) && (($cats[$i - 1]->sort) == $user->sort)) {
                                        echo 'selected="selected"';
                                        $possDetected = true;
                                    } ?>>
                                    <?php echo $counter . ". " .$champEntry->title  ?>
                                </option>

                            <?php   } ?>

                            <option value="<?=($lastSort + 1)?>" <?=(!$possDetected ? 'selected="selected"' : "")?>>В самый конец</option>

                        </select>
                         
                    </td>
                </tr>

            <? } ?>

            <tr style="display:none">
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="fieldsedit[excel]" <?php echo ($user->excel == 1) ? 'checked="checked"' : "" ?>  value="1" > Поместить характеристику в Excel-прайс</label>
				<div class="smallInfo">
					При автоматическом составлении Excel-прайса вашего Интернет-магазина, данное характеристика будет включена в него.
                    </div>
                </td>
            </tr>

		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Изменить"> 
				<a href="/settings/fields/catsubid/<?=$catsubid?>" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			 

        </table>

    </form>

</center>
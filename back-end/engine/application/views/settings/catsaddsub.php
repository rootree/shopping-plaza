
<center>

    <form action="" method="post">

        <? if(isset($catssub) && !$catssub->count()) { ?>
            <input name="catssub[sort]" value="1" type="hidden"/>
        <? } ?>
        
        <table class="form">


			
            <tr>
                <td class="label <? if(in_array('Основная категория', $this->errorFields)){ ?>errorField<? } ?> ">Основная категория:</td>
                <td class="elements">
                    <select name="catssub[cat_id]" Title="Выберите основную категорию в которой будет добавлена подкатегория" 
                            onchange="$('#catssub_cat_id').attr('disabled','disabled'); if(this.value != <?=$catid?> && this.value != 0){location.href='/settings/catsaddsub/catid/' + this.value;}">

                        <option value="0" id="catssub_cat_id">
                            Выберите категорию
                        </option>

                        <?php
                        $lastSort = 0; $counter = 0;
                        foreach ($cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>
 
                            <option value="<?php echo $champEntry->cat_id ?>"
                                <?=($catid == $champEntry->cat_id ? 'selected="selected"' : '') ?>
                                    >
                                <?php echo $counter . ". " .$champEntry->title ?>
                            </option>

                        <?php } ?>
 
                    </select>
                    <div class="smallInfo">Привязка будет осуществлена к выбранной основной категории.</div>
                </td>

            </tr>
 
             <? if($catid) { ?>
			 
			 
			 <tr>
					<td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
					<td class="elements">
						<input Title="Укажите название новой подкатегории" name="catssub[title]" class="text" value="<?php echo @html::specialchars($_POST['catssub']['title']) ?>" /> 
					</td>
				</tr>
			
				<? if(isset($catssub) && $catssub->count()) { ?>
					<tr>
						<td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?> ">Разместить перед:</td>
						<td class="elements">
							<select name="catssub[sort]" Title="Выберите расположение среди других подкатегорий " >

								<?php
								$lastSort = 0; $counter = 0;
								foreach ($catssub as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

									<option value="<?php echo $champEntry->sort ?>">
										<?php echo $counter . ". " .$champEntry->title ?>
									</option>

								<?php } ?>

								<option value="<?=($lastSort + 1)?>">В самый конец</option>

							</select> 
							
						</td>
					</tr>

                    <tr>
                        <td class="label <? if(in_array('Развёрнутое описание', $this->errorFields)){ ?>errorField<? } ?>">Развёрнутое описание:</td>
                        <td class="elements">
                            <textarea rows="3" cols="4" id="cat_content" name="catssub[desc]"><?php
                                echo @html::specialchars($_POST['catssub']['desc'])
                            ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                            <div class="smallInfo">
                                Когда пользователь попадает в подкатегорию, первым делом он увидит это описание.
                                <br/><br/>
                                Полезно для описания товаров, которые будут перечислены в этой категории.

                            </div>
                        </td>
                    </tr>

				<? } ?>
  
				<tr >
					<td class="label"></td>
					<td class="elements bottomHandler">
					<input type="submit" value="Добавить"> 
					<a href="/settings/catssub" class="cancelBtn"  >Отмена</a>
					</td>
				</tr>
	 
            <? } ?>

        </table>

    </form>

</center>

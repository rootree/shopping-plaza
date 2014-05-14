
        <div id="" class="body_left_panel shadow" >

            <b>Категории:</b>
            <ol id="nav">

                <? foreach ($this->cats as $item) { ?>

                <?PHP if($this->accessRules['index'] & $this->access){ ?>
                    <li <?php if(STATUS_HIDE == $item->status) { ?> style="background-color: #e2e1e1 !important; "<?php } ?>>
                        <a <?php if($this->catid == $item->cat_id) { ?>id="selected"<?php } ?>
                              href="<?php echo url::site(); ?>products/index/catid/<?php echo ($item->cat_id) ?>">
                        <?php echo ($item->title) ?></a></li>
                    <?PHP } ?>

                <?php } ?>

            </ol>

        </div>

        <? if(isset($this->catssub) && $this->catssub->count()) { ?>

        <div id="" class="body_left_panel shadow" >

            <b>Подкатегории:</b>
            <ol id="nav">


                <? foreach ($this->catssub as $item) { ?>

                <?PHP if($this->accessRules['index'] & $this->access){ ?>
                    <li <?php if(STATUS_HIDE == $item->status) { ?>style="background-color: #e2e1e1 !important; "<?php } ?>><a <?php if($this->catssubid == $item->catsub_id) { ?>id="selected"<?php } ?>
                            href="<?php echo url::site(); ?>products/index/catid/<?php echo ($item->cat_id) ?>/catssubid/<?php echo ($item->catsub_id) ?>"
                            ><?php echo ($item->title) ?></a></li>
                    <?PHP } ?>

                <?php } ?>

            </ol>

        </div>

        <?php } ?>
 

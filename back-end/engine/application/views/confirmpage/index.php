<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


    <center>

        <form action="/confirmpage" method="post">

            <table class="form">

                <tr>
                    <td class="label">Введите когд подтверждения:</td>
                    <td class="elements">
                        <input name="confirm_code" value="<?php echo @html::specialchars($_REQUEST['confirm_code']) ?>" />
                        <div class="smallInfo">
                            Уровни не должны повторяться
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">Введите когд фирмы:</td>
                    <td class="elements">
                        <input name="firmID" value="<?php echo @html::specialchars($_REQUEST['firmID']) ?>" />
                        <div class="smallInfo">
                            Уровни не должны повторяться
                        </div>
                    </td>
                </tr>


                <tr>
                    <td class="label"></td>
                    <td class="elements">
                        <input type="submit" value="Ога">
                    </td>
                </tr>

            </table>

        </form>

    </center>

 
<?php

include 'tml/head.php';

if (isset($_POST['min_exp_lvl']) and isset($_POST['name']) and isset($_POST['full_name']) and isset($_POST['terms']) and isset($_POST['reward'])) {
    $min_exp_lvl = (int) $_POST['min_exp_lvl'];
    $questName = $_POST['name'];
    $questFullName = $_POST['full_name'];
    $questTerms = $_POST['terms'];
    $questReward = $_POST['reward'];
    if (isset($_POST['item'])) {
        $questItemDrop = $_POST['item'];
        $questReward['item'] = $questItemDrop;
    }

    $questReward = serialize($questReward);
    $questTerms = serialize($questTerms);
    $dataToInsert = array('min_exp_lvl' => $min_exp_lvl, 'name' => $questName, 'full_name' => $questFullName, 'terms' => $questTerms, 'reward' => $questReward);
    $db->query("INSERT INTO quests SET ?u ", $dataToInsert);
    header("Location: quests_list.php");
}
?>
<script src="tml/scripts.js"></script>
<table border="1">
    <tr>
        <td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td>
    </tr>
</table>
<div id="gameContainer">
    <form method="POST" action="">
        <p>
            Минимальный уровень для квеста(not_Null):<br>
            <input type="text" name="min_exp_lvl">
        </p>
        <p>
            Название квеста(not_Null):<br>
            <input type="text" name="name">
        </p>
        <p>
            Описание(not_Null):<br>
            <input type="text" name="full_name">
        </p>
        <p>
            Условия победы(not_Null)<br>
            Тип объекта взлома:<br><select name="terms[type]">
                <option value="server">Сервер</option>
                <option value="game_server">Игровой сервер</option>
            </select><br>
            Cложность(10-100)
            <br><input type="text" name="terms[complexity]"><br>
            Количество(1-10)
            <br><input type="text" name="terms[nums]">


        </p>

        Награда(is_Null)<br>
        Денюшка:<br><input type="text" name="reward[money]"><br>
        Опыт:   <br><input type="text" name="reward[exp]"><br>

        <table border="1">
            <tr>
                <td>

                    Предмет
                    <div id="items"><br>
                        Тип<br><select id="selectItemType" onchange="showSelect('item_type')" name="item[type]">
                            <optgroup label="Данные">
                                <option value="null" >Выберите</option>
                                <option value="needDecode" >Закодированные</option>
                                <option value="decode" >Раскодированные</option>
                            </optgroup>
                        </select>

                        <div id="needDecodeItemSelectRares" class="hide" >
                            Качество(шанс:60%/30%/9%/1%/0%)<br>
                            <select id="selectItemRare" onchange="showSelect('item_rare')" name="item[rare]">
                                <option value="common">Common</option>
                                <option value="uncommon">unCommon</option>
                                <option value="rare">Rare</option>
                                <option value="unique">Unique</option>
                                <option value="arcana">Arcana</option>
                            </select><br>
                            Кол-во<br><input type="text" name="item[nums]">
                        </div>
                    </div> 
                </td>
             

            </tr>
        </table>
        <div id="moreItems">

            </div> 
        <a onclick="moreItemsButton()" >Добавить ещё</a>

        <p>
            <input type="submit" value="Добавить">
        </p>
    </form>
</div>
<?php

include 'tml/footer.php';
?>
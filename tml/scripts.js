function showSelect(what) {
    if (what == 'item_type') {
        //selectVal = document.getElementById('selectItemType');
        select = $('#selectItemType').val();
        //alert(select);
        if (select == 'needDecode') {
            $('#needDecodeItemSelectRares').removeClass('hide');
        } else {
            $('#needDecodeItemSelectRares').addClass('hide');
        }
    }
    if (what == 'item_rare') {

    }


}

function howmuch() {
    var id = $('#id').val();
    var nums = $('#userNums').val();
    $(document).ready(function() {
        $.get("api.php", {itemRare: id})
                .done(function(data) {
                    timeRemain = data * nums;
                    timeRemain = timeRemain / 60 / 60;
            
                    $('#timeRemain').val(timeRemain);
                });

        
    });
}


function moreItemsButton() {
    var divblock = '<table border="1">\
            <tr><td>Предмет \
                    <div id="items" style="float:right"><br> \
                        Тип<br><select id="selectItemType" onchange="showSelect(\'item_type\')" name="item[type]"> \
                            <optgroup label="Данные"> \
                                <option value="null" >Выберите</option> \
                                <option value="needDecode" >Закодированные</option > \
                                <option value="decode" >Раскодированные</option> \
                            </optgroup> \
                        </select> \
                        <div id="needDecodeItemSelectRares" > \
                            Качество(60%/30%/9%/1%/0%)<br> \
                            <select id="selectItemRare" onchange="showSelect(\'item_rare\')" name="item[rare]"> \
                                <option value="common">Common</option> \
                                <option value="uncommon">unCommon</option> \
                                <option value="rare">Rare</option> \
                                <option value="unique">Unique</option> \
                                <option value="arcana">Arcana</option> \
                            </select><br> \
                            Кол-во<br><input type="text" name="item[nums]">\
                        </div>\
                    </div></td> </tr>\
        </table> ';
    $('#moreItems').append(divblock);
}
<?php
include 'tml/head.php';

?>
<table border="1">
        <tr>
            <td id="picContainer" ><img src="tml/images.jpg" width="100%" height="100%"> </td>
        </tr>
    </table>
<div id="gameContainer">
    <p>
    <h3>Характеристики компьютера</h3>
    </p>
    <p>
        Max bandwidth:<?=$data[0][capacity_max]?>
    </p>
    <p>
        CPU:<?=$data[0][cpu_type]?> <?=$data[0][cpu_ghz]?> GHZ
    </p>
    <p>
        HDD:<?=$data[0][hdd]?> гб.
    </p>
    <p>
    <h3><a href="pc_upgrade.php">Улучшить</a></h3>
    </p>
    <p>
    <h3><a href="pc_buynew.php">Преобрести новый</a></h3>
    </p>
    <p>
    <h3><a href="pc_dedic.php">Управление дедиком</a></h3>
    </p>
</div>

<?php
include 'tml/footer.php';
?>

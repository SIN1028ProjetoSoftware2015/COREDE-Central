<?php
include_once 'ui/seguranca.interface.php';

include_once 'ui/header.ui.php';

?>

<div class="corede-subtitulo">Atas</div>

<div class="corede-atas">
    <form action="atas.php">
        <input name="arquivo" type="file">
    </form>
    <table id="tabelaDeAtas">
        <tr>
            <th>Descrição</th>
            <th>Data</th>
            <th>Download</th>
        </tr>
        <?php 
        for ($i = 0; $i < 10; $i++) {
            echo '<tr>
                    <td>teste de ata</td>
                    <td>24/05/15</td>
                    <td><a href="#">baixar</a><a class="remover" href="#">remover</a></td>
                </tr>';
        }
        ?>
    </table>
</div>

<?php
include_once 'ui/footer.ui.php';
?>
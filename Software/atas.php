<?php
include_once 'ui/header.ui.php';

?>

<div class="corede-subtitulo">Atas</div>

<div class="corede-atas">
    <form action="">
        <input type="text" placeholder="login">
        <input type="password" placeholder="senha">
        <input type="button" value="entrar">
    </form>
    <table>
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
                    <td><a href="#">Baixar</a></td>
                </tr>';
        }
        ?>
    </table>
</div>

<?php
include_once 'ui/footer.ui.php';
?>
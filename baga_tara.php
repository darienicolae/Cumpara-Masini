<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

mysql_connect('localhost', 'root', 'cumparamasini');
mysql_select_db('cumparamasini');

if(isset($_POST['submit']))
{
    mysql_query("INSERT INTO tari (nume_tara) VALUES ('$_POST[nume]')");
}


?>
<html>
    <body>
        <a href="baga_tara.php">Baga tara</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_marca.php">Baga marca</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_model.php">Baga model</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_masina.php">Baga masina</a>
        <h1>Baga tara</h1>
        <form action="" method="post">
            Tara:
            <input type="text" name="nume"/>
            <input type="submit" name="submit" value="Baga"/>
        </form>
        <h2>
            Tari existente(uitati-va aici, ca sa nu bagati aceeasi tara de 2 ori ca prostii:D)
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Tara</th>
                </tr>
                <?php
                $res = mysql_query("select * from tari");
                while($row = mysql_fetch_assoc($res))
                {
                    echo '<tr><td>' . $row['id'] . '</td><td>' . $row['nume_tara'] . '</td></tr>';
                }
                ?>
            </table>
        </h2>
    </body>
</html>


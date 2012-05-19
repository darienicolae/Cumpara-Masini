<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

mysql_connect('localhost', 'root', 'cumparamasini');
mysql_select_db('cumparamasini');

if(isset($_POST['submit']))
{
    mysql_query("INSERT INTO marci (nume_marca) VALUES ('$_POST[nume]')");
}


?>
<html>
    <body>
        <a href="baga_tara.php">Baga tara</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_marca.php">Baga marca</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_model.php">Baga model</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_masina.php">Baga masina</a>
        <h1>Baga marca</h1>
        <form action="" method="post">
            Marca:
            <input type="text" name="nume"/>
            <input type="submit" name="submit" value="Baga"/>
        </form>
        <h2>
            Marci existente(uitati-va aici, ca sa nu bagati aceeasi marca de 2 ori ca prostii:D)
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                </tr>
                <?php
                $res = mysql_query("select * from marci");
                while($row = mysql_fetch_assoc($res))
                {
                    echo '<tr><td>' . $row['id'] . '</td><td>' . $row['nume_marca'] . '</td></tr>';
                }
                ?>
            </table>
        </h2>
    </body>
</html>


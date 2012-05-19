<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

mysql_connect('localhost', 'root', 'cumparamasini');
mysql_select_db('cumparamasini');

if(isset($_POST['submit']))
{
    //echo "INSERT INTO modele (marci_id, nume) VALUES ('$_POST[marci_id]', '$_POST[nume]')";
    mysql_query("INSERT INTO modele (marci_id, nume_model) VALUES ('$_POST[marci_id]', '$_POST[nume]')");
}


?>
<html>
    <body>
        <a href="baga_tara.php">Baga tara</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_marca.php">Baga marca</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_model.php">Baga model</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_masina.php">Baga masina</a>
        <h1>Baga model</h1>
        <form action="" method="post">
            Marca:
            <select name="marci_id">
            <?php
            $res = mysql_query("select * from marci");
                while($row = mysql_fetch_assoc($res))
                {
                    echo '<option value="' . $row['id'] . '">' . $row['nume_marca'] . '</option>';
                }
            ?>
            </select>
            <br/><br/>
            Model: <input type="text" name="nume"/>
            <input type="submit" name="submit" value="Baga"/>
        </form>
        <h2>
            Marci existente(uitati-va aici, ca sa nu bagati aceeasi marca de 2 ori ca prostii:D)
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                    <th>Model</th>
                </tr>
                <?php
                $res = mysql_query("select modele.id, marci.nume_marca 'Marca', modele.nume_model 'Model' from marci, modele where marci.id = modele.marci_id");
                while($row = mysql_fetch_assoc($res))
                {
                    echo '<tr><td>' . $row['id'] . '</td><td>' . $row['Marca'] . '</td><td>' . $row['Model'] .'</td></tr>';
                }
                ?>
            </table>
        </h2>
    </body>
</html>


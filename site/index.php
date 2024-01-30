<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>

<body>
    <h1>Test Page</h1>
    <?php
    $dbhost = '10.10.20.11';
    $dbuser = 'db_connector';
    $dbpass = 'Password&1';
    $dbname = 'magazzino';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname,3306);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, nome_prodotto, quantità, prezzo FROM stock";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - Nome Prodotto: " . $row["nome_prodotto"] . " - Quantità: " . $row["quantità"] . " - Prezzo: " . $row["prezzo"] . "<br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>

</html>
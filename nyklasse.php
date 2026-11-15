<?php
include("db-kobling.php");
?>

<h3>Registrer ny klasse</h3>

<form method="post" action="" id="registrerklasse">

    Klassekode
    <input type="text" id="klassekode" name="klassekode" required />
    <br/>

    Klassenavn
    <input type="text" id="klassenavn" name="klassenavn" required />
    <br/>

    Studiumkode

    <select name="studiumkode" id="studiumkode" required>
        <option value="">Velg studium</option>

        <?php
        $sqlSetning = "SELECT * FROM studium";
        $sqlResultat = mysqli_query($db, $sqlSetning);

        while ($rad = mysqli_fetch_array($sqlResultat))
        {
            print("<option value='$rad[studiumkode]'>$rad[studiumkode]</option>");
        }
        ?>

    </select>
    <br/>

    <input type="submit" value="Registrer klasse"
    id="registrerKlasseKnapp" name="registrerKlasseKnapp" />

    <input type="reset" value="Nullstill"
    id="nullstill" name="nullstill" />

</form>


<?php

if (isset($_POST["registrerKlasseKnapp"]))
{
    $klassekode = $_POST["klassekode"];
    $klassenavn = $_POST["klassenavn"];
    $studiumkode = $_POST["studiumkode"];

    $sqlSetning = "SELECT * FROM klasse
                   WHERE klassekode='$klassekode'";

    $sqlResultat = mysqli_query($db, $sqlSetning)
        or die("Ikke mulig hente data fra databasen");

    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader != 0)
    {
        print("Klassen er registrert fra før");
    }
    else
    {
        $sqlSetning = "INSERT INTO klasse
                       VALUES('$klassekode','$klassenavn','$studiumkode')";

        mysqli_query($db, $sqlSetning)
            or die("Ikke mulig registrere data i databasen");

        print("klasse er registrert:
        $klassekode $klassenavn $studiumkode <br/>");
    }
}

?>

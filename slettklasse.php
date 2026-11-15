<?php
include("db-kobling.php");
?>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettklasse" name="slettklasse"
onsubmit="return confirm('Er du sikker på at du vil slette denne klassen?')">

    Klassekode

    <select name="klassekode" id="klassekode" required>
        <option value="">Velg klasse</option>

        <?php
        $sqlSetning = "SELECT * FROM klasse";
        $sqlResultat = mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å hente data fra databasen");

        while ($rad = mysqli_fetch_array($sqlResultat))
        {
            print("<option value='$rad[klassekode]'>
            $rad[klassekode] - $rad[klassenavn]
            </option>");
        }
        ?>

    </select>
    <br/>

    <input type="submit" value="Slett klasse"
    name="slettKlasseKnapp" id="slettKlasseKnapp" />

</form>


<?php

if (isset($_POST["slettKlasseKnapp"]))
{
    $klassekode = $_POST["klassekode"];

    $sqlSetning = "SELECT * FROM klasse
                   WHERE klassekode='$klassekode'";

    $sqlResultat = mysqli_query($db, $sqlSetning)
        or die("Ikke mulig å hente data fra databasen");

    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0)
    {
        print("Klassen finnes ikke");
    }
    else
    {
        // Slett studentene som tilhorer klassen

        $sqlSetning = "DELETE FROM student
                       WHERE klassekode='$klassekode'";

        mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å slette studentene");

        // Slett klassen

        $sqlSetning = "DELETE FROM klasse
                       WHERE klassekode='$klassekode'";

        mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å slette klassen");

        print("Følgende klasse er nå slettet:
        $klassekode <br/>");
    }
}

?>
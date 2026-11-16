<?php
include("db-kobling.php");

// Slett klasse når knappen trykkes
if (isset($_POST["slettKlasseKnapp"]))
{
    $klassekode = mysqli_real_escape_string($db, $_POST["klassekode"]);

    // Kontroller om klassen finnes
    $sqlSetning = "SELECT * FROM klasse
                   WHERE klassekode='$klassekode'";

    $sqlResultat = mysqli_query($db, $sqlSetning)
        or die("Ikke mulig å hente data fra databasen");

    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0)
    {
        print("Klassen finnes ikke.");
    }
    else
    {
        // Kontroller om klassen har studenter
        $sqlSetning = "SELECT * FROM student
                       WHERE klassekode='$klassekode'";

        $sqlResultat = mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å hente studenter fra databasen");

        $antallStudenter = mysqli_num_rows($sqlResultat);

        if ($antallStudenter > 0)
        {
            print("Klassen kan ikke slettes fordi den har registrerte studenter.");
        }
        else
        {
            // Slett klassen
            $sqlSetning = "DELETE FROM klasse
                           WHERE klassekode='$klassekode'";

            mysqli_query($db, $sqlSetning)
                or die("Ikke mulig å slette klassen");

            print("Følgende klasse er nå slettet: $klassekode <br/>");
        }
    }
}
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
    name="slettKlasseKnapp" id="slettKlasseKnapp"/>

</form>

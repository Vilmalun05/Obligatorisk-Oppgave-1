<?php
include("db-kobling.php");
?>

<h3>Slett student</h3>

<form method="post" action="" id="slettstudent" name="slettstudent"
onsubmit="return confirm('Er du sikker på at du vil slette denne studenten?')">

    Velg student

    <select name="brukernavn" id="brukernavn" required>
        <option value="">Velg student</option>

        <?php
        $sqlSetning = "SELECT * FROM student";
        $sqlResultat = mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å hente data fra databasen");

        while ($rad = mysqli_fetch_array($sqlResultat))
        {
            print("<option value='$rad[brukernavn]'>
            $rad[brukernavn] - $rad[fornavn] $rad[etternavn]
            </option>");
        }
        ?>

    </select>
    <br/>

    <input type="submit" value="Slett student"
    name="slettStudentKnapp" id="slettStudentKnapp" />

</form>


<?php

if (isset($_POST["slettStudentKnapp"]))
{
    $brukernavn = $_POST["brukernavn"];

    // Sjekker om studenten finnes

    $sqlSetning = "SELECT * FROM student
                   WHERE brukernavn='$brukernavn'";

    $sqlResultat = mysqli_query($db, $sqlSetning)
        or die("Ikke mulig å hente data fra databasen");

    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0)
    {
        print("Studenten finnes ikke");
    }
    else
    {
        // Slett studenten

        $sqlSetning = "DELETE FROM student
                       WHERE brukernavn='$brukernavn'";

        mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å slette studenten");

        print("Følgende student er nå slettet:
        $brukernavn <br/>");
    }
}

?>

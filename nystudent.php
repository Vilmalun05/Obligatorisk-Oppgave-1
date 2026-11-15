<?php
include("db-kobling.php");
?>

<h3>Registrer ny student</h3>

<form method="post" action="" id="registrerstudent" name="registrerstudent">

    Brukernavn
    <input type="text" id="brukernavn" name="brukernavn" required />
    <br/>

    Fornavn
    <input type="text" id="fornavn" name="fornavn" required />
    <br/>

    Etternavn
    <input type="text" id="etternavn" name="etternavn" required />
    <br/>

    Klassekode

    <select name="klassekode" id="klassekode" required>
        <option value="">Velg klasse</option>

        <?php
        $sqlSetning = "SELECT * FROM klasse";
        $sqlResultat = mysqli_query($db, $sqlSetning)
            or die("Ikke mulig å hente klasser fra databasen");

        while ($rad = mysqli_fetch_array($sqlResultat))
        {
            print("<option value='$rad[klassekode]'>
            $rad[klassekode] - $rad[klassenavn]
            </option>");
        }
        ?>

    </select>
    <br/>

    <input type="submit" value="Registrer student"
    id="registrerStudentKnapp" name="registrerStudentKnapp" />

    <input type="reset" value="Nullstill"
    id="nullstill" name="nullstill" />

</form>


<?php

if (isset($_POST["registrerStudentKnapp"]))
{
    $brukernavn = $_POST["brukernavn"];
    $fornavn = $_POST["fornavn"];
    $etternavn = $_POST["etternavn"];
    $klassekode = $_POST["klassekode"];

    // Sjekker om brukernavnet allerede finnes

    $sqlSetning = "SELECT * FROM student
                   WHERE brukernavn='$brukernavn'";

    $sqlResultat = mysqli_query($db, $sqlSetning)
        or die("Ikke mulig å hente data fra databasen");

    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader != 0)
    {
        print("Studenten er registrert fra før!");
    }
    else
    {
        $sqlSetning = "INSERT INTO student VALUES
        ('$brukernavn','$fornavn','$etternavn','$klassekode')";

        mysqli_query($db, $sqlSetning)
            or die("Ikke mulig registrere student i databasen");

        print("student er registrert:
        $brukernavn $fornavn $etternavn $klassekode");
    }
}

?>

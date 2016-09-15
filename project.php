<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mad Libs!</title>
</head>
<body style="text-align: center">
    <h1>Mad Libs!</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            Enter a noun:<br /> <input type="text" value="<?php $_POST['noun'] ?>"name="noun" /><br />
            Enter a verb:<br /> <input type="text" value="<?php $_POST['verb'] ?>"name="verb" /><br />
            Enter an adjective: <br /><input type="text" value="<?php $_POST['adjective'] ?>"name="adjective" /><br />
            Enter an adverb:<br /> <input type="text" value="<?php $_POST['adverb'] ?>"name="adverb" /><br />
            <input type="submit" name="submit" value="Make a madlib!" />
            <input type="reset" name="reset" value="Clear Form">
    </form>

    <br />

    <?php
    if(isset($_POST['submit'])){

        $noun = $_POST['noun'];
        $verb = $_POST['verb'];
        $adjective = $_POST['adjective'];
        $adverb = $_POST['adverb'];

        if(!empty($noun) && !empty($verb) && !empty($adjective) && !empty($adverb))
        {
            echo "You like to <span style='color:red'>$adverb $verb $adjective $noun</span>'s? How strange... ";

            $dbc = mysqli_connect('localhost', 'root', '', 'kthomas')
                    or die("Error connecting to the database");

            $query = "INSERT INTO mad_libs (noun, verb, adjective, adverb, time)"
                    . "VALUES ('$noun', '$verb', '$adjective', '$adverb', NOW())";

            mysqli_query($dbc, $query)
                    or die("Error querying database");

            echo "<br /> <br />";

            $query = "SELECT * FROM mad_libs ORDER BY time DESC";
            $response = mysqli_query($dbc, $query)
                    or die("Error querying for list");

            echo "<strong>Previous Submissions: <br /></strong>";
            while($row = mysqli_fetch_array($response)){
                echo $row['id'] . ": You like to " .  $row['adverb'] . " " . $row['verb']
                        . " " . $row['adjective'] . " " . $row['noun'] . "'s? How strange... " .$row['time'];
                echo "<br />";
            }

            mysqli_close($dbc);
        } else {
            echo "Looks like you forgot a field. Try again.";
        }
    }
?>
</body>
</html>
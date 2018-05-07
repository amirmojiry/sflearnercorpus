<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}

global $HOSTDB; // Host name
global $USERDB; // Mysql username
global $PASSDB; // Mysql password
global $NAMEDB;

$coo = mysqli_connect ( $HOSTDB, $USERDB, $PASSDB, $NAMEDB );
if (! $coo)
{
    die ( 'Could not connect: ' . mysqli_error ( $coo ) );
}
else
{
    if (! mysqli_connect_error ())
    {
        $coo->set_charset ( "utf8" );
        $result = mysqli_query ( $coo, "SET CHARACTER SET 'utf8';" );
        $result = mysqli_query ( $coo, "SET SESSION collation_connection = 'utf8_persian_ci';" );
		
				//query for texts
        $query = "SELECT * FROM text";
        $result = mysqli_query ( $coo, $query );

        if ($result)
        {
            if ($result->num_rows > 0)
            {
                $cntr = 0;
				$AllTexts = array ();
                while ( $mrow = mysqli_fetch_assoc ( $result ) )
                {
                    $AllTexts [$cntr] = $mrow;
                    $cntr ++;
                }
            }
        }
	}
}
for($i = 0; $i < count ($AllTexts); $i ++) {
	echo strip_tags($AllTexts[$i]['LabeledText'], '<a>');
}

?>












<?php
ini_set ( "display_errors", true );
date_default_timezone_set ( "Asia/Tehran" );

// db properties
if (! defined ( 'DBHOST' ))
	define ( 'DBHOST', 'localhost' );

if (! defined ( 'DBUSER' ))
	define ( 'DBUSER', 'amaje_sfcorpus' );

if (! defined ( 'DBPASS' ))
	define ( 'DBPASS', 'Cxp3adu@3fb12aaf8' );

if (! defined ( 'DBNAME' ))
	define ( 'DBNAME', 'amaje_sfcorpus' );

$HOSTDB = DBHOST; // Host name
$USERDB = DBUSER; // Mysql username
$PASSDB = DBPASS; // Mysql password
$NAMEDB = DBNAME; // Database name
                  
// define site path
if (! defined ( 'DIR' ))
	define ( 'DIR', 'http://localhost/sflc/admin/' );
	
	// define admin site path
if (! defined ( 'DIRADMIN' ))
	define ( 'DIRADMIN', 'http://localhost/sflc/admin/' );
	
	// define upload path
if (! defined ( 'DIRUPLOAD' ))
	define ( 'DIRUPLOAD', 'uploads/' );
	
	// define site title for top of the browser
if (! defined ( 'SITETITLE' ))
	define ( 'SITETITLE', 'SAADI' );
	
	// define include checker
if (! defined ( 'included' ))
	define ( 'included', 1 );
	
	// return ['host' => DBHOST,'username' => DBUSER,'pass' => DBPASS,'database' => DBNAME ];
	
///////////////////////////////////////////////
/////Constants
///////////////////////////////////////////////
class FILETYPES
{
	const PROFILEIMAGE = 2;
	const SHENASNAMEPAGE1 = 3;
	const SHENASNAMEPAGE2 = 4;
	const MELLICARDPAGE1 = 5;
	const MELLICARDPAGE2 = 6;
	const MADRAKTAHSILI = 7;
	const RESUME = 8;
}
class UPLOADERRORS
{
	const FILEERROR = - 1;
	const FILEEXISTS = - 2;
	const FILETOOLARGE = - 3;
	const BADFORMAT = - 4;
	const UPLOADINGERROR = - 5;
	const UPLOADUKNOWNERROR = - 6;
	const DBFILEPATHINSERTIONERROR = - 7;
	static function GetErrorText($ErrorID)
	{
		if($ErrorID>0)
			return "Uploaded Successfully";
		switch ($ErrorID)
		{
			case UPLOADERRORS::FILEERROR :
				return "There was a problem in Post File";
				break;
			case UPLOADERRORS::FILEEXISTS :
				return "This file already exists";
				break;
			case UPLOADERRORS::FILETOOLARGE :
				return "File size is more than legal Size";
				break;
			case UPLOADERRORS::BADFORMAT :
				return "File format is not legel";
				break;
			case UPLOADERRORS::UPLOADINGERROR :
				return "There was a problem in Post File";
				break;
			case UPLOADERRORS::UPLOADUKNOWNERROR :
				return "There was a problem in Post File";
				break;
			case UPLOADERRORS::DBFILEPATHINSERTIONERROR:
				return "There was a problem in insertion of file path 2 DB";
				break;
		}
	}
}


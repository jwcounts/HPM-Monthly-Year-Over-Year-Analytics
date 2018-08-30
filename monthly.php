<?php
	/**
	 * Defining a couple of terms and some helper functions
	 */
	define( 'BASE', __DIR__ );
	define( 'DS', DIRECTORY_SEPARATOR );

	// Read keyboard input from terminal during execution
	function read_stdin() {
		$fr = fopen( "php://stdin", "r" );
		$input = fgets( $fr, 128 );
		$input = rtrim( $input );
		fclose ( $fr );
		return $input;
	}
	
	/**
	 * Load the composer dependencies and my terminal color helper
	 */
	require BASE . DS . 'vendor' . DS . 'autoload.php';
	require BASE . DS . 'colors.php';

	/**
	 * Expose global env() function from oscarotero/env
	 */
	Env::init();

	/**
	 * Use Dotenv to set required environment variables and load .env file in root
	 */
	$dotenv = new Dotenv\Dotenv( BASE );
	if ( file_exists( BASE . DS . '.env' ) ) :
		$dotenv->load();
		$dotenv->required([ 'GA_CLIENT', 'GDRIVE_CREDS', 'GDRIVE_TOKEN', 'GDRIVE_FILE_ID', 'GA_MAIN', 'YT_ACCESS', 'YT_CLIENT', 'CLIENT_EMAILS', 'CF_DISTRO', 'TIMEZONE', 'FB_PAGE_ID', 'FB_PAGE_ACCESS', 'FB_PAGE_PROOF', 'AWS_KEY', 'AWS_SECRET', 'APP_URL', 'FROM_EMAIL', 'S3_BUCKET' ]);
	endif;

	// Map all of the variables from .env to constants and variables
	date_default_timezone_set( env('TIMEZONE') );
	define( 'GA_CLIENT', BASE . DS . env( 'GA_CLIENT' ) );
	define( 'GDRIVE_CREDS', BASE . DS . env( 'GDRIVE_CREDS' ) );
	define( 'GDRIVE_TOKEN', BASE . DS . env( 'GDRIVE_TOKEN' ) );
	define( 'GDRIVE_FILE_ID', env( 'GDRIVE_FILE_ID' ) );
	define( 'GA_MAIN', env( 'GA_MAIN' ) );
	define( 'YT_ACCESS', BASE . DS . env( 'YT_ACCESS' ) );
	define( 'YT_CLIENT', BASE . DS . env( 'YT_CLIENT' ) );
	define( 'APP_URL', env( 'APP_URL' ) );
	define( 'FROM_EMAIL', env( 'FROM_EMAIL' ) );
	$cf_distro = env( 'CF_DISTRO' );
	$s3_bucket = env( 'S3_BUCKET' );
	$email_arr = explode( ',', env( 'CLIENT_EMAILS' ) );
	$hpm_fb = env( 'FB_PAGE_ID' );
	$page_access = env( 'FB_PAGE_ACCESS' );
	$page_proof = env( 'FB_PAGE_PROOF' );
	$aws_key = env( 'AWS_KEY' );
	$aws_secret = env( 'AWS_SECRET' );

	/**
	 * Pull in data from previous runs
	 * You can see an example in the 'data' folder
	 */
	$graphs = json_decode( file_get_contents( BASE . DS . "data" . DS . "yoy-data.json" ), true );

	/**
	 * Set up data for our various interactive checks
	 * All of these checks are set up as while loops for input checking
	 * If the user doesn't enter anything into the prompt, or doesn't stick to the pattern, it prints an error and prompts again
	 */
	$date_conf = $gdoc = $gdoc_conf = $emails = $email_conf = $new_set_color_confirm = false;

	/**
	 * These are all of the datapoints that I can't pull in via an API,
	 * 		so I set this up to prompt the user for each
	 */
	$pulls = [
		'TV 8 Viewers' => [
			'graph' => 'tv8-viewers',
			'status' => false
		],
		'News On-Air Listeners' => [
			'graph' => 'news-weekly-listeners',
			'status' => false
		],
		'News Online Streamers' => [
			'graph' => 'news-monthly-streamers',
			'status' => false
		],
		'Classical Online Streamers' => [
			'graph' => 'classical-monthly-streamers',
			'status' => false
		],
		'@HoustonPubMedia Retweets' => [
			'graph' => 'twitter-hpm-rts',
			'status' => false
		],
		'@HoustonPubMedia Likes' => [
			'graph' => 'twitter-hpm-likes',
			'status' => false
		],
		'@HPMNews887 Retweets' => [
			'graph' => 'twitter-news-rts',
			'status' => false
		],
		'@HPMNews887 Likes' => [
			'graph' => 'twitter-news-likes',
			'status' => false
		]
	];
	/**
	 * Set the month for your report. This will determine the start and end dates
	 * 		the script will use for the API pulls
	 */
	while ( $date_conf == false ) :
		echo "Enter the year and month your report (YYYY-MM): ";
		$date_in = read_stdin();
		if ( preg_match( '/^[0-9]{4}-[0-9]{2}$/', $date_in ) ) :
			$datex = explode( '-', $date_in );
			$syear = intval( $datex[0] );
			$smonth = intval( $datex[1] );
			if (
				$syear >= 2016 &&
				( $smonth > 0 && $smonth <= 12 )
			):
				// Set the start and end date
				$startu = mktime( 0, 0, 0, $smonth, 1, $syear );
				$start = date( 'Y-m-d', $startu );
				// Check if the end date doesn't cross into another year, and adjust
				if ( ( $smonth + 1 ) == 13 ) :
					$emonth = 1;
					$eyear = $syear + 1;
				else :
					$emonth = $smonth + 1;
					$eyear = $syear;
				endif;
				
				$endu = mktime( 12, 0, 0, $emonth, 1, $eyear );
				$end = date( 'Y-m-d', $endu - 86400 );

				$date_conf = true;
			else :
				echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
			endif;
		else :
			echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
		endif;
	endwhile;

	/**
	 * Choose whether or not to upload to Google Docs. Useful for testing
	 */
	while ( $gdoc_conf == false ) :
		echo "Do you want this data uploaded to Google Drive? (y/n) ";
		$gdoc_in = read_stdin();
		if ( $gdoc_in == 'y' ) :
			$gdoc_conf = true;
			$gdoc = true;
		elseif ( $gdoc_in == 'n' ) :
			$gdoc_conf = true;
		else :
			echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
		endif;
	endwhile;

	/**
	 * Choose whether or not to email the group. Also useful for testing
	 */
	while ( $email_conf == false ) :
		echo "Do you want this report emailed to the group? (y/n) ";
		$email_in = read_stdin();
		if ( $email_in == 'y' ) :
			$email_conf = true;
			$emails = true;
		elseif ( $email_in == 'n' ) :
			$email_conf = true;
		else :
			echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
		endif;
	endwhile;
	
	/**
	 * All of my datasets start with 2016, so in the graphing data, set 0 = 2016,
	 * 		set 1 = 2017, etc.
	 */
	$dataset_year = 0;
	if ( $syear > 2016 ) :
		$dataset_year = $syear - 2016;
	endif;

	$bgcolor = '';
	$dset = $smonth - 1;

	// Loop through the non-API pulled numbers
	foreach ( $pulls as $k => $v ) :
		while ( $v['status'] == false ) :
			echo $FG_BR_CYAN . $BG_BLACK . $FS_BOLD . "Enter the amount of ".$k." for ".date( 'F Y', $startu ).": " . $RESET_ALL;
			// read the keyboard input
			$value = read_stdin();

			// Check if it's a number, otherwise kick out an error
			if ( preg_match( '/^[0-9]+$/', $value ) ) :
				// If the dataset for the selected year doesn't exist, create it
				if ( empty( $graphs[$v['graph']]['datasets'][$dataset_year] ) ) :

					/**
					 * When a new dataset is created, a background color needs to be
					 * 		assigned for the graphs. Once one is set, it will be
					 * 		used on all of the following datasets for that year
					 */
					if ( empty( $bgcolor ) ) :
						while ( $new_set_color_confirm == false ) :
							echo 'Creating a new dataset for '.$syear.PHP_EOL.'What color do you want to set (RRR,GGG,BBB)? ';
							$bgcolor = read_stdin();
							if ( preg_match( '/^[0-9]{1,3},[0-9]{1,3},[0-9]{1,3}$/', $bgcolor ) ) :
								$new_set_color_confirm = true;
							else :
								echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
							endif;
						endwhile;
					endif;
					// Inserting the new dataset into the graphing data
					$graphs[$v['graph']]['datasets'][$dataset_year] = [
						'label' => strval( $syear ),
						'backgroundColor' => 'rgba('.$bgcolor.',0.2)',
						'borderColor' => 'rgba('.$bgcolor.',1)',
						'data' => []
					];
				endif;
				$graphs[$v['graph']]['datasets'][$dataset_year]['data'][$dset] = $value;
					$v['status'] = true;
			else :
				echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input (numbers only, no commas). Please try again." . $RESET_ALL . PHP_EOL;
			endif;
		endwhile;
	endforeach;

	echo $FG_BR_CYAN . $BG_BLACK . $FS_BOLD . "Hold please while we pull the rest..." . $RESET_ALL . PHP_EOL;

	// Facebook Graph API base
	$fb_base = 'https://graph.facebook.com/v3.1/';

	// Where the magic happens
	if ( file_exists( GA_CLIENT ) ) :
		require BASE . DS . 'google' . DS . 'google.php';
	endif;

	if ( !empty( $page_access ) ) :
		require BASE . DS . 'facebook' . DS . 'facebook.php';
	endif;

	if ( file_exists( YT_ACCESS ) ) :
		require BASE . DS . 'google' . DS . 'youtube.php';
	endif;

	// Initialize PHPSpreadsheet software so we can create XLSX files
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	$spreadsheet = new Spreadsheet();

	// Setting the default font size
	$spreadsheet->getDefaultStyle()->getFont()->setName( 'Arial' );
	$spreadsheet->getDefaultStyle()->getFont()->setSize( 14 );

	// Parse through the graph data and convert it into the spreadsheet format
	
	require BASE . DS . 'sheet.php';

	if ( $gdoc && file_exists( GDRIVE_CREDS ) ) :
		// Upload file contents to Google Sheet
		require BASE . DS . 'google'. DS .'gsheet.php';
	endif;
	
	// Delete the local XLSX file
	unlink( BASE . DS . 'data' . DS . 'analytics-'.$date_in.'.xlsx' );

	// Write the graphing data back to the JSON file
	file_put_contents( BASE . DS . 'data' . DS . 'yoy-data.json', json_encode( $graphs ) );

	// Upload the file to S3, alert everyone via email, clear the Cloudfront cache
	if ( !empty( $aws_key ) ) :	
		require BASE . DS . 'amazon.php';
	endif;

	// All done!
	echo $FG_BR_GREEN . $BG_BLACK . $FS_BOLD . 'Report process completed successfully!' . $RESET_ALL . PHP_EOL;
?>
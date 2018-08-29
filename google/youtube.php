<?php
	/**
	 * Use the Google API PHP Client to create and authenticate a YouTube Analytics Client
	 * If an access token already exists, it will use that, or it will walk you through obtaining one
	 */
	function getYTClient() {
		$client = new Google_Client();
		$client->setApplicationName( 'APIs Explorer PHP Samples' );
		$client->setScopes([ 'https://www.googleapis.com/auth/youtube.readonly' ]);
		$client->setAuthConfig( YT_CLIENT );
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');

		// Load previously authorized credentials from a file.
		$credentialsPath = YT_ACCESS;
		if ( file_exists( $credentialsPath ) ) :
			$accessToken = json_decode( file_get_contents( $credentialsPath ), true );
		else :
			// Request authorization from the user.
			$authUrl = $client->createAuthUrl();
			printf( "Open the following link in your browser:\n%s\n", $authUrl );
			print 'Enter verification code: ';
			$authCode = trim( fgets( STDIN ) );

			// Exchange authorization code for an access token.
			$accessToken = $client->fetchAccessTokenWithAuthCode( $authCode );

			// Check to see if there was an error.
			if ( array_key_exists( 'error', $accessToken ) ) :
				throw new Exception( join( ', ', $accessToken ) );
			endif;

			// Store the credentials to disk.
			if ( !file_exists( dirname( $credentialsPath ) ) ) :
				mkdir( dirname( $credentialsPath ), 0700, true );
			endif;
			file_put_contents( $credentialsPath, json_encode( $accessToken ) );
			printf( "Credentials saved to %s\n", $credentialsPath );
		endif;
		$client->setAccessToken( $accessToken );

		// Refresh the token if it's expired.
		if ( $client->isAccessTokenExpired() ) :
			$client->fetchAccessTokenWithRefreshToken( $client->getRefreshToken() );
			file_put_contents( $credentialsPath, json_encode( $client->getAccessToken() ) );
		endif;
		return $client;
	}

	$client = getYTClient();

	// Define service object for making API requests.
	$service = new Google_Service_YouTubeAnalytics( $client );

	// Pull the view count for the month, as well as the subscribers gained
	$params = [
		'dimensions' => 'channel',
		'endDate' => $end,
		'ids' => 'channel==MINE',
		'maxResults' => 20,
		'metrics' => 'views,subscribersGained',
		'sort' => '-views',
		'startDate' => $start
	];

	// Make the request
	$response = $service->reports->query( $params );

	// Info to help map the data into the proper graph datasets
	$yt_vals = [
		'youtube-views' => 1,
		'youtube-subscribers-added' => 2
	];

	// Loop through the response rows
	foreach ( $yt_vals as $gv => $gk ) :
		/**
		 * If the year's dataset doesn't exist, create it
		 */
		if ( empty( $graphs[$gv]['datasets'][$dataset_year] ) ) :
			/**
			 * If a new year's dataset is being created, set the background
			 * 		color if it hasn't been set already
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

			// Create the empty dataset
			$graphs[$gv]['datasets'][$dataset_year] = [
				'label' => strval( $syear ),
				'backgroundColor' => 'rgba('.$bgcolor.',0.2)',
				'borderColor' => 'rgba('.$bgcolor.',1)',
				'data' => []
			];
		endif;
		
		// Insert the data
		$graphs[$gv]['datasets'][$dataset_year]['data'][$dset] = $response->rows[0][$gk];
	endforeach;
?>
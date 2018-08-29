<?php
	// Create connection to Google Analytics
	function initializeAnalytics() {
		$client = new Google_Client();
		$client->setApplicationName("Hello Analytics Reporting");
		$client->setAuthConfig( GA_CLIENT );
		$client->setScopes([ 'https://www.googleapis.com/auth/analytics.readonly' ]);
		$analytics = new Google_Service_Analytics( $client );
		return $analytics;
	}

	// Google Analytics property ID
	$ga = GA_MAIN;

	// Setting up device colors for the graphing application
	$ga_device_colors = [
		'desktop' => 'rgba(255,0,0,1)',
		'tablet' => 'rgba(0,0,255,1)',
		'mobile' => 'rgba(0,255,0,1)'
	];

	$analytics = initializeAnalytics();

	// User / Session pull from GA
	$result2 = $analytics->data_ga->get(
		'ga:'.$ga,
		$start,
		$end,
		'ga:visits',
		[
			'dimensions' => 'ga:year,ga:month',
			'metrics' => 'ga:pageviews,ga:users',
			'sort' => 'ga:year,ga:month',
			'output' => 'json'
		]
	);

	// Users / Sessions by Device Category from GA
	$result3 = $analytics->data_ga->get(
		'ga:'.$ga,
		$start,
		$end,
		'ga:visits',
		[
			'dimensions' => 'ga:deviceCategory',
			'metrics' => 'ga:sessions,ga:users',
			'sort' => '-ga:users',
			'output' => 'json'
		]
	);

	// Mapping data for which graph to put which data into
	$ga_vals = [
		'site-overall-pageviews' => 2,
		'site-overall-users' => 3
	];
	foreach ( $ga_vals as $gv => $gk ) :
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
			$graphs[$gv]['datasets'][$dataset_year] = [
				'label' => strval( $syear ),
				'backgroundColor' => 'rgba('.$bgcolor.',0.2)',
				'borderColor' => 'rgba('.$bgcolor.',1)',
				'data' => []
			];
		endif;
		$graphs[$gv]['datasets'][$dataset_year]['data'][$dset] = $result2->rows[0][$gk];
	endforeach;

	$ga_devices = [];
	$bgcolor_ga_mobile = $bgcolor_ga_tablet = '';
	$new_color_ga_mobile = $new_color_ga_tablet = false;
	foreach ( $graphs['site-users-device-type']['datasets'] as $sk => $sv ) :
		$ga_devices[$sk] = strtolower( $sv['label'] );
	endforeach;
	foreach ( $result3->rows as $row ) :
		if ( $row[0] != 'desktop' ) :
			/**
			 * If the year's dataset doesn't exist, create it
			 */
			$key = array_search( $row[0].' ('.$syear.')', $ga_devices );
			if ( $key === false ) :
				/**
				 * If a new year's dataset is being created, set the background
				 * 		color for mobile if it hasn't been set already
				 */
				if ( empty( $bgcolor_ga_mobile ) ) :
					while ( $new_color_ga_mobile == false ) :
						echo 'Creating new datasets for Google Analytics.'.PHP_EOL.'What color do you want for mobile devices (RRR,GGG,BBB)? ';
						$bgcolor_ga_mobile = read_stdin();
						if ( preg_match( '/^[0-9]{1,3},[0-9]{1,3},[0-9]{1,3}$/', $bgcolor_ga_mobile ) ) :
							$new_color_ga_mobile = true;
						else :
							echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
						endif;
					endwhile;
				endif;

				/**
				 * If a new year's dataset is being created, set the background
				 * 		color for tablet if it hasn't been set already
				 */
				if ( empty( $bgcolor_ga_tablet ) ) :
					while ( $new_color_ga_tablet == false ) :
						echo 'Creating new datasets for Google Analytics.'.PHP_EOL.'What color do you want for tablets (RRR,GGG,BBB)? ';
						$bgcolor_ga_tablet = read_stdin();
						if ( preg_match( '/^[0-9]{1,3},[0-9]{1,3},[0-9]{1,3}$/', $bgcolor_ga_tablet ) ) :
							$new_color_ga_tablet = true;
						else :
							echo $FG_BR_RED . $BG_BLACK . $FS_BOLD . "Invalid input, please try again." . $RESET_ALL . PHP_EOL;
						endif;
					endwhile;
				endif;

				// Create the empty datasets
				$c = count( $graphs['site-users-device-type']['datasets'] );
				$graphs['site-users-device-type']['datasets'][$c] = [
					'label' => 'Mobile ('.strval( $syear ).')',
					'backgroundColor' => 'rgba('.$bgcolor_ga_mobile.',0.2)',
					'borderColor' => 'rgba('.$bgcolor_ga_mobile.',1)',
					'stack' => strval( $syear ),
					'data' => []
				];
				$graphs['site-users-device-type']['datasets'][$c+1] = [
					'label' => 'Tablet ('.strval( $syear ).')',
					'backgroundColor' => 'rgba('.$bgcolor_ga_tablet.',0.2)',
					'borderColor' => 'rgba('.$bgcolor_ga_tablet.',1)',
					'stack' => strval( $syear ),
					'data' => []
				];
				$graphs['site-sessions-device-type']['datasets'][$c] = [
					'label' => 'Mobile ('.strval( $syear ).')',
					'backgroundColor' => 'rgba('.$bgcolor_ga_mobile.',0.2)',
					'borderColor' => 'rgba('.$bgcolor_ga_mobile.',1)',
					'stack' => strval( $syear ),
					'data' => []
				];
				$graphs['site-sessions-device-type']['datasets'][$c+1] = [
					'label' => 'Tablet ('.strval( $syear ).')',
					'backgroundColor' => 'rgba('.$bgcolor_ga_tablet.',0.2)',
					'borderColor' => 'rgba('.$bgcolor_ga_tablet.',1)',
					'stack' => strval( $syear ),
					'data' => []
				];
				$ga_devices[$c] = 'mobile-'.strval( $syear );
				$ga_devices[$c+1] = 'tablet-'.strval( $syear );
				$key = array_search( $row[0].'-'.$syear, $ga_devices );
			endif;
			
			// Insert the data
			$graphs['site-users-device-type']['datasets'][$key]['data'][$dset] = $row[2];
			$graphs['site-sessions-device-type']['datasets'][$key]['data'][$dset] = $row[1];
		endif;
	endforeach;
?>
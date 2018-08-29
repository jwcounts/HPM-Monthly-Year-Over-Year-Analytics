<?php
	// Start Facebook Insights Pull
	$sheet = 'Facebook Insights';
	$fb_page_url = $fb_base.$hpm_fb.'/';

	/**
	 * Since the Facebook Graph API will only allow certain metrics to be pull for a particular period,
	 * 		I broke them up into several sets. That way, I can manage the order they show up in the spreadsheet
	 */
	$insights = [
		0 => [
			'day' => 'page_impressions_unique'
		],
		1 => [
			'lifetime' => 'page_fans'
		]
	];
	$reach = [];

	/**
	 * The Graph API only allows you to pull 93 days at a time. This script is dealing with weekly increments,
	 * 		so the loop isn't completely necessary, but this way it can be used for longer pulls if need be
	 */
	for ( $i = $startu; $i <= $endu; ) :
		$di = $endu - $i;
		if ( $di > 7776000 ) :
			$endt = $i + 7776000;
		else :
			$endt = $endu;
		endif;

		/**
		 * Loop through the $insights array to pull the various metrics we need
		 */
		foreach ( $insights as $insight ) :
			foreach ( $insight as $k => $v ) :
				$period = $k;
				$metric = $v;
				$args = [
					'pretty' => 0,
					'metric' => $metric,
					'period' => $period,
					'since' => $i,
					'until' => $endt,
					'access_token' => $page_access,
					'appsecret_proof' => $page_proof
				];

				// Build and clean the query and generate the URL
				$query = http_build_query( $args, '', '&' );
				$query = str_replace( '%2C', ',', $query );
				$url = "{$fb_page_url}insights?{$query}";

				// Run that URL through cURL
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				$result = curl_exec( $ch );
				curl_close( $ch );

				// Decode the response from the Graph API and loop through
				$json = json_decode( $result );
				foreach ( $json->data as $d ) :
					$name = $d->name;
					if ( $name == 'page_fans' ) :
						$fb_likes = $d->values[0]->value;
					elseif ( $name == 'page_impressions_unique' ) :
						foreach ( $d->values as $val ) :
							$reach[] = ( empty( $val->value ) ? 0 : $val->value );
						endforeach;
					endif;
				endforeach;
			endforeach;
		endforeach;
		$i += 7776000;
	endfor;

	// Since Facebook doesn't provide an average reach for the month, generate one
	$fb_reach = round( array_sum( $reach ) / count( $reach ), 0 );

	/**
	 * Much like the interactive numbers, if the dataset doesn't exist, create it
	 */
	if ( empty( $graphs['facebook-reach']['datasets'][$dataset_year] ) ) :
		/**
		 * If new datasets are being created, a background color should already
		 * 		have been set. If not, ask the user to set it.
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
		$graphs['facebook-reach']['datasets'][$dataset_year] = [
			'label' => strval( $syear ),
			'backgroundColor' => 'rgba('.$bgcolor.',0.2)',
			'borderColor' => 'rgba('.$bgcolor.',1)',
			'data' => []
		];
	endif;

	// Map the data into the graphing data
	$graphs['facebook-reach']['datasets'][$dataset_year]['data'][$dset] = $fb_reach;

	/**
	 * If the specific month's data already exists, find it and update it. If not,
	 * 		add it in
	 */
	$fb_like_label = date( 'F Y', $startu );
	$key = array_search( $fb_like_label, $graphs['facebook-likes']['labels'] );
	if ( $key === false ) :
		$graphs['facebook-likes']['labels'][] = $fb_like_label;
		$graphs['facebook-likes']['datasets'][0]['data'][] = $fb_likes;
	else :
		$graphs['facebook-likes']['datasets'][0]['data'][$key] = $fb_likes;
	endif;
?>
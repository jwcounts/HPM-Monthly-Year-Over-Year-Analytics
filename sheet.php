<?php
	// Creating the basic spreadsheet structure
	$sheets = [
		'Dashboard' => []
	];
	$sheets['Dashboard'][] = [
		'', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
	];

	// TV 8 stats
	$sheets['Dashboard'][] = [
		'TV 8', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * For each dataset, we basically grab the data array, append the label
	 * 		to the front of the array, and save that as a row in the spreadsheet
	 */
	foreach ( $graphs['tv8-viewers']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Viewers per Month ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	// News 88.7 stats
	$sheets['Dashboard'][] = [
		'News 88.7', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['news-weekly-listeners']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Listeners Each Week ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'News 88.7 Stream', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['news-monthly-streamers']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Monthly Listeners ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'Classical Stream', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['classical-monthly-streamers']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Monthly Listeners ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'HoustonPublicMedia.org', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['site-overall-pageviews']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Overall Pageviews ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['site-overall-users']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Unique Users ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * Since the User and Session information for the Google Analytics device types are stored
	 * 		together for the graph, we have to separate them out for the spreadsheet. After this
	 * 		loop runs, it ends up looking like this:
	 * 
	 * $ga_stats = [
	 * 		'Mobile (2018)'] => [
	 *			'Users' => [],
	 *			'Sessions' => []
	 *		],
	 *		'Tablet (2018)'] => [
	 *			'Users' => [],
	 *			'Sessions' => []
	 *		]
	 *	];
	 */
	$ga_stats = [];
	foreach ( $graphs['site-users-device-type']['datasets'] as $v ) :
		$ga_stats[$v['label']] = [
			'Users' => [],
			'Sessions' => []
		];
	endforeach;

	// Populate the arrays we created above with the actual user data
	foreach ( $graphs['site-users-device-type']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Users ('.$v['stack'].')' );
		$ga_stats[$v['label']]['Users'] = $data;
	endforeach;

	// Populate the arrays we created above with the actual session data
	foreach ( $graphs['site-sessions-device-type']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Sessions ('.$v['stack'].')' );
		$ga_stats[$v['label']]['Sessions'] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'Mobile (Phone)', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	// Insert the Mobile User data into the spreadsheet
	foreach ( $ga_stats as $gv => $gk ) :
		if ( strpos( $gv, 'Mobile' ) !== false ) :
			$sheets['Dashboard'][] = $gk['Users'];
		endif;
	endforeach;
	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	// Insert the Mobile Session data into the spreadsheet
	foreach ( $ga_stats as $gv => $gk ) :
		if ( strpos( $gv, 'Mobile' ) !== false ) :
			$sheets['Dashboard'][] = $gk['Sessions'];
		endif;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'Mobile (Tablet)', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	// Insert the Tablet User data into the spreadsheet
	foreach ( $ga_stats as $gv => $gk ) :
		if ( strpos( $gv, 'Tablet' ) !== false ) :
			$sheets['Dashboard'][] = $gk['Users'];
		endif;
	endforeach;
	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	// Insert the Tablet Session data into the spreadsheet
	foreach ( $ga_stats as $gv => $gk ) :
		if ( strpos( $gv, 'Tablet' ) !== false ) :
			$sheets['Dashboard'][] = $gk['Sessions'];
		endif;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'Social Outlets', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'YouTube', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['youtube-views']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Monthly Views ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['youtube-subscribers-added']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Monthly Subscribers Added ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'Facebook', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['facebook-likes']['datasets'] as $v ) :
		$divs = floor( count( $v['data'] ) / 12 );
		$starting = 2016;
		for ( $i = 0; $i <= $divs; $i++ ) :
			$slice_start = $i * 12;
			$arrslice = array_slice( $v['data'], $slice_start, 12 );
			$year_label = $i + $starting;
			array_unshift( $arrslice, 'Total Page Likes ('.$year_label.')' );
			$sheets['Dashboard'][] = $arrslice;
		endfor;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['facebook-reach']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Average Monthly Reach ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'Twitter', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'@HoustonPubMedia', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['twitter-hpm-rts']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Retweets ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	foreach ( $graphs['twitter-hpm-likes']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Likes ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];
	$sheets['Dashboard'][] = [
		'@HPMNews887', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['twitter-news-rts']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Retweets ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	$sheets['Dashboard'][] = [
		'', '', '', '', '', '', '', '', '', '', '', '', ''
	];

	/**
	 * See above
	 */
	foreach ( $graphs['twitter-news-likes']['datasets'] as $v ) :
		$data = $v['data'];
		array_unshift( $data, 'Likes ('.$v['label'].')' );
		$sheets['Dashboard'][] = $data;
	endforeach;

	// Write sheets from array into XLSX file
	foreach ( $sheets as $k => $v ) :
		$myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet( $spreadsheet, $k );
		$spreadsheet->addSheet( $myWorkSheet, 0 );
		$spreadsheet->setActiveSheetIndexByName( $k );
		$spreadsheet->getActiveSheet()->fromArray( $v, NULL, 'A1' );
	endforeach;

	// Get total number of rows
	$row_num = count( $sheets['Dashboard'] );
	
	// Set default column widths
	$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
	$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(12);

	// Default styling for top row of spreadsheet
	$styleArray = [
		'font' => [
			'bold' => true,
		],
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		],
		'borders' => [
			'bottom' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
			],
		],
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'color' => [
				'argb' => 'FFD3D3D3',
			]
		]
	];

	// Styling for the section headers of the spreadsheet
	$styleArray_section = [
		'font' => [
			'bold' => true,
		],
		'borders' => [
			'bottom' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
			],
		],
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'color' => [
				'argb' => 'FFFFFF00',
			]
		]
	];

	// Styling for the service headers of the spreadsheet
	$styleArray_head = [
		'borders' => [
			'bottom' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		],
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'color' => [
				'argb' => 'FFF5964F',
			]
		]
	];

	// Styling for the first column of each section
	$styleArrayLess = [
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'color' => [
				'argb' => 'FFC6D9F0',
			]
		]
	];

	// Applying the styling
	$spreadsheet->getActiveSheet()->getStyle('B1:M1')->applyFromArray( $styleArray );
	
	// Applying the number format
	$spreadsheet->getActiveSheet()->getStyle('B2:M'.$row_num)->getNumberFormat()
	->setFormatCode('#,##0');

	// Loop through each row of the spreadsheet and apply styling as needed
	foreach ( $sheets['Dashboard'] as $k => $v ) :
		$n = 0;
		foreach ( $v as $vv ) :
			if ( !empty( $vv ) ) :
				$n++;
			endif;
		endforeach;
		$ro = $k + 1;
		if ( $n == 1 ) :
			if ( $v[0] == 'Social Outlets' ) :
				$spreadsheet->getActiveSheet()->getStyle('A'.$ro)->applyFromArray( $styleArray_section );
			else :
				$styleArray['fill']['color']['argb'] = 'FF00FFFF';
				$spreadsheet->getActiveSheet()->getStyle('A'.$ro)->applyFromArray( $styleArray_head );
			endif;
		elseif ( $n > 1 && !empty( $v[0] ) ) :
			$spreadsheet->getActiveSheet()->getStyle('A'.$ro)->applyFromArray( $styleArrayLess );
		endif;
	endforeach;

	// Remove the default worksheet that is created
	$sheetIndex = $spreadsheet->getIndex(
		$spreadsheet->getSheetByName( 'Worksheet' )
	);
	$spreadsheet->removeSheetByIndex( $sheetIndex );

	// Write XLSX file
	$writer =  new Xlsx( $spreadsheet );
	$writer->save( BASE . DS . 'data' . DS . 'analytics-'.$date_in.'.xlsx' );
?>
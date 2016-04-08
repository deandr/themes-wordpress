<?php
	register_sidebar( array(
		'name'          => 'home-highlights',
		'id'            => 'home-highlights',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => 'tv',
		'id'            => 'tv',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => 'weather',
		'id'            => 'weather',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );


	function format_tv_date($ical_date){
		if ($ical_date['hour'] != ''){
			$format_date = 'd/m \à\s H:i';
		}else{
			$format_date = 'd/m';
		}
		$date_time = ical2dtime($ical_date);

		return date($format_date, $date_time);
	}

	function ical2dtime($ical_date){
		$timezone_offet = get_option('gmt_offset');

		$str_date = $ical_date['year'] . '-' . $ical_date['month'] . '-' . $ical_date['day'];
		if ($ical_date['hour'] != ''){
			$str_date .= ' ' . $ical_date['hour'] . ':' . $ical_date['min'];
		}

		$date_time = strtotime($str_date);

		if ($ical_date['hour'] != ''){
			if ($ical_date['tz'] == 'Z'){
				$date_time += $timezone_offet * 3600;
			}
		}

		return $date_time;
	}

	function events_modify_query_order( $query ) {
	    if ( $query->is_home() ) {
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'meta_key', 'start_timestamp' );
	        $query->set( 'order', 'ASC' );
	    }
	}
	add_action( 'pre_get_posts', 'events_modify_query_order' );

?>

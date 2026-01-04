				<?php 
					global $post, $wp_locale;
					$current_time = current_time('mysql'); 
					list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_match( '([^0-9])', $current_time );
					$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;
					// Gets the event start month from the meta field
					$start_nummonth = get_post_meta( $post->ID, '_start_month', true );
					$start_month = get_post_meta( $post->ID, '_start_month', true );
					// Converts the month number to the month name
					$start_month = $wp_locale->get_month( $start_month );
					// Gets the event start day
					$start_day = get_post_meta( $post->ID, '_start_day', true );
					// Gets the event start year
					$start_year = get_post_meta( $post->ID, '_start_year', true );
					// Gets the event start hour
					$start_hour = get_post_meta( $post->ID, '_start_hour', true );
					// Gets the event start minute
					$start_minute = get_post_meta( $post->ID, '_start_minute', true );
					$end_nummonth = get_post_meta( $post->ID, '_end_month', true );
					$end_month = get_post_meta( $post->ID, '_end_month', true );
					// Converts the month number to the month name
					$end_month = $wp_locale->get_month( $end_month );
					// Gets the event start day
					$end_day = get_post_meta( $post->ID, '_end_day', true );
					// Gets the event start year
					$end_year = get_post_meta( $post->ID, '_end_year', true );
					// Gets the event start hour
					$end_hour = get_post_meta( $post->ID, '_end_hour', true );
					// Gets the event start minute
					$end_minute = get_post_meta( $post->ID, '_end_minute', true );
					$location = get_post_meta( $post->ID, '_event_location', true );
					$venue = get_post_meta( $post->ID, '_event_venue', true );
					$registration = get_post_meta( $post->ID, '_event_registration', true );
					$endday = $end_year . $end_month . $end_day;
				?>				
				<div class="event-details-wrapper clearfix">
					<?php if(! is_single() ) : ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php endif; ?>
					<div class="event-map">
					<a href="<?php the_permalink(); ?>">
            <span class="image-wrap avatar"><img class="avatar" src="//maps.googleapis.com/maps/api/staticmap?center=<?php if ( $location ) : ?><?php echo urlencode($location); ?><?php endif; ?>&amp;zoom=12&amp;size=106x106&amp;sensor=false" alt="" /></span>
					</a>
				</div><!-- /.event-map -->
				<dl class="event-details">
						<dt class="accessibility-aid">Date:</dt>
						<dd class="event-date">
						<?php if ($start_day != $end_day && $start_month == $end_month) : ?>
							<?php echo ltrim($start_day, '0') . '-' . ltrim($end_day, '0') . ' ' . $start_month . ' ' . $end_year; ?>
						<?php endif; ?>
						<?php if ($start_month != $end_month) : ?>
							<?php echo ltrim($start_day, '0') . ' ' . $start_month . ' - ' . ltrim($end_day, '0') . ' ' . $end_month . ' ' . $end_year; ?>
						<?php endif; ?>
						<?php if ($start_day == $end_day) : ?>
							<?php echo $start_day. ' ' . $start_month . ' ' . $end_year; ?>
						<?php endif; ?>
							<span class="accesibilty-aid">
								<time itemprop="startDate" datetime="<?php echo $start_year .'-' . $start_nummonth . '-' . $start_day . 'T' . $start_hour . ':' . $start_minute; ?>"></time>
								<time itemprop="endDate" datetime="<?php echo $end_year .'-' . $end_nummonth . '-' . $end_day . 'T' . $end_hour . ':' . $end_minute; ?>"></time>
							</span>
						</dd><?php if ( $location ) : ?>
						<dt class="accessibility-aid">Location:</dt>
						<dd class="location" itemprop="location" itemscope itemtype="http://schema.org/PostalAddress"><?php echo $location; ?></dd><?php endif; ?><?php if ( $venue && ( is_single() )) : ?>
						<dt class="accessibility-aid">Venue:</dt>
						<dd class="venue" itemprop="venue" itemscope itemtype="http://schema.org/PostalAddress"><?php echo $venue; ?></dd><?php endif; ?>
				</dl>
			</div><!-- /.event-details-wrapper -->

<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ozeum_tribe_events_get_css' ) ) {
	add_filter( 'ozeum_filter_get_css', 'ozeum_tribe_events_get_css', 10, 2 );
	function ozeum_tribe_events_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title,
.tribe-common .tribe-common-h7,
 .tribe-common .tribe-common-b2 {
	{$fonts['h3_font-family']};
}

.tribe-events .tribe-events-c-subscribe-dropdown .tribe-events-c-subscribe-dropdown__button .tribe-events-c-subscribe-dropdown__button-text,
.tribe-common .tribe-events-c-view-selector__list *,
.tribe-common button.tribe-events-c-search__button,
.tribe-common.tribe-events ul li>a.tribe-common-b1--min-medium,
.tribe-common .tribe-events-c-nav__today,
.tribe-common .tribe-events-c-nav__prev,
.tribe-common .tribe-events-c-nav__next,
.tribe-common.tribe-events .tribe-events-c-nav__list-item button[disabled],
a.tribe-events-c-ical__link,
#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
.tribe-common input,
.tribe-common .tribe-events-c-search__input.tribe-common-form-control-text__input,
.tribe-common.tooltipster-base .tribe-events-calendar-month__calendar-event-tooltip-datetime,
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title,
.tribe-events-content p, .tribe-events-event-meta {
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}
.tribe-events-list .tribe-events-event-meta .tribe-events-venue-details {
    {$fonts['decor_font-family']};
}
.tribe-common a.tribe-events-c-top-bar__today-button {
    {$fonts['button_font-family']};
	{$fonts['button_text-decoration']};
}
.tribe-common.tribe-events .tribe-events-calendar-month__header-column-title,
.tribe-common .tribe-events-c-top-bar__datepicker .tribe-common-h3,
.tribe-common.tooltipster-base .tooltipster-box .tribe-common-h7,
.tribe-common.tribe-events .datepicker .datepicker-switch {
	{$fonts['h5_font-family']};
	{$fonts['h5_font-size']};
	{$fonts['h5_font-weight']};
	{$fonts['h5_font-style']};
	{$fonts['h5_line-height']};
	{$fonts['h5_text-decoration']};
	{$fonts['h5_text-transform']};
	{$fonts['h5_letter-spacing']};
}
.tribe-common .tribe-events-calendar-list__month-separator-text,
.tribe-common .tribe-events-calendar-day__type-separator-text {
    {$fonts['h6_font-family']}
	{$fonts['h6_font-style']}
	{$fonts['h6_text-decoration']}
	{$fonts['h6_text-transform']}
	{$fonts['h6_letter-spacing']}
}
.tribe-common .tribe-events-calendar-list__event-datetime,
.tribe-common .tribe-events-calendar-list__event-date-tag-weekday {
    {$fonts['p_font-family']}
}
.tribe-common .tribe-events-calendar-list__event-title,
.tribe-common .tribe-events-calendar-day__event-title {
    {$fonts['h2_font-family']};
	{$fonts['h2_font-size']};
	{$fonts['h2_font-style']};
	{$fonts['h2_line-height']};
	{$fonts['h2_text-decoration']};
	{$fonts['h2_text-transform']};
	{$fonts['h2_letter-spacing']};
}
.tribe-common .tribe-events-calendar-list__event-date-tag-daynum, 
.tribe-common .tribe-events-calendar-month__day-date-daynum {
	{$fonts['h4_font-family']};
	{$fonts['h4_font-size']};
	{$fonts['h4_font-weight']};
	{$fonts['h4_font-style']};
	{$fonts['h4_line-height']};
	{$fonts['h4_text-decoration']};
	{$fonts['h4_text-transform']};
	{$fonts['h4_letter-spacing']};
}
.tribe-common .tribe-events-calendar-day__event-datetime,
.tribe-common address.tribe-events-calendar-list__event-venue.tribe-common-b2,
.tribe-common .tribe-events-calendar-list__event-description,
.tribe-common .tribe-events-calendar-month__multiday-event-bar-title,
.tribe-common .tribe-events-calendar-month__multiday-event--past .tribe-events-calendar-month__multiday-event-bar-title,
.tribe-common p,
.tribe-common.tribe-events .datepicker tbody>tr>td,
.tribe-common.tribe-events .datepicker .month,
.tribe-common.tribe-events .datepicker .dow,
.tribe-common .tribe-events-c-messages__message-list-item {
    {$fonts['p_font-family']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_font-style']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_text-transform']}
	{$fonts['p_letter-spacing']}
}


CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

#tribe-bar-form .tribe-bar-submit input[type="submit"],
#tribe-bar-form button,
#tribe-bar-form a,
#tribe-events .tribe-events-button,
#tribe-bar-views .tribe-bar-views-list,
.tribe-events-button,
.tribe-events-cal-links a,
#tribe-events-footer ~ a.tribe-events-ical.tribe-events-button,
.tribe-events-sub-nav li a {

}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}

/* The Events Calendar 5.0+ styles */
.tribe-events-content {
	color: {$colors['text']};
}
.tribe-common .tribe-events-c-top-bar__datepicker-button,
.tribe-common .tribe-events-c-events-bar__search-button-text:before {
	color: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-events-bar__search-filters-container {
    color: {$colors['input_text']};
}
.tribe-common .tribe-events-calendar-day__type-separator-text:after,
.tribe-common .tribe-events-calendar-list__month-separator-text:after {
    background-color: {$colors['input_bd_color']};
}

/*---------*/

.tribe-events .tribe-events-calendar-list-nav {
    border-color: {$colors['input_bd_color']};
}
.tribe-common .tribe-events-c-top-bar__nav-list-item,
.tribe-common input[type="text"],
#tribe-bar-form input[type="text"] {
	color: {$colors['input_text']};
	background-color: {$colors['input_bg_color']};
	border-color: {$colors['input_bd_color']};
}
input[type="text"].tribe-common-form-control-text__input:focus,
#tribe-bar-form input[type="text"]:focus,
#tribe-bar-form input[type="text"].filled {
	color: {$colors['input_dark']};
	background-color: {$colors['input_bg_hover']};
	border-color: {$colors['input_bd_hover']};
}
#tribe-bar-form input[type="text"][placeholder]::-webkit-input-placeholder 		{  color: {$colors['input_light']}; }
#tribe-bar-form input[type="text"][placeholder]::-moz-placeholder 				{  color: {$colors['input_light']}; }
#tribe-bar-form input[type="text"][placeholder]:-ms-input-placeholder 			{  color: {$colors['input_light']}; }
#tribe-bar-form input[type="text"][placeholder]::placeholder 					{  color: {$colors['input_light']}; }

#tribe-bar-form input[type="text"]:focus[placeholder]::-webkit-input-placeholder 		{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"].filled[placeholder]::-webkit-input-placeholder 		{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"]:focus[placeholder]::-moz-placeholder 				{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"].filled[placeholder]::-moz-placeholder 				{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"]:focus[placeholder]:-ms-input-placeholder 			{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"].filled[placeholder]:-ms-input-placeholder 			{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"]:focus[placeholder]::placeholder 				    	{ opacity: 1; color: {$colors['input_text']}; }
#tribe-bar-form input[type="text"].filled[placeholder]::placeholder 				    { opacity: 1; color: {$colors['input_text']}; }


.datepicker.dropdown-menu {
    background: {$colors['bg_color']};
    border-color: {$colors['bd_color']};
}
.datepicker-dropdown:before {
    border-bottom-color: {$colors['bd_color']};
}
.datepicker-dropdown:after {
    border-bottom-color: {$colors['bg_color']};
}
.datepicker-dropdown.datepicker-orient-top:before {
    border-top-color: {$colors['bd_color']};
}
.datepicker-dropdown.datepicker-orient-top:after {
    border-top-color: {$colors['bg_color']};
}
.datepicker thead tr:first-child th:hover,
.datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.datepicker .datepicker-days table th,
.datepicker .datepicker-years table th,
.datepicker .datepicker-months table th {
    color: {$colors['inverse_hover']};
    background: {$colors['text_dark']};
}
.datepicker .datepicker-days tbody,
.datepicker .datepicker-months tbody, 
.datepicker .datepicker-years tbody, 
.datepicker .datepicker-days tbody > tr > td,
.datepicker .datepicker-years tbody > tr > td,
.datepicker .datepicker-months tbody > tr > td {
    background-color: {$colors['alter_bg_color']};
}
.datepicker .datepicker-days tbody > tr > td.active,
.datepicker .datepicker-years tbody > tr > td.active,
.datepicker .datepicker-months tbody > tr > td.active {
   	color: {$colors['inverse_link']};
	background: {$colors['text_link']}; 
}
.datepicker .datepicker-days tbody tr td.day.focused,
.datepicker .datepicker-days tbody tr td.day:hover {
    color: {$colors['text_dark']};
}

.tribe-events .datepicker .next .tribe-events-c-top-bar__datepicker-nav-icon-svg path,
.tribe-events .datepicker .prev .tribe-events-c-top-bar__datepicker-nav-icon-svg path {
    fill: {$colors['inverse_link']};
}

.tribe-events .datepicker .next:hover .tribe-events-c-top-bar__datepicker-nav-icon-svg path,
.tribe-events .datepicker .prev:hover .tribe-events-c-top-bar__datepicker-nav-icon-svg path {
    fill: {$colors['inverse_hover']};
}

.datepicker .datepicker-days table th.prev:hover,
.datepicker .datepicker-days table th.next:hover, 
.datepicker .datepicker-years table th.prev:hover, 
.datepicker .datepicker-years table th.next:hover, 
.datepicker .datepicker-months table th.prev:hover,
.datepicker .datepicker-months table th.next:hover,
.datepicker .datepicker-years table th.prev:hover,
.datepicker .datepicker-years table th.next:hover {
    color: {$colors['text_link']};
}

.datepicker table tr td span.active.active,
.datepicker table tr td span.focused {
    color: {$colors['inverse_link']};
    background: {$colors['text_link']};
}
.datepicker table tr td span:hover {
    color: {$colors['inverse_hover']};
    background: {$colors['text_hover']};
}
.datepicker table tr td.active.active:hover,
.datepicker table tr td span.active.active:hover,
.tribe-events .datepicker .year.active, 
.tribe-events .datepicker .year.active.focused,
.tribe-events .datepicker .year:hover {
    color: {$colors['inverse_hover']};
    background: {$colors['text_hover']};
}
.tribe-events .datepicker .year.focused {
	color: {$colors['inverse_link']};
	background: {$colors['text_link']};
}
.datepicker table tr td.new, .datepicker table tr td.old {
    color: {$colors['extra_light']}; 
}

.datepicker .datepicker-switch:hover,
.datepicker .next:hover, .datepicker .prev:hover,
.datepicker tfoot tr th:hover {
	background: {$colors['extra_bg_color']} !important;
}
.datepicker table tr td span.new,
.datepicker table tr td span.old {
    color: {$colors['text_light']}; 
}


/* Content */
.tribe-events-calendar thead th {
	color: {$colors['extra_text']};
	background: {$colors['extra_bg_color']} !important;
}
.tribe-events-calendar > tbody > tr:nth-child(2n) > td,
.tribe-events-calendar > tbody > tr:nth-child(2n+1) > td {
    background-color: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-calendar td:hover {
    background-color: {$colors['alter_bg_color']};
}

#tribe-events-content .tribe-events-calendar td + td {
	border-left-color: {$colors['alter_bd_color']} !important;
}
#tribe-events-content .tribe-events-calendar th + th {
	border-left-color: {$colors['extra_bg_hover']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_hover']};
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a,
.tribe-events-calendar td div[id*="tribe-events-daynum-"]:hover > a {
    background: transparent;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"]:hover {
    color: {$colors['inverse_link']};
	background-color: {$colors['alter_link']};
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"]:hover > a {
    color: {$colors['inverse_link']};
}

.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_hover']};
	
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_hover']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['inverse_link']};
	background: {$colors['alter_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text_dark']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['text_link']};
}
#tribe-mobile-container .type-tribe_events ~ .type-tribe_events {
    border-color: {$colors['bd_color']};
}

#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_dark']};
}

#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['inverse_link']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-present.mobile-active:hover,
.tribe-events-calendar td.tribe-events-present.mobile-active,
.tribe-events-calendar td.tribe-events-present.mobile-active div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present.mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: {$colors['alter_bg_color']};
}
.events-archive.events-gridview #tribe-events-content table .type-tribe_events {
	border-color: {$colors['bd_color']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-present h3.tribe-events-month-event-title a {
  	color: {$colors['text_dark']};  
}
#tribe-events-content .tribe-events-calendar td.tribe-events-present h3.tribe-events-month-event-title a:hover {
  	color: {$colors['text_link']};  
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-shortcode.view-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bd_color']};
}

#tribe-events-content .tribe-events-tooltip .summary { 
	color: {$colors['extra_dark']};
	background: {$colors['extra_bg_color']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['extra_text']};
}


/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['text_dark']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list-separator-month span {
	background-color: transparent;	
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['extra_dark']};
	border-color: {$colors['extra_bg_color']};
	background: {$colors['extra_bg_color']};
}
.tribe-events-list .tribe-events-venue-details {
    color: {$colors['text_dark']};
}


.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

.single-tribe_events #tribe-events-footer,
.tribe-events-day #tribe-events-footer,
.events-list #tribe-events-footer,
.tribe-events-map #tribe-events-footer,
.tribe-events-photo #tribe-events-footer {
	border-color: {$colors['bd_color']};	
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5,
.tribe-events-day .tribe-events-day-time-slot .tribe-events-day-time-slot-heading {
	color: {$colors['extra_dark']};
	background: {$colors['extra_bg_color']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}
.single-tribe_events .tribe-events-event-meta {
    color: {$colors['text']};
	background: {$colors['bg_color']};
}
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt {
    color: {$colors['text_dark']};
}
.single-tribe_events .tribe-events-meta-group .tribe-events-single-section-title {
    border-color: {$colors['text_dark']};
}
.single-tribe_events .tribe-events-meta-group .tribe-events-event-categories a {
    color: {$colors['text']};
}
.single-tribe_events .tribe-events-meta-group .tribe-events-event-categories a:hover {
    color: {$colors['text_dark']};
}
.single-tribe_events .tribe-events-meta-group .tribe-organizer-url a {
    color: {$colors['text']};
}
.single-tribe_events .tribe-events-meta-group .tribe-organizer-url a:hover {
    color: {$colors['text_dark']};
}
.single-tribe_events .tribe-events-meta-group .tribe-venue-url a {
    color: {$colors['text']};
}
.single-tribe_events .tribe-events-meta-group .tribe-venue-url a:hover {
    color: {$colors['text_dark']};
}

.single-tribe_events .tribe-events-meta-group .tribe-venue-location .tribe-events-address a {
    color: {$colors['text']};
}
.single-tribe_events .tribe-events-meta-group .tribe-venue-location .tribe-events-address a:hover {
    color: {$colors['text_dark']};
}
.single-tribe_events .tribe-events-meta-group .tribe-event-tags a {
    color: {$colors['text']};
}
.single-tribe_events .tribe-events-meta-group .tribe-event-tags a:hover {
    color: {$colors['text_dark']};
}
#tribe-events .tribe-events-cal-links .tribe-events-ical.tribe-events-button,
#tribe-events-pg-template .tribe-events-cal-links .tribe-events-ical.tribe-events-button{
    color: {$colors['text_dark']} !important;
    border-color: {$colors['bd_color']} !important;
	background-color: transparent !important;
}
#tribe-events .tribe-events-cal-links .tribe-events-ical.tribe-events-button:hover,
#tribe-events-pg-template .tribe-events-cal-links .tribe-events-ical.tribe-events-button:hover {
    color: {$colors['inverse_hover']} !important;
    border-color: {$colors['text_dark']} !important;
	background-color: {$colors['text_dark']} !important;
}

.tribe-common .tribe-events-c-nav__list a,
 .tribe-common .tribe-events-c-nav__list a:hover {
    color: {$colors['text_dark']}
}

.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__prev:before,
.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__next:after,
.tribe-common .tribe-events-c-nav__today {
    color: {$colors['text_dark']};
    border-color: {$colors['bd_color']}
}
.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__prev:hover:before,
.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__next:hover:after {
    color: {$colors['text_dark']};
    border-color: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__next:before,
.tribe-common .tribe-events-c-nav__list a.tribe-events-c-nav__prev:after,
.tribe-common .tribe-events-c-nav__list .tribe-events-c-ical__link:before,
.tribe-common .tribe-events-c-nav__list .tribe-events-c-ical__link:after,
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-next a:before,
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-previous a:before, 
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-previous a:before, 
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-next a:before {
    background-color: {$colors['text_dark']};
}
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-previous a:after,
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-next a:after,
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-previous a:after,
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-next a:after {
    border-color: {$colors['bd_color']};
}
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-previous a:hover:after,
#tribe-events-header .tribe-events-sub-nav li.tribe-events-nav-next a:hover:after,
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-previous a:hover:after,
#tribe-events-footer .tribe-events-sub-nav li.tribe-events-nav-next a:hover:after {
    border-color: {$colors['text_dark']};
}
/* Toggle */
#tribe-bar-collapse-toggle {
    color: {$colors['inverse_hover']};
    border-color: {$colors['text_hover']};
	background-color: {$colors['text_hover']};
}

#tribe-bar-form.tribe-bar-collapse .tribe-bar-filters {
    background-color: {$colors['alter_bg_color']};
}


/* Notices */
.tribe-events-notices {
    color: {$colors['text']};
    border-color: {$colors['text_link']};
	background-color: {$colors['bg_color']};
}
.tribe-events-notices strong {
    color: {$colors['text_dark']};
}

/* The Events Calendar 5.0+ */

.tribe-common .tribe-common-c-loader__dot {
   background-color: {$colors['text_link']};
}

.tribe-common .tribe-events-c-ical__link,
.tribe-common .tribe-common-c-btn-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.tribe-common .tribe-events-c-ical__link:hover,
.tribe-common .tribe-common-c-btn-icon:hover {
    color: {$colors['inverse_hover']};
	background-color: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-top-bar__today-button {
    color: {$colors['text']};
    border-color: {$colors['text_link']};
	background-color: transparent;
}
.tribe-common .tribe-events-c-top-bar__today-button:hover {
	color: {$colors['inverse_link']} !important;
    border-color: {$colors['alter_link']};
	background-color: {$colors['alter_link']};
}
.tribe-common .tribe-events-calendar-list__event-description {
    color: {$colors['text']};
}
.tribe-common .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-common .tribe-events-calendar-list__event-header .tribe-events-calendar-list__event-title a,
.tribe-common .tribe-events-calendar-day__event-title a,
.tribe-common .tribe-events-calendar-list__event-date-tag-daynum,
.tribe-common .tribe-events-calendar-month__day-date-daynum a {
    color: {$colors['text_dark']};
}
.tribe-common .tribe-events-calendar-list__event-datetime,
.tribe-common .tribe-events-calendar-day__event-datetime,
 .tribe-common.tooltipster-base .tribe-events-calendar-month__calendar-event-tooltip-datetime {
    color: {$colors['extra_text']};
}
.tribe-common .tribe-events-calendar-month__day-date,
.tribe-common.tribe-events .tribe-events-calendar-month__header-column-title,
.tribe-common .tribe-events-calendar-list__event-venue {
    color: {$colors['text_dark']};
}
.tribe-common .tribe-events-calendar-month__multiday-event-bar-inner {
	background-color: {$colors['alter_bg_color']};
}
.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-month__day:hover:after {
    background-color: {$colors['alter_link']};
}
.tribe-common .datepicker-days tbody>tr>td,
.tribe-common.tribe-events .datepicker .month {
    background-color: {$colors['alter_bg_color']};
    color: {$colors['text']};
}
.tribe-common .datepicker-switch:hover,
.tribe-common .datepicker .prev:hover span,
.tribe-common .datepicker .next:hover span,
.tribe-common-anchor-thin-alt:hover,
.tribe-common-anchor-thin-alt:active,
.tribe-common-anchor-thin-alt:focus,
.tribe-events .tribe-events-c-view-selector__list-item-text:hover,
.tribe-common .tribe-events-calendar-list__event-header .tribe-events-calendar-day__event-title a
.tribe-common .tribe-events-calendar-list__event-title a:hover,
.tribe-common .tribe-events-calendar-list__event-header .tribe-events-calendar-list__event-title a:hover {
    color: {$colors['alter_link']};
}
.tribe-common .datepicker .datepicker tbody>tr>td.current,
.tribe-common .datepicker table tr td.active.active:hover {
    color: {$colors['extra_dark']};
}
.tribe-common .datepicker .datepicker-days tbody>tr>td.current {
    background-color: {$colors['extra_bg_color']};
    color: {$colors['extra_text']};
}
.tribe-common .datepicker .datepicker-days tbody>tr>td.current:hover {
    color: {$colors['inverse_link']};
}
.tribe-common.tribe-events .datepicker .month.current {
	color: {$colors['inverse_link']};
	background: {$colors['text_link']}; 
}
.tribe-common.tribe-events .datepicker .month.active,
.tribe-common.tribe-events .datepicker .month.focused {
    background-color: {$colors['extra_bg_color']};
    color: {$colors['inverse_link']};
}
.tribe-common.tribe-events .datepicker .month:hover {
    background-color: {$colors['extra_bg_color']};
    color: {$colors['inverse_hover']};
}
.tribe-common.tribe-events .tribe-events-c-nav__list-item button[disabled] {
    color: {$colors['text']} !important;
}
.tribe-common.tribe-events .tribe-events-c-messages__message {
	background-color: {$colors['alter_bg_color']};
}
.tribe-common .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__day-date {
    color: {$colors['alter_link']};
}
.tribe-common.tribe-events .tribe-events-calendar-month__mobile-events-icon--event {
    background-color: {$colors['text_dark']};
}
.tribe-common .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__mobile-events-icon--event {
    background-color: {$colors['alter_link']};
}
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date {
    color: {$colors['alter_link']};
}
.tribe-events .tribe-events-c-events-bar__search-button--active .tribe-common-svgicon:before {
	color: {$colors['alter_link']};
}
.tribe-common #tribe-events-view-selector-content,
.tribe-common .tribe-events-c-events-bar__search-filters-container,
.tribe-common .tribe-events-c-top-bar__nav-list-item,
.tribe-common .tribe-events-c-events-bar,
.tribe-common .tribe-events-header,
 .tribe-events .tribe-events-c-events-bar__search-container {
    background-color: {$colors['alter_bg_color']};
}
.tribe-common .tribe-common-h7,
.tribe-common .tribe-common-anchor-thin-alt,
.tribe-common .tribe-events-c-messages__message-list-item,
.tribe-common .tribe-events-c-view-selector__list-item-text,
.tribe-common .tribe-events-c-view-selector__list-item-link,
.tribe-common .tribe-events-c-view-selector__list-item-link:visited,
.tribe-common .tribe-events-c-view-selector__button,
.tribe-common .tribe-events-c-view-selector__list-item-link .tribe-events-c-view-selector__button-icon:after,
.tribe-common .tribe-events-c-view-selector__button-icon:after,
.tribe-events-c-view-selector__list-item-link .tribe-events-c-view-selector__list-item-icon:after,
.tribe-events-c-events-bar__search-button-text:before,
.tribe-common .tribe-events-c-top-bar__datepicker-button {
    color: {$colors['text_dark']};
}
.tribe-common .tribe-common-anchor-thin-alt:hover,
.tribe-common .tribe-events-c-view-selector__list-item-text:hover,
.tribe-common .tribe-events-c-view-selector__list-item-link:hover .tribe-events-c-view-selector__list-item-text,
.tribe-common .tribe-events-c-view-selector__button:hover,
.tribe-common .tribe-events-c-view-selector__button-icon:hover:after,
.tribe-events-c-view-selector__list-item-link:hover .tribe-events-c-view-selector__list-item-icon:after,
.tribe-events-c-events-bar__search-button-text:hover:before, 
.tribe-common .tribe-events-c-top-bar__datepicker-button:hover {
    color: {$colors['alter_link']};
}
.tribe-common.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-view-selector--tabs .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-link:after {
    background-color: {$colors['text_dark']};
}
.tribe-common.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-view-selector--tabs .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-link:hover:after {
    background-color: {$colors['alter_link']};
}
.tribe-common .datepicker .next:hover,
.tribe-common .datepicker .prev:hover {
    background: {$colors['text_dark']} !important;
}
.tribe-events-notices {
    color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
	border-top-color: {$colors['alter_dark']};
}
CSS;
		}

		return $css;
	}
}
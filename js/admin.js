/* 
 * Copyright (c) 2014 Dominik Schilling (ocean90)
 *
 * This program was created by a WordPress core contributor and
 * modified by James M. Joyce, Flashpoint Computer Services, LLC
 * from its distribution on trac.wordpress.org.
 *
 * WordPress is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, version 2. 
 *
 * WordPress is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
 * GNU General Public License for more details. 
 *
 * You should have received a copy of the GNU General Public License 
 * along with WordPress. If not, see <https://www.gnu.org/licenses/gpl-2.0.txt>. 
 */
 
(function ($) {
	"use strict";
	$(function () {
		function initColorPicker( widget ) {
			widget.find( '.color-picker' ).wpColorPicker( {
				change: _.throttle( function() { // For Customizer
					$(this).trigger( 'change' );
				}, 3000 )
			});
		}
		
		function onFormUpdate( event, widget ) {
			initColorPicker( widget );
		}

		$( document ).on( 'widget-added widget-updated', onFormUpdate );
	
		$( document ).ready( function() {
			$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
				initColorPicker( $( this ) );
			} );
		} );
	});
}(jQuery));
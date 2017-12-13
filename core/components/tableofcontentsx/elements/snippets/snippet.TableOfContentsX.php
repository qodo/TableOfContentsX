<?php
/**
 * TableOfContentsX
 *
 * This snippet takes HTML content and generates a table of contents based
 * on the HTML headers <h1>, <h2> etc. Each header should have a HTML anchor
 * if it should be clickable.
 *
 * Based on code by Joost de Valk, submitted on 02/08/2011
 * http://www.westhost.com/contest/php/function/create-table-of-contents/124
 *
 * TableOfContentsX is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * TableOfContentsX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * @author Stewart Orr @ Qodo Ltd <stewart@qodo.co.uk>
 * @version 1.1
 */

// Parameters/options
// What should the snippet output? Either 'toc' or 'content'
$options = isset($options) && ($options == 'content' || $options == 'toc') ? $options : 'toc';

// If you would prefer the content to be placeholders - DISABLED for now
//$toPlaceholder = isset($toPlaceholder) ? $toPlaceholder : FALSE ;
//$toPlaceholderPrefix = isset($toPlaceholderPrefix) ? $toPlaceholderPrefix . "." : '' ; // If you want to prefix the placeholders

preg_match_all('/<h([1-6])()>([^<]+)<\/h[1-6]>/i', $input, $matches, PREG_SET_ORDER);

$anchors = array();
$toc 	 = '<ol class="toc">'."\n";
$i 		 = 0;

// Content should be MODX input
$content = $input;

foreach ($matches as $heading) {

	if ($i == 0)
		$startlvl = $heading[1];
		$lvl = $heading[1];

	$ret = preg_match( '/id=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $anchor );
	if ( $ret && $anchor[1] != '' ) {
		$anchor = stripslashes( $anchor[1] );
		$add_id = false;
	} else {
		$anchor = preg_replace( '/\s+/', '-', preg_replace('/[^a-z\s]/', '', strtolower( $heading[3] ) ) );
		$add_id = true;
	}

	if ( !in_array( $anchor, $anchors ) ) {
		$anchors[] = $anchor;
	} else {
		$orig_anchor = $anchor;
		$i = 2;
		while ( in_array( $anchor, $anchors ) ) {
			$anchor = $orig_anchor.'-'.$i;
			$i++;
		}
		$anchors[] = $anchor;
	}

	if ($add_id) {
		$content = substr_replace( $content, '<h'.$lvl.' id="'.$anchor.'"'.$heading[2].'>'.$heading[3].'</h'.$lvl.'>', strpos( $content, $heading[0] ), strlen( $heading[0] ) );
	}

	$ret = preg_match( '/title=[\'|"](.*)?[\'|"]/i', stripslashes( $heading[2] ), $title );
	if ( $ret && $title[1] != '' )
		$title = stripslashes( $title[1] );
	else
		$title = $heading[3];
	$title 		= trim( strip_tags( $title ) );

	if ($i > 0) {
		if ($prevlvl < $lvl) {
			$toc .= "\n"."<ol>"."\n";
		} else if ($prevlvl > $lvl) {
			$toc .= '</li>'."\n";
			while ($prevlvl > $lvl) {
				$toc .= "</ol>"."\n".'</li>'."\n";
				$prevlvl--;
			}
		} else {
			$toc .= '</li>'."\n";
		}
	}

	$j = 0;
	$toc .= '<li><a href="[[~[[*id]]]]#'.$anchor.'">'.$title.'</a>';
	$prevlvl = $lvl;

	$i++;
}

unset( $anchors );

while ( $lvl > $startlvl ) {
	$toc .= "\n</ol>";
	$lvl--;
}

$toc .= '</li>'."\n";
$toc .= '</ol>'."\n";

// Finally output the content
if ($options == 'content') {
	echo $content;
} else {
	echo $toc;
}
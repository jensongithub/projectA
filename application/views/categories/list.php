<?php

function print_cat($categories, $level = 0) {
	foreach ($categories as $item) {
		if( $level == 0 )
			echo "<div class='category-level-$level'><h4>" . $item['itself']['name'] . '</h4></div>';
		else
			echo "<div class='category-level-$level'>" . $item['itself']['name'] . '</div>';

		if( count($item['child']) > 0 )
			print_cat($item['child'], $level + 1);
	}
}

print_cat($cat);
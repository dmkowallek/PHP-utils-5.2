<?php

/**
 * Summary of sputcsv (safe for PHP 5.2)
 * 
 * Like fputcsv but returns a string
 * 
 * @category   PHP utils (5.2)
 * @package    n/a
 * @author     D M Kowallek <git@kowallekfamily.com>
 * @license    https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GPLv2 License
 * @version    1.0.0
 *
 * @param array $fields
 * @param string $delimiter
 * @param string $enclosure
 * @return string
 */
function sputcsv($fields, $delimiter = ",", $enclosure = '"')
{
	$handle = fopen('php://temp', 'r+');
	fputcsv($handle, $fields, $delimiter, $enclosure);
	rewind($handle);
	$line = stream_get_contents($handle);
	fclose($handle);

	return str_replace(array("\r", "\n"), '', $line);
}

?>

<?php

/**
 * Summary of is_crawler
 * 
 * Returns 'true' if HTTP request appears to be from a well-known crawler
 * Else returns 'false'
 * 
 * @category   PHP utils (5.2)
 * @package    n/a
 * @author     D M Kowallek <git@kowallekfamily.com>
 * @license    https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GPLv2 License
 * @version    1.0.0
 *
 * @param string $user_agent
 * 
 * @return bool
 */
function is_crawler($user_agent)
{
	// 1. Normalize inputs
	$user_agent = strtolower($user_agent);

	// 2. Google
	if (strpos($user_agent, 'googlebot') !== false)
		return true;

	// 3. Bing
	if (strpos($user_agent, 'bingbot') !== false)
		return true;

	// 4. Yahoo
	if (strpos($user_agent, 'slurp') !== false)
		return true;

	// 5. DuckDuckGo
	if (strpos($user_agent, 'duckduckbot') !== false || strpos($user_agent, 'duckassistbot') !== false)
		return true;

	// 6. Wayback Machine (Internet Archive)
	if (strpos($user_agent, 'archive.org_bot') !== false || strpos($user_agent, 'ia_archiver') !== false)
		return true;

	return false;
}

/**
 * Summary of is_verified_crawler
 * 
 * Returns 'true' if HTTP request is from a well-known crawler
 * Else returns 'false'
 * 
 * @param string $ip
 * @param string $user_agent
 * 
 * @return bool
 */
function is_verified_crawler($ip, $user_agent)
{
	// 1. Normalize inputs
	$user_agent = strtolower($user_agent);

	// 2. Validate Google
	if (strpos($user_agent, 'googlebot') !== false)
	{
		$hostname = gethostbyaddr($ip);
		if (preg_match('/\.googlebot\.com$/i', $hostname) || preg_match('/\.google\.com$/i', $hostname))
			return gethostbyname($hostname) === $ip;
	}

	// 3. Validate Bing
	if (strpos($user_agent, 'bingbot') !== false)
	{
		$hostname = gethostbyaddr($ip);
		if (preg_match('/\.search\.msn\.com$/i', $hostname))
			return gethostbyname($hostname) === $ip;
	}

	// 4. Validate Yahoo (Yahoo! Slurp uses crawl.yahoo.net)
	if (strpos($user_agent, 'slurp') !== false)
	{
		$hostname = gethostbyaddr($ip);
		if (preg_match('/\.crawl\.yahoo\.net$/i', $hostname))
			return gethostbyname($hostname) === $ip; // Cross-verify IP match
	}

	// 5. Validate DuckDuckGo (Uses an official IP array lookup)
	if (strpos($user_agent, 'duckduckbot') !== false || strpos($user_agent, 'duckassistbot') !== false)
	{
		// Fetch or hardcode the list from: https://duckduckgo.com/duckduckbot.json
		$ddg_ips = array(
			'23.21.227.69',
			'40.88.21.235',
			'50.16.241.113',
			'50.16.241.114',
			'50.16.241.117',
			'50.16.247.234',
			'52.204.97.54',
			'52.5.190.19',
			'54.197.234.188',
			'54.208.100.253',
			'54.208.102.37',
			'107.21.1.8'
		);
		return in_array($ip, $ddg_ips, true);
	}

	// 6. Validate Wayback Machine (Internet Archive)
	if (strpos($user_agent, 'archive.org_bot') !== false || strpos($user_agent, 'ia_archiver') !== false)
	{
		$hostname = gethostbyaddr($ip);
		// Ensure the hostname belongs to archive.org
		if (preg_match('/\.archive\.org$/i', $hostname))
			return gethostbyname($hostname) === $ip; // Cross-verify IP match
	}

	return false;
}

?>


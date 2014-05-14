<?

class time_Core {

	// Essentially replaces date() but includes timezone conversion
	public static function date($time_string = NULL, $output_format = 'Y-m-d H:i:s')
	{
		return $time_string;

        if ($time_string === NULL) $time_string = date('Y-m-d H:i:s');
		$time_string = (is_numeric($time_string)) ? "@".$time_string : $time_string;

		return NULL;
	}
	// Essentially replaces date() but includes timezone conversion
	public static function dateOLD($time_string = NULL, $output_format = 'Y-m-d H:i:s', $timezone = 'UTC')
	{
		if ($time_string === NULL) $time_string = date('Y-m-d H:i:s');
		$time_string = (is_numeric($time_string)) ? "@".$time_string : $time_string;
		if ($d = new DateTime($time_string))
		{
			$d->setTimeZone(new DateTimeZone($timezone));
			return $d->format($output_format);
		}
		return NULL;
	}

	// Generate a timezone dropdown list
	public static function timezones($show_local = FALSE, $filter = NULL)
	{
		$timezones = DateTimeZone::listIdentifiers();
		foreach ($timezones as $timezone)
		{
			$region = explode("/", $timezone);

			if (($filter !== NULL and in_array($region[0], $filter) and $timezone !== 'US/Pacific-New')
				or ($timezone == 'UTC'))
			{
				$return[$timezone] = str_replace(array('/','_'), array(' - ',' '), $timezone);
				if ($show_local)
				{
					$return[$timezone] .= ' ('.time::date(time(), 'g:iA', $timezone).')';
					$return[$timezone] .= (time::date(time(), 'I', $timezone)) ? ' DST' : '';
					$return[$timezone] .= ' '.time::date(time(), 'P', $timezone).')';
				}
			}
			elseif ($filter === NULL)
			{
				// 'US/Pacific-New' is being phased out
				if ($timezone != 'US/Pacific-New')
				{
					$return[$timezone] = str_replace(array('/','_'), array(' - ',' '), $timezone);
					if ($show_local)
					{
						$return[$timezone] .= ' ('.time::date(time(), 'g:iA', $timezone);
						$return[$timezone] .= (time::date(time(), 'I', $timezone)) ? ' DST' : '';
						$return[$timezone] .= ' '.time::date(time(), 'P', $timezone).')';
					}
				}
			}
		}

		return $return;
	}

	// Validate a timezone
	public static function valid_timezone($tz)
	{
		$timezones = DateTimeZone::listIdentifiers();
		foreach ($timezones as $timezone)
		{
			if ($timezone === $tz)
				return TRUE;
		}
		return FALSE;
	}
}

?>
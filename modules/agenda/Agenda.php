<?php
/**
 * Agenda class.
 *
 * @package	Agenda
 * @version	0.1
 * @author	Steven Normore
*/

define('MAX_EVENTS_NAME', 50);

class Agenda
{
	/**
	 * array containting date of agenda
	 * @var $date array
	*/
	var $date;

	/**
	 * array containting next date of agenda
	 * @var $next_date array
	*/
	var $next_date;

	/**
	 * array containting last date of agenda
	 * @var $last_date array
	*/
	var $last_date;

	/**
	 * Class constructor.
	 * Initialize things.
	 * @param string date, format is YYYY-mm-dd (year-month-day)
	*/
	function Agenda($t, $view)
	{
		if(!get_magic_quotes_gpc())
			$t = addslashes($t);

		if($view == 'month')
		{
			$a_t = explode('-', $t);
			if(empty($t) || count($a_t) < 2 || !checkdate($a_t[1],1,$a_t[0]))
			{
				$t = gmdate('Y-m');
				$a_t = explode('-', $t);
			}
			list($this->date['year'], $this->date['month']) = $a_t;
		}
		elseif($view == 'day')
		{
			$a_t = explode('-', $t);
			if(empty($t) || count($a_t) < 3 || !checkdate($a_t[1],$a_t[2],$a_t[0]))
			{
				if(count($a_t) == 2)
					$t .= '-'.gmdate('d', mktime(0,0,0,$a_t[1],gmdate('d'),$a_t[0]));
				else
					$t = gmdate('Y-m-d');
				$a_t = explode('-', $t);
			}
			list($this->date['year'], $this->date['month'], $this->date['day']) = $a_t;
		}

		$this->next_date = $this->nextDate();
		$this->last_date = $this->lastDate();
	}

	/**
	 * Returns an array of the next date after increasing the date by one,
	 * this could mean the next month or the next day, depending on the current
	 * view.
	 * @return array Array of next date.
	*/
	function nextDate()
	{
		if(count($this->date) == 2)	// month view
			list($next['year'], $next['month']) = split('-', gmdate('Y-m', mktime(0,0,0,$this->date['month']+1,1,$this->date['year'])));
		else	// day view
			list($next['year'], $next['month'], $next['day']) = split('-', gmdate('Y-m-d', mktime(0,0,0,$this->date['month'],$this->date['day']+1,$this->date['year'])));
		
		return $next;
	}

	/**
	 * Returns an array of the next date after descreasing the date by one,
	 * this could mean the last month or the last day, depending on the current
	 * view.
	 * @return array Array of last day.
	*/
	function lastDate()
	{
		if(count($this->date) == 2)	// month view
			list($last['year'], $last['month']) = split('-', gmdate('Y-m', mktime(0,0,0,$this->date['month']-1,1,$this->date['year'])));
		else	// day view
			list($last['year'], $last['month'], $last['day']) = split('-', gmdate('Y-m-d', mktime(0,0,0,$this->date['month'],$this->date['day']-1,$this->date['year'])));
		
		return $last;
	}

	/**
	 * Returns the date converted to the format that will be passed
	 * between pages. YYYY-mm-dd
	 * @return array Array of last day.
	*/
	function formatDate($date)
	{
		if(count($date) == 2)
			$ret = implode('-', array($date['year'],$date['month']));
		else
			$ret = implode('-', array($date['year'],$date['month'],$date['day']));

		return $ret;
	}

	/**
	 * Display 'jump to date' interface.
	*/
	function showJumpTo($page, $Project)
	{
		global $Project;
		?>
		<div style="text-align:center">
		<form action="index.php" method="get">
		<input type="hidden" name="mod" value="agenda" />
		<input type="hidden" name="page" value="<?=$page?>" />
		<input type="hidden" name="pid" value="<?=$Project->pid?>" />
		<?=$page == 'index' ? 'Jump to (yyyy-mm):<br />' : 'Jump to (yyyy-mm-dd):<br />'?>
		<input type="text" name="t" value="<?=$this->formatDate($this->date)?>" style="text-align:center" /><br />
		<input type="submit" value="Go" />
		</form>
		</div>
		<?php
	}
}
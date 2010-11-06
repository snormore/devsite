<?php
/**
 * FText, formats and parses text to the fText specifications.
 *
 * @package	DevSite
 * @version	0.1
 * @author	Steven Normore
*/
class FText
{
	/**
	 * Displays the fText editor.
	 *
	 * @param	string	The id or name that will be given to the text area.
	 * @param	string	Text that will be placed in the textarea. (Optional).
	 * @param	integer	The width the textarea, default to 60 (Optional).
	 * @param	integer	The height the textarea, default to 30 (Optional).
	 *
	 * @return  VOID
	*/
	function showEditor($idname, $text = '', $cols = 60, $rows = 30)
	{
		?>
		<input type="button" value="bold">
		<input type="button" value="italic">
		<input type="button" value="underline">
		<input type="button" value="url">
		<input type="button" value="image">
		<input type="button" value="center">
		<input type="button" value="left">
		<input type="button" value="right">
		<br />
		<textarea name="<?=$idname?>" cols="<?=$cols?>" rows="<?=$rows?>"><?=FText::db2fText($text)?></textarea>
		<?php
	}

	/**
	 * Convert text from plain text format to the format stored in the database.
	 *
	 * @param	string Text to be converted.
	 *
	 * @return  string Converted text.
	*/
	function fText2db($text)
	{
		if(!get_magic_quotes_gpc())
			return addslashes($text);
		return $text;
	}

	/**
	 * Convert text stored in database to plain text format.
	 *
	 * @param	string Text to be converted.
	 *
	 * @return  string Converted text.
	*/
	function db2fText($text)
	{
		return $text;
	}

	/**
	 * Convert plain text to its html equivalent.
	 *
	 * @param	string Text to be converted.
	 *
	 * @return  string Converted text.
	*/
	function fText2html($text)
	{
		$text = nl2br(htmlentities($text));

		$p[] = '/\[b\]/';              $r[] = '<b>';
		$p[] = '/\[\/b\]/';            $r[] = '</b>';
		$p[] = '/\[u\]/';              $r[] = '<u>';
		$p[] = '/\[\/u\]/';            $r[] = '</u>';
		$p[] = '/\[i\]/';              $r[] = '<i>';
		$p[] = '/\[\/i\]/';            $r[] = '</i>';
		$p[] = '/\[img (.+)\]/';       $r[] = '<img $1>';
		$p[] = '/\[\/a\]/';            $r[] = '</a>';
		$p[] = '/\[a (.+)\]/';         $r[] = '<a $1>';
		$p[] = '/\[left\]/';           $r[] = '<div style="text-align:left">';
		$p[] = '/\[\/left\]/';         $r[] = '</div>';
		$p[] = '/\[center\]/';         $r[] = '<div style="text-align:center">';
		$p[] = '/\[\/center\]/';       $r[] = '</div>';
		$p[] = '/\[right\]/';          $r[] = '<div style="text-align:right">';
		$p[] = '/\[\/right\]/';        $r[] = '</div>';

		$text = preg_replace($p, $r, $text);
		return $text;
	}
}
?>
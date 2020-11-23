/**
 * humanReadable
 *
 * This simple snippet will format a machine readable-style 
 * number (i.e. 15000 or 1500000) into its human readable 
 * counterpart (e.g. 15k or 1.5m).
 *
 * TODO: Add support for other machine readable formats
 *       For example: filesize, weight, etc.
 *
 * &number    integer   The number you wish to format.
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$output = '';
$number = (integer) $modx->getOption('number',$scriptProperties, null);
    if (is_null($number)) {
        $err = "[humanReadableKilo] You must specify a number to format!";
        $modx->log(modX::LOG_LEVEL_ERROR, $err);
    }
    if ($number > 1000) {
        $x = round($number);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        $output = $x_display;
    }
    return $output;
    

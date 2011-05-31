<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Constructs and formats messages with place-holders.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassMessageFormat.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Constructs and formats messages with place-holders.
 *
 * MessageFormat takes a pattern string and a list of substitutes, then inserts
 * those substitutes into the pattern at appropriate place-holders.
 *
 * Example of pattern:
 * <pre>
 * Hello {name}! I am {me}
 * </pre>
 *
 * Example of substitutes:
 * <pre>
 * Array('name' => 'Tom', 'me' => 'Thanh')
 * </pre>
 *
 * @package    	Commons
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @since      	Class available since v0.1
 */
class Ddth_Commons_MessageFormat {
    /**
     * The pattern string.
     *
     * @var string
     */
    private $pattern = NULL;

    /**
     * Constructs a new Ddth_Commons_MessageFormat object.
     */
    public function __construct($pattern=NULL) {
        $this->setPattern($pattern);
    }

    /**
     * Gets the pattern string
     *
     * @param string
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     * Sets the pattern string.
     *
     * @param string
     */
    public function setPattern($pattern) {
        $this->pattern = $pattern;
    }

    /**
     * Formats the pattern against supplied substitute and returns
     * the formatted pattern string.
     *
     * @param Array()
     * @return string
     */
    public function format($substitutes=Array()) {
        $result = "";
        $text = $this->pattern !== NULL ? $this->pattern : "";
        if ( !is_array($substitutes) ) {
            $substitutes = Array();
        }
        while ( strlen($text) > 0 ) {
            $pEsc = strpos($text, "\\");
            $pOpen = strpos($text, "{");
            if ( $pEsc===false && $pOpen===false ) {
                //no escape char, no open tag char
                //--> stop processing
                $result .= $text;
                break;
            }
            if ( $pEsc === false ) {
                $pEsc = strlen($text)-1;
            }
            if ( $pOpen === false ) {
                $pOpen = strlen($text)-1;
            }
            $pos = min(Array($pEsc, $pOpen));
            $prefix = substr($text, 0, $pos);
            $result .= $prefix;
            $text = substr($text, strlen($prefix));

            if ( $pos === $pEsc ) {
                //found escape character
                if ( strlen($text) > 1 ) {
                    //take the next character
                    $result .= substr($text, 1, 1);
                    $text = substr($text, 2);
                } else {
                    //the escape character is the last character of the string
                    //--> take it
                    $result .= "\\";
                    $text = substr($text, 1);
                }
            } else {
                $pClose = strpos($text, "}");
                if ( $pClose === false ) {
                    //no close tag character
                    //-->take one char and continue to process
                    $result .= substr($text, 0, 1);
                    $text = substr($text, 1);
                } else {
                    $tag = substr($text, 0, $pClose+1);
                    if ( strpos($tag, "\n") !==false ) {
                        //invalid tag --> ignore
                        $result .= substr($text, 0, 1);
                        $text = substr($text, 1);
                    } else {
                        $text = substr($text, strlen($tag));
                        $tag = substr($tag, 1, strlen($tag)-2);
                        $nText = trim($tag);
                        if ( isset($substitutes[$nText]) ) {
                            $result .= $substitutes[$nText];
                        } else {
                            $result .= '{'.$tag.'}';
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Creates a MessageFormat with the given pattern and uses it to format
     * the given substitutes.
     *
     * This static method is shortcut of:
     * <code>
     * (new Ddth_Commons_MessageFormat($pattern)).format($substitutes)
     * </code>
     *
     * @param string
     * @param Array()
     * @return string
     */
    public static function formatString($pattern, $substitutes=Array()) {
        $mf = new Ddth_Commons_MessageFormat($pattern);
        return $mf->format($substitutes);
    }
}
?>

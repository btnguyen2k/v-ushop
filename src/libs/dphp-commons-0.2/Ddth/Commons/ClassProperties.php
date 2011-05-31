<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a set of properties as pair of {key => value}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassProperties.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * This class represents a set of properties as pairs of (key => value).
 *
 * The property list can be exported as a string, imported from a string, saved
 * to a file or loaded from a file. Keys and values are treated as strings.
 *
 * Encoding: Properties class uses UTF-8 as the default character encoding.
 *
 * Supported property file format: the loading, storing, exporting and importing
 * methods support the following property file/string formats.
 *
 * <b>Java-like properties files:</b>
 * - Lines begin with ; or # are comments
 * - Each key/value pair is stored in one or more lines with the following
 * format: propertyKey=propertyValue
 * - Property value can span multiple lines, joining by character \
 *
 * Example:
 * <pre>
 * ;this is a comment
 * #this is also a comment
 * key1=value1
 * key2 = value2
 * key3  =     multiple-line value \
 * line 2 \
 * ; line 3 \
 * # line 4
 * </pre>
 *
 * @package    	Commons
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @since      	Class available since v0.1
 */
class Ddth_Commons_Properties {
    /**
     * Set of properties (key => value). Key is a string, value is an array of
     * 2 elements, the first one is the property value (string),
     * the second (optional) is the property comment (string.
     */
    private $properties = Array();

    private static $STATE_START = 0;
    private static $STATE_IN_COMMENT = 1;
    private static $STATE_IN_PROPERTY_VALUE = 2;
    private static $COMMENT_START = Array('#', ';');
    private static $MULTILINE_FLAG = '\\';

    /**
     * Constructs a new Ddth_Commons_Properties object.
     */
    public function __construct() {
    }

    /**
     * Empties the property list.
     */
    public function clear() {
        $this->properties = Array();
    }

    /**
     * Counts number of properties in the list.
     *
     * @return int
     */
    public function count() {
        return count($this->properties);
    }

    /**
     * Gets all property key in the list.
     *
     * @return Array()
     */
    public function keys() {
        return array_keys($this->properties);
    }

    /**
     * Exports property list to a string.
     *
     * @return string
     */
    public function export() {
        $result = "";
        foreach ($this->properties as $key => $node) {
            $comment = count($node) > 1 ? $node[1] : NULL;
            if ($comment !== NULL) {
                $lines = explode("\n", $comment);
                if ($lines !== false) {
                    foreach ($lines as $line) {
                        $result .= self::$COMMENT_START[0];
                        $result .= $line;
                        $result .= "\n";
                    }
                }
            }
            $value = $node[0];
            $result .= $key;
            $result .= "=";
            $lines = explode("\n", $value);
            if ($lines !== false) {
                for ($i = 0, $n = count($lines); $i < $n; $i++) {
                    if ($i > 0) {
                        $result .= "\t";
                    }
                    $result .= $lines[$i];
                    if ($i !== $n - 1) {
                        $result .= " \\";
                    }
                    $result .= "\n";
                }
            }
            $result .= "\n";
        }
        return $result;
    }

    /**
     * Imports property list from a string input (Java-like properties format).
     *
     * @param string property list in Java-like properties format
     * @throws {@link Ddth_Commons_Exceptions_IllegalArgumentException IllegalArgumentException}
     * @throws {@link Ddth_Commons_Exceptions_IllegalStateException IllegalStateException}
     */
    public function import($input) {
        if ($input === NULL) {
            $msg = "Null input!";
            throw new Ddth_Commons_Exceptions_IllegalArgumentException($msg);
        }
        $input = str_replace("\n\r", "\n", $input);
        $input = str_replace("\r", "\n", $input);
        $lines = preg_split("/\\n/", $input);
        $this->parse($lines);
    }

    /**
     * Loads property list from a file (Java-like properties format).
     *
     * @param string name of the property list file
     * @throws {@link Ddth_Commons_Exceptions_IllegalArgumentException IllegalArgumentException}
     * @throws {@link Ddth_Commons_Exceptions_IllegalStateException IllegalStateException}
     * @throws {@link Ddth_Commons_Exceptions_IOException IOException}
     */
    public function load($fileName) {
        $content = @file_get_contents($fileName);
        if ($content !== false) {
            $this->import($content);
        } else {
            $msg = 'Error reading file "' . $fileName . '"';
            throw new Ddth_Commons_Exceptions_IOException($msg);
        }
    }

    /**
     * Stores property list to a file.
     *
     * @param string name of the file
     * @throws {@link Ddth_Commons_Exceptions_IOException IOException}
     */
    public function store($fileName) {
        $content = $this->export();
        $fh = @fopen($fileName, "wb");
        if ($fh === false) {
            $msg = 'Can not open file "' . $fileName . '" for writing';
            throw new Ddth_Commons_Exceptions_IOException($msg);
        }
        if (@fwrite($fh, $content) === false) {
            $msg = 'Error while writing to file "' . $fileName . '"';
            throw new Ddth_Commons_Exceptions_IOException($msg);
        }
        if (@fclose($fh) === false) {
            $msg = 'Error while writing to file "' . $fileName . '"';
            throw new Ddth_Commons_Exceptions_IOException($msg);
        }
    }

    /**
     * Parses input and populates properties.
     *
     * @param Array() input as array of strings
     * @throws {@link Ddth_Commons_Exceptions_IllegalArgumentException IllegalArgumentException}
     * @throws {@link Ddth_Commons_Exceptions_IllegalStateException IllegalStateException}
     */
    private function parse($lines = Array()) {
        if (!is_array($lines)) {
            $msg = "Invalid input";
            throw new Ddth_Commons_Exceptions_IllegalArgumentException($msg);
        }
        $state = self::$STATE_START;
        $comment = NULL;
        $value = NULL;
        $key = NULL;
        foreach ($lines as $line) {
            switch ($state) {
                case self::$STATE_START:
                    $this->parseStateStart($state, $line, $key, $value, $comment);
                    break;
                case self::$STATE_IN_COMMENT:
                    $this->parseStateInComment($state, $line, $key, $value, $comment);
                    break;
                case self::$STATE_IN_PROPERTY_VALUE:
                    $this->parseStateInPropertyValue($state, $line, $key, $value, $comment);
                    break;
                default:
                    throw new Ddth_Commons_Exceptions_IllegalStateException();
                    break;
            }
        }
        if ($key !== (NULL) && $value !== NULL) {
            $this->setProperty($key, $value, $comment);
        }
    }

    private function parseReset(&$state, &$key, &$value, &$comment) {
        $comment = NULL;
        $value = NULL;
        $key = NULL;
        $state = self::$STATE_START;
    }

    private function parseComment(&$state, &$comment, $input) {
        if ($comment !== NULL) {
            $comment .= "\n" . $input;
        } else {
            $comment = $input;
        }
        $state = self::$STATE_IN_COMMENT;
    }

    private function parseValue(&$state, &$key, &$value, &$comment, $input) {
        $tokens = preg_split('/\s*=\s*/', $input, 2);
        if (count($tokens) !== 2) {
            $msg = 'Invalid input near "' . substr($input, 0, 20) . '"';
            throw new Ddth_Commons_Exceptions_IllegalArgumentException($msg);
        }
        $key = trim($tokens[0]);
        $value = trim($tokens[1]);
        if ($key === "") {
            $msg = 'Empty property key at "' . substr($input, 0, 20) . '"';
            throw new Ddth_Commons_Exceptions_IllegalArgumentException($msg);
        }
        if ($value !== "" && $value[strlen($value) - 1] === self::$MULTILINE_FLAG) {
            $value = trim(substr($value, 0, strlen($value) - 1)); //ignore the last char
            $state = self::$STATE_IN_PROPERTY_VALUE;
        } else {
            $this->setProperty($key, $value, $comment);
            //reset
            $this->parseReset($state, $key, $value, $comment);
        }
    }

    private function parseStateStart(&$state, $line, &$key, &$value, &$comment) {
        $line = trim($line);
        if ($line === "") {
            //reset
            $this->parseReset($state, $key, $value, $comment);
        } elseif (in_array($line[0], self::$COMMENT_START)) {
            //comment
            $this->parseComment($state, $comment, substr($line, 1));
        } else {
            //should be propertyKey=propertyValue line by now
            $this->parseValue($state, $key, $value, $comment, $line);
        }
    }

    private function parseStateInComment(&$state, $line, &$key, &$value, &$comment) {
        $line = trim($line);
        if ($line === "") {
            //reset
            $this->parseReset($state, $key, $value, $comment);
        } elseif (in_array($line[0], self::$COMMENT_START)) {
            //comment
            $this->parseComment($state, $comment, substr($line, 1));
        } else {
            //should be propertyKey=propertyValue line by now
            $this->parseValue($state, $key, $value, $comment, $line);
        }
    }

    private function parseStateInPropertyValue(&$state, $line, &$key, &$value, &$comment) {
        $line = trim($line);
        if ($line === "") {
            $this->setProperty($key, $value, $comment);
            //reset
            $this->parseReset($state, $key, $value, $comment);
        } elseif (in_array($line[0], self::$COMMENT_START)) {
            $this->setProperty($key, $value, $comment);
            //reset
            $this->parseReset($state, $key, $value, $comment);
            //comment
            $this->parseComment($state, $comment, substr($line, 1));
        } else {
            if ($line[strlen($line) - 1] === self::$MULTILINE_FLAG) {
                //property value continues
                $value .= "\n" . substr($line, 0, strlen($line) - 1); //ignore the last char
                $value = trim($value);
                $state = self::$STATE_IN_PROPERTY_VALUE;
            } else {
                //last line of property value
                $value .= "\n" . $line;
                $this->setProperty($key, $value, $comment);
                $this->parseReset($state, $key, $value, $comment);
            }
        }
    }

    /**
     * Gets a property comment.
     *
     * @param string the property key
     * @return string the property comment if found, NULL otherwise
     */
    public function getComment($key) {
        if (isset($this->properties[$key])) {
            $value = $this->properties[$key];
            if (is_array($value) && count($value) > 1) {
                return $value[1];
            } else {
                return NULL;
            }
        }
        return NULL;
    }

    /**
     * Gets a property value.
     *
     * @param string the property key
     * @param string a default value
     * @return string the property value if found, the default value otherwise
     */
    public function getProperty($key, $defaultValue = NULL) {
        if (isset($this->properties[$key])) {
            $value = $this->properties[$key];
            if (is_array($value) && count($value) > 0) {
                return $value[0];
            } else {
                return $defaultValue;
            }
        }
        return $defaultValue;
    }

    /**
     * Sets a property value.
     *
     * @param string the property key
     * @param string the property value
     * @param string the property comment
     * @return string the previous value of the property specified by property key, or
     * NULL if there is no such value
     */
    public function setProperty($key, $value, $comment = NULL) {
        $result = $this->getProperty($key);
        $this->properties[$key] = Array($value, $comment);
        return $result;
    }

    /**
     * Gets all properties as an associative array.
     *
     * @return Array
     * @since function available since v0.2
     */
    public function toArray() {
        $result = Array();
        foreach ($this->properties as $key => $value) {
            if (is_array($value)) {
                if (count($value) > 0) {
                    $result[$key] = $value[0];
                } else {
                    $result[$key] = '';
                }
            } elseif (is_scalar($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
?>

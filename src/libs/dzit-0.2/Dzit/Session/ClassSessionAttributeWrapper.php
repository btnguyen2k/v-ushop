<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Wrapper of a http session attribute.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  Session
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSessionAttributeWrapper.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * This class wraps a http session attribute inside and also provides extra functionality
 * such as maximum idle time.
 *
 * @package     Dzit
 * @subpackage  Session
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_Session_SessionAttributeWrapper {

    private $name;
    private $value;
    private $maxIdleTime=0;
    private $lastaccessTimestamp;

    /**
     * Constructs a new Dzit_Session_SessionAttributeWrapper object.
     *
     * @param string $name name of the wrapped session attribute
     * @param mixed $value value of the wrapped session attribute
     * @param int $maxIdleTime (optional) max idle time (in seconds) of the session attribute
     */
    public function __construct($name, $value, $maxIdleTime=0) {
        $this->name = $name;
        $this->value = $value;
        $this->maxIdleTime = $maxIdleTime+0;
        $this->lastaccessTimestamp = time();
    }

    /**
     * Gets name of the wrapped session attribute.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets name of the wrapped session attribute.
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets value of the wrapped session attribute.
     *
     * @return mixed
     */
    public function getValue() {
        if ( !$this->isExpired() ) {
            $this->lastaccessTimestamp = time();
            return $this->value;
        }
        return NULL;
    }

    /**
     * Sets value of the wrapped session attribute.
     *
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * Gets the last access timestamp.
     *
     * @return int
     */
    public function getLastAccessTimestamp() {
        return $this->lastaccessTimestamp;
    }

    /**
     * Gets maximum idle time for the wrapped session attribute.
     *
     * @return int maximum idle time (in seconds) for the wrapped session attribute
     */
    public function getMaxIdleTime() {
        return $this->maxIdleTime;
    }

    /**
     * Sets maximum idle time for the wrapped session attribute
     *
     * @param int $maxIdleTime maximum idle time (in seconds) for the wrapped session attribute
     */
    public function setMaxIdleTime($maxIdleTime) {
        $this->maxIdleTime = $maxIdleTime+0;
    }

    /**
     * Tests the session attribute is expired.
     *
     * @return bool
     */
    public function isExpired() {
        return time() > $this->lastaccessTimestamp + $this->maxIdleTime;
    }
}
?>

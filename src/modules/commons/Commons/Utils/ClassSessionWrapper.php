<?php
class Commons_Utils_SessionWrapper {

    private $value;
    private $expiry;

    public function __construct($value, $expiry = 0) {
        $this->setValue($value);
        $this->setExpiry($expiry);
    }

    /**
     * Getter for $value.
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Getter for $expiry.
     *
     * @return int
     */
    public function getExpiry() {
        return $this->expiry;
    }

    /**
     * Setter for $value.
     *
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * Setter for $expiry.
     *
     * @param int $expiry
     */
    public function setExpiry($expiry) {
        $this->expiry = $expiry <= 0 ? time() + 30 * 60 : $expiry;
    }

    /**
     * Tests if the entry is expired.
     *
     * @return boolean
     */
    public function isExpired() {
        return $this->expiry < time();
    }
}
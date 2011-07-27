<?php
class Commons_Utils_SessionUtils {
    /**
     * Gets a session entry.
     *
     * @param string $key
     * @param mixed
     */
    public static function getSessionEntry($key) {
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
        if ($value instanceof Commons_Utils_SessionWrapper) {
            $value = $value->isExpired() ? NULL : $value->getValue();
        }
        return $value;
    }

    /**
     * Deletes a session entry.
     *
     * @param string $key
     */
    public static function deleteSessionEntry($key) {
        unset($_SESSION[$key]);
    }
}
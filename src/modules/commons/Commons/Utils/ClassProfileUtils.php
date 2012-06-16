<?php
class Commons_Utils_ProfileLog {

    const KEY_CHILDREN = 'CHILDREN';
    const KEY_PARENT = 'PARENT';
    const KEY_NAME = 'NAME';
    const KEY_TIMESTAMP_START = 'TIMESTAMP_START';
    const KEY_TIMESTAMP_END = 'TIMESTAMP_END';
    const KEY_DURATION = 'DURATION';

    private static $root = Array();
    private static $current = NULL;
    private static $logEntry = NULL;
    private static $profiling = Array();

    /**
     * "Pushes" a profiling data to the stack.
     *
     * @param string $name
     */
    public static function push($name) {
        $entry = self::createEntry($name, self::$current);
        if (self::$current !== NULL) {
            self::$current[self::KEY_CHILDREN][] = &$entry;
        } else {
            self::$profiling[] = &$entry;
        }
        self::$current = &$entry;
    }

    /**
     * "Pops" the last profiling data from the stack
     */
    public static function pop() {
        if (self::$current === NULL) {
            throw new Exception('Illegal state!');
        }
        self::$current[self::KEY_TIMESTAMP_END] = microtime();
        self::$current = &self::$current[self::KEY_PARENT];
    }

    private static function createEntry($name, &$parent) {
        $entry = Array(self::KEY_CHILDREN => Array(),
                self::KEY_NAME => $name,
                self::KEY_PARENT => $parent,
                self::KEY_TIMESTAMP_START => microtime());
        return $entry;
    }

    /**
     * Gets tge profile log entry.
     *
     * @return Array
     */
    public static function get() {
        $result = self::$profiling;
        foreach ($result as &$item) {
            self::prepareProfileResult($item);
        }
        return $result;
    }

    private static function prepareProfileResult(&$result) {
        unset($result[self::KEY_PARENT]);
        $timeStart = $result[self::KEY_TIMESTAMP_START];
        if (!isset($result[self::KEY_TIMESTAMP_END])) {
            $result[self::KEY_TIMESTAMP_END] = microtime();
        }
        $timeEnd = $result[self::KEY_TIMESTAMP_END];

        list($usecStart, $secStart) = explode(" ", $timeStart);
        list($usecEnd, $secEnd) = explode(" ", $timeEnd);

        $duration = ($secEnd - $secStart) + ($usecEnd - $usecEnd);
        $result[self::KEY_DURATION] = round($duration, 3);

        foreach ($result[self::KEY_CHILDREN] as &$child) {
            self::prepareProfileResult($child);
        }
    }
}

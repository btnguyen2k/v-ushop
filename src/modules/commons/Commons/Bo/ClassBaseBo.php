<?php
/**
 * Base Business Object.
 *
 * @author btnguyen2k@gmail.com
 */
class Commons_Bo_BaseBo {

    const TYPE_STRING = 1;
    const TYPE_INT = 2;
    const TYPE_FLOAT = 3;
    const TYPE_DOUBLE = 3;
    const TYPE_REAL = 3;
    const TYPE_BOOL = 4;
    const TYPE_BOOLEAN = 4;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Gets the map {db_column:class_member_name}.
     *
     * Sub-class overrides this function to returns its own mapping.
     *
     * @return Array
     */
    protected function getFieldMap() {
        return Array();
    }

    /**
     * Populates the BO.
     *
     * This function expects the parameter to be an associative array. It obtains the mapping
     * by calling {@link Commons_Bo_BaseBo::getFieldMap()} and uses setters to populate the BO.
     *
     * @param mixed $dataRow
     */
    public function populate($dataRow) {
        if ($dataRow === NULL || !is_array($dataRow)) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Invalid argument!";
            $this->LOGGER->warn($msg);
            return;
        }
        $fieldMap = $this->getFieldMap();
        foreach ($dataRow as $key => $value) {
            $fieldInfo = isset($fieldMap[$key]) ? $fieldMap[$key] : NULL;
            if ($fieldInfo == NULL || !is_array($fieldInfo)) {
                $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Can not map db column [$key] to class member variable!";
                $this->LOGGER->warn($msg);
                continue;
            }
            $memberName = $fieldInfo[0];
            if ($this->LOGGER->isDebugEnabled()) {
                $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Db column [$key] is mapped to class member variable [$memberName]";
                $this->LOGGER->debug($msg);
            }
            $methodName = 'set' . ucfirst($memberName);
            if (!method_exists($this, $methodName)) {
                $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Setter [$methodName] does not exist in class [" . __CLASS__ . "!";
                $this->LOGGER->warn($msg);
                continue;
            }
            $type = count($fieldInfo) > 1 ? $fieldInfo[1] : 0;
            if ($type != 0 && $value !== NULL) {
                switch ($type) {
                    case self::TYPE_BOOL:
                    case self::TYPE_BOOLEAN:
                        $value = (bool)$value;
                        break;
                    case self::TYPE_DOUBLE:
                    case self::TYPE_FLOAT:
                    case self::TYPE_REAL:
                        $value = (double)$value;
                        break;
                    case self::TYPE_INT:
                        $value = (int)$value;
                        break;
                    default:
                        $value = (string)$value;
                        break;
                }
            }
            $this->$methodName($value);
        }
    }
}

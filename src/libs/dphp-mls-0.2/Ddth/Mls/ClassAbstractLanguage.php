<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract implementation of {@link Ddth_Mls_ILanguage}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractLanguage.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Abstract implementation of {@link Ddth_Mls_ILanguage}.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
abstract class Ddth_Mls_AbstractLanguage implements Ddth_Mls_ILanguage {
    /**
     * @var Array
     */
    private $config = Array();

    /**
     * @var string
     */
    private $languageName = NULL;

    /**
     * @var string
     */
    private $locale = NULL;

    /**
     * @var string
     */
    private $displayName = NULL;

    /**
     * @var string
     */
    private $description = NULL;

    /**
     * @var Array
     */
    private $languageData = NULL;

    /**
     * Constructs a new Ddth_Mls_AbstractLanguage object.
     */
    public function __construct() {
    }

    /**
     * Gets the configuration array.
     *
     * @return Array
     */
    protected function getConfig() {
        return $this->config;
    }

    /**
     * @see Ddth_Mls_ILanguage::getMessage()
     */
    public function getMessage($key, $replacements = NULL) {
        $msg = isset($this->languageData[$key]) ? $this->languageData[$key] : NULL;
        if ($replacements === NULL) {
            return $msg;
        }
        if (!is_array($replacements)) {
            $replacements = Array();
            for ($i = 1, $n = func_num_args(); $i < $n; $i++) {
                $t = func_get_arg($i);
                if ($t !== NULL) {
                    $replacements[] = $t;
                }
            }
        }
        return $msg !== NULL ? Ddth_Commons_MessageFormat::formatString($msg, $replacements) : NULL;
    }

    /**
     * @see Ddth_Mls_ILanguage::getDescription()
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the language pack's description.
     *
     * @param string $description
     */
    protected function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @see Ddth_Mls_ILanguage::getDisplayName()
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Sets the language pack's display name.
     *
     * @param string $displayName
     */
    protected function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * @see Ddth_Mls_ILanguage::getLocale()
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Sets the language pack's locale.
     *
     * @param string $locale
     */
    protected function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * @see Ddth_Mls_ILanguage::getName()
     */
    public function getName() {
        return $this->languageName;
    }

    /**
     * Sets the language pack's name.
     *
     * @param string $name
     */
    protected function setName($name) {
        $this->languageName = $name;
    }

    /**
     * @see Ddth_Mls_ILanguage::init()
     */
    public function init($langName, $config) {
        $this->setName($langName);
        $this->config = $config;
        $this->setDisplayName(isset($config[self::CONF_DISPLAY_NAME]) ? $config[self::CONF_DISPLAY_NAME] : NULL);
        $this->setDescription(isset($config[self::CONF_DESCRIPTION]) ? $config[self::CONF_DESCRIPTION] : NULL);
        $this->setLocale(isset($config[self::CONF_LOCALE]) ? $config[self::CONF_LOCALE] : NULL);
        $this->buildLanguageData();
    }

    /**
     * Loads and builds language data. Called by
     * {@link Ddth_Mls_AbstractLanguage::init()} method.
     *
     * @throws Ddth_Mls_MlsException
     */
    protected abstract function buildLanguageData();

    /**
     * Sets language data.
     *
     * @param Array $languageData
     */
    protected function setLanguageData($languageData) {
        if ($languageData === NULL || !is_array($languageData)) {
            $this->languageData = Array();
        } else {
            $this->languageData = $languageData;
        }
    }

    /**
     * Gets language data.
     *
     * @return Array
     */
    protected function getLanguageData() {
        return $this->languageData;
    }
}
?>

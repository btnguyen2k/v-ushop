<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An implementation of {@link Ddth_Mls_ILanguageFactory}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBaseLanguageFactory.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * An implementation of {@link Ddth_Mls_ILanguageFactory}. This can be used as the base class
 * to develop custom language factory class.
 *
 * This class provides a {@link getInstance() static function} to get instance of
 * {@link Ddth_Mls_ILanguageFactory}. The static function takes an array as parameter.
 * See {@link getInstance()} for details of the configuration array.
 *
 * Usage:
 * <code>
 * $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
 * $lang = $mlsFactory->getLanguage($langName);
 * echo $lang->getMessage('home');
 * echo $lang->getMessage('login');
 * //...
 * </code>
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Mls_BaseLanguageFactory implements Ddth_Mls_ILanguageFactory {

    private static $cacheInstances = Array();

    const DEFAULT_FACTORY_CLASS = 'Ddth_Mls_BaseLanguageFactory';

    const CONF_PREFIX = 'language.';

    const CONF_LANGUAGES = 'languages';
    const CONF_FACTORY_CLASS = 'factory.class';
    const CONF_LANGUAGE_CLASS = 'language.class';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * @var Array
     */
    private $config = Array();

    /**
     * List of declared language names (index array).
     *
     * @var Array
     */
    private $languageNames = NULL;

    /**
     * Registered language packs (associative array {languageName => languageObject}).
     *
     * @var Array
     */
    private $languagePacks = NULL;

    /**
     * Static function to get instances of {@link Ddth_Mls_ILanguageFactory}.
     *
     * This function accepts an associative array as parameter. If the argument is NULL,
     * the global variable $DPHP_MLS_CONFIG is used instead (if there is no global variable
     * $DPHP_MLS_CONFIG, the function falls back to use the global variable $DPHP_MLS_CONF).
     *
     * Detailed specs of the configuration array:
     * <code>
     * Array(
     * # Class name of the concrete factory.
     * # Default value is Ddth_Mls_BaseLanguageFactory.
     * 'factory.class' => 'Ddth_Mls_BaseLanguageFactory',
     *
     * # Names of registered language packs, separated by (,) or (;) or spaces.
     * # Language name should contain only lower-cased letters (a-z), digits (0-9)
     * # and underscores (_) only!
     * 'languages' => 'default, en, vn',
     *
     * # Class name of the concrete language pack, it *must* implement interface
     * # Ddth_Mls_ILanguage.
     * 'language.class' => 'Ddth_Mls_FileLanguage',
     *
     * # Configuration settings for each language pack. Each configuration
     * # setting follows the format:
     * 'language.<name>.<key>' => <value>,
     * # Note: <name> is the language name
     * # Note: all those configuration settings will be passed to the language
     * # pack Ddth_Mls_ILanguage::init() function. Before being passed to
     * # the function, the "language.<name>." will be removed from the key.
     * # Which means, the passed array will contain elements such as {'<key>' => <value>}
     *
     * # Three special language settings that would be widely used:
     * # - Display name of the language pack:
     * 'language.en.displayName' => 'English',
     * # - Locale associated with the language pack:
     * 'language.en.locale' => 'en_GB',
     * # - Description of the language pack:
     * 'language.en.description' => 'English (GB) language pack'
     * )
     * </code>
     *
     * @param Array $config the configuration array
     * @return Ddth_Mls_ILanguageFactory
     * @throws {@link Ddth_Mls_MlsException}
     */
    public static function getInstance($config = NULL) {
        if ($config === NULL) {
            global $DPHP_MLS_CONFIG;
            $config = isset($DPHP_MLS_CONFIG) ? $DPHP_MLS_CONFIG : NULL;
        }
        if ($config === NULL) {
            global $DPHP_MLS_CONF;
            $config = isset($DPHP_MLS_CONF) ? $DPHP_MLS_CONF : NULL;
        }
        if ($config === NULL) {
            global $DPHP_MLS_CFG;
            $config = isset($DPHP_MLS_CFG) ? $DPHP_MLS_CFG : NULL;
        }
        if ($config === NULL) {
            return NULL;
        }
        $hash = md5(serialize($config));
        if (!isset(self::$cacheInstances[$hash])) {
            $factoryClass = isset($config[self::CONF_FACTORY_CLASS]) ? $config[self::CONF_FACTORY_CLASS] : NULL;
            if ($factoryClass === NULL || trim($factoryClass) === "") {
                $factoryClass = self::DEFAULT_FACTORY_CLASS;
            } else {
                $factoryClass = trim($factoryClass);
            }
            try {
                $instance = new $factoryClass();
                if ($instance instanceof Ddth_Mls_ILanguageFactory) {
                    $instance->init($config);
                } else {
                    $msg = "[$factoryClass] does not implement Ddth_Mls_ILanguageFactory";
                    throw new Ddth_Mls_MlsException($msg);
                }
            } catch (Ddth_Mls_MlsException $me) {
                throw $me;
            } catch (Exception $e) {
                $msg = $e->getMessage();
                throw new Ddth_Mls_MlsException($msg);
            }
            self::$cacheInstances[$hash] = $instance;
        }
        return self::$cacheInstances[$hash];
    }

    /**
     * Constructs a new Ddth_Mls_AbstractLanguageFactory object.
     */
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * @see Ddth_Mls_ILanguageFactory::init()
     */
    public function init($config) {
        $this->config = $config;
        $this->registerLanguages();
    }

    /**
     * Registers declared language packs.
     */
    protected function registerLanguages() {
        $this->languagePacks = Array();
        $languageNames = $this->getLanguageNames();
        foreach ($languageNames as $langName) {
            $language = $this->createLanguagePack($langName);
            if ($language !== NULL) {
                $this->languagePacks[$langName] = $language;
            }
        }
    }

    /**
     * Creates a language pack object.

     * @param string $langName name of the language pack to create
     * @return Ddth_Mls_ILanguage
     */
    protected function createLanguagePack($langName) {
        $languageClass = $this->getLanguageClassName();
        if ($languageClass === NULL) {
            $msg = 'No language class specified!';
            $this->LOGGER->error($msg);
            return NULL;
        }
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = "Language class [$languageClass].";
            $this->LOGGER->debug($msg);
            $msg = "Loading language pack [$langName]...";
            $this->LOGGER->debug($msg);
        }
        $languagePack = new $languageClass();
        if (!($languagePack instanceof Ddth_Mls_ILanguage)) {
            $msg = "[$languageClass] is not an instance of Ddth_Mls_ILanguage!";
            throw new Ddth_Mls_MlsException($msg);
        }
        $languagePack->init($langName, $this->getLanguageConfig($langName));
        return $languagePack;
    }

    /**
     * Gets name of the language pack class.
     *
     * This function uses the configuration {@link CONF_LANGUAGE_CLASS} as
     * the name of the language pack class. Sub-class may override this function to
     * provide its own behavior.
     *
     * @return string
     */
    protected function getLanguageClassName() {
        return isset($this->config[self::CONF_LANGUAGE_CLASS]) ? $this->config[self::CONF_LANGUAGE_CLASS] : NULL;
    }

    /**
     * Builds/Extracts the language settings from the factory settings. See {@link getInstance()}
     * for more information.
     *
     * @param string $langName
     * @return Array
     */
    protected function getLanguageConfig($langName) {
        $languageNames = $this->getLanguageNames();
        $languageConfig = Array();
        $prefix = self::CONF_PREFIX . $langName . '.';
        $len = strlen($prefix);
        foreach ($this->config as $key => $value) {
            if ($prefix === substr($key, 0, $len)) {
                $key = substr($key, $len);
                if ($key !== '') {
                    $languageConfig[$key] = $value;
                }
            } else {
                $languageConfig[$key] = $value;
            }
        }
        return $languageConfig;
    }

    /**
     * @see Ddth_Mls_ILanguageFactory::getLanguage()
     */
    public function getLanguage($name) {
        if ($this->languagePacks === NULL) {
            $this->registerLanguages();
        }
        if (isset($this->languagePacks[$name])) {
            return $this->languagePacks[$name];
        } else {
            $msg = "Language pack [$name] does not exist!";
            $this->LOGGER->warn($msg);
            return NULL;
        }
    }

    /**
     * @see Ddth_Mls_ILanguageFactory::getLanguageNames()
     */
    public function getLanguageNames() {
        if ($this->languageNames === NULL) {
            $this->languageNames = Array();
            $languagePacks = isset($this->config[self::CONF_LANGUAGES]) ? $this->config[self::CONF_LANGUAGES] : '';
            $languagePacks = trim(preg_replace('/[\s,;]+/', ' ', $languagePacks));
            $tokens = preg_split('/[\s,;]+/', trim($languagePacks));
            if (count($tokens) === 0) {
                $msg = 'No language pack defined!';
                $this->LOGGER->error($msg);
            } else {
                foreach ($tokens as $langName) {
                    if ($langName === "") {
                        continue;
                    }
                    $this->languageNames[] = $langName;
                }
            }
        }
        return $this->languageNames;
    }

    /**
     * Gets the configuration array.
     *
     * @return Array
     */
    protected function getConfig() {
        return $this->config;
    }
}
?>

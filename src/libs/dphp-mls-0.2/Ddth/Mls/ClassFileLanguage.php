<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * File-based language pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassFileLanguage.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * File-based language pack.
 *
 * This language pack loads language data from files on disk. It needs 2
 * {@link Ddth_Mls_BaseLanguageFactory::getInstance() configuration settings}:
 * <ul>
 * <li><b>language.baseDirectory</b>: base directory where language packs are located</li>
 * <li><b>location</b>: location (relative to base.directory) of this language pack</li>
 * </ul>
 * Language data is loaded from all {@link Ddth_Commons_Properties .properties files} within
 * directory <i><language.baseDirectory>/<location></i>.
 *
 * @package     Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
class Ddth_Mls_FileLanguage extends Ddth_Mls_AbstractLanguage {

    const CONF_LOCATION = "location";
    const CONF_BASE_DIRECTORY = "language.baseDirectory";

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Ddth_Mls_FileLanguage object.
     */
    public function __construct() {
        parent::__construct();
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * This function loads language data from all {@link Ddth_Commons_Properties .properties files}
     * within the directory <i><baseDirectory>/<location></i>.
     *
     * @see Ddth_Mls_AbstractLanguage::buildLanguageData()
     * @see Ddth_Commons_Properties
     */
    protected function buildLanguageData() {
        $config = $this->getConfig();
        $baseDirectory = isset($config[self::CONF_BASE_DIRECTORY]) ? $config[self::CONF_BASE_DIRECTORY] : '';
        $langDir = new Ddth_Commons_File($baseDirectory);
        $location = isset($config[self::CONF_LOCATION]) ? $config[self::CONF_LOCATION] : '';
        $langDir = new Ddth_Commons_File($location, $baseDirectory);
        if (!$langDir->isDirectory()) {
            $msg = "[{$langDir->getPathname()}] is not a directory!";
            throw new Ddth_Mls_MlsException($msg);
        }
        $languageData = new Ddth_Commons_Properties();
        $dh = @opendir($langDir->getPathname());
        if ($dh) {
            $file = @readdir($dh);
            while ($file) {
                $langFile = new Ddth_Commons_File($file, $langDir);
                if ($langFile->isFile() && $langFile->isReadable() && preg_match('/^.+\.properties$/i', $file)) {
                    try {
                        $msg = "Load language file [{$langFile->getPathname()}]...";
                        $this->LOGGER->info($msg);
                        $languageData->load($langFile->getPathname());
                    } catch (Exception $e) {
                        $msg = $e->getMessage();
                        $this->LOGGER->warn($msg, $e);
                    }
                }
                $file = @readdir($dh);
            }
            @closedir($dh);
        } else {
            $msg = "[{$langDir->getPathname()}] is not accessible!";
            throw new Ddth_Mls_MlsException($msg);
        }
        $this->setLanguageData($languageData->toArray());
    }
}
?>
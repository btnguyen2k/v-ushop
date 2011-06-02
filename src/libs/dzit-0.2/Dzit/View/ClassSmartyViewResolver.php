<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Smarty-based single-template view resolver.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSmartyViewResolver.php 73 2011-06-02 07:52:49Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Smarty-based single-template view resolver.
 *
 * This class resolves view name to a {@link Dzit_View_SmartyView}. Use this view resolver
 * if the application uses just a single Smarty-based template.
 * This resolver is constructed with following arguments:
 * <ul>
 * <li>'templateDir': root directory where template files are located.
 * <li>'smartyCacheDir': directory where Smarty's cache files are stored; can be absolute, or relative to 'templateDir'.
 * <li>'smartyCompileDir': directory where Smarty's compiled files are stored; can be absolute, or relative to 'templateDir'.
 * <li>'smartyConfigDir':  directory where Smarty's configuration files are stored; can be absolute, or relative to 'templateDir'.
 * <li>'smartyLeftDelimiter': Smarty's left delimiter string (optional)
 * <li>'smartyRightDelimiter': Smarty's right delimiter string (optional)
 * <li>'prefix': a prefix string to form the resolved template file.
 * <li>'suffix': a suffix string to form the resolved template file.
 * </ul>
 * This resover receives a view name (e.g. 'main'), add a prefix (configurable,
 * e.g. 'page_') and a suffix ('.tpl') to form the full filename (e.g. 'page_main.tpl').
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Dzit_View_SmartyViewResolver implements Dzit_IViewResolver {

    private $templateDir = '';
    private $smartyCacheDir = '', $smartyCompileDir = '', $smartyConfigDir = '';
    private $smartyLeftDelimiter = '', $smartyRightDelimiter = '';
    private $prefix = '', $suffix = '';
    private $smarty = NULL;

    /**
     * Constructs a new Dzit_View_SmartyViewResolver object.
     */
    public function __construct($params = Array()) {
        $this->setPrefix(isset($params['prefix']) ? $params['prefix'] : '');
        $this->setSuffix(isset($params['suffix']) ? $params['suffix'] : '');
        $this->setSmartyCacheDir(isset($params['smartyCacheDir']) ? $params['smartyCacheDir'] : '');
        $this->setSmartyCompileDir(isset($params['smartyCompileDir']) ? $params['smartyCompileDir'] : '');
        $this->setSmartyConfigDir(isset($params['smartyConfigDir']) ? $params['smartyConfigDir'] : '');
        $this->setTemplateDir(isset($params['templateDir']) ? $params['templateDir'] : '');
        $this->setSmartyLeftDelimiter(isset($params['smartyLeftDelimiter']) ? $params['smartyLeftDelimiter'] : '');
        $this->setSmartyRightDelimiter(isset($params['smartyRightDelimiter']) ? $params['smartyRightDelimiter'] : '');
    }

    /**
     * Gets the prefix string.
     *
     * @return string.
     */
    public function getPrefix() {
        return $this->prefix;
    }

    /**
     * Sets the prefix string.
     *
     * @param string $prefix
     */
    public function setPrefix($prefix) {
        if (trim($prefix) === '' || $prefix === NULL) {
            $this->prefix = '';
        } else {
            $this->prefix = trim($prefix);
        }
    }

    /**
     * Gets the suffix string.
     *
     * @return string.
     */
    public function getSuffix() {
        return $this->suffix;
    }

    /**
     * Sets the suffix string.
     *
     * @param string $suffix
     */
    public function setSuffix($suffix) {
        if (trim($suffix) === '' || $suffix === NULL) {
            $this->suffix = '';
        } else {
            $this->suffix = trim($suffix);
        }
    }

    /**
     * Gets the Smarty template directory.
     *
     * @return string.
     */
    public function getTemplateDir() {
        return $this->templateDir;
    }

    /**
     * Sets the Smarty template directory.
     *
     * @param string $templateDir
     */
    public function setTemplateDir($templateDir) {
        if (trim($templateDir) === '' || $templateDir === NULL) {
            $this->templateDir = '';
        } else {
            $this->templateDir = trim($templateDir);
        }
    }

    /**
     * Gets the Smarty config directory.
     *
     * @return string.
     */
    public function getSmartyConfigDir() {
        return $this->smartyConfigDir;
    }

    /**
     * Sets the Smarty config directory.
     *
     * @param string $smartyConfigDir
     */
    public function setSmartyConfigDir($smartyConfigDir) {
        if (trim($smartyConfigDir) === '' || $smartyConfigDir === NULL) {
            $this->smartyConfigDir = '';
        } else {
            $this->smartyConfigDir = trim($smartyConfigDir);
        }
    }

    /**
     * Gets the Smarty cache directory.
     *
     * @return string.
     */
    public function getSmartyCacheDir() {
        return $this->smartyCacheDir;
    }

    /**
     * Sets the Smarty cache directory.
     *
     * @param string $smartyCacheDir
     */
    public function setSmartyCacheDir($smartyCacheDir) {
        if (trim($smartyCacheDir) === '' || $smartyCacheDir === NULL) {
            $this->smartyCacheDir = '';
        } else {
            $this->smartyCacheDir = trim($smartyCacheDir);
        }
    }

    /**
     * Gets the Smarty compile directory.
     *
     * @return string.
     */
    public function getSmartyCompileDir() {
        return $this->smartyCompileDir;
    }

    /**
     * Sets the Smarty compile directory.
     *
     * @param string $smartyCompileDir
     */
    public function setSmartyCompileDir($smartyCompileDir) {
        if (trim($smartyCompileDir) === '' || $smartyCompileDir === NULL) {
            $this->smartyCompileDir = '';
        } else {
            $this->smartyCompileDir = trim($smartyCompileDir);
        }
    }

    /**
     * Gets Smarty's left delimiter.
     *
     * @return string.
     */
    public function getSmartyLeftDelimiter() {
        return $this->smartyLeftDelimiter;
    }

    /**
     * Sets Smarty's left delimiter.
     *
     * @param string $smartyLeftDelimiter
     */
    public function setSmartyLeftDelimiter($smartyLeftDelimiter) {
        if (trim($smartyLeftDelimiter) === '' || $smartyLeftDelimiter === NULL) {
            $this->smartyLeftDelimiter = '';
        } else {
            $this->smartyLeftDelimiter = trim($smartyLeftDelimiter);
        }
    }

    /**
     * Gets Smarty's right delimiter.
     *
     * @return string.
     */
    public function getSmartyRightDelimiter() {
        return $this->smartyRightDelimiter;
    }

    /**
     * Sets Smarty's right delimiter.
     *
     * @param string $smartyRightDelimiter
     */
    public function setSmartyRightDelimiter($smartyRightDelimiter) {
        if (trim($smartyRightDelimiter) === '' || $smartyRightDelimiter === NULL) {
            $this->smartyRightDelimiter = '';
        } else {
            $this->smartyRightDelimiter = trim($smartyRightDelimiter);
        }
    }

    /**
     * Gets the Smarty instance.
     *
     * @return Smarty
     */
    protected function getSmarty() {
        if ($this->smarty === NULL) {
            $smarty = new Smarty();

            //Smarty's template directory
            $templateDir = $this->getTemplateDir();
            $smarty->template_dir = $templateDir;

            //Smarty's cache directory
            $cacheDir = new Ddth_commons_File($this->getSmartyCacheDir(), $templateDir);
            $smarty->cache_dir = $cacheDir->getPathname();

            //Smarty's compile directory
            $compileDir = new Ddth_commons_File($this->getSmartyCompileDir(), $templateDir);
            $smarty->compile_dir = $cacheDir->getPathname();

            //Smarty's configuration directory
            $configDir = new Ddth_commons_File($this->getSmartyConfigDir(), $templateDir);
            $smarty->config_dir = $cacheDir->getPathname();

            if ($this->smartyLeftDelimiter !== NULL && $this->smartyLeftDelimiter !== '') {
                $smarty->left_delimiter = $this->smartyLeftDelimiter;
            }
            if ($this->smartyRightDelimiter !== NULL && $this->smartyRightDelimiter !== '') {
                $smarty->right_delimiter = $this->smartyRightDelimiter;
            }

            $this->smarty = $smarty;
        }
        return $this->smarty;
    }

    /**
     * This function resolves a view name to an instance of {@link Dzit_View_SmartyView}.
     *
     * @see Dzit_IViewResolver::resolveViewName()
     */
    public function resolveViewName($viewName) {
        //a quick check to make sure we the view name is not malform!
        if (preg_match('/^[a-z0-9_\\.\\-]+$/i', $viewName)) {
            $filename = $this->prefix . $viewName . '.tpl';
            return new Dzit_View_SmartyView($this->getSmarty(), $filename);
        }
        return NULL;
    }
}
?>

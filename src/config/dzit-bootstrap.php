<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/*
 * From http://www.daniweb.com/web-development/php/code/216305
 */
class Dzit_SessionHandler {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * @var boolean
     */
    private $alive = TRUE;

    /**
     * @var Vcatalog_Bo_Session_ISessionDao
     */
    private $dao = NULL;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        session_set_save_handler(array(&$this, 'open'), array(&$this, 'close'), array(&$this,
                'read'), array(&$this, 'write'), array(&$this, 'destroy'), array(&$this, 'gc'));
    }

    public function __destruct() {
        if ($this->alive) {
            session_write_close();
            $this->alive = FALSE;
        }
    }

    /*
     * Open function, this works like a constructor in classes and is executed
     * when the session is being opened. The open function expects two parameters,
     * where the first is the save path and the second is the session name.
     */
    public function open($savePath, $sesionName) {
        $daoFactory = Ddth_Dao_BaseDaoFactory::getInstance();
        $this->dao = $daoFactory->getDao(DAO_SESSION);
        if ($this->dao === NULL) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Can not obtain Vcatalog_Bo_Session_ISessionDao instance!";
            $e = new Exception($msg);
            $this->LOGGER->fatal("Can not obtain Vcatalog_Bo_Session_ISessionDao instance!", $e);
            throw $e;
        }
        return TRUE;
    }

    /*
     * Close function, this works like a destructor in classes and
     * is executed when the session operation is done.
     */
    public function close() {
        return $this->dao = NULL;
    }

    /*
     * Read function must return string value always to make save handler work as
     * expected. Return empty string if there is no data to read. Return values from
     * other handlers are converted to boolean expression. TRUE for success, FALSE for failure.
     */
    public function read($sid) {
        try {
            $sessionData = $this->dao->readSessionData($sid);
            return $sessionData !== NULL ? $sessionData : '';
        } catch (Exception $e) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]{$e->getMessage()}";
            $this->LOGGER->fatal($msg, $e);
            throw $e;
        }
    }

    /*
     * Write function that is called when session data is to be saved. This function expects
     * two parameters: an identifier and the data associated with it.
     */
    public function write($sid, $data) {
        try {
            $this->dao->writeSessionData($sid, $data);
            return TRUE;
        } catch (Exception $e) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]{$e->getMessage()}";
            $this->LOGGER->fatal($msg, $e);
            throw $e;
        }
    }

    /*
     * The destroy handler, this is executed when a session is destroyed with session_destroy()
     * and takes the session id as its only parameter.
     */
    public function destroy($sid) {
        try {
            $this->dao->deleteSessionData($sid);
            return TRUE;
        } catch (Exception $e) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]{$e->getMessage()}";
            $this->LOGGER->fatal($msg, $e);
            throw $e;
        }
    }

    /*
     * The garbage collector, this is executed when the session garbage collector is executed
     * and takes the max session lifetime as its only parameter.
     */
    public function gc($expiry) {
        try {
            $this->dao->deleteExpiredSessions($expiry);
            return TRUE;
        } catch (Exception $e) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]{$e->getMessage()}";
            $this->LOGGER->fatal($msg, $e);
            throw $e;
        }
    }
}
$sessionHandler = new Dzit_SessionHandler();
session_cache_limiter('no-cache');
session_start();

if ( !(ini_get('output_handler') || ini_get('zlib.output_compression')) ) {
    ob_start("ob_gzhandler");
}

/**
 * Dzit's core bootstrap file.
 * What this bootstrap does?
 * - Load each application module's bootstrap file.
 */

if (defined('MODULES_DIR')) {
    /* load module bootstraps */
    $_BOOTSTRAPS = Array();
    if (!defined("MODULE_BOOTSTRAP_FILE")) {
        define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
    }
    if (($dh = @opendir(MODULES_DIR)) !== FALSE) {
        while (($file = readdir($dh)) !== FALSE) {
            if (is_dir(MODULES_DIR . "/$file") && $file != "." && $file != "..") {
                $bootstrap = MODULES_DIR . "/$file/" . MODULE_BOOTSTRAP_FILE;
                if (file_exists($bootstrap)) {
                    $_BOOTSTRAPS[] = $bootstrap;
                }
            }
        }
    }
    //bootstrap files are included in order!
    sort($_BOOTSTRAPS);
    foreach ($_BOOTSTRAPS as $bootstrap) {
        include_once $bootstrap;
    }
}

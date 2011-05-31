<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract implementation of {@link Dzit_IView}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractView.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Abstract implementation of {@link Dzit_IView}.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
abstract class Dzit_View_AbstractView implements Dzit_IView {

    /**
     * Default content type.
     *
     * @var string
     */
    const DEFAULT_CONTENT_TYPE = 'text/html; charset=UTF-8';

    private $contentType = self::DEFAULT_CONTENT_TYPE;

    /**
     * Returns content type of this view.
     *
     * @return string
     */
    public function getContentType() {
        return $this->contentType;
    }

    /**
     * Sets content type for this view.
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }
}
?>

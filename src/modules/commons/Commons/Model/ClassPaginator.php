<?php
/**
 * Paginator model object.
 *
 * @author btnguyen2k@gmail.com
 */
class Commons_Model_Paginator {

    private $numEntries = 0;
    private $pageSize = 1;
    private $currentPage = 1;
    private $urlTemplate;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Construts a new {@link Commons_Model_Paginator} object.
     *
     * @param string $urlTemplate
     * @param int $numEntries
     * @param int $pageSize
     * @param int $currentPage
     */
    public function __construct($urlTemplate, $numEntries, $pageSize, $currentPage = 1) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->urlTemplate = $urlTemplate;
        $this->numEntries = $numEntries;
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
    }

    /**
     * Gets the current page number.
     *
     * @return int
     */
    public function getCurrentPage() {
        return $this->currentPage;
    }

    /**
     * Sets the current page number.
     *
     * @param int $currentPage
     */
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }

    /**
     * Gets number of pages.
     *
     * @return int
     */
    public function getNumPages() {
        $numPages = $this->numEntries / $this->pageSize;
        return $numPages * $this->pageSize == $this->numEntries ? $numPages : $numPages + 1;
    }

    /**
     * Sets number of entries.
     *
     * @param int $numEntries
     */
    public function setNumEntries($numEntries) {
        $this->numEntries = $numEntries;
    }

    /**
     * Sets number of entries per page.
     *
     * @param int $pageSize
     */
    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    /**
     * Sets the url template.
     *
     * @param string $urlTemplate
     */
    public function setUrlTemplate($urlTemplate) {
        $this->urlTemplate = $urlTemplate;
    }

    /**
     * Gets the url for a page.
     *
     * @param int $pageNum
     * @return string
     */
    public function getUrlForPage($pageNum) {
        $url = $this->urlTemplate;
        $searchTerms = Array('/\$\{PAGE_NUMBER\}/i',
                '/\$\{PAGE_NUM\}/i',
                '/\$\{pageNumber\}/i',
                '/\$\{pageNum\}/i',
                '/\$\{page\}/i');
        $url = $this->templateReplace($url, $searchTerms, $pageNum);
        return $url;
    }

    private function templateReplace($subject, $searchTerms = Array(), $replacement = '') {
        foreach ($searchTerms as $term) {
            $subject = preg_replace($term, $replacement, $subject);
        }
        return $subject;
    }
}

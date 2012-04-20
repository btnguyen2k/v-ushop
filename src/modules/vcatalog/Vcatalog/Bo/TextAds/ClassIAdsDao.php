<?php
interface Vcatalog_Bo_TextAds_IAdsDao extends Ddth_Dao_IDao {

    const PARAM_START_OFFSET = 'startOffset';
    const PARAM_PAGE_SIZE = 'pageSize';

    /**
     * Counts number of current ads.
     *
     * @return int
     */
    public function countNumAds();

    /**
     * Creates a new text ads.
     *
     * @param Vcatalog_Bo_TextAds_BoAds $ads
     */
    public function createAds($ads);

    /**
     * Deletes an ads.
     *
     * @param Vcatalog_Bo_TextAds_BoAds $ads
     */
    public function deleteAds($ads);

    /**
     * Gets an ads by id.
     *
     * @param int $id
     * @return Vcatalog_Bo_TextAds_BoAds
     */
    public function getAdsById($id);

    /**
     * Gets ads as a list.
     *
     * @return Array
     */
    public function getAds($pageNum = 1, $pageSize = PHP_INT_MAX);

    /**
     * Updates an ads.
     *
     * @param Vcatalog_Bo_TextAds_BoAds $ads
     */
    public function updateAds($ads);

    /**
     * Increases ads' click count by 1.
     *
     * @param Vcatalog_Bo_TextAds_BoAds $ads
     */
    public function incClicksCount($ads);
}

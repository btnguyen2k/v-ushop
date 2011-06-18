<?php
interface Paperclip_Bo_IPaperclipDao extends Ddth_Dao_IDao {

    /**
     * Creates a new attachment.
     *
     * @param string $pathToFileContent path to the file on disk to load
     * @param string $filename name of the to store in db
     * @param string $mimeType
     * @return Paperclip_Bo_BoPaperclip
     */
    public function createAttachment($pathToFileContent, $filename, $mimeType);

    /**
     * Deletes an attachment.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     */
    public function deleteAttachment($attachment);

    /**
     * Gets an attachment by id.
     *
     * @param string $id
     * @return Paperclip_Bo_BoPaperclip
     */
    public function getAttachment($id);

    /**
     * Update an attachment.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     */
    public function updateAttachment($attachment);
}

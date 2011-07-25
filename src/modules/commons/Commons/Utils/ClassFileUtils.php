<?php
class Commons_Utils_FileUtils {

    /**
     * Checks if a filename is in allowed list of file extensions.
     *
     * @param string $filename
     * @param string $allowedFileExtensions
     */
    public static function isValidFileExtension($filename, $allowedFileExtensions) {
        $pathinfo = pathinfo(strtolower($filename));
        if (!isset($pathinfo['extension'])) {
            $pathinfo['extension'] = '';
        }
        $allowedFileExtensions = preg_split('/[,:;]+/', strtolower($allowedFileExtensions));
        foreach ($allowedFileExtensions as $ext) {
            $index = strrpos($ext, '.');
            if ($index >= 0) {
                $ext = substr($ext, $index + 1);
            }
            if ($ext === $pathinfo['extension']) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Reads file content and returns it as binary string.
     *
     * @param string $filepath
     * @return string
     */
    public static function getFileContent($filepath) {
        $filesize = filesize($filepath);
        $fp = fopen($filepath, 'rb');
        $filecontent = fread($fp, $filesize);
        fclose($fp);
        return $filecontent;
    }
}

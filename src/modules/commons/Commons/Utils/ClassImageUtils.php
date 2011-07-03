<?php
class Commons_Utils_ImageUtils {

    /**
     * Creates an in-memory image source from an image file. This image source
     * can be used latter for function such as imageCopyResized().
     *
     * @param string $imagePath path to the image file
     * @return Array NULL if the image source can not be created, or an array where
     * [0] is the image width,
     * [1] is the image height,
     * [2] is a binary string containing content of the image source;
     */
    private static function createImageSource($imagePath) {
        $imageInfo = @getImageSize($imagePath);
        if ($imageInfo === FALSE) {
            return NULL;
        }
        $imageSrc = @imageCreateFromString(file_get_contents($imagePath));
        if ($imageSrc === FALSE) {
            return NULL;
        }
        return Array($imageInfo[0], $imageInfo[1], $imageSrc);
    }

    /**
     * Creates Jpeg thumbnail from an image file.
     *
     * @param string $orgImgPath fullpath to the original image file
     * @param int $thumbnailWidth
     * @param int $thumbnailHeight
     * @return string binary string containing the thumbnail content, NULL if the thumbnail can not be created
     */
    public static function createThumbnailJpeg($orgImgPath, $thumbnailWidth, $thumbnailHeight) {
        if ($thumbnailHeight < 1 || $thumbnailWidth < 1) {
            return NULL;
        }
        $imageSource = self::createImageSource($orgImgPath);
        if ($imageSource == NULL) {
            return NULL;
        }
        $orgWidth = $imageSource[0];
        $orgHeight = $imageSource[1];
        $imageThumbnail = imageCreateTrueColor($thumbnailWidth, $thumbnailHeight);
        imageCopyResized($imageThumbnail, $imageSource[2], 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $orgWidth, $orgHeight);

        /* imageJpeg() does not directly write the image content to a variable.
         * Hence we need to use output buffering to capture the image content.
         */
        ob_start();
        imageJpeg($imageThumbnail, NULL, 100);
        $thumbnailContent = ob_get_clean();
        imageDestroy($imageSource[2]);
        imageDestroy($imageThumbnail);
        return $thumbnailContent;
    }
}

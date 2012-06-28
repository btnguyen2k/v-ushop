<?php
class Vushop_Utils {
    /**
     * Formats a price value for displaying purpose.
     *
     * @param double $price
     */
    public static function formatPrice($price) {
        $configDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CONFIG);
        $currency = $configDao->loadConfig(CONFIG_CURRENCY)->getValue();
        $priceDecimalPlaces = $configDao->loadConfig(CONFIG_PRICE_DECIMAL_PLACES)->getValue();
        $decimalSeparator = $configDao->loadConfig(CONFIG_DECIMAL_SEPARATOR)->getValue();
        $thousandsSeparator = $configDao->loadConfig(CONFIG_THOUSANDS_SEPARATOR)->getValue();
        return number_format($price, $priceDecimalPlaces, $decimalSeparator, $thousandsSeparator) . $currency;
    }

    /**
     * Formats a quantity value for displaying purpose.
     *
     * @param double $quantity
     */
    public static function formatQuantity($quantity) {
        $configDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CONFIG);
        $quantityDecimalPlaces = $configDao->loadConfig(CONFIG_QUANTITY_DECIMAL_PLACES)->getValue();
        $decimalSeparator = $configDao->loadConfig(CONFIG_DECIMAL_SEPARATOR)->getValue();
        $thousandsSeparator = $configDao->loadConfig(CONFIG_THOUSANDS_SEPARATOR)->getValue();
        return number_format($quantity, $quantityDecimalPlaces, $decimalSeparator, $thousandsSeparator);
    }
}

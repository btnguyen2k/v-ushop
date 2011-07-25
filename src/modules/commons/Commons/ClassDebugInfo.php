<?php
class Commons_DebugInfo {
    public function getMemoryUsage() {
        return memory_get_usage();
    }

    public function getMemoryUsageKb() {
        return memory_get_usage() / 1024;
    }

    public function getMemoryUsageMb() {
        return memory_get_usage() / 1024 / 1024;
    }

    public function getMemoryPeakUsage() {
        return memory_get_peak_usage();
    }

    public function getMemoryPeakUsageKb() {
        return memory_get_peak_usage() / 1024;
    }

    public function getMemoryPeakUsageMb() {
        return memory_get_peak_usage() / 1024 / 1024;
    }

    public function getMemoryLimit() {
        return ini_get('memory_limit');
    }

    public function getSqlLog() {
        $sqlLog = Ddth_Dao_BaseDaoFactory::getQueryLog();
        for ($i = 0; $i < count($sqlLog); $i++) {
            $sql = $sqlLog[$i][0];
            if (strlen($sql) > 200) {
                $sqlLog[$i][0] = substr($sql, 0, 197) . '...';
            }
        }
        return $sqlLog;
    }
}

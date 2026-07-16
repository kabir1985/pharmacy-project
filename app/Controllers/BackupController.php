<?php

namespace App\Controllers;

class BackupController extends BaseController
{
    public function databaseBackup()
    {
        $db = \Config\Database::connect();

        $hostname = $db->hostname;
        $username = $db->username;
        $password = $db->password;
        $database = $db->database;

        $filename = $database . '_' . date('Y-m-d_H-i-s') . '.sql';

        $backupPath = WRITEPATH . 'backups/';

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $filepath = $backupPath . $filename;

        $command = "mysqldump --host={$hostname} --user={$username} --password={$password} {$database} > \"{$filepath}\"";

        exec($command, $output, $result);

        if ($result == 0 && file_exists($filepath)) {

            return $this->response->download($filepath, null)
                ->setFileName($filename);

        } else {

            return "Database Backup Failed.";

        }
    }
}
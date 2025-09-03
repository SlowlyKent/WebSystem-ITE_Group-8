<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMedicinesAddBatchSku extends Migration
{
    public function up()
    {
        // Add columns if they do not exist
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('medicines');

        if (!in_array('sku', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `sku` VARCHAR(100) NULL AFTER `category`");
        }
        if (!in_array('batch_no', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `batch_no` VARCHAR(100) NULL AFTER `sku`");
        }
        if (!in_array('quantity', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `quantity` INT(11) NOT NULL DEFAULT 0 AFTER `batch_no`");
        }
        if (!in_array('reorder_level', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `reorder_level` INT(11) NOT NULL DEFAULT 0 AFTER `quantity`");
        }
        if (!in_array('expiry_date', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `expiry_date` DATE NULL AFTER `reorder_level`");
        }
        if (!in_array('unit', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `unit` VARCHAR(50) NULL AFTER `expiry_date`");
        }
        if (!in_array('price', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `unit`");
        }
    }

    public function down()
    {
        // No down migration to avoid dropping live data
    }
}

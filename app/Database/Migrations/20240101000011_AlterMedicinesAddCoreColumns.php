<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMedicinesAddCoreColumns extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('medicines');

        if (!in_array('name', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `name` VARCHAR(150) NOT NULL AFTER `id`");
        }
        if (!in_array('generic_name', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `generic_name` VARCHAR(150) NULL AFTER `name`");
        }
        if (!in_array('category', $fields)) {
            $db->query("ALTER TABLE `medicines` ADD `category` VARCHAR(100) NULL AFTER `generic_name`");
        }
    }

    public function down()
    {
        // No down migration
    }
}

<?php

namespace VendorName\Skeleton\migrations;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;
use craft\helpers\Json;
use craft\db\Query;
use craft\queue\Queue;

use yii\db\Exception;

class Install extends Migration
{

    public function safeUp(): bool
    {
        $this->createTables();
        $this->seedTables();

        return true;
    }

    public function safeDown(): bool
    {
        $this->removeTables();
        return true;
    }

}

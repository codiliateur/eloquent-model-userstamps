<?php 

namespace Codiliateur\Userstamps\Tests;

use Codiliateur\Userstamps\Tests\Models\User;
use Codiliateur\Userstamps\Tests\Models\TestTable3;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Schema\Blueprint;

class ModelCustomUserstampNamesTest extends AbstractTest
{

    /**
     * @return void
     */
    public function test_create_test_table_1()
    {
        $this->createTestTable1();

        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_1'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'created_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'updated_by'));
        $this->assertFalse(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'deleted_by'));
    }

    /**
     * @return void
     */
    public function test_create_test_table_2()
    {
        $this->createTestTable2();

        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_2'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'created_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'updated_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'deleted_by'));
    }

    /**
     * @return void
     */
    public function test_create_test_table_3()
    {
        $this->createTestTable3();
        
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_3'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'created_by_user_id'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'updated_by_user_id'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'deleted_by_user_id'));
    }

}
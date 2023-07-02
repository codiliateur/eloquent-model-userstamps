<?php 

namespace Codiliateur\Userstamps\Tests;

use Codiliateur\Userstamps\Tests\Models\User;
use Codiliateur\Userstamps\Tests\Models\TestTable1;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Schema\Blueprint;

class ModelWithoutSoftDeletingTest extends AbstractTest
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function createContextTables(\Illuminate\Foundation\Application $app)
    {
        $this->createTestTable1();
    }

    /**
     * Test of creating table with default named userstamps without soft deleting
     *
     * @return void
     */
    public function test_table_without_soft_deletes()
    {
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_1'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'created_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'updated_by'));
        $this->assertFalse(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_1', 'deleted_by'));

        // Initializing model
        $model = new TestTable1();

        $this->assertNull($model->created_by);
        $this->assertNull($model->updated_by);

        // Creating by user 1
        $this->setAuthUser(self::USER1_ID);
        $model->title = 'test 1';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER1_ID);

        // Updating by user 2
        $this->setAuthUser(self::USER2_ID);
        $model->title = 'test 2';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER2_ID);

        // Model deleted
        $modelId = $model->id;
        $model->delete();

        $this->assertNull(TestTable1::find($modelId));

    }

}
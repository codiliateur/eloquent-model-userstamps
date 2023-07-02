<?php 

namespace Codiliateur\Userstamps\Tests;

use Codiliateur\Userstamps\Tests\Models\User;
use Codiliateur\Userstamps\Tests\Models\TestTable2;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Schema\Blueprint;

class ModelWithSoftDeletingTest extends AbstractTest
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function createContextTables(\Illuminate\Foundation\Application $app)
    {
        $this->createTestTable2();
    }

    /**
     * Test of creating table with default named userstamps without soft deleting
     *
     * @return void
     */
    public function test_table_with_soft_deletes()
    {
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_2'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'created_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'updated_by'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_2', 'deleted_by'));

        // Initializing model
        $model = new TestTable2();

        $this->assertNull($model->created_by);
        $this->assertNull($model->updated_by);
        $this->assertNull($model->deleted_by);

        // Creating by user 1
        $this->setAuthUser(self::USER1_ID);
        $model->title = 'test 1';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER1_ID);
        $this->assertNull($model->deleted_by);

        // Updating by user 2
        $this->setAuthUser(self::USER2_ID);
        $model->title = 'test 2';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER2_ID);
        $this->assertNull($model->deleted_by);

        // Deleting by user 2
        $modelId = $model->id;
        $model->delete();
        $model = TestTable2::withTrashed()->find($modelId);

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER2_ID);
        $this->assertTrue($model->deleted_by == self::USER2_ID);

        // Restoring by user 1
        $this->setAuthUser(self::USER1_ID);
        $model->restore();
        $model->refresh();

        $this->assertTrue($model->created_by == self::USER1_ID);
        $this->assertTrue($model->updated_by == self::USER1_ID);
        $this->assertNull($model->deleted_by);
    }

}
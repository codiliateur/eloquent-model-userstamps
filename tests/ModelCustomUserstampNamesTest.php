<?php 

namespace Codiliateur\Userstamps\Tests;

use Codiliateur\Userstamps\Tests\Models\User;
use Codiliateur\Userstamps\Tests\Models\TestTable3;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Schema\Blueprint;

class ModelCustomUserstampNamesTest extends AbstractTest
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function createContextTables(\Illuminate\Foundation\Application $app)
    {
        $this->createTestTable3();
    }

    /**
     * Test of creating table with default named userstamps without soft deleting
     *
     * @return void
     */
    public function test_table_with_custom_userstamp_names_deletes()
    {
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasTable('test_table_3'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'created_by_user_id'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'updated_by_user_id'));
        $this->assertTrue(\DB::connection()->getSchemaBuilder()->hasColumn('test_table_3', 'deleted_by_user_id'));

        // Initializing model
        $model = new TestTable3();

        $this->assertNull($model->created_by_user_id);
        $this->assertNull($model->updated_by_user_id);
        $this->assertNull($model->deleted_by_user_id);

        // Creating by user 1
        $this->setAuthUser(self::USER1_ID);
        $model->title = 'test 1';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by_user_id == self::USER1_ID);
        $this->assertTrue($model->updated_by_user_id == self::USER1_ID);
        $this->assertNull($model->deleted_by_user_id);

        // Updating by user 2
        $this->setAuthUser(self::USER2_ID);

        $model->title = 'test 2';
        $model->save();
        $model->refresh();

        $this->assertTrue($model->created_by_user_id == self::USER1_ID);
        $this->assertTrue($model->updated_by_user_id == self::USER2_ID);
        $this->assertNull($model->deleted_by_user_id);

        // Deleting by user 2
        $modelId = $model->id;
        $model->delete();
        $model = TestTable3::withTrashed()->find($modelId);

        $this->assertTrue($model->created_by_user_id == self::USER1_ID);
        $this->assertTrue($model->updated_by_user_id == self::USER2_ID);
        $this->assertTrue($model->deleted_by_user_id == self::USER2_ID);

        // Restoring by user 1
        $this->setAuthUser(self::USER1_ID);
        $model->restore();
        $model->refresh();

        $this->assertTrue($model->created_by_user_id == self::USER1_ID);
        $this->assertTrue($model->updated_by_user_id == self::USER1_ID);
        $this->assertNull($model->deleted_by_user_id);
    }

}
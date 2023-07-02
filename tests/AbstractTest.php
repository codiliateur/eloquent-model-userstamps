<?php 

namespace Codiliateur\Userstamps\Tests;

use Codiliateur\Userstamps\Tests\Models\User;
use Codiliateur\Userstamps\UserstampsServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase;

abstract class AbstractTest extends TestCase
{
    const USER1_ID = 1;
    const USER2_ID = 2;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app->make('config'), function (Repository $config) {
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);

            // Setup queue database connections.
            $config->set([
                'queue.batching.database' => 'testbench',
                'queue.failed.database' => 'testbench',
            ]);

        });
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // Code before application created.

        parent::setUp();

        // Code after application created.

        $this->setUpDatabase($this->app);
        $this->setUpSeeder();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            UserstampsServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function setUpDatabase(\Illuminate\Foundation\Application $app)
    {
        $this->createUsersTable($app);
        $this->createContextTables($app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function createContextTables(\Illuminate\Foundation\Application $app)
    {
        //
    }

    /**
     * @return void
     */
    protected function setUpSeeder()
    {
        $user = new User();
        $user->id = self::USER1_ID;
        $user->name = 'test1';
        $user->email = 'test1@test.test';
        $user->password = 'test';
        $user->save();

        $user = new User();
        $user->id = self::USER2_ID;
        $user->name = 'test2';
        $user->email = 'test2@test.test';
        $user->password = 'test';
        $user->save();
    }

    protected function createUsersTable(\Illuminate\Foundation\Application $app)
    {
        \DB::connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Creating table with default named userstamps without soft deleting
     *
     * @return void
     */
    protected function createTestTable1()
    {
        \DB::connection()->getSchemaBuilder()->create('test_table_1', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->userstamps();
        });
    }

    /**
     * Creating table with default named userstamps with soft deleting
     *
     * @return void
     */
    protected function createTestTable2()
    {
        \DB::connection()->getSchemaBuilder()->create('test_table_2', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps(true);
        });
    }

    /**
     * Creating table with default named userstamps with soft deleting
     *
     * @return void
     */
    protected function createTestTable3()
    {
        \DB::connection()->getSchemaBuilder()->create('test_table_3', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps(true, null, [
                'created_by_user_id',
                'updated_by_user_id',
                'deleted_by_user_id'
            ]);
        });
    }

    protected function setAuthUser(int $userId)
    {
        \Auth::setUser(User::find($userId));
    }
}
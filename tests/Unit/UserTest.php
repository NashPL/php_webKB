<?php
namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{

    private $newUser;
    private $oldUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->newUser = [];
        $this->newUser['email'] = 'newtest@test.com';
        $this->newUser['password'] = '123';
        $this->newUser['country'] = 'UK';

        DB::table('users')->insert(
            ['_email' => 'test@test.php', '_password' => password_hash('123', PASSWORD_BCRYPT),
                '_country' => 'UK', '_validated' => true]
        );
    }

    public function tearDown(): void
    {
        // parent::tearDown();
        DB::table('users')->truncate();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInitalizeClass()
    {
        $user = new User($this->newUser['email'], $this->newUser);
        $id = $user->getId();
        $this->assertTrue(is_object($user));
        $this->assertTrue(!is_null($user));
        $this->assertTrue(!is_null($id));
        $this->assertTrue(is_integer($id));
    }

    public function testInitalizeClassWrongEmailString()
    {
        $this->expectException(\InvalidArgumentException::class);
        new User('this is a wrong email');
    }

    public function testInitalizeClassEmptyStringProvided()
    {
        $this->expectException(\InvalidArgumentException::class);
        new User('');
    }

    public function testInitalizeClassProvideNumberAsAEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        new User(12345);
    }

}

<?php

namespace Tests\Cases;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\QueryException;
use joshtronic\LoremIpsum;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;

class ModelsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        system('vendor/bin/phoenix --config=src/phoenix.php --environment=test init');
        system('vendor/bin/phoenix --config=src/phoenix.php --environment=test migrate');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        system('vendor/bin/phoenix --config=src/phoenix.php --environment=test cleanup');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function runApp(string $entity)
    {
        $settings = require __DIR__ . '/../../src/settings.php';
        $app = new App($settings);
        $dependencies = require __DIR__ . '/../../src/dependencies.php';
        $dependencies($app);
        $app->getContainer()->get('db_test')->table($entity);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testEmptyTableUsers(): void
    {
        $this->runApp('users');
        $user = User::all()->toArray();
        $this->assertEquals([], $user);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testEmptyTablePosts(): void
    {
        $this->runApp('posts');
        $post = Post::all()->toArray();
        $this->assertEquals([], $post);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInsertInvalidUser(): void
    {
        $this->runApp('users');
        $this->expectException(QueryException::class);
        User::create(['email' => 'leonardo.cruz@feedz.com.br']);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInsertValidUser(): void
    {
        $data = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $this->runApp('users');
        $created = User::create($data)->toArray();
        $this->assertArrayHasKey('id', $created);
        $this->assertEquals(1, $created['id']);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testNotEmptyTableUser()
    {
        $data = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $this->runApp('users');
        User::create($data)->toArray();
        $readed = User::all()->toArray();
        $this->assertTrue(count($readed) === 1);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInserAndUpdateTableUser()
    {
        $data = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $newEmail = 'leonardo.cruz+feedz@feedz.com.br';
        $this->runApp('users');
        User::create($data)->toArray();
        $readed = User::all()->toArray();
        $this->assertTrue(count($readed) === 1);
        $loaded = User::find(1);
        $loaded->setAttribute('email', $newEmail);
        $saved = $loaded->save();
        $this->assertTrue($saved);
        $reloaded = User::find(1)->toArray();
        $this->assertEquals($newEmail, $reloaded['email']);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRemoveUser()
    {
        $data = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $this->runApp('users');
        $created = User::create($data)->toArray();
        $this->assertArrayHasKey('id', $created);
        $this->assertEquals(1, $created['id']);
        $loaded = User::find(1);
        $this->assertTrue($loaded->delete());
        $this->assertEquals([], User::all()->toArray());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInsertInvalidBlogPost(): void
    {
        $this->runApp('posts');
        $this->expectException(QueryException::class);
        Post::create([]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInsertValidBlogPost()
    {
        $lipsum = new LoremIpsum();
        $user = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $post = [
            'user_id' => 1,
            'title' => $lipsum->words(5),
            'content' => $lipsum->paragraphs(3)
        ];
        $this->runApp('users');
        $createdUser = User::create($user)->toArray();
        $this->runApp('posts');
        $createdPost = Post::create($post)->toArray();
        $this->assertArrayHasKey('user_id', $createdPost);
        $this->assertEquals($createdUser['id'], $createdPost['user_id']);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testUpdateInvalidBlogPost(): void
    {
        $this->runApp('posts');
        $loaded = Post::find(2);
        $this->assertNull($loaded);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testUpdateValidBlogPost(): void
    {
        $lipsum = new LoremIpsum();
        $user = [
            'email' => 'leonardo.cruz@feedz.com.br',
            'password' => '123456'
        ];
        $post = [
            'user_id' => 1,
            'title' => $lipsum->words(5),
            'content' => $lipsum->paragraphs(3)
        ];
        $this->runApp('users');
        User::create($user);
        $this->runApp('posts');
        $createdPost = Post::create($post);
        $createdPost->setAttribute('title', 'Post title update');
        $this->assertTrue($createdPost->save());
        $loadedPost = Post::find(1)->toArray();
        $this->assertNotEquals($post['title'], $loadedPost['title']);
    }
}
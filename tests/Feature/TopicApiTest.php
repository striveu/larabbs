<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        $response = $this->JWTActingAs($this->user)
            ->json('POST', '/api/topics', $data);

        $assertData = [
            'category_id' => 1,
            'user_id' => $this->user->id,
            'title' => 'test title',
            'body' => clean('test body', 'user_topic_body'),
        ];

        $response->assertStatus(201)
            ->assertJsonFragment($assertData);
    }

    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/topics/'.$topic->id, $editData);

        $assertData = [
            'category_id' => 2,
            'user_id' => $this->user->id,
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
    }

    public function testShowTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/topics/'.$topic->id);

        $assertData = [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/topics/');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function testDeleteTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)
            ->json('DELETE', '/api/topics/'.$topic->id);
        $response->assertStatus(204);

        $response = $this->json('GET', '/api/topics/'.$topic->id);
        $response->assertStatus(404);
    }

    /**
     * A basic feature test example.
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

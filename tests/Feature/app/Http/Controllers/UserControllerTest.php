<?php

namespace Tests\Feature\app\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $userService;

    public function testValidationOfRepeteadEmailsOrDocumentIdInStoreMethod()
    {
        $this->userService = $this->app[UserService::class];

        $responseBody = [
            "name" => "Fake",
            "document_id" => "123456789",
            "email"       => "fake@gmail.com",
            "password"    => "123456789",
        ];

        // creating with the same informations to force the validation of no-repeated email and document_id
        $this->userService->create($responseBody);

        $response = $this->post('/api/users', $responseBody);

        $response->assertJson(['errors' => ['email already in use', 'document already in use']]);
        $response->assertStatus(400);
    }

    public function testCreateUser()
    {
        $responseBody = [
            "name" => "Gabriel",
            "document_id" => "48690318844",
            "email"       => "gbldelazerii@gmail.com",
            "password"    => "123456789",
        ];

        $response = $this->post('/api/users', $responseBody);
        $response->assertStatus(200);
    }

    public function testValidationOfRepeatedEmailsOrDocumentIdInUpdateMethod()
    {
        $this->userService = $this->app[UserService::class];

        $responseBody = [
            "name" => "Fake",
            "document_id" => "123456789",
            "email"       => "fake@gmail.com",
            "password"    => "123456789",
        ];

        // creating with the same informations to force the validation of no-repeated email and document_id in update
        $this->userService->create($responseBody);

        $response = $this->put('/api/users/1', $responseBody);
        $response->assertStatus(200);
    }

    public function testTryDeleteUserWithoutValidId()
    {
        $response = $this->delete('/api/users/1');
        $response->assertJson(['errors' => ['user not found']]);
        $response->assertStatus(400);
    }
}

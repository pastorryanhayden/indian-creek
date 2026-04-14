<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

function makeAdminUser(): User
{
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $user = User::factory()->create();
    $user->assignRole('admin');
    return $user;
}

it('admin can upload a pdf file', function () {
    Storage::fake('s3');
    $admin = makeAdminUser();

    $response = $this->actingAs($admin)->post('/admin/upload/file', [
        'file' => UploadedFile::fake()->create('handout.pdf', 100, 'application/pdf'),
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['url', 'name']);
    expect($response->json('name'))->toBe('handout.pdf');
    expect(Storage::disk('s3')->allFiles('editor-files'))->not->toBeEmpty();
});

it('upload rejects disallowed mime type', function () {
    Storage::fake('s3');
    $admin = makeAdminUser();

    $response = $this->actingAs($admin)
        ->withHeaders(['Accept' => 'application/json'])
        ->post('/admin/upload/file', [
            'file' => UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream'),
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('file');
});

it('upload rejects files over 10mb', function () {
    Storage::fake('s3');
    $admin = makeAdminUser();

    $response = $this->actingAs($admin)
        ->withHeaders(['Accept' => 'application/json'])
        ->post('/admin/upload/file', [
            'file' => UploadedFile::fake()->create('huge.pdf', 10241, 'application/pdf'),
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('file');
});

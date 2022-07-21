<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testGetAllStudents()
    {        
        $response = $this->post('api/login' , [
            'email' => 'cruickshank.aida@example.org',
            'password' => 'password',
            'device_name' => 'Galaxy',
        ]);
        $response = $this->get('api/student');
        $response->assertStatus(200);
    }

    public function testCreateNewStudent()
    {
        $response = $this->post('api/login' , [
            'email' => 'cruickshank.aida@example.org',
            'password' => 'password',
            'device_name' => 'Galaxy',
        ]);
        
        $response = $this->post('/student', [
            'name' => 'Test User',
            'school_id' => 3,
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(200);
    }
}

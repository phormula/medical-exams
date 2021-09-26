<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
// use App\Models\Structure;
use App\Models\Structure;
use Laravel\Sanctum\Sanctum;
use App\Models\StructureExam;
use Database\Seeders\ExamSeeder;
use Database\Seeders\GeolocateSeeder;
use Database\Seeders\StructureSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_structures_with_their_exams()
    {
        $response = $this->get('api/structures');

        $response->assertOk();
    }

    public function test_add_structures()
    {
        $user = User::factory()->create();
        $this->seed(GeolocateSeeder::class);
        $this->seed(ExamSeeder::class);

        Sanctum::actingAs($user, ['*']);
        $response = $this->post('api/structures',
                    [
                        'name' => 'SS4',
                        'city_id' => '8',
                        'phone' => '+1545125542',
                        'address' => 'via hksfks',
                        'premium' => 1
                    ]);

        $response->assertOk();
        $this->assertCount(1, Structure::all());
    }

    public function test_adds_exam_offered_by_structures()
    {
        $this->test_add_structures();

        $response = $this->post('api/structures-exam/1',
                    ['exam_id' => '4,5,6']);

        $response->assertOk();
        $this->assertCount(3, StructureExam::all());
    }

    public function test_removes_exam_offered_by_structures()
    {
        $this->test_adds_exam_offered_by_structures();
        
        $response = $this->delete('api/structures-exam/1',
                    ['exam_id' => '6']);

        $response->assertOk();
        $this->assertCount(2, StructureExam::all());

    }
}

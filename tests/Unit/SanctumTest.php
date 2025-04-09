<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
 
class SanctumTest extends TestCase {
    public function test_task_list_can_be_retrieved(): void
{
    Sanctum::actingAs(
        User::factory()->create(),
        ['view-tasks']
    );
 
    $response = $this->get('/api/task');
 
    $response->assertOk();
}
}
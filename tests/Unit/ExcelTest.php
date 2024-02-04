<?php

namespace Tests\Unit;

use Database\Factories\UserFactory;
use Tests\TestCase;

class ExcelTest extends TestCase
{
    public function test_index_rows()
    {
        $this->actingAs(UserFactory::new()->create())
            ->get(route('web.rows.index'))
            ->assertStatus(200)
            ->assertViewHas('items');
    }
}

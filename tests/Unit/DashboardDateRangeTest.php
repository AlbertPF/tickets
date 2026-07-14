<?php

namespace Tests\Unit;

use App\Support\DashboardDateRange;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DashboardDateRangeTest extends TestCase
{
    public function test_it_builds_an_inclusive_explicit_date_range(): void
    {
        $range = DashboardDateRange::fromRequest(Request::create('/', 'GET', [
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-04-30',
        ]));

        $this->assertSame('2025-01-01 00:00:00', $range->start->format('Y-m-d H:i:s'));
        $this->assertSame('2025-04-30 23:59:59', $range->end->format('Y-m-d H:i:s'));
        $this->assertSame(120, $range->inclusiveDays());
        $this->assertCount(120, $range->days());
    }

    public function test_it_defaults_to_the_current_month(): void
    {
        CarbonImmutable::setTestNow('2026-07-14 10:30:00');

        try {
            $range = DashboardDateRange::fromRequest(Request::create('/', 'GET'));

            $this->assertSame('2026-07-01 00:00:00', $range->start->format('Y-m-d H:i:s'));
            $this->assertSame('2026-07-14 23:59:59', $range->end->format('Y-m-d H:i:s'));
        } finally {
            CarbonImmutable::setTestNow();
        }
    }

    public function test_it_rejects_an_end_date_before_the_start_date(): void
    {
        $this->expectException(ValidationException::class);

        DashboardDateRange::fromRequest(Request::create('/', 'GET', [
            'fecha_inicio' => '2025-04-30',
            'fecha_fin' => '2025-01-01',
        ]));
    }
}

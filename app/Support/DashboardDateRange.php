<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;

final class DashboardDateRange
{
    public function __construct(
        public readonly CarbonImmutable $start,
        public readonly CarbonImmutable $end,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validate([
            'fecha_inicio' => ['nullable', 'required_with:fecha_fin', 'date_format:Y-m-d'],
            'fecha_fin' => ['nullable', 'required_with:fecha_inicio', 'date_format:Y-m-d', 'after_or_equal:fecha_inicio'],
        ], [
            'fecha_inicio.required_with' => 'Debe indicar la fecha de inicio.',
            'fecha_inicio.date_format' => 'La fecha de inicio debe tener el formato AAAA-MM-DD.',
            'fecha_fin.required_with' => 'Debe indicar la fecha de fin.',
            'fecha_fin.date_format' => 'La fecha de fin debe tener el formato AAAA-MM-DD.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);

        if (empty($validated['fecha_inicio']) && empty($validated['fecha_fin'])) {
            return new self(
                CarbonImmutable::now()->startOfMonth(),
                CarbonImmutable::now()->endOfDay(),
            );
        }

        return new self(
            CarbonImmutable::parse($validated['fecha_inicio'])->startOfDay(),
            CarbonImmutable::parse($validated['fecha_fin'])->endOfDay(),
        );
    }

    public function apply(EloquentBuilder|QueryBuilder $query, string $column): EloquentBuilder|QueryBuilder
    {
        return $query->whereBetween($column, [$this->start, $this->end]);
    }

    public function days(): array
    {
        $dates = [];

        for ($date = $this->start->startOfDay(); $date->lte($this->end); $date = $date->addDay()) {
            $dates[] = $date->toDateString();
        }

        return $dates;
    }

    public function inclusiveDays(): int
    {
        return $this->start->startOfDay()->diffInDays($this->end->startOfDay()) + 1;
    }
}

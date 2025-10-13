<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotInteraction extends Model
{
    protected $fillable = [        
        'started_at',
        'ended_at',        
        'message_count',
        'successful_responses',
        'failed_responses',
        'model_used',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
}

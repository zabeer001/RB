<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'due_date',
        'project_id', // If you need to set this manually, otherwise it will be auto-assigned
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function to_dos()
    {
        return $this->hasMany(ToDo::class);
    }
}

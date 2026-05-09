<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWork extends Model
{
    use HasFactory;

    protected $table = 'project_works';

    protected $guarded = [];

    /**
     * The work item details
     */
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * The project this work belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The contractor assigned to this specific work item (for partial allocation)
     */
    public function assignedContractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }
}

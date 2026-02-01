<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Journal;
use Illuminate\Http\Request;

class EditorialWorkflowController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::with(['journal', 'author', 'assignedEditor']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $submissions = $query->latest()->paginate(20);
        
        $workflowStats = [
            'submitted' => Submission::where('status', 'submitted')->count(),
            'under_review' => Submission::where('status', 'under_review')->count(),
            'revision_required' => Submission::where('status', 'revision_requested')->count(),
            'accepted' => Submission::where('status', 'accepted')->count(),
            'rejected' => Submission::where('status', 'rejected')->count(),
        ];
        
        return view('admin.editorial-workflows.index', compact('submissions', 'workflowStats'));
    }
}


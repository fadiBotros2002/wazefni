<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{

    public function index()
    {
        $reports = Report::all();
        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'message' => 'required|string',
        ]);

        $report = new Report([
            'user_id' => auth()->id(),
            'post_id' => $request->input('post_id'),
            'message' => $request->input('message'),
            'is_read' => false,
            'status' => 'pending',
        ]);

        $report->save();

        return response()->json(['message' => 'Report submitted successfully'], 201);
    }


    //reports of auth user
    public function userReports()
    {
        $reports = Report::where('user_id', auth()->id())->get();
        return response()->json($reports);
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,resolved,dismissed',
    ]);

    $report = Report::find($id);
    $report->status = $request->input('status');
    $report->is_read=true;
    $report->save();

    return response()->json(['message' => 'Report status updated successfully']);
}

}

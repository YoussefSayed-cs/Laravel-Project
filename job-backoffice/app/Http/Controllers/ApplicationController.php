<?php

namespace App\Http\Controllers;


use App\Models\job_application;
use App\Notifications\newJobApply;
use App\Http\Requests\JobApplication\JobApplicationUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Ensure this is imported

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = job_application::latest();



        if (Auth::user()->role == 'company-owner') {  // Changed from auth()->user()
            $query->whereHas('jobVacancy', function ($q) {
                $q->where('companyID', Auth::user()->company->id);  // Changed from auth()->user()
            });
        }

        // Filter by job vacancy if provided
        if ($request->has('job')) {
            $query->where('jobVacancyID', $request->input('job'));
        }

        //clear archive
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        // Pagination
        $job_applications = $query->paginate(10)->onEachSide(1);

        return view('JobApplication.index', compact('job_applications'));
    }


    public function show(string $id)
    {
        $job_application = job_application::withTrashed()->findOrFail($id);
        return view('JobApplication.show', compact('job_application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job_application = job_application::findOrFail($id);
        return view('JobApplication.edit', compact('job_application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $job_application = job_application::findOrFail($id);
        $job_application->update([$validated]);

        // if ($request->query('redirectToList') == 'false') {

        //     return redirect()->route('job-applications.show', $job_application->id)->with('success', 'Job application updated successfully.');
        // }

        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    public function store(Request $request)
    {
        $jobApplication = job_application::create([
            'jobVacancyID' => $request->jobVacancyID,
            'userID'       => Auth::id(),
            'status'       => 'pending',
        ]);

        // Define the user variable
        $user = Auth::user();


        // Company owner
        $owner = $jobApplication->jobVacancy->company->Owner;

        //  send Notification to company owner
        $owner->notify(
            new newJobApply($jobApplication, route('job-applications.show', $jobApplication->id), $user, 'Application submitted successfully')
        );

        return back()->with('success', 'Application sent successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job_application = job_application::findOrFail($id);
        $job_application->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully.');
    }

    public function restore(string $id)
    {
        $job_application = job_application::withTrashed()->findOrFail($id);
        $job_application->restore();

        return redirect()->route('job-applications.index')->with('success', 'Job application restored successfully.');
    }
}

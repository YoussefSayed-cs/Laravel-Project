<?php

namespace App\Http\Controllers;

use App\Models\job_application;
use App\Models\job_vacancy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
     $user = Auth::user();

    if ($user->role == 'admin') {
        $analytics = $this->adminDashboard();
    } else {
        $analytics = $this->companyOwnerDashboard();
    }

    return view('Dashboard.index', compact('analytics'));
  }

  private function adminDashboard()
  {
    // Total Users (job seekers role)
    $totalUsers = User::where('role', 'job-seeker')->count();

    //Total job vacancies (not deleted)
    $totalJob = job_vacancy::whereNull('deleted_at')->count();

    // Total applications (not deleted)
    $totalapplications = job_application::whereNull('deleted_at')->count();

    // Most applied jobs
    $mostAppliedJobs = job_vacancy::withCount('job_application as totalCount')
      ->with('company')
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get();

    //conversion rates
    $conversionRates = job_vacancy::withCount('job_application as totalCount')
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get()
      ->map(function ($job) {
        $views = $job->views_count ?? 0;
        
        // Simulate views for dummy data if views are 0 but there are applications
        // Using a deterministic multiplier based on the job ID so the chart doesn't jump randomly on refresh
        if ($views == 0 && $job->totalCount > 0) {
            $multiplier = (crc32($job->id) % 5) + 3; // Generates a stable number between 3 and 7
            $views = $job->totalCount * $multiplier; 
        }

        if ($views > 0) {
          $conversionRate = round(($job->totalCount / $views) * 100, 1);
        } else {
          $conversionRate = 0;
        }

        $job->views_count = $views;
        $job->conversionRates = $conversionRate;

        return $job;
      });

    $analytics = [
      'activeUsers' => $totalUsers,
      'totalJob' => $totalJob,
      'totalapplications' => $totalapplications,
      'mostAppliedJobs' => $mostAppliedJobs,
      'conversionRates' => $conversionRates
    ];

    return $analytics;
  }

  private function companyOwnerDashboard()
  {
    $company = Auth::user()->company;

    if (!$company) {
        return [
            'activeUsers' => 0,
            'totalJob' => 0,
            'totalapplications' => 0,
            'mostAppliedJobs' => collect(), // return empty collection
            'conversionRates' => collect()
        ];
    }

    // filter total users by applying to jobs of the company
    $totalUsers = User::where('role', 'job-seeker')
      ->whereHas('job_application', function ($query) use ($company) {
        $query->whereIn('jobVacancyID', $company->jobVacancies->pluck('id'));
      })
      ->count();

    // total jobs of the company
    $totalJobs = $company->jobVacancies->count();

    // total applications of the company
    $totalApplications = job_application::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();

    // most applied jobs of the company
    $mostAppliedJobs = job_vacancy::withCount('job_application as totalCount')
      ->whereIn('id', $company->jobVacancies->pluck('id'))
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get();

    $conversionRates = job_vacancy::withCount('job_application as totalCount')
      ->whereIn('id', $company->jobVacancies->pluck('id'))
      ->having('totalCount', '>', 0)
      ->limit(5)
      ->orderByDesc('totalCount')
      ->get()
      ->map(function ($job) {
        $views = $job->views_count ?? 0;
        
        // Simulate views for dummy data if views are 0 but there are applications
        if ($views == 0 && $job->totalCount > 0) {
            $multiplier = (crc32($job->id) % 5) + 3;
            $views = $job->totalCount * $multiplier; 
        }

        if ($views > 0) {
          $conversionRate = round(($job->totalCount / $views) * 100, 1);
        } else {
          $conversionRate = 0;
        }

        $job->views_count = $views;
        $job->conversionRates = $conversionRate;

        return $job;
      });

    $analytics = [
      'activeUsers' => $totalUsers,
      'totalJob' => $totalJobs,
      'totalapplications' => $totalApplications,
      'mostAppliedJobs' => $mostAppliedJobs,
      'conversionRates' => $conversionRates
    ];

    return $analytics;
  }
}

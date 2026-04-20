<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyupdateRequest;
use Illuminate\Support\Facades\Auth;  // Ensure imported if used elsewhere
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public $industries = ['Technology', 'Healthcare', 'Education'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Active
        $query = company::latest();

        //Archive
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        return view('Company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $industries = $this->industries;
        return view('Company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest  $request)
    {
        $validated = $request->validated();
        company::create($validated);
        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(?string $id = null)
    {

        $company = $this->myCompany($id);
        return view('Company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?string $id = null)
    {

        $company = $this->myCompany($id);

        $industries = $this->industries;

        return view('Company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyupdateRequest $request, ?string $id = null)
    {
        $validated = $request->validated();
        $company = $this->myCompany($id);
        $company->update($validated);

        if (Auth::user()->role == 'company-owner') {
            return redirect()->route('my-company.show')->with('success', 'Company update successfully!');
        }

        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('companies.index')->with('success', 'Company updated successfully');
        } else {
            return redirect()->route('companies.show', $id)->with('success', 'Company updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companies = company::findOrFail($id);
        $companies->delete();
        return redirect()->route('companies.index')->with('success', 'Company archived successfully');
    }

    public function restore(string $id)
    {
        $companies = company::withTrashed()->findOrFail($id);
        $companies->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company restored successfully');
    }

    private function myCompany(?string $id = null)
    {
        if ($id) {
            return Company::findOrFail($id);
        } else {
            return Company::where('ownerID', Auth::user()->id)->first();
        }


    }
}

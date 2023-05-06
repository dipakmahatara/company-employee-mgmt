<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Notifications\CompanyCreated;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return response()->json($companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        $input = $request->validated();

        $path = '';
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public');
        }

        $input['logo'] =  Str::after($path, 'public/');
        $company = Company::create($input);

        $company->notify(new CompanyCreated());

        return response()->json([
            'message' => 'Company Created Successfully!!',
            'company' => $company
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $input = $request->validated();

        $path = $company->logo;
        if ($request->hasFile('logo')) {
            Storage::delete('public/' . $company->logo);
            $path = $request->file('logo')->store('public');
            $path = Str::after($path, 'public/');
        }

        $input['logo'] =  $path;
        $company->fill($input)->save();
        return response()->json([
            'message' => 'Company Updated Successfully!!',
            'company' => $company
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        Storage::delete('public/' . $company->logo);
        $company->delete();
        return response()->json([
            'message' => 'Company Deleted Successfully!!'
        ]);
    }

    public function getAllCompanies()
    {
        $companies = Company::get();
        return response()->json($companies);
    }
}

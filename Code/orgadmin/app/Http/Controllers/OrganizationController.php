<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.organization');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.organization-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $organization = Organization::create($request->all());
        return redirect()->route('organization')->with('success', 'Organization created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organization = Organization::findOrFail($id);
        return view('pages.organization-show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $organization = Organization::findOrFail($id);
        return view('pages.organization-edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());
        return redirect()->route('organization')->with('success', 'Organization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return redirect()->route('organization')->with('success', 'Organization deleted successfully');
    }
}

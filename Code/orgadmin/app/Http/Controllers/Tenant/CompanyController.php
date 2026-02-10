<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Symfony\Component\Translation\t;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.tenant.company.index');
    }

    // Settings page
    public function settings()
    {
        $tenant = tenant();
        return view('pages.tenant.company.settings', compact('tenant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenant.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('tenant.company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('tenant.company.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('tenant.company.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('tenant.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('tenant.company.index');
    }
}

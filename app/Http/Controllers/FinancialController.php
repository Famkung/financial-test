<?php

// app/Http/Controllers/FinancialController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FinancialTransaction;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = FinancialTransaction::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
            });
        }

        $financials = $query->get()->sortBy(function($item) {
            return Carbon::parse($item->birthdate)->age;
        });

        return view('financial_list', compact('financials', 'search'));
    }

    public function create()
    {
        return view('financial_form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'profile_image' => 'nullable|image|max:2048', 
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $path;
        }

        $validated['updated_at'] = now();

        FinancialTransaction::create($validated);

        return redirect()->route('financial.create')->with('updated_at', now());
    }

    public function edit($id)
    {
        $financial = FinancialTransaction::findOrFail($id);
        return view('financial_edit', compact('financial'));
    }

    public function update(Request $request, $id)
    {
        $financial = FinancialTransaction::findOrFail($id);

        $validated = $request->validate([
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($financial->profile_image && \Storage::disk('public')->exists($financial->profile_image)) {
                \Storage::disk('public')->delete($financial->profile_image);
            }
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $path;
        } else {
            $validated['profile_image'] = $financial->profile_image;
        }

        $validated['updated_at'] = now();

        $financial->update($validated);

        return redirect()->route('financial.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    public function report()
    {
        $ageGroups = FinancialTransaction::all()
            ->groupBy(function($item) {
                return Carbon::parse($item->birthdate)->age;
            })
            ->map->count()
            ->sortKeys();

        return view('financial_report', compact('ageGroups'));
    }

    public function destroy($id)
    {
        $financial = FinancialTransaction::findOrFail($id);
        if ($financial->profile_image) {
            \Storage::disk('public')->delete($financial->profile_image);
        }
        $financial->delete();
        return redirect()->route('financial.index')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::query()->orderBy('id_branch')->get();
        return view('master.branches.index', compact('branches'));
    }

    public function create()
    {
        $nextBranchId = (int) (DB::table('m_branches')->max('id_branch') ?? 0) + 1;

        return view('master.branches.create', compact('nextBranchId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_branch' => ['required', 'integer', 'min:1', 'unique:m_branches,id_branch'],
            'branch_name' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
        ]);

        $idBranch = (int) $validated['id_branch'];

        Branch::query()->create([
            'id_branch' => $idBranch,
            'branch_name' => $validated['branch_name'],
            'address' => $validated['address'] ?? null,
        ]);

        return redirect('/master/branches')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $branch = Branch::query()->where('id_branch', $id)->firstOrFail();

        return view('master.branches.edit', compact('branch'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'branch_name' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
        ]);

        $branch = Branch::query()->where('id_branch', $id)->firstOrFail();
        $branch->update([
            'branch_name' => $validated['branch_name'],
            'address' => $validated['address'] ?? null,
        ]);

        return redirect('/master/branches')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function toggleDisable(int $id)
    {
        $branch = Branch::query()->where('id_branch', $id)->firstOrFail();

        $suffix = ' [NONAKTIF]';
        $name = (string) ($branch->branch_name ?? '');
        $isDisabled = str_ends_with($name, $suffix);

        $branch->update([
            'branch_name' => $isDisabled ? rtrim(substr($name, 0, -strlen($suffix))) : ($name . $suffix),
        ]);

        return redirect('/master/branches')->with('success', $isDisabled ? 'Cabang diaktifkan.' : 'Cabang dinonaktifkan.');
    }
}

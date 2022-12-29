<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportUser implements FromView
{
    public function view(): View
    {
        $users = User::query()->with('pasport', 'fillial', 'role')->get();
        return view('exports.users', ['users' => $users]);
    }
}

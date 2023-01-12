<?php

namespace App\Imports;

use App\Models\Fillial;
use App\Models\Pasport;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUser implements ToCollection, WithHeadingRow
{
    private $branches;
    private $roles;

    public function __construct()
    {
        $this->branches = Fillial::query()->get();
        $this->roles = Role::query()->get();
    }

    /**
     * @throws Exception
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            /*$role = $this->roles->where('type', $value['role'])->first();
            $branch = $this->branches->filter(function ($item) use ($value) {
                return array_search($value['region'], [$item->name_uz, $item->name_ru, $item->name_en]);
            })->first();
            if ($branch && $role) {*/
            try {
                DB::beginTransaction();
                $passport = new Pasport();
                $passport->fill($value->toArray());
                $passport->save();
                DB::commit();
                    /*if ($passport->save()) {
                        $user = new User();
                        $user->fill([
                            'role_id' => $role->id,
                            'pasport_id' => $passport->id,
                            'fillial_id' => $branch->id,
                            'login' => $value['login'],
                            'password' => Hash::make($value['password'])
                        ]);
                        $user->save();
                        DB::commit();
                    }*/
                } catch (Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
//        }
    }
}

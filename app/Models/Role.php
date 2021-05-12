<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ROLE_EDITORIAL_DESIGN_MANAGER = 'editorial-design-managers';

    protected $table = 'roles';

    public function run() {
        $role = new Role();
        $role->name='editorial-design-managers';
        $role->key='ROLE_EDITORIAL_DESIGN_MANAGER';
        $role->Save();
    }


}

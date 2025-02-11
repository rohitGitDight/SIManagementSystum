<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define permissions
        $permissions = [
            // Student Permissions
            'add student', 'edit student', 'view student', 'delete student', 'view student list',
            
            // Role Permissions
            'view role', 'edit role', 'view role list', 'delete role',
            
            // Batch Permissions
            'view batch', 'add batch', 'edit batch', 'delete batch', 'view batch list',
            
            // Course Permissions
            'view course', 'add course', 'edit course', 'delete course', 'view course list',
            
            // Professor Permissions
            'view professor', 'add professor', 'edit professor', 'delete professor', 'view professor list',
            
            // Fee Transactions
            'view student fee transactions', 'edit student fee transaction',
            
            // Student Course Fees
            'view student course fees', 'add student course fees',
            
            // Payment Calendar
            'view student payment calendar',
            
            // Invoices
            'view invoice list', 'view student personal invoice list'
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $professor = Role::firstOrCreate(['name' => 'Professor', 'guard_name' => 'web']);
        $hr = Role::firstOrCreate(['name' => 'HR', 'guard_name' => 'web']);
        $student = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'web']);

        // Assign all permissions to Super Admin
        $superAdmin->syncPermissions($permissions);

        // Assign permissions to HR
        $hrPermissions = [
            'add student', 'edit student', 'view student', 'view student list',
            'view batch', 'add batch', 'edit batch', 'delete batch', 'view batch list',
            'view course', 'add course', 'edit course', 'delete course', 'view course list',
            'view professor', 'view professor list',
            'view student fee transactions', 'view student course fees', 'add student course fees',
            'view invoice list'
        ];
        $hr->syncPermissions($hrPermissions);

        // Assign permissions to Professor
        $professorPermissions = [
            'view student', 'view student list',
            'view batch', 'view batch list',
            'view course', 'view course list',
            'view professor', 'view professor list'
        ];
        $professor->syncPermissions($professorPermissions);

        // Assign permissions to Student
        $studentPermissions = [
            'view student personal invoice list'
        ];
        $student->syncPermissions($studentPermissions);

        echo "✅ Permissions and roles assigned successfully Done!\n";
    }
}
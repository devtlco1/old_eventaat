<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'expense_management_access',
            ],
            [
                'id'    => 23,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 24,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 25,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 26,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 27,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 28,
                'title' => 'income_category_create',
            ],
            [
                'id'    => 29,
                'title' => 'income_category_edit',
            ],
            [
                'id'    => 30,
                'title' => 'income_category_show',
            ],
            [
                'id'    => 31,
                'title' => 'income_category_delete',
            ],
            [
                'id'    => 32,
                'title' => 'income_category_access',
            ],
            [
                'id'    => 33,
                'title' => 'expense_create',
            ],
            [
                'id'    => 34,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 35,
                'title' => 'expense_show',
            ],
            [
                'id'    => 36,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 37,
                'title' => 'expense_access',
            ],
            [
                'id'    => 38,
                'title' => 'income_create',
            ],
            [
                'id'    => 39,
                'title' => 'income_edit',
            ],
            [
                'id'    => 40,
                'title' => 'income_show',
            ],
            [
                'id'    => 41,
                'title' => 'income_delete',
            ],
            [
                'id'    => 42,
                'title' => 'income_access',
            ],
            [
                'id'    => 43,
                'title' => 'expense_report_create',
            ],
            [
                'id'    => 44,
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => 45,
                'title' => 'expense_report_show',
            ],
            [
                'id'    => 46,
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => 47,
                'title' => 'expense_report_access',
            ],
            [
                'id'    => 48,
                'title' => 'restaurent_create',
            ],
            [
                'id'    => 49,
                'title' => 'restaurent_edit',
            ],
            [
                'id'    => 50,
                'title' => 'restaurent_show',
            ],
            [
                'id'    => 51,
                'title' => 'restaurent_delete',
            ],
            [
                'id'    => 52,
                'title' => 'restaurent_access',
            ],
            [
                'id'    => 53,
                'title' => 'event_create',
            ],
            [
                'id'    => 54,
                'title' => 'event_edit',
            ],
            [
                'id'    => 55,
                'title' => 'event_show',
            ],
            [
                'id'    => 56,
                'title' => 'event_delete',
            ],
            [
                'id'    => 57,
                'title' => 'event_access',
            ],
            [
                'id'    => 58,
                'title' => 'story_create',
            ],
            [
                'id'    => 59,
                'title' => 'story_edit',
            ],
            [
                'id'    => 60,
                'title' => 'story_show',
            ],
            [
                'id'    => 61,
                'title' => 'story_delete',
            ],
            [
                'id'    => 62,
                'title' => 'story_access',
            ],
            [
                'id'    => 63,
                'title' => 'index_access',
            ],
            [
                'id'    => 64,
                'title' => 'privacy_create',
            ],
            [
                'id'    => 65,
                'title' => 'privacy_edit',
            ],
            [
                'id'    => 66,
                'title' => 'privacy_show',
            ],
            [
                'id'    => 67,
                'title' => 'privacy_delete',
            ],
            [
                'id'    => 68,
                'title' => 'privacy_access',
            ],
            [
                'id'    => 69,
                'title' => 'feature_create',
            ],
            [
                'id'    => 70,
                'title' => 'feature_edit',
            ],
            [
                'id'    => 71,
                'title' => 'feature_show',
            ],
            [
                'id'    => 72,
                'title' => 'feature_delete',
            ],
            [
                'id'    => 73,
                'title' => 'feature_access',
            ],
            [
                'id'    => 74,
                'title' => 'offer_create',
            ],
            [
                'id'    => 75,
                'title' => 'offer_edit',
            ],
            [
                'id'    => 76,
                'title' => 'offer_show',
            ],
            [
                'id'    => 77,
                'title' => 'offer_delete',
            ],
            [
                'id'    => 78,
                'title' => 'offer_access',
            ],
            [
                'id'    => 79,
                'title' => 'booking_create',
            ],
            [
                'id'    => 80,
                'title' => 'booking_edit',
            ],
            [
                'id'    => 81,
                'title' => 'booking_show',
            ],
            [
                'id'    => 82,
                'title' => 'booking_delete',
            ],
            [
                'id'    => 83,
                'title' => 'booking_access',
            ],
            [
                'id'    => 84,
                'title' => 'contact_create',
            ],
            [
                'id'    => 85,
                'title' => 'contact_edit',
            ],
            [
                'id'    => 86,
                'title' => 'contact_show',
            ],
            [
                'id'    => 87,
                'title' => 'contact_delete',
            ],
            [
                'id'    => 88,
                'title' => 'contact_access',
            ],
            [
                'id'    => 89,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}

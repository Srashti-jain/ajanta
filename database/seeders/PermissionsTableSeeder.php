<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'order.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:28:29',
                'updated_at' => '2021-05-27 11:28:29',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'order.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:28:58',
                'updated_at' => '2021-05-27 11:28:58',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'order.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:06',
                'updated_at' => '2021-05-27 11:29:06',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'order.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:13',
                'updated_at' => '2021-05-27 11:29:13',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'login.can',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:24',
                'updated_at' => '2021-05-27 11:29:24',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'roles.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:26',
                'updated_at' => '2021-05-27 11:30:26',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'roles.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:32',
                'updated_at' => '2021-05-27 11:30:32',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:36',
                'updated_at' => '2021-05-27 11:30:36',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'roles.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:40',
                'updated_at' => '2021-05-27 11:30:40',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'users.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:02:40',
                'updated_at' => '2021-05-27 13:02:40',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'users.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:02:45',
                'updated_at' => '2021-05-27 13:02:45',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'users.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:03:08',
                'updated_at' => '2021-05-27 13:03:08',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'users.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:03:11',
                'updated_at' => '2021-05-27 13:03:11',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'dashboard.states',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:16:02',
                'updated_at' => '2021-05-28 14:16:02',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'menu.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:07',
                'updated_at' => '2021-05-28 14:19:07',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'menu.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:12',
                'updated_at' => '2021-05-28 14:19:12',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'menu.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:17',
                'updated_at' => '2021-05-28 14:19:17',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'menu.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:20:08',
                'updated_at' => '2021-05-28 14:20:08',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'stores.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:38:57',
                'updated_at' => '2021-05-28 14:38:57',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'stores.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:04',
                'updated_at' => '2021-05-28 14:39:04',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'stores.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:09',
                'updated_at' => '2021-05-28 14:39:09',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'stores.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:12',
                'updated_at' => '2021-05-28 14:39:12',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'stores.accept.request',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:26',
                'updated_at' => '2021-05-28 14:39:26',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'review.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:35',
                'updated_at' => '2021-05-31 06:42:35',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'review.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:42',
                'updated_at' => '2021-05-31 06:42:42',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'review.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:47',
                'updated_at' => '2021-05-31 06:42:47',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'brand.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:20',
                'updated_at' => '2021-05-31 06:49:20',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'brand.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:29',
                'updated_at' => '2021-05-31 06:49:29',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'brand.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:32',
                'updated_at' => '2021-05-31 06:49:32',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'brand.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:47',
                'updated_at' => '2021-05-31 06:49:47',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'category.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:54:58',
                'updated_at' => '2021-05-31 06:54:58',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'category.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:01',
                'updated_at' => '2021-05-31 06:55:01',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'category.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:05',
                'updated_at' => '2021-05-31 06:55:05',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'category.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:09',
                'updated_at' => '2021-05-31 06:55:09',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'subcategory.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:59:57',
                'updated_at' => '2021-05-31 06:59:57',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'subcategory.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:02',
                'updated_at' => '2021-05-31 07:00:02',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'subcategory.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:07',
                'updated_at' => '2021-05-31 07:00:07',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'subcategory.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:17',
                'updated_at' => '2021-05-31 07:00:17',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'childcategory.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:09',
                'updated_at' => '2021-05-31 07:14:09',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'childcategory.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:14',
                'updated_at' => '2021-05-31 07:14:14',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'childcategory.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:20',
                'updated_at' => '2021-05-31 07:14:20',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'childcategory.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:24',
                'updated_at' => '2021-05-31 07:14:24',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'products.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:15',
                'updated_at' => '2021-05-31 07:22:15',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'products.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:20',
                'updated_at' => '2021-05-31 07:22:20',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'products.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:25',
                'updated_at' => '2021-05-31 07:22:25',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'products.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:29',
                'updated_at' => '2021-05-31 07:22:29',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'products.import',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:23:32',
                'updated_at' => '2021-05-31 07:23:32',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'attributes.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:30',
                'updated_at' => '2021-05-31 07:28:30',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'attributes.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:37',
                'updated_at' => '2021-05-31 07:28:37',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'attributes.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:40',
                'updated_at' => '2021-05-31 07:28:40',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'attributes.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:44',
                'updated_at' => '2021-05-31 07:28:44',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'coupans.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:30:48',
                'updated_at' => '2021-05-31 07:30:48',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'coupans.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:30:52',
                'updated_at' => '2021-05-31 07:30:52',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'coupans.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:31:01',
                'updated_at' => '2021-05-31 07:31:01',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'coupans.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:31:11',
                'updated_at' => '2021-05-31 07:31:11',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'returnpolicy.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:33:55',
                'updated_at' => '2021-05-31 07:33:55',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'returnpolicy.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:33:59',
                'updated_at' => '2021-05-31 07:33:59',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'returnpolicy.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:34:03',
                'updated_at' => '2021-05-31 07:34:03',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'returnpolicy.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:34:07',
                'updated_at' => '2021-05-31 07:34:07',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'units.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:36:26',
                'updated_at' => '2021-05-31 07:36:26',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'units.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:36:35',
                'updated_at' => '2021-05-31 07:36:35',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'units.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:37:01',
                'updated_at' => '2021-05-31 07:37:01',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'units.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:37:05',
                'updated_at' => '2021-05-31 07:37:05',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'specialoffer.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:50',
                'updated_at' => '2021-05-31 07:39:50',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'specialoffer.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:54',
                'updated_at' => '2021-05-31 07:39:54',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'specialoffer.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:59',
                'updated_at' => '2021-05-31 07:39:59',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'specialoffer.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:40:02',
                'updated_at' => '2021-05-31 07:40:02',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'invoicesetting.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:44:34',
                'updated_at' => '2021-05-31 07:44:34',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'invoicesetting.update',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:44:39',
                'updated_at' => '2021-05-31 07:44:39',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'hotdeals.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'hotdeals.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'hotdeals.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'hotdeals.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'blockadvertisments.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:21',
                'updated_at' => '2021-05-31 07:55:21',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'blockadvertisments.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'blockadvertisments.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'blockadvertisments.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'advertisements.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'advertisements.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'advertisements.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'advertisements.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'testimonials.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:35',
                'updated_at' => '2021-05-31 07:56:35',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'testimonials.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:35',
                'updated_at' => '2021-05-31 07:56:35',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'testimonials.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:36',
                'updated_at' => '2021-05-31 07:56:36',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'testimonials.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:36',
                'updated_at' => '2021-05-31 07:56:36',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'offerpopup.setting',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:57:45',
                'updated_at' => '2021-05-31 07:57:45',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'pushnotification.settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:58:16',
                'updated_at' => '2021-05-31 07:58:16',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'location.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:19:03',
                'updated_at' => '2021-05-31 08:19:03',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'shipping.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:24:03',
                'updated_at' => '2021-05-31 08:24:03',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'taxsystem.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:24:27',
                'updated_at' => '2021-05-31 08:24:27',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'commission.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:29:16',
                'updated_at' => '2021-05-31 08:29:16',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'sellerpayout.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:31:59',
                'updated_at' => '2021-05-31 08:31:59',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'currency.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:36:47',
                'updated_at' => '2021-05-31 08:36:47',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'sliders.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:00:01',
                'updated_at' => '2021-05-31 09:00:01',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'sellersubscription.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:16:44',
                'updated_at' => '2021-05-31 09:16:44',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'affiliatesystem.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:20:57',
                'updated_at' => '2021-05-31 09:20:57',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'faq.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'faq.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'faq.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'faq.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'pwasettings.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:28:39',
                'updated_at' => '2021-05-31 09:28:39',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'terms-settings.update',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:37:19',
                'updated_at' => '2021-05-31 09:37:19',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'color-options.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:39:55',
                'updated_at' => '2021-05-31 09:39:55',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'payment-gateway.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:42:03',
                'updated_at' => '2021-05-31 09:42:03',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'manual-payment.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'manual-payment.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'manual-payment.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'manual-payment.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'widget-settings.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:51:31',
                'updated_at' => '2021-05-31 09:51:31',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'wallet.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 10:57:25',
                'updated_at' => '2021-05-31 10:57:25',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'support-ticket.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:22:27',
                'updated_at' => '2021-05-31 11:22:27',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'reported-products.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:25:09',
                'updated_at' => '2021-05-31 11:25:09',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'addon-manager.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:26:31',
                'updated_at' => '2021-05-31 11:26:31',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'reports.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:28:50',
                'updated_at' => '2021-05-31 11:28:50',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'others.systemstatus',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:24',
                'updated_at' => '2021-05-31 11:31:24',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'others.importdemo',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:30',
                'updated_at' => '2021-05-31 11:31:30',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'others.database-backup',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:46',
                'updated_at' => '2021-05-31 11:31:46',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'site-settings.genral-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:33:53',
                'updated_at' => '2021-05-31 12:33:53',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'site-settings.language',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:17',
                'updated_at' => '2021-05-31 12:34:17',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'site-settings.mail-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:27',
                'updated_at' => '2021-05-31 12:34:27',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'site-settings.social-login-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:39',
                'updated_at' => '2021-05-31 12:34:39',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'site-settings.sms-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:48',
                'updated_at' => '2021-05-31 12:34:48',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'site-settings.dashboard-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:58',
                'updated_at' => '2021-05-31 12:34:58',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'site-settings.maintenance-mode',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:17',
                'updated_at' => '2021-05-31 12:35:17',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'site-settings.style-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:47',
                'updated_at' => '2021-05-31 12:35:47',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'site-settings.footer-customize',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:58',
                'updated_at' => '2021-05-31 12:35:58',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'site-settings.social-handle',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:36:11',
                'updated_at' => '2021-05-31 12:36:11',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'site-settings.bank-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:36:31',
                'updated_at' => '2021-05-31 12:36:31',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'seo.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:01',
                'updated_at' => '2021-05-31 12:37:01',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'pages.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'pages.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'pages.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'pages.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:22',
                'updated_at' => '2021-05-31 12:37:22',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'blog.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'blog.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'blog.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'blog.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:25',
                'updated_at' => '2021-05-31 12:37:25',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'others.abuse-word-manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:38:13',
                'updated_at' => '2021-05-31 12:38:13',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'digital-products.view',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'digital-products.create',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'digital-products.edit',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'digital-products.delete',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:15',
                'updated_at' => '2021-06-07 10:14:15',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'mediamanager.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:09:23',
                'updated_at' => '2021-11-22 18:09:23',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'chat.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:10:34',
                'updated_at' => '2021-11-22 18:10:34',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'sizechart.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:10:46',
                'updated_at' => '2021-11-22 18:10:46',
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [3, 'CG-CLEANERS', 'Cleaners', '2019-01-30 00:09:46', '2019-01-30 00:09:46'],
            [4, 'CG-Nurses', 'Nurses', '2019-01-30 00:10:25', '2019-01-30 00:10:25'],
            [5, 'CG-Lab', 'Lab', '2019-01-30 00:10:49', '2019-01-30 00:10:49'],
            [6, 'CG-Security', 'Security', '2019-01-30 00:11:07', '2019-01-30 00:11:07'],
            [7, 'CG-Doctors', 'Doctors', '2019-01-30 00:11:40', '2019-01-30 00:11:40'],
            [8, 'CG-Partners', 'Partners', '2019-01-30 00:12:22', '2019-01-30 00:12:22'],
            [9, 'CG-PHARMACY', 'Pharmacy', '2019-01-30 00:16:09', '2019-01-30 00:16:09'],
            [10, 'CG-SEPLAT', 'Seplat', '2019-01-30 00:49:13', '2019-01-30 00:49:13'],
            [11, 'CG-LIFE FLOUR', 'Life Flour Mills', '2019-01-30 00:50:06', '2019-01-30 00:51:19'],
            [12, 'CG-MANAGEMENT', 'Management', '2019-01-30 01:28:16', '2019-01-30 01:28:16'],
            [13, 'CG-PATIENT', 'Patients', '2019-01-30 01:29:17', '2019-01-30 01:29:17'],
            [14, 'CG-ADMIN', 'Admin', '2019-02-01 20:51:40', '2019-02-01 20:51:40'],
            [15, 'CG-I.T DEP', 'I.T Dep', '2019-02-19 00:49:11', '2019-02-19 00:49:32'],
            [17, 'CG_DIALYSIS_UNIT', 'Dialysis_Unit', '2019-03-06 18:03:10', '2019-03-06 18:03:10'],
            [19, 'CG_RINGARDAS', 'RINGARDAS', '2019-04-15 00:43:32', '2019-04-15 00:43:32'],
            [20, 'CG_ANCHOR', 'ANCHOR', '2019-05-14 23:50:55', '2019-05-14 23:50:55'],
            [21, 'CG_MANSARD', 'MANSARD', '2019-05-20 21:19:44', '2019-05-20 21:19:44'],
            [22, 'CG_FCARD', 'fCARD', '2019-05-20 23:21:04', '2019-05-20 23:21:04'],
            [23, 'CG_DIALYSIS', 'DIALYSIS', '2019-05-30 16:52:56', '2019-05-30 16:52:56'],
            [24, 'CG_THT', 'THT', '2019-05-30 17:20:47', '2019-05-30 17:20:47'],
            [25, 'CG_AWT', 'AWT', '2019-05-31 02:14:02', '2019-05-31 02:14:02'],
            [26, 'CG_DERM', 'Derm', '2019-06-05 21:21:50', '2019-06-05 21:21:50'],
            [27, 'CG_STERLING', 'STERLING', '2019-06-15 17:33:05', '2019-06-15 17:33:05'],
            [28, 'CG_SMATHEALTH', 'SMATHEALTH', '2019-06-15 17:40:16', '2019-06-15 17:40:16'],
            [29, 'CG_HYGEIA', 'HYGEIA', '2019-06-15 17:41:36', '2019-06-15 17:41:36'],
            [30, 'CG_MONTEGO', 'MONTEGO', '2019-06-15 17:42:23', '2019-06-15 17:42:23'],
            [31, 'CG_MARINAHMO', 'MARINAHMO', '2019-06-19 16:16:22', '2019-06-19 16:16:22'],
            [32, 'CG_PHEALTH', 'PHEALTH', '2019-06-19 16:16:54', '2019-06-19 16:16:54'],
            [33, 'CG_MEDIFIELD', 'MEDIFIELD', '2019-06-19 16:17:17', '2019-06-19 16:17:17'],
            [34, 'CG_IHMS', 'IHMS', '2019-06-19 16:17:40', '2019-06-19 16:17:40'],
            [35, 'CG_NHIS', 'NHIS', '2019-06-19 16:18:33', '2019-06-19 16:18:33'],
            [36, 'CG_PRINCETON', 'PRINCETON', '2019-06-19 16:19:04', '2019-06-19 16:19:04'],
            [37, 'CG_LIBERTYBLUE', 'LIBERTYBLUE', '2019-06-19 17:15:54', '2019-06-19 17:15:54'],
        ];

          // Insert data into the database
        foreach ($groups as $group) {
            DB::table('groups')->insert([
                'id' => $group[0],
                'ref_code' => $group[1],
                'name' => $group[2],
                'created_at' => $group[3],
                'updated_at' => $group[4],
            ]);
        }
    }
}

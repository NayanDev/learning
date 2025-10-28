<?php

namespace App\Helpers;

use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar
{

  public function generate()
  {
    $menus = $this->menus();
    $constant = new Constant();
    $permission = $constant->permissions();

    $arrMenu = [];
    foreach ($menus as $key => $menu) {
      $visibilityMenu = in_array($menu['key'] . ".index", $permission['list_access']);
      if (isset($menu['override_visibility'])) {
        $visibilityMenu = $menu['override_visibility'];
      }
      $menu['visibility'] = $visibilityMenu;
      $menu['url'] = (Route::has($menu['key'] . ".index")) ? route($menu['key'] . ".index") : "#";
      $menu['base_key'] = $menu['key'];
      $menu['key'] = $menu['key'] . ".index";

      $arrMenu[] = $menu;
    }
    return $arrMenu;
  }


  public function menus()
  {
    $role = "admin";
    if (config('idev.enable_role', true)) {
      $role = Auth::user()->role->name;
    }
    return
      [
        [
          'name' => 'Dashboard',
          'icon' => 'ti ti-dashboard',
          'key' => 'dashboard',
          'base_key' => 'dashboard',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        // [
        //   'name' => 'Department',
        //   'icon' => 'ti ti-menu',
        //   'key' => 'department',
        //   'base_key' => 'department',
        //   'visibility' => true,
        //   'ajax_load' => false,
        //   'childrens' => []
        // ],
        // [
        //   'name' => 'Employee',
        //   'icon' => 'ti ti-database',
        //   'key' => 'employee',
        //   'base_key' => 'employee',
        //   'visibility' => true,
        //   'ajax_load' => false,
        //   'childrens' => []
        // ],
        [
          'name' => 'Workshop',
          'icon' => 'ti ti-tools',
          'key' => 'workshop',
          'base_key' => 'workshop',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training New Employee',
          'icon' => 'ti ti-user-plus',
          'key' => 'training-new-employee',
          'base_key' => 'training-new-employee',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        // [
        //     'name' => 'Employee Test',
        //     'icon' => 'ti ti-menu',
        //     'key' => 'employee-test',
        //     'base_key' => 'employee-test',
        //     'visibility' => true,
        //     'ajax_load' => false,
        //     'childrens' => []
        //   ],
        [
          'name' => 'User Answer',
          'icon' => 'ti ti-flask',
          'key' => 'user-answer',
          'base_key' => 'user-answer',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        // [
        //   'name' => 'Training New Participant',
        //   'icon' => 'ti ti-menu',
        //   'key' => 'training-new-participant',
        //   'base_key' => 'training-new-participant',
        //   'visibility' => true,
        //   'ajax_load' => false,
        //   'childrens' => []
        // ],
        [
          'name' => 'Training',
          'icon' => 'ti ti-device-analytics',
          'key' => 'training',
          'base_key' => 'training',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training Detail',
          'icon' => 'ti ti-menu',
          'key' => 'training-detail',
          'base_key' => 'training-detail',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training Analyst',
          'icon' => 'ti ti-menu',
          'key' => 'training-analyst',
          'base_key' => 'training-analyst',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training Need',
          'icon' => 'ti ti-menu',
          'key' => 'training-need',
          'base_key' => 'training-need',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Need Workshop',
          'icon' => 'ti ti-menu',
          'key' => 'need-workshop',
          'base_key' => 'need-workshop',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Need Participant',
          'icon' => 'ti ti-menu',
          'key' => 'training-need-participant',
          'base_key' => 'training-need-participant',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training Schedule',
          'icon' => 'ti ti-menu',
          'key' => 'training-schedule',
          'base_key' => 'training-schedule',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Training Unplanned',
          'icon' => 'ti ti-menu',
          'key' => 'training-unplanned',
          'base_key' => 'training-unplanned',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Unplan Participant',
          'icon' => 'ti ti-menu',
          'key' => 'training-unplan-participant',
          'base_key' => 'training-unplan-participant',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Event',
          'icon' => 'ti ti-layout-grid',
          'key' => 'event',
          'base_key' => 'event',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Participant',
          'icon' => 'ti ti-users',
          'key' => 'participant',
          'base_key' => 'participant',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Materi',
          'icon' => 'ti ti-book',
          'key' => 'materi',
          'base_key' => 'materi',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        // [
        //   'name' => 'Materi Log',
        //   'icon' => 'ti ti-menu',
        //   'key' => 'materi-log',
        //   'base_key' => 'materi-log',
        //   'visibility' => true,
        //   'ajax_load' => false,
        //   'childrens' => []
        // ],
        [
          'name' => 'Question',
          'icon' => 'ti ti-question-mark',
          'key' => 'question',
          'base_key' => 'question',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Result Question',
          'icon' => 'ti ti-menu',
          'key' => 'result-question',
          'base_key' => 'result-question',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Answer',
          'icon' => 'ti ti-pencil',
          'key' => 'answer',
          'base_key' => 'answer',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Event Answer',
          'icon' => 'ti ti-menu',
          'key' => 'event-answer',
          'base_key' => 'event-answer',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Event Question',
          'icon' => 'ti ti-menu',
          'key' => 'event-question',
          'base_key' => 'event-question',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Role',
          'icon' => 'ti ti-key',
          'key' => 'role',
          'base_key' => 'role',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'User',
          'icon' => 'ti ti-users',
          'key' => 'user',
          'base_key' => 'user',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],

      ];
  }


  public function defaultAllAccess($exclude = [])
  {
    return ['list', 'create', 'show', 'edit', 'delete', 'import-excel-default', 'export-excel-default', 'export-pdf-default'];
  }


  public function accessCustomize($menuKey)
  {
    $arrMenu = [
      'dashboard' => ['list'],
    ];

    return $arrMenu[$menuKey] ?? $this->defaultAllAccess();
  }
}

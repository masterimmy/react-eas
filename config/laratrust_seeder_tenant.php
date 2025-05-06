<?php
return [
    'role_structure' => [
        'super_admin' => [
            'dashboard'=>'r-al',
            'meetings' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'tasks' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'attendances' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'leaves' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'wfh' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'tracker' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'users' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'reports' => 'r-al',
            'configuration' => 'r-al',
            'messages' => 'c',
            'holidays' => 'c-al,r-al,d-al,e-al,i-al,u-al',
            'kiosk'=> 'r-al,u-al',
            'tracker-km' => 'c-al'
        ],
        'admin' => [
            'dashboard'=>'r-al',
            'meetings' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'tasks' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'attendances' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'leaves' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'wfh' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'tracker' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'users' => 'c,r-al,u-al,d-al,e-al,i-al,a-al',
            'reports' => 'r-al',
            'configuration' => 'r-al',
            'messages' => 'c',
            'holidays' => 'c-al,r-al,d-al,e-al,i-al,u-al',
            'kiosk'=> 'r-al,u-al',
            'tracker-km' => 'c-al'
        ],
        'manager' => [
            'meetings' => 'c,r-gr,u-gr,d-gr,a-gr',
            'tasks' => 'c,r-gr,u-gr,d-gr,a-gr',
            'attendances' => 'c,r-gr,u-gr',
            'leaves' => 'c,r-gr,u-gr,d-gr,a-gr',
            'wfh' => 'c,r-gr,u-gr,d-gr,e-gr,i-al,a-gr',
            'tracker' => 'c,r-gr,u-gr,d-gr,a-gr',
            'reports' => 'r-gr',
            'users' => 'c,r-gr,u-gr,d-gr',
            'messages' => 'c',
            'holidays' => 'r-al',
            'tracker-km' => 'c-al'
        ],
        'user' => [
            'meetings' => 'c,r-ascr,u-ascr',
            'tasks' => 'c,r-ascr,u-ascr,d-ascr',
            'attendances' => 'r-cr',
            'wfh' => 'r-ascr',
            'leaves' => 'c,r-cr,u-cr,d-cr',
            'holidays' => 'r-al',
            'tracker-km' => 'c-al'
        ],
        'sales_admin' => [],
        'kiosk' => [
            'kisok'=> 'c,r-al'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'a' => 'approve',
        'e' => 'export',
        'i' => 'import',
    ],
    'access_map' => [
        'as' => 'assigned',
        'cr' => 'created',
        'ascr' => 'assignedOrCreated',
        'al' => 'all',
        'gr' => 'group',
    ],
];

<?php
return [
    //true：单条数据空值返回{}，多条数据空值返回[]
    //false：单条数据空值返回[]，多条数据空值返回[]
    'is_object' => true,
    //默认状态码，根据自己项目中的走，这里只是默认区分一下
    'code' => [
        'success' => 0,
        'created' => 0,
        'no_content' => 0,
        'fail' => -1,
        'unauthorized' => -2,
        'forbidden' => -2,
        'not_found' => -2,
        'validate_fail' => -2,
        'error' => -3,
    ],

    //默认返回信息，根据自己项目中的走，这里只是默认区分一下
    'message' => [
        'success' => '请求成功.',
        'created' => '操作成功.',
        'no_content' => '操作成功.',
        'fail' => '请求失败.',
        'unauthorized' => '未授权.',
        'forbidden' => '权限不足.',
        'not_found' => '资源不存在.',
        'validate_fail' => '验证失败.',
        'error' => '系统故障.',
    ]
];

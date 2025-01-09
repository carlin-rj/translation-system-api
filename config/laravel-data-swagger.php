<?php
return [
	'documentations' => [
		'default' => [
			//doc文档生成驼峰还是下划线
			'is_camel' => false,

			//对象属性是否是驼峰
			'object_is_camel' => false,

			// 新增响应格式配置
			'response_format' => [
				// 基础响应字段配置
				'base_properties' => [
					'state' => [
						'field' => 'state', // 实际返回的字段名
						'type' => 'string',
						'description' => 'response code',
						'example' => '000001'
					],
					'msg' => [
						'field' => 'msg',
						'type' => 'string',
						'description' => 'response message',
						'example' => 'success'
					],
					// 可以移除或添加字段
					'debug' => [
						'field' => 'debug',
						'type' => 'mixed',
						'description' => 'debug info',
						'example' => null
					],
					'request_id' => [
						'field' => 'request_id',
						'type' => 'string',
						'description' => 'request id',
						'example' => 'xxx-xxx-xxx'
					]
				],
				// 数据字段配置
				'data_field' => 'data',
			],
		],
	],
];

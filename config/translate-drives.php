<?php

use Carlin\TranslateDrives\Supports\Provider;

return [
	// 驱动
	'drives' => [
		// 免费版
		Provider::GOOGLE => [

		],
		Provider::BAIDU => [
			'app_id'  => env('BAIDU_TRANSLATE_APP_ID', ''),
			'app_key' => env('BAIDU_TRANSLATE_APP_KEY', ''),
		],
		Provider::ALIBABA_CLOUD => [
			'app_id'  => env('ALIBABA_CLOUD_TRANSLATE_APP_ID', ''),
			'app_key' => env('ALIBABA_CLOUD_TRANSLATE_APP_KEY', ''),
		],
	],
];

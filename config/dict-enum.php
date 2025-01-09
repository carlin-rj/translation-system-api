<?php
return [
	'store'=>env('DICT_ENUM_STORE', 'octane'),
	'cache-key'=>env('DICT_ENUM_CACHE_KEY', 'dict-cache-key'),
	'cache-ttl'=> (int)env('DICT_ENUM_CACHE_TTL', 60 * 60 * 24 * 30),
	'enum-scan-paths'=>[
        base_path('app/Enums/*.php'),
        base_path('Modules/*/app/Enums/*.php'),
	],
];

<?php


namespace App\Notifications\Sender;


use GuzzleHttp\Client;

class DingTalkMessageSender
{
	protected Client $client;
	protected array  $config;

	/** @var string 机器人地址 */
	protected string $hookUrl = "https://oapi.dingtalk.com/robot/send";

	/** @var string 机器人TOKEN */
	protected string $accessToken = "";

	public function __construct($config)
	{
		$this->config = $config;
		$this->setAccessToken();
		$this->client = $this->createClient();
	}

	/**  */
	public function setAccessToken()
	{
		$this->accessToken = $this->config['token'];
	}

	/**
	 * 实例化 GuzzleHttp 对象
	 * @return Client
	 */
	protected function createClient()
	{
		return new Client([
			'timeout' => $this->config['timeout'] ?? 2.0,
		]);
	}

	/**
	 * 发送短信
	 * @param array $params
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function send(array $params): array
	{
		$request = $this->client->post($this->getRobotUrl(), [
			'body'    => json_encode($params),
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'verify'  => $this->config['ssl_verify'] ?? false,
		]);

		$result = $request->getBody()->getContents();
		return json_decode($result, true) ?? [];
	}

	/**
	 * 生成机器人地址
	 * @return string
	 */
	public function getRobotUrl()
	{
		$query['access_token'] = $this->accessToken;
		//是否加密
		if (isset($this->config['secret']) && $secret = $this->config['secret']) {
			$timestamp          = time() . sprintf('%03d', random_int(1, 999));
			$sign               = hash_hmac('sha256', $timestamp . "\n" . $secret, $secret, true);
			$query['timestamp'] = $timestamp;
			$query['sign']      = base64_encode($sign);
		}
		return $this->hookUrl . "?" . http_build_query($query);
	}
}

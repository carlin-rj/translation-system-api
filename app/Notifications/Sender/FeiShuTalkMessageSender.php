<?php


namespace App\Notifications\Sender;


use GuzzleHttp\Client;

class FeiShuTalkMessageSender
{
	protected Client $client;
	protected array  $config;

	/** @var string 机器人地址 */
	protected string $hookUrl = "https://open.feishu.cn/open-apis/bot/v2/hook/";

	/** @var string 机器人TOKEN */
	protected string $accessToken = "";

	public function __construct($config)
	{
		$this->config = $config;
		$this->setAccessToken();
		$this->client = $this->createClient();
	}

	public function setAccessToken(): void
	{
		$this->accessToken = $this->config['token'];
	}

	/**
	 * 实例化 GuzzleHttp 对象
	 * @return Client
	 */
	protected function createClient(): Client
	{
		return new Client([
			'timeout' => $this->config['timeout'] ?? 2.0,
		]);
	}

	/**
	 * 发送短信
	 *
	 * @param array $params
	 * @return array
	 * @throws \JsonException
	 */
	public function send(array $params): array
	{
		try {
			$request = $this->client->post($this->getRobotUrl(), [
				'body'    => json_encode($params, JSON_THROW_ON_ERROR),
				'headers' => [
					'Content-Type' => 'application/json',
				],
				'verify'  => $this->config['ssl_verify'] ?? false,
			]);
			$result  = $request->getBody()->getContents();
		}
		catch (\Throwable $e) {
			return [];
		}
		return json_decode($result, true, 512, JSON_THROW_ON_ERROR) ?? [];
	}

	/**
	 * 生成机器人地址
	 * @return string
	 */
	public function getRobotUrl(): string
	{
		return $this->hookUrl . $this->accessToken;
	}
}

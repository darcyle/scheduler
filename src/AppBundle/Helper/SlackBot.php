<?php

namespace AppBundle\Helper;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class SlackBot {
	const BASE_API_URL = 'https://slack.com/api/';
	private $token;
	private $userName;
	public $lastHttpStatus = null;
	private $logger;

	public function __construct(LoggerInterface $logger, $token, $userName = null) {
		$this->logger = $logger;
		$this->token = $token;
		$this->userName = $userName;
	}

	public function setUsername($userName) {
		$this->userName = $userName;
	}

	public function api($method, $arguments = array()) {
		$url = self::BASE_API_URL . $method;

		$arguments['token'] = $this->token;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arguments));

		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);

		$this->logger->info($url);
		$this->logger->info(json_encode($arguments));

		$result = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$result = json_decode($result, true);

		if ($result === false) {
			return false;
		}

		if ($result['ok'] === true) {
			return $result;
		} else {
			return false;
		}
	}

	public function channelsList($excludeArchived = 1) {
		$result = $this->api('channels.list', array('exclude_archived' => $excludeArchived));
		$channels = false;		
		if ($result) {
			$channels = array();
			foreach($result['channels'] as $channel) {
				$channels[$channel['name']] = $channel;
			}
		}

		return $channels;
	}

	public function chatPostMessage($channel, $text, $iconEmoji = null) {
		$arguments = array(
			'channel' => $channel,
			'text' => $text,
			'as_user' => "false"
		);
		if (isset($this->userName)) {
			$arguments['username'] = $this->userName;
		}
		if ($iconEmoji !== null) {
			$arguments['icon_emoji'] = $iconEmoji;
		}
		$result = $this->api('chat.postMessage', $arguments);

		return $result;
	}
}
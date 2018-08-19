<?php
/**
 * Yandex Dictionary PHP
 *
 * @author Konstantin Bogomolov <bog.konstantin@gmail.com>
 * @link https://github.com/bogkonstantin/yandex-dictionary-api-php
 */
namespace Yandex;

class Dictionary
{
  const BASIC_URL = 'https://dictionary.yandex.net';
  const TYPE_XML = 'dicservice';
  const TYPE_JSON = 'dicservice.json';

  const METHOD_GET_LANGS = 'getLangs';
  const METHOD_LOOKUP = 'lookup';

  private $apiKey;
  private $type;
  private $translateFrom;
  private $translateTo;
  private $text;

  private $httpClient;

  public function __construct(string $apiKey)
  {
    $this->apiKey = $apiKey;
    $this->type = self::TYPE_JSON;
    $this->translateFrom = 'en';
    $this->translateTo = 'ru';
    $this->httpClient = new \GuzzleHttp\Client();
    $this->text = null;
  }


  public function lookup(string $text)
  {
    $this->text = $text;
    $url = $this->getUrl(self::METHOD_LOOKUP);
    return $this->request($url)->def;
  }

  public function getLangs()
  {
    $url = $this->getUrl(self::METHOD_GET_LANGS);
    return $this->request($url);
  }


  public function setType($type): void
  {
    if (!in_array($type, $this->getTypeList())) {
      throw new \http\Exception\InvalidArgumentException('Use class constants as response type');
    }
    $this->type = $type;
  }

  public function setTranslateFrom($translateFrom): void
  {
    $this->translateFrom = $translateFrom;
  }

  public function setTranslateTo($translateTo): void
  {
    $this->translateTo = $translateTo;
  }

  private function request(string $url)
  {
    $response = $this->httpClient->request('GET', $url);
    $body = $response->getBody();
    $content = $body->getContents();
    return json_decode($content);
  }

  private function getTypeList(): array
  {
    return [self::TYPE_XML, self::TYPE_JSON];
  }

  private function getType(): string
  {
    return $this->type;
  }

  public function getTranslateFrom(): string
  {
    return $this->translateFrom;
  }

  public function getTranslateTo(): string
  {
    return $this->translateTo;
  }

  private function getText(): string
  {
    return $this->text;
  }

  private function getApiKey(): string
  {
    return $this->apiKey;
  }

  private function getParams(string $method): array
  {
    switch ($method) {
      case self::METHOD_GET_LANGS:
        return [];
      case self::METHOD_LOOKUP:
        return $this->getLookupParams();
    }
  }

  private function getLookupParams(): array
  {
    return [
      'lang' => $this->getTranslateFrom() . '-' . $this->getTranslateTo(),
      'text' => $this->getText(),
    ];
  }

  private function getUrl(string $method): string
  {
    $params = http_build_query(array_merge(['key' => $this->getApiKey()], $this->getParams($method)));
    return self::BASIC_URL . '/api/v1/' . $this->getType() . '/' . $method . '?' . $params;
  }
}
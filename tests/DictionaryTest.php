<?php

use PHPUnit\Framework\TestCase;
use Yandex\Dictionary;

class DictionaryTest extends TestCase
{
  private $key = 'apiKey';

  public function testLookup()
  {
    $dictionary = new Dictionary($this->key);

    $dictionary->setTranslateFrom('en');
    $dictionary->setTranslateTo('ru');
    $translation = $dictionary->lookup('hello');
    $this->assertEquals('привет', $translation[0]->tr[0]->text);

    $dictionary->setTranslateFrom('ru');
    $dictionary->setTranslateTo('en');
    $translation = $dictionary->lookup('привет');
    $this->assertEquals('hi', $translation[0]->tr[0]->text);
  }

  public function testGetLangs()
  {
    $dictionary = new Dictionary($this->key);

    $langs = $dictionary->getLangs();
    $this->assertContains('en-ru', $langs);
  }
}

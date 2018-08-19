# Yandex dictionary api
## Description
Api contains two methods: get languages (getLangs) and lookup.  
To use it you need api key. You can get it here:  
https://tech.yandex.ru/dictionary/

## Installation
```
composer require bog/yandex-dictionary-api
```

## Usage  
Create object with Api Key as parameter.
```
$dictionary = new Dictionary('apiKey');
```
### Set output type
You can get respose as JSON (default) or XML.  
Output examples for both types:  
https://tech.yandex.ru/dictionary/doc/dg/reference/getLangs-docpage/  
https://tech.yandex.ru/dictionary/doc/dg/reference/lookup-docpage/  

```
// JSON output (default)
$dictionary->setType(Dictionary::TYPE_JSON);

// XML output
$dictionary->setType(Dictionary::TYPE_XML);

```
### Get available languages
```
$langs = $dictionary->getLangs();
```

### Lookup (translate)
Set languages ('en-ru' is default):
```
$dictionary->setTranslateFrom('en');
$dictionary->setTranslateTo('ru');
```
Lookup:
```
$translation = $dictionary->lookup('hello');
```
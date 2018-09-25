# Octopus Laravel Wrapper

## O que é?

O Octopus é uma aplicação _serverless_ que aceita, redistribui, lida com falhas e ajuda na prevenção e correção de problemas de comunicações feitas entre serviços web. Para mais informações, consulte a [documentação](https://documentation-octopus.wedeploy.io/).

O Octopus Laravel Wrapper é um componente que integra o Octopus no framework Laravel 5, disponibilizando uma classe auxiliadora para facilitar o trabalho de utilizar o Octopus.


### Versão

1.0.4

### Compatibility

O Octopus Laravel Wrapper foi testado apenas com o Laravel 5.5 ou superior. Não é garantida a compatibildade com versões anteriores, apesar de ser provavel que funcione com qualquer versão do Laravel 5.


## Instalação

Para instalar o Octopus Laravel Wrapper, você precisa do seguinte:
 - Laravel 5.5 ou superior
 - PHP 7.0.31 ou superior
 - Composer

A instalação é feita via Composer:
```
composer require unaspbr/laravel-octopus
```

## Configuração

Após a instalação, você deverá adicionar o ServiceProvider do Octopus à `array` **providers**, no arquivo `config/app.php` do Laravel, desta forma:

```php
unaspbr\OctopusServiceProvider::class,
```

Caso você queira expor o _wrapper_ para que não precise importar o namespace, adicione o seguinte valor à `array` **aliases**:

```php
'Octopus' => unaspbr\Octopus::class,
```

Por fim, para publicar o arquivo de configuração do Octopus, execute o comando:

 ```php 
 php artisan vendor:publish
 ```

No arquivo `config/octopus.php` gerado, mude o campo `OCTOPUS_API_KEY` da `array` para a API Key que você usará como autenticaçãod a API. Caso você não tenha uma API Key, entre em contato com algum administrador do Octopus.


## Usando o Wrapper

O _wrapper_ possui duas funções, `queue` e `send`, equivalentes aos _endpoints_ de mesmo nome no Octopus. Ambas podem ser usadas para enviar uma action única ou várias simultâneas, conforme os exempos abaixo. Ambas retornam uma `array` contendo o _status code_ e _message_ da resposta da requisição.

### Action única
```php
<?php

use unaspbr\Octopus;

$result = Octopus::queue('nome_da_action', [
	'param1' => 'valor',
	'param2' => 'valor',
]);

var_dump($result);
```

### Múltiplas actions

```php
<?php

use unaspbr\Octopus;

$result = Octopus::send([
	[
		'name' => 'nome_da_action',
		'params' => [
			'param1' => 'valor',
			'param2' => 'valor',
		],
	],
	[
		'name' => 'nome_da_outra_action',
		'params' => [
			'param3' => 'valor',
			'param4' => 'valor',
		],
	],
]);

var_dump($result);
```

## Licença

[GNU GENERAL PUBLIC LICENSE v3](https://www.gnu.org/licenses/gpl-3.0.pt-br.html)

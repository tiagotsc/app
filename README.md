# PASSO A PASSO PARA USO EM DOCKER: #

1 - Através do Powershell ou CMD, acesse a pasta do projeto (aonde esta o arquivo docker-compose.yaml), e executar o comando: docker-compose up --build -d

2- Para entrar no container execute: docker-compose exec php-fpm bash

3 - Já dentro do container execute o comando: composer install

4 - Dentro do container, execute o migrate para criar as tabelas: php artisan migrate

5 - Dentro do container, execute o seed para popular o banco: php artisan db:seed

6 - Dentro do container, dê permissão a pasta storage: chmod -R 777 storage/

7 - Dentro do container, caso queira rodar testes da carteira, execute: ./vendor/bin/phpunit --group wallet

## Acesso ao Banco MySQL:

- Host: IP_SUA_MAQUINA_DOCKER
- Usuário: app
- Senha: app
- Banco de dado: app

## Usuário da aplicação cadastrado no banco:

- Login: admin (Usuário admin do tipo comum)
- Senha: admin
- API Token: stcNdoonMY3jxPf6nIQCvBwTmCKPr2ypGA0U6KgzN7AkATXxisyw13nNpqlD
_________________________________________________________________________

- Login: diego (Usuário do tipo comum)
- Senha: diego
- API Token: $2y$10$M6EkjDstqM9pQT4l2OyujenbtEUNO0BV4dch6zb5/L2AcaaNOM38W
_________________________________________________________________________

- Login: nanotech (Usuário do tipo logista)
- Senha: nanotech 
- API Token: vkzAF6aZM8bOhiF0Un6nH6SviNCQrsTUEbWKrlziDLS8GrzD3HeBeIrIkrXT

## Para acessar o front-end da aplicação, acesse no navegador:

http://IP_SUA_MAQUINA_DOCKER

Na tela de login, logue com algum dos usuários informados acima

## Métodos disponíveis da API de transação e seus respectivos exemplos de uso:

### - Listando carteira do usuário Diego: ###
	- URL: http://IP_SUA_MAQUINA_DOCKER/api/wallet/data
	- Authorization: Bearer Token $2y$10$M6EkjDstqM9pQT4l2OyujenbtEUNO0BV4dch6zb5/L2AcaaNOM38W
	- Método: GET
	- Header: [{"key":"Content-Type","value":"application/json"]

### - Usuário Diego enviando dinheiro para logista NanoTech: ### 
	- URL: http://IP_SUA_MAQUINA_DOCKER/api/wallet/money/send/2
	- Authorization: Bearer Token $2y$10$M6EkjDstqM9pQT4l2OyujenbtEUNO0BV4dch6zb5/L2AcaaNOM38W
	- Método: PUT
	- Header: [{"key":"Content-Type","value":"application/json"]
	- Body raw: { "transfer": "10", "destiny": 3 }

###  - Listando transações do usuário Diego: ### 
	- URL: http://IP_SUA_MAQUINA_DOCKER/api/wallet/transactions
	- Authorization: Bearer Token $2y$10$M6EkjDstqM9pQT4l2OyujenbtEUNO0BV4dch6zb5/L2AcaaNOM38W
	- Método: GET
	- Header: [{"key":"Content-Type","value":"application/json"]

# PASSO A PASSO EM SERVIDOR INTERNO PHP ARTISAN #

1 - Acessa a pasta do projeto chamada api e abra o arquivo .env

	Altere os dados da seguinte parte para os dados de acesso do seu ambiente e salve:

		DB_CONNECTION=mysql
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=app
		DB_USERNAME=app
		DB_PASSWORD=app

2 - Dentro da pasta app rode o comando: composer install

3 - Dentro da pasta app, executar o migrate para criar as tabelas: php artisan migrate

4 - Executar o seed para popular o banco: php artisan db:seed

5 - Através do Powershell ou CMD, acesse a pasta do projeto chamada app, e executar o comando: php artisan serve

6 - No navegador acesse: http://127.0.0.1:8000

7 - Logue com o usuário

	- Login: diego
	- Senha: diego
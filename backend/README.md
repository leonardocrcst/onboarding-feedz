# Blog super simples com Slim Framework 3 e Eloquent

Esse blog foi escrito para demonstrar o uso do Slim Framework 3 com Eloquent.

## Rodar a aplicação

Para rodar o container da aplicação, basta clonar o projeto e rodar o seguinte comando na raíz

    docker compose up -d

## Rodando os testes

Os testes são executados em um ambiente separado, na base de dados `onboarding_test`. Execute a cadeia de comandos abaixo para criar rodar os testes

Iniciar a base de testes

    vendor/bin/phoenix --config=src/phoenix.php --environment=test init
    vendor/bin/phoenix --config=src/phoenix.php --environment=test migrate

Rodar a suíte de testes unitários e de integração (com code coverage)
    
    php -d xdebug.mode=coverage vendor/phpunit/phpunit/phpunit -d memory_limit=-1

Remover a base de dados (ao final dos testes)

    vendor/bin/phoenix --config=src/phoenix.php --environment=test cleanup
# Back Transaction

Este projeto é uma implementação de um aplicativo de transações bancárias com uma arquitetura em camadas, projetada seguindo os princípios SOLID. Essa abordagem visa garantir clareza, manutenibilidade e escalabilidade do sistema, tornando-o mais organizado e fácil de entender e modificar no futuro


## Estrutura do Projeto

O projeto está estruturado da seguinte forma:

- **src/**: Contém o código-fonte da aplicação.
    - **app/**: Onde reside a lógica da aplicação.
        - **Exceptions/**: Classes de exceção personalizadas.
        - **Http/**: Controladores e middlewares HTTP.
            - **Middleware/**: Middlewares da aplicação.
            - **Controllers/**: Controladores da API REST.
        - **Models/**: Modelos de dados da aplicação.
        - **Providers/**: Provedores de serviços da aplicação.
        - **Infrastructure/**: Código relacionado à infraestrutura da aplicação.
            - **Repositories/**: Implementações dos repositórios de dados.
            - **Adapters/**: Adaptadores para integrações externas, como autorização e notificação.
    - **core/**: Contém a lógica de negócios da aplicação.
        - **Domain/**: Classes de domínio contendo entidades, repositórios e serviços.
        - **Application/**: Casos de uso da aplicação, organizados por contexto.
- **database/**: Contém migrações e sementes para o banco de dados.
- **routes/**: Definições de rotas da aplicação.
- **tests/**: Testes automatizados.
- **.env.example**: Modelo de arquivo de configuração de ambiente. Deve ser copiado e renomeado para `.env`, contendo as configurações específicas do ambiente.

## Tecnologias Utilizadas

- **PHP 8.2+**: Linguagem de programação principal.
- **Lumen**: Framework PHP para criação de APIs.
- **Docker / Docker Compose**: Utilizados para encapsular a aplicação e suas dependências em contêineres isolados.
- **MySQL**: Banco de dados utilizado para armazenar os dados da aplicação.

## Componentes chave:

- Design orientado a domínio (DDD) para uma clara separação de interesses.
- Princípios SOLID para código sustentável, testável e escalável.
- Arquitetura em camadas para flexibilidade e testabilidade.
- Injeção de dependência para componentes fracamente acoplados.
- Docker para ambientes de desenvolvimento.

## Plugin Utilizado

- **SwaggerLume**: Gera documentação da API. Saiba mais em: [SwaggerLume](https://github.com/DarkaOnLine/SwaggerLume)

## Como Rodar Utilizando o Docker

Para executar a aplicação localmente, siga os passos abaixo:

1. Clone este repositório.
2. Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente necessárias, especialmente as relacionadas ao banco de dados.
3. Execute `docker-compose up` para iniciar os contêineres Docker.
4. Execute as migrações do banco de dados utilizando o comando `docker-compose exec app php artisan migrate`.
5. Acesse a aplicação em `http://localhost:8000`.
6. Acesse a documentação da API em `http://localhost:8000/api/documentation`.

## Como executar com PHP

Para executar a aplicação localmente, siga os passos abaixo:

1. Clone este repositório.
2. Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente necessárias, especialmente aquelas relacionadas ao banco de dados.
3. Acesse a pasta `src` e execute o comando `composer install`.
4. Ainda na pasta `src`, abra o terminal e execute `php artisan migrate`.
5. Execute a aplicação digitando `php -S 127.0.0.1 -t public` no terminal.
6. Acesse a aplicação em `http://localhost:8000`.
7. Consulte a documentação da API em `http://localhost:8000/api/documentation`.
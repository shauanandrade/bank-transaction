# Back Transaction

Este projeto implementa um aplicativo de transação bancária com uma arquitetura em camadas, seguindo os princípios SOLID para clareza, manutenabilidade e escalabilidade.

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
- **Lumen**: Framework PHP para criação de APIs e microserviços.
- **Docker / Docker Compose**: Utilizados para encapsular a aplicação e suas dependências em contêineres isolados.
- **MySQL**: Banco de dados utilizado para armazenar os dados da aplicação.
  Claro, aqui está uma versão mais simples:
- **SwaggerLume**: Gera automaticamente a documentação da sua API. Saiba mais em: [SwaggerLume](https://github.com/DarkaOnLine/SwaggerLume)

## Componentes chave:

- Design orientado a domínio (DDD) para uma clara separação de interesses.
- Princípios SOLID para código sustentável, testável e escalável.
- Arquitetura em camadas para flexibilidade e testabilidade.
- Injeção de dependência para componentes fracamente acoplados.
- Docker para ambientes de desenvolvimento e deploy consistentes.

## Como Rodar

Para executar a aplicação localmente, siga os passos abaixo:

1. Clone este repositório.
2. Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente necessárias, especialmente as relacionadas ao banco de dados.
3. Execute `docker-compose up` para iniciar os contêineres Docker.
4. Execute as migrações do banco de dados utilizando o comando `docker-compose exec app php artisan migrate`.
5. Acesse a aplicação em `http://localhost:8000`.

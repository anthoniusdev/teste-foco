Olá, meu nome é Anthonius Miguel Vaz Figueiredo Souza, tenho 20 anos e sou estudante de Análise e Desenvolvimento de Sistemas no IFBAIANO - Campus Gunamabi.
Além de estudante, sou uma pessoa que busca constantemente evolução, tanto como desenvolvedor de software, quanto como pessoa.
Decidi me dedicar e participar desse processo seletivo, pois tenho ciencia de que a Foco é uma excelente empresa que assim como eu, está sempre buscando evoluir.
Abaixo deixo minhas redes sociais para mantermos contato:

[![LinkedIn](https://img.shields.io/badge/LinkedIn-0e76a8?style=flat-square&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/anthonius-souza)
[![Gmail](https://img.shields.io/badge/Gmail-ea4335?style=flat-square&logo=gmail&logoColor=white)](mailto:anthoniusmiguel@gmail.com)
[![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/anthoniusdev)


# Projeto de Teste para Integração ao Time da Foco Tecnologia & Marketing

Este projeto é uma API RESTful desenvolvida em Laravel que atende a um teste técnico para a integração ao time de desenvolvedores da Foco Tecnologia & Marketing. O projeto inclui funcionalidades de CRUD para quartos e um endpoint que aceita o método POST para reservas, além de importação de dados XML e execução via Docker.

## Visão Geral

A API foi projetada para gerenciar acomodações, permitir a reserva de quartos, e incluir funcionalidades de importação de dados XML via um script Laravel. Também foi implementado suporte para descontos em reservas e verificação de disponibilidade de quartos.

### Funcionalidades
1. **Documentação**: Documentação da API gerada com Swagger/OpenAPI 3.0.
2. **Modelagem de Dados**: A modelagem dos dados foi realizada por meio de migrations no Laravel, utilizando como base os XMLs disponibilizados, com algumas alterações para acomodar as funcionalidades adicionais.
3. **Importação de Dados XML**: Script para importação de dados XML e persistência no banco de dados, acionado via Eloquent Laravel.
4. **CRUD de Quartos/Acomodações**: API RESTful para gerenciar quartos.
5. **POST de Reservas**: API RESTful para criar reservas, considerando disponibilidade e aplicação de descontos.
6. **Padrões de Projeto**: Implementação seguindo boas práticas de design e padrões REST.
7. **Containerização com Docker**: O projeto é executado em contêineres Docker, facilitando a configuração, a execução para testes e o deployment.

## Tecnologias Utilizadas

- **PHP** (Laravel)
- **MySQL**
- **Docker**
- **Composer**
- **Swagger/OpenAPI 3.0**

## Como Configurar o Projeto

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/anthoniusdev/teste-foco
   cd teste-foco
2. **Configure o Docker**: 
Certifique-se de ter o Docker e o Docker Compose instalados na sua máquina. Caso não os tenha, segue links para ajudar na instalação:

    **Linux**:
    - https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-pt
    - https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04-pt
    
    **Windows**:
    - https://docs.docker.com/desktop/install/windows-install/
    
    **Mac**:
    - https://docs.docker.com/desktop/install/mac-install/

3. **Instale as dependências**:
   ```bash
   composer install

4. **Configure as variáveis de ambiente**:
    - Copie o arquivo ```.env.example``` para ```.env```. Em seguida abra o arquivo `.env` em um editor de texto de sua preferência e substitua as variáveis existentes pelos valores abaixo:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=testefoco
    DB_USERNAME=testefoco
    DB_PASSWORD=testefoco
    ```
    - Certifique-se de que as credenciais e nome do banco de dados estejam exatamente como acima.
    - Obs.: Caso queira modificar o valor de alguma variável acima, será necessário abrir o arquivo `docker-compose.yml` e modificar os valores lá também. Porém, para o funcionamento perfeito da API, não recomendo.


5. **Inicie o Projeto com Docker**:
    Para iniciar o projeto, execute o seguinte comando:
     ```bash
     docker-compose up --build
     ```
    Se desejar executar o Docker em segundo plano e liberar o terminal, utilize o comando:
     ```bash
     docker-compose up --build -d
     ```
   - O flag `-d` (detached mode) permite que os contêineres sejam executados em segundo plano, liberando o terminal para outras operações.

    ###### ⚠️ Importante:
    A importação dos dados é realizada automaticamente ao iniciar o contêiner Docker, eliminando a necessidade de configurar o CRON, assim simplificando o processo.

6. **Acesse a API**:
   Com o contêiner em correto funcionamento, a aplicação Laravel que contém a API estará disponível na seguinte URL:
   ```http://127.0.0.1:8000```

7. **Acesse a documentação da API**:
   A documentação da API pode ser acessada em ```http://localhost:8000/api/documentation``` após a inicialização do projeto. OpenAPI 3.0 foi utilizado para fornecer uma visão abrangente dos endpoints disponíveis.

## Exemplo de cabeçalho de requisições
Para todas as requisições da API, é imprescindível incluir o cabeçalho `Accept` com o valor `application/json`. Isso garante que a API responda no formato JSON, que é o esperado para o correto funcionamento do CRUD de Quartos e POST de reservas.
```http
Accept: application/json
```

## Como executar o CRUD de Quartos
Para gerenciar quartos, você pode realizar operações de CRUD (Criar, Ler, Atualizar, Deletar) utilizando os seguintes endpoints. É importante observar que, embora esta seção forneça um guia sobre como realizar essas operações, recomendo consultar a documentação gerada com OpenAPI para obter uma visão mais detalhada e abrangente de todos os endpoints disponíveis e suas especificações.

### Valores fictícios:
Todos os valores inseridos no corpo das requisições abaixos são apenas para fins demonstrativos.
###### Listar todos os quartos:
```http
    GET http://127.0.0.1:8000/api/rooms
```
###### Listar um quarto específico:
*É necessário inserir o id do quarto que deseja listar*   
```http
    GET http://127.0.0.1:8000/api/room/{id}
```
###### Criar um quarto:
```http
    POST http://127.0.0.1:8000/api/room
```
- Corpo da requisição:
```body
    {
        "Name": "Room 3 Hotel 1",
        "hotelCode": 1
    }
```
##### Atualizar um quarto:
*É necessário inserir o id do quarto que deseja atualizar:*
```http
    PUT http://127.0.0.1:8000/api/room/{id}
```
- Corpo da requisição:
```body
    {
        "Name": "Room 39 Hotel 12",
        "hotelCode": 12
    }
```
##### Atualizar um ou mais atributos específicos de um quarto:
*É necessário inserir o id do quarto que deseja atualizar:*
```http
    PATCH http://127.0.0.1:8000/api/room/{id}
```
- Corpo da requisição:
```body
    {
        "Name": "Room 39 Hotel 12",
        "hotelCode": 12
    }
```
##### Deletar um quarto:
*É necessário inserir o id do quarto que deseja deletar:*
```http
    DELETE http://127.0.0.1:8000/api/room/{id}
```
## Como realizar Reservas
##### Criar uma reserva:
```http
    POST http://127.0.0.1:8000/api/reserve
```
- Corpo da requisição:
```body
{
    "CheckIn": "2024-11-04",
    "CheckOut": "2024-11-04",
    "hotelCode": 12,
    "roomCode": 101,
    "dailyValue": 150.00,
    "guestName": "Anthonius",
    "guestLastName": "Souza",
    "guestPhone": "5577999255474",
    "paymentMethod": 1,
    "paymentValue": 150.00
}
```
Os campos `paymentMethod` e `paymentValue` são opcionais. No caso de serem incluídos na requisição, a reserva será automaticamente registrada como paga.
#### Considerações de Disponibilidade e Descontos
- A API verifica automaticamente a disponibilidade dos quartos antes de confirmar uma reserva.
- Descontos podem ser aplicados por meio de cupons e promoções especificadas no banco de dados.


## Versionamento do Código
Todo o código fonte deste projeto está versionado no GitHub.
Neste repositório, você encontrará:

- O código fonte completo da API RESTful.
- Um histórico de alterações detalhado.
- Instruções para contribuir com o projeto, caso deseje.
- Problemas conhecidos e melhorias planejadas.
  
## Agradecimentos
Gostaria de expressar minha sincera gratidão à empresa Foco pela oportunidade de participar deste teste técnico e pela confiança depositada em meu trabalho. Foi muito bacana desenvolver uma API em laravel sabendo que esta serviria para uma avaliação de vaga de emprego. Embora já tivesse trabalhado com laravel para construir uma API em outra oportunidade, desta vez foi bem diferente, o cuidado com a documentação, com o versionamento do código, isso me mostrou ser algo com que eu quero trabalhar.
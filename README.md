# Sistema de Leilão em PHP
Este repositório contém o código-fonte de um sistema de leilão implementado em PHP, composto por quatro classes principais: ```Leilao```, ```Leiloeiro```, ```Usuario```, ```Lance``` e ```Produto```. O objetivo deste projeto é criar a lógica de um leilão, permitindo que usuários façam lances em produtos específicos.

## Estrutura do Projeto
- ### app/: Contém as classes principais do sistema.
  - **Leilao.php**: Definição da classe Leilao.
  - **Leiloeiro.php**: Definição da classe Leiloeiro.
  - **Usuario.php**: Definição da classe Usuario.
  - **Lance.php**: Definição da classe Lance.
  - **Produto.php**: Definição da classe Produto.
- ### tests/: Contém os testes unitários desenvolvidos com PHPUnit.
  - **LeilaoTest.php**: Testes para a classe Leilao.
  - **LeiloeiroTest.php**: Testes para a classe Leiloeiro.
  - **UsuarioTest.php**: Testes para a classe Usuario.
  - **LanceTest.php**: Testes para a classe Lance.
  - **ProdutoTest.php**: Testes para a classe Produto.

## Funcionalidades Principais
### 1. Leilao
A classe Leilao representa um leilão e possui métodos para adicionar produtos, receber lances, encerrar o leilão e obter o vencedor.

### 2. Leiloeiro
A classe Leiloeiro é responsável por conduzir o leilão, controlando o andamento do processo, validando lances e determinando o vencedor.

### 3. Usuario
A classe Usuario representa um participante do leilão, com a capacidade de fazer lances nos produtos.

### 4. Lance
A classe Lance modela um lance feito por um usuário em um determinado produto durante o leilão.

### 5. Produto
A classe Produto representa um item específico a ser leiloado, contendo informações como descrição e lance inicial.

## Como Executar os Testes
Certifique-se de ter o PHPUnit instalado em sua máquina. Execute os testes usando o seguinte comando:

```
phpunit tests/
```
Os testes serão executados, e os resultados serão exibidos no terminal.

## Contribuições
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests para melhorar este projeto.

## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 🌐 PHP Pure RESTful API Client (PDO & HTTP Methods)

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/php-rest-api?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/php-rest-api?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/php-rest-api)

Este projeto é um passo fundamental para entender a arquitetura REST. Ele foca na criação de uma API backend limpa e sem *frameworks*, gerenciando recursos (livros) através dos verbos HTTP padrões (GET, POST, PUT, DELETE).

---

## 🚀 Arquitetura REST e Recursos

* **Roteamento Manual:** O arquivo `src/api.php` atua como um roteador que analisa o método HTTP (`$_SERVER['REQUEST_METHOD']`) e o parâmetro da URL (`$_GET['id']`) para determinar qual ação CRUD deve ser executada.
* **Dados JSON:** A API recebe (`POST`, `PUT`) e envia (`GET`, `POST`, `PUT`) dados exclusivamente no formato JSON, usando `file_get_contents('php://input')` para ler o corpo da requisição.
* **Códigos de Status:** Utiliza códigos de status HTTP padrão (e.g., `200 OK`, `201 Created`, `204 No Content`, `400 Bad Request`, `404 Not Found`) para indicar o resultado da operação.
* **POO com PDO:** As classes `Database` e `BookController` isolam a lógica de conexão e interação com o banco de dados SQLite.

---

## 🧠 Tecnologias utilizadas

* **Backend:** PHP 7.4+ (POO, Headers HTTP, Manipulação de JSON).
* **Banco de Dados:** SQLite (via PDO) para persistência.
* **Frontend/Teste:** JavaScript Vanilla (`fetch` API) para simular um cliente consumindo a API.

---

## 🧩 Estrutura do Projeto

```
php-rest-api/
├── index.html
├── Database.php
├── BookController.php
├── api.php
└── books.sqlite
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.
2.  Extensão PDO SQLite habilitada.
3.  Permissão de escrita na pasta `src/` para a criação do arquivo `books.sqlite`.

### Execução

1.  Crie a estrutura de pastas.
2.  Execute o servidor embutido do PHP (a partir da raiz do projeto):

    ```bash
    php -S localhost:8001
    ```

3.  Acesse o painel de testes: `http://localhost:8001/public/index.html`.

---

## 📝 Teste da API

Use o painel de testes (`index.html`) e o Console do Desenvolvedor (F12) para validar cada operação:

| Método | URL | Ação | Expectativa |
| :--- | :--- | :--- | :--- |
| **GET** | `/src/api.php` | Lista todos. | Retorna `200 OK` e um array de livros. |
| **POST** | `/src/api.php` | Cria um novo livro. | Retorna `201 Created` e o objeto do livro criado. |
| **GET** | `/src/api.php?id=X` | Busca um único livro. | Retorna `200 OK` ou `404 Not Found`. |
| **PUT** | `/src/api.php?id=X` | Atualiza campos. | Retorna `200 OK` e o objeto atualizado. |
| **DELETE**| `/src/api.php?id=X` | Exclui o recurso. | Retorna `204 No Content` (corpo da resposta vazio). |

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/php-rest-api/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/php-rest-api/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---

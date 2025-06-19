
# 🌍 API de Turismo

Esta é uma API RESTful desenvolvida em **PHP com MySQL**, que permite o gerenciamento de informações turísticas como pontos turísticos, categorias, cidades, avaliações . Ideal para uso em sistemas web e aplicativos voltados ao turismo regional ou nacional.



## 🚀 Funcionalidades

- 🔹 Cadastro e listagem de **pontos turísticos**
- 🏙️ Gerenciamento de **cidades** e **categorias**
- ⭐ Avaliação de pontos turísticos (nota e comentário)
- 
- 📍 Filtros por cidade, categoria, mais bem avaliados, etc.


## 📁 Estrutura de Pastas

# **API de Turismo - Documentação**

Este projeto é uma **API de gerenciamento de pontos turísticos**, desenvolvida em **PHP** com banco de dados **MySQL**, seguindo o padrão **MVC (Model-View-Controller)**. Ele permite cadastrar, listar, editar e excluir cidades, categorias e pontos turísticos.

---

## **📌 Sumário**
1. [Funcionalidades](#-funcionalidades)
2. [Estrutura do Projeto](#-estrutura-do-projeto)
3. [Tecnologias Utilizadas](#-tecnologias-utilizadas)
4. [Configuração do Ambiente](#-configuração-do-ambiente)
5. [Rotas da API](#-rotas-da-api)
6. [Banco de Dados](#-banco-de-dados)
7. [Front-end](#-front-end)
8. [Contribuição](#-contribuição)
9. [Licença](#-licença)

---

## **✨ Funcionalidades**
✅ **Cidades**  
- Cadastrar, editar, listar e excluir cidades  

✅ **Categorias**  
- Cadastrar, editar, listar e excluir categorias de pontos turísticos  

✅ **Pontos Turísticos**  
- Cadastrar, editar, listar e excluir pontos turísticos  
- Relacionamento com cidades e categorias  
- Filtros por nome, cidade e categoria  

✅ **Front-end Responsivo**  
- Interface administrativa com Bootstrap 5  
- Formulários validados  

---

## **📂 Estrutura do Projeto**
```
turismo-api/
│
├── /includes/
│   ├── config.php
│   └── funcoes.php
│
├── /pontos/
│   ├── listar.php       # Lista todos (com links para editar/excluir)
│   ├── detalhes.php     # Visualização detalhada
│   ├── cadastrar.php    # Formulário de cadastro
│   ├── editar.php       # Formulário de edição
│   └── excluir.php      # Processa exclusão
│
├── /cidades/
│   ├── listar.php
│   └── cadastrar.php
│
├── /categorias/
│   ├── listar.php
│   └── cadastrar.php
│
└── index.php            # Dashboard principal com navegação, essa e a base de dados           
  # Script SQL do banco de dados
```

---

## **🛠 Tecnologias Utilizadas**
| Tecnologia       | Descrição                     |
|------------------|-------------------------------|
| **PHP**          | Back-end da API               |
| **MySQL**        | Banco de dados relacional     |
| **Bootstrap 5**  | Front-end responsivo          |
| **JavaScript**   | Validações e interações       |
| **HTML/CSS**     | Estrutura e estilização       |



## **⚙ Configuração do Ambiente**
### **Pré-requisitos**
- Servidor web (Apache, Nginx)
- PHP 8.0+
- MySQL 5.7+



## **🎨 Front-end**
### **Principais Componentes**
- **Navbar:** Navegação entre páginas  
- **Formulários:** Validação em tempo real  
- **Tabelas:** Listagem com paginação (opcional)  
- **Alertas:** Mensagens de sucesso/erro  

### **Tecnologias Front-end**
- **Bootstrap 5** (design responsivo)  
- **JavaScript** (validações e interações)  
- **Bootstrap Icons** (ícones modernos)  

###**💡 Back-End e Endpoints**
##**sem hospedagem**
-**pontos**
GET http://localhost/turismo_api/api/routes/pontos/listar.php → Lista os pontos turísticos
POST http://localhost/turismo_api/api/routes/pontos/cadastrar.php → Cadastra um novo ponto
GET http://localhost/turismo_api/api/routes/pontos/editar.php?id=1 → Busca ponto para editar
DELETE http://localhost/turismo_api/api/routes/pontos/excluir.php?id=1 → Exclui um ponto
http://localhost/turismo_api/api/routes/pontos/detalhes.php?id=1-> Detalhes do ponto


-**categorias**
GET http://localhost/turismo_api/api/routes/categorias/listar.php → Lista categorias
POST http://localhost/turismo_api/api/routes/categorias/cadastrar.php → Cadastra uma nova categoria
GET http://localhost/turismo_api/api/routes/categorias/editar.php?id=1 → Busca categoria para editar
DELETE http://localhost/turismo_api/api/routes/categorias/excluir.php?id=1 → Exclui um categoria

-**cidades**
GET http://localhost/turismo_api/api/routes/cidades/listar.php → Lista cidades
POST http://localhost/turismo_api/api/routes/cidades/cadastrar.php → Cadastra uma nova cidade
GET http://localhost/turismo_api/api/routes/cidades/editar.php?id=1 → Busca cidade para editar
DELETE http://localhost/turismo_api/api/routes/cidades/excluir.php?id=1 → Exclui uma cidade

**com hospedagem**
Ação	                     Endpoint
🔹 Listar cidades-> https://api-turismo.free.nf/api/routes/cidades.php
🔹 Obter cidade por ID->	https://api-turismo.free.nf/api/routes/cidades.php?id=1
🔹 Listar categorias->	https://api-turismo.free.nf/api/routes/categorias.php
🔹 Obter categoria por ID->	https://api-turismo.free.nf/api/routes/categorias.php?id=2
🔹 Listar pontos turísticos->	https://api-turismo.free.nf/api/routes/pontos.php
🔹 Obter ponto por ID-> https://api-turismo.free.nf/api/routes/pontos.php?id=3




**Desenvolvido por** : Julieta Sequeta e Silvestre Quintas
🌐 **GitHub:** https://github.com/Julietadealmeida/api-turismos.git
**Link para hospedagem:**[api](https://api-turismo.free.nf/)
---

**🎉 Pronto para começar?** Clone o repositório e explore a API de turismo! 🚀
>>>>>>> 86de4f5 (Atualizações no projeto)

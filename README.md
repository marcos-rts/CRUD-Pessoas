# Sistema de Gestão de Colaboradores para RH

![Sistema de RH](https://img.shields.io/badge/Status-Funcionando-green)
![Tecnologias](https://img.shields.io/badge/Tecnologias-HTML%2C%20CSS%2C%20JavaScript%2C%20PHP%2C%20MySQL-blue)

Sistema CRUD completo para gerenciamento de colaboradores em departamentos de Recursos Humanos.

## 📌 Visão Geral

Este sistema foi desenvolvido para auxiliar departamentos de RH no gerenciamento eficiente de informações dos colaboradores, oferecendo todas as operações básicas de um CRUD (Create, Read, Update, Delete) com interface intuitiva e responsiva.

## ✨ Funcionalidades

- **Cadastro completo de colaboradores** com todos os dados relevantes
- **Visualização organizada** dos registros em tabela
- **Filtros dinâmicos** para rápida localização
- **Edição simplificada** de informações
- **Exclusão segura** com confirmação
- **Interface responsiva** que se adapta a diferentes dispositivos
- **Feedback visual** para todas as operações

## 🛠️ Tecnologias Utilizadas

- **Frontend**:
  - HTML5
  - CSS3 (com Bootstrap 5)
  - JavaScript (com jQuery)

- **Backend**:
  - PHP (PDO para conexão com banco de dados)
  - MySQL

## 📦 Instalação

1. **Pré-requisitos**:
   - Servidor web (Apache, Nginx)
   - PHP 7.4 ou superior
   - MySQL 5.7 ou superior

2. **Configuração do banco de dados**:
   ```sql
   CREATE DATABASE rh_system;
   USE rh_system;

   CREATE TABLE colaboradores (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(100) NOT NULL,
       cpf VARCHAR(14) UNIQUE NOT NULL,
       data_nascimento DATE NOT NULL,
       email VARCHAR(100) NOT NULL,
       telefone VARCHAR(15) NOT NULL,
       cargo VARCHAR(50) NOT NULL,
       departamento VARCHAR(50) NOT NULL,
       data_admissao DATE NOT NULL,
       salario DECIMAL(10,2) NOT NULL,
       endereco TEXT NOT NULL,
       ativo BOOLEAN DEFAULT TRUE,
       data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

3. **Configuração da aplicação**:
   - Edite o arquivo `conexao.php` com as credenciais do seu banco de dados
   ```php
   $host = 'localhost';
   $dbname = 'rh_system';
   $username = 'seu_usuario';
   $password = 'sua_senha';
   ```

4. **Estrutura de arquivos**:
   ```
   /sistema-rh/
   ├── conexao.php         # Configuração do banco de dados
   ├── funcoes.php        # Funções auxiliares
   ├── index.php          # Página principal
   ├── processar.php      # Processamento dos formulários
   ├── scripts.js         # JavaScript da aplicação
   └── styles.css         # Estilos CSS
   ```

## 🚀 Como Usar

1. Acesse o sistema através do arquivo `index.php`
2. Utilize o menu lateral para navegação
3. Para adicionar um novo colaborador, clique no botão "Adicionar Colaborador"
4. Para visualizar detalhes, clique no ícone de olho (👁️) na linha do colaborador
5. Para editar, clique no ícone de lápis (✏️)
6. Para excluir, clique no ícone de lixeira (🗑️)

## 📷 Screenshots

![Tela Principal](screenshots/Tela%20principal%20com%20lista%20de%20colaboradores.png)
*Tela principal com lista de colaboradores*

![Modal de Cadastro](screenshots/Modal%20para%20adicionar%20novo%20colaborador.png)
*Modal para adicionar novo colaborador*

## 📄 Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## ✉️ Contato

Para dúvidas ou sugestões, entre em contato:

- Email: marcosreis.santos384@outlook.com.br
- GitHub: [Marcos-rts](https://github.com/marcos-rts)

---

Desenvolvido com ❤️ para departamentos de RH

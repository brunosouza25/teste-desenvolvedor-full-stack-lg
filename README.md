# Teste Desenvolvedor Full Stack - LG

Este projeto é uma aplicação Laravel containerizada com Docker, preparada para rodar de forma rápida e padronizada em qualquer ambiente.

---

## Tecnologias utilizadas

- PHP (Laravel 7)
- Docker / Docker Compose
- MySQL
- Composer

---

## Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- Docker
- Docker Compose

---

## 🛠Setup do projeto

Siga os passos abaixo para rodar o projeto localmente:

```bash
# Clonar o repositório
git clone https://github.com/brunosouza25/teste-desenvolvedor-full-stack-lg.git

# Acessar a pasta do projeto
cd teste-desenvolvedor-full-stack-lg

# Subir os containers
docker compose up -d --build

# Copiar arquivo de ambiente
cp .env.example .env

# Instalar dependências do PHP
docker compose exec app composer install

# Gerar chave da aplicação
docker compose exec app php artisan key:generate

# Rodar migrations + seeders
docker compose exec app php artisan migrate --seed
```

## Permissões (IMPORTANTE)

Caso ocorra erro de permissão nas pastas de cache/logs, execute:
```bash
docker compose exec app chown -R www:www storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

## ⚠Configuração de portas e rede

Para evitar conflitos com serviços locais já existentes (como MySQL, Nginx, etc.), as portas padrão foram alteradas neste projeto.

### Portas utilizadas

- Aplicação (Nginx):  
  `http://localhost:8077`

- Banco de dados (MySQL):  
  `localhost:3325`

---

## 🛠Ajustando portas (caso necessário)

Se houver conflito de portas na sua máquina, você pode alterá-las diretamente no arquivo:

```bash
docker-compose.yml
nginx:
  ports:
    - "8077:80"
    #Altere a porta 8077 para outra disponível na sua máquina.
    db:
  ports:
    - "3325:3306"
    #Altere a porta 3325 para outra disponível na sua máquina.

```
## Host da aplicação

A aplicação estará disponível em:

http://localhost:8077

## Rede Docker

O projeto utiliza uma rede isolada para comunicação entre containers:
```bash
networks:
projeto-full-stack-bruno-souza-network:
driver: bridge
```


## Evoluções Futuras & Roadmap

Melhorias Futuras (Roadmap)
Se este projeto fosse para um ambiente de produção real, estas seriam as evoluções planejadas:

1. Modernização das Tecnologias
   Laravel 13 + PHP 8.5: Atualizar para as versões mais recentes para ganhar performance e usar as novas funções de tipagem do PHP.

Frontend Reativo: Usar Vue 3 com Inertia.js para transformar a aplicação em um SPA, ou criar uma API REST completa para atender mobile e web.

2. Organização e Arquitetura
   Services e Actions: Tirar a lógica de negócio dos Controllers e mover para classes específicas (Actions/Services), deixando o código mais limpo e fácil de testar.

Arquitetura por Domínios (DDD): Organizar o código por módulos (Qualidade, Produção, etc.) para facilitar a manutenção conforme o projeto cresce.

Repositories: Isolar a lógica de banco de dados para facilitar futuras mudanças ou otimizações.

3. Qualidade e Segurança
   PHPStan Nível Máximo: Configurar o PHPStan no nível 9 para garantir que não existam erros de tipo em nenhuma parte do sistema.

Testes com Pest: Implementar testes de integração e feature usando Pest PHP para garantir que as regras de negócio críticas não quebrem.

4. Infraestrutura
    CI/CD Avançado: Melhorar o pipeline atual para fazer deploys automáticos e verificações de segurança em cada atualização.

# Teste Desenvolvedor Full Stack - LG Electronics

Este projeto é uma aplicação Laravel containerizada com Docker, focada no acompanhamento da eficiência produtiva da **Planta A**. O sistema apresenta um dashboard de indicadores para as linhas de Geladeira, Máquina de Lavar, TV e Ar-Condicionado.

---

## 💡 Decisões Técnicas (Filtro de Datas)

Conforme solicitado nos requisitos do desafio, o dashboard foi desenvolvido para exibir a eficiência de produção especificamente durante o **mês de Janeiro de 2026**.

- **Escopo:** Para garantir a entrega fiel ao que foi pedido ("apresente a eficiência... durante o mês de janeiro de 2026"), os filtros de data foram mantidos fixos neste período.
- **Roadmap:** A implementação de um seletor dinâmico de Meses/Anos está listada na seção de melhorias futuras para uma versão de produção em larga escala.

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
## Para refazer os dados randomicos só executar o comando: 

```bash
docker compose exec app php artisan migrate:fresh --seed
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

1. Modernização da Stack
    * Upgrade de Core: Migração para Laravel 13 e PHP 8.5, aproveitando as melhorias de performance e as novas funcionalidades de tipagem nativa.

    * Frontend Reativo: Implementação de interface SPA (Single Page Application) utilizando Vue 3 com Inertia.js ou arquitetura API First com consumo via Vue 3.

    * Filtros Avançados: Adição de seletor de calendário e filtros por períodos dinâmicos para análise de série histórica (atualmente fixo em Jan/2026 conforme requisito).

2. Arquitetura e Qualidade de Código
    * Camadas de Responsabilidade: Implementação de Service Layer ou Actions para desacoplar a lógica de negócio dos Controllers.

    * Tipagem Estrita: Aumento da cobertura de tipos em toda a aplicação para reduzir bugs em tempo de execução.

    * PHPStan Nível MAX: Configuração da análise estática no nível máximo (Level 9) para garantir a integridade total do código.

    * Suite de Testes: Implementação de testes unitários e de integração utilizando Pest PHP para garantir a estabilidade das regras de negócio.

3. Performance e Real-time
    * Caching com Redis: Implementação de cache para consultas de dashboards de alta volumetria.
    
    * Comunicação Real-time: Integração de WebSockets (Laravel Echo + Redis) para atualização dinâmica dos gráficos no frontend Vue 3, permitindo que a diretoria acompanhe a produção em tempo real sem necessidade de refresh.
    
    * CI/CD Avançado: Pipeline automatizado para verificações de segurança, análise estática e deploys contínuos.
    

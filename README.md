
# RNPM

REDIS - NGINX - PHP8/PHPMYADMIN - MARIADB


Crie um servidor web nginx + php de forma facil utilizando um arquivo Compose e gerenciar sua implantação com o Docker Compose.




## Estrutura do projeto

```
.
├── docker-compose.yml
├── config
│    ├── Dockerfile
│    └── http.conf
├── data 
│    └── (Persistência de dados Mysql/Redis)
├── www
│    └── (Coloque seu projeto aqui!)

```


## Nota

> **Nota**
> Você pode utilizar a versão admin web, para definir configurações personalizadas nginx. Acesse: `localhost:81`

| E-mail            | Senha             |
| ----------------- | ----------------- |
| admin@example.com | changeme          |


## Outros recursos

- `localhost:8081` - phpmyadmin
- `composer`

Há um composer integrado ao `php-fpm` caso não possua em sua maquina própria, você pode alcança-lo da seguinte maneira:

**Entre no modo interativo com shell:**
```sh
docker exec -it php-fpm /bin/sh
```
**Navegue ate a pasta:**
```sh
cd /var/www/html/
```
Agora você pode utilizar o composer em seu projeto, lembre-se que seu projeto esta na pasta _/www_, que justamente esta apontando para dentro do container do php em _/var/www/html_.

Qualquer alteração dentro dela, e atualizado dentro do container php/nginx.


## Configurando Senhas/Banco de dados.
Você pode definir uma senha para o redis/mariadb.
> **Nota**
> Você precisa deletar o conteudo dentro da pasta `data/mysql` ou `data/redis`, mas faça um backup do banco de dados caso não deseje perder os registros.

Em `docker-compose.yml` localize e altere para suas credenciais:
```
  mariadb:
    environment:
      #MYSQL_ALLOW_EMPTY_PASSWORD: "yes" # Habilitar login sem senha!
      MYSQL_ROOT_PASSWORD: root 
      MYSQL_DATABASE: npm 
      MYSQL_USER: root
      MYSQL_PASSWORD: suasenhaqui

  redis:
    environment:
      - REDIS_PASSWORD=suasenhaqui
```
Se você alterou as variaveis do mariadb, agora e necessario altera-las também no **Nginx Proxy Manager**.
```
  npm:
    environment:
      DB_MYSQL_HOST: mariadb
      DB_MYSQL_NAME: "npm"
      DB_MYSQL_PORT: 3306
      DB_MYSQL_USER: root
      DB_MYSQL_PASSWORD: suasenhaqui
```

## Comunicação entre os containers

Alguns containers ja estão linkados entre si como, nginx > mariadb.

Nas suas aplicações como por ex uma conexão com banco de dados, você não utilizará mais `localhost` para referenciar o hostname.

Para conexão com mysql utilize `mariadb` ex:
```php
$conn = new PDO("mysql:host=mariadb;dbname=npm", 'root', 'suasenhaqui');
```
Para conexão com redis utilize `redis` ex:
```php
(new Redis())->connect("redis", 6379)
```

## Instalando
**Suba o container:**
```bash
docker compose -f "docker-compose.yml" up -d --build
```
_Aguarde alguns segundos, ate tudo ser iniciado consulte com `docker ps`_

Pronto! Agora você pode acessar http://localhost, caso sua aplicação esteja em uma VPS e possua um dominio. Você pode adiciona-lo e criar regras personalizadas utilizando o NPM Web `http://ip_da_vps:81`, aponte para o proprio IP na porta **80**. Mas considere também que o DNS ja esteja configurado para o IP da maquina.

**Desligando todos os container:**
```bash
docker-compose down
```

**Desligando um container especifico:**
```bash
docker stop redis
```

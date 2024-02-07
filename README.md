# Blog on Laravel 10 + Filament 3

## Setup

Locally you should have `php`, `composer` and `npm` installed.

#### Local
```
OS: Linux Mint 21.3
Docker version 25.0.2
Docker Compose version v2.24.5

PHP 8.2.15 (cli)
Composer 2.6.6
Node 18.19.0
NPM 10.3.0
```

#### Init
```bash
git clone git@github.com:amberlex78/filablog.git
cd filablog
cp .env.example .env
```
#### Install
```
composer install
npm i && npm run build
```

#### Docker up
```
sail up -d
sail artisan key:generate
sail artisan storage:link
```

#### Database
```
sail artisan migrate --seed
```

## Servers

FRONT: Project server running on [http://localhost](http://localhost)

![](./art/10-localhost.png)

ADMIN: Project server running on  [http://localhost/admin](http://localhost/admin)

```
username: filablog
password: password
```

![](./art/20-localhost-admin-login.png)

![](./art/30-localhost-admin-dashboard.png)

### Adminer

Adminer server running on [http://localhost:8080](http://localhost:8080)

Used theme: [Adminer eok8177 dark theme](https://github.com/eok8177/adminer.css)


![](./art/01-adminer.png)

### Mailpit

Mailpit server running on [http://localhost:8025](http://localhost:8025)

![](./art/02-mailpit.png)

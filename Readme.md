XML test case
## Installation

1. 😀 Clone this rep.

2. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as template. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.

3. Go inside folder `./docker` and run `docker-compose build`, next `docker-compose up -d` to start containers.

4. You should work inside the `php` container. This project is configured to work with [Remote Container](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension for Visual Studio Code, so you could run `Reopen in container` command after open the project.

5. Inside the `php` container, run `composer install` to install dependencies from `/var/www/symfony` folder.

6. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://db_user:db_password@db:3306/db_name?serverVersion=8.0.23
```

##Annotation
Вывод продуктов, сортировка, фильтрация, выборка по названию, весу.

В данном приложении не хватает
 - покрытия тестами. Тест написан для примера
 - работы с большими файлами
 - добавление стримингового сервиса для обработки нескольких потоков при импорте из XML
 - доработки для нормального вывода пагинации



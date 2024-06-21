# Requirements - Требования
- Stable version of [Docker](https://docs.docker.com/engine/install/)
- Compatible version of [Docker Compose](https://docs.docker.com/compose/install/#install-compose)

# How To Deploy - Как развернуть проэкт

### For first time only ! - При первом запуске
- `git clone https://github.com/qwezertino/supportone_test.git`
- `cd supportone_test`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache`
- `chmod -R 775 /var/www/storage /var/www/bootstrap/cache`
- `composer setup`

### From the second time onwards - При последующих запусках
- `docker compose up -d`

# Notes

### Laravel App
- URL: http://localhost

- После загрузки главной страницы будут инпут поля для ввода данных (где это нужно по заданию) или же просто кнопки которые будут возвращать некоторые данные
- Весь код доступен в контроллере MainController (/app/Http/Controllers)
- Некоторый впомогательный код был вынесен в сервисы (/app/Services)
- Некоторые задачи требуют создания файлов, при нажатии на кнопки на главной странице сообщение вверху экрана подскажет где конкретно они будут лежать. По стандарту они создаются в `storage/app/public/`
- Для выполнения задания с созданием папок и подпапок с файлами будет создана отдельная директория `storage/storage_data`

## Не выполненные задачи
- Не выполнены были последние 3 задачи из всего списка, так как я столкнулся с проблемами установки и развертывания WordPress и Woocomerce, также практически не имел с ними опыта работы

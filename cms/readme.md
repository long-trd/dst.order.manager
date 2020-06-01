## About CMS
Aperiri dolores indoctum nec ut. Semper scriptorem efficiantur his ex, utroque abhorreant cu vis. Ea cum nobis disputando, vivendo hendrerit intellegat ea his. Cu esse paulo ancillae per, eu vix iisque pertinacia argumentum. Ad duo vituperata scripserit, assum debitis complectitur et vis. At zril sententiae his, eu vix impedit docendi. His diam denique repudiare at, mea in nihil putent fierent.

Munere aliquid civibus mei ei, zril libris persecuti ad sea. In purto veri facete sit. Ut per noluisse delectus principes, te paulo errem voluptatum mel. Mei quis tempor quaestio ea, mei recteque corrumpit te, aliquip numquam voluptatum qui eu. Ex qui congue eripuit molestie, ea eam esse intellegat, in doming offendit conceptam vix.

## CMS Setup

- Create `.env` file
```
$ cp .env.example .env
```

- Define database information
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

- Generate project key
```
$ php artisan key:generate
```

- Run `cms.setup` command
    + CMS Migration
    + CMS Sample data
```
$ php artisan cms.setup
```

- Login base
    + Administrator
    ```
    email: admin@caerux.cms
    password: 00000000
    ```
    + User
    ```
    email: user@caerux.cms
    password: 00000000
    ```
- Role base: `admin`, `user`
- Permission base: `create-user`

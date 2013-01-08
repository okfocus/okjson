# OKJson

OKJson turns a regular old directory structure on a server into JSON. This is quite useful for single page JavaScript applicaitons that need to be managed without a database.

## Usage

Once you have downloaded OKJson you may require it like so:

```php

require_once(__DIR__ . "lib/okjson.php"); // or wherever it is on your filesystem\

```

After you have required OKJson you initialize it like this:

```php

$okjson = new OKJson(__DIR__);

```

Now you can put JSON anywhere in your application with ease:

```php

echo $okjson->to_json();

```

## LICENSE

MIT

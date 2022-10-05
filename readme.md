
# PaySystem by Gabriel-Delazeri

Projeto escrito em PHP que simula um sistema onde temos clientes e vendedores, focado na transação entre eles. (Desafio proposto em: https://github.com/PicPay/picpay-desafio-backend).




## Ambientação do Projeto

1 - Executar o Docker (Sail):

```http
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
https://laravel.com/docs/9.x/sail

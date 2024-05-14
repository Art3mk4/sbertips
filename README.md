# Пакет интеграции со Сберчаевыми

## включает в себя методы для создания, управления и оплаты чаевых

## [документация для Сберчаевых](https://pay.mysbertips.ru/sbrftips-proxy/docs/api-guide-SBERBANK.html#_api)

### подключение пакета
```bash
composer require sushi-market/sbertips
```

### пример конфига
```dotenv
SBERTIPS_URL="https://pay.mysbertips.ru/sbrftips-proxy/api/"                                // url для работы с api
SBERTIPS_MERCHANT_LOGIN="Sushi-login"                                                       // login мерчанта
SBERTIPS_MERCHANT_PASSWORD="sushi-password"                                                 // password мерчанта
SBERTIPS_RIDER_MODEL="App\\Models\\Courier\\Courier"                                        // Модель курьера
SBERTIPS_ORDER_MODEL="App\\Models\\Order\\Order"                                            // Модель заказа
SBERTIPS_CARD_MODEL="App\\Models\\Client\\Card"                                             // Модель карты
SBERTIPS_CLIENT_MODEL="App\\Models\\Client\\Client"                                         // Модель клиента
SBERTIPS_RIDER_ACCESS_TOKEN_MODEL="App\\Models\\RiderAccessToken"                           // Модель токенов для курьера
SBERTIPS_AUTH_MIDDLEWARE="SushiMarket\\Sbertips\\Middleware\\SbertipsAuthMiddleware"        // Миддлеваре для авторизации в методах
SBERTIPS_API_TOKEN="c42af3b9-b46b-418d-ab6e-8b4656402f2a"                                   // bearer token для вызова методов
SBERTIPS_TEAM_UUID="40016421"                                                               // идентификатор команды для создания Qr Code
SBERTIPS_FAKE_PAYMENT="true"                                                                // флаг включения faker для оплаты
SBERTIPS_API_ENABLE_LOG="true"                                                              // флаг включения логов запросов в middleware
```
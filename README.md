# Currency Rate Api

## Installation

1. Clone GitHub repo for this project locally
```bash
git clone https://github.com/lauana-oh/currency-rate-api.git
```

2. Install Composer Dependencies
```bash
composer install
```

3. Create a copy of your .env file and configure variables

4. Generate an app encryption key
```bash
php artisan key:generate
```

5. Migrate the database
```bash
php artisan migrate
```

5. Configure crin job [OPTIONAL]
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Endpoints

### /api/convert
This endpoint can be used to convert one or more values between
different currencies. Optionally, you can convert with a currencies
rate different from today, by seeding the desired date.

#### Request
```json
[
  {
    "from": "USD",
    "to": "BRL",
    "value": 10
  },
  {
    "from": "BRL",
    "to": "CLP",
    "value": 10, 
    "date": "2021-11-27" 
  },
  ...
]
```

#### Response
```json
[
  {
    "from": "USD",
    "to": "BRL",
    "value": 10,
    "date": "2021-11-28",
    "quote": 5.67,
    "result": 56.7
  },
  {
    "from": "BRL",
    "to": "CLP",
    "value": 10,
    "date": "2021-11-27",
    "quote": 146.746,
    "result": 1467
  },
  ...
]
```

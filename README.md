<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Authenticatino REST API

The API provides OTP verification on email.

## Install

```
    composer install
```

## Run the app

```
    composer artisan server
```

# REST API

| Endpoint           | Method | Request | Response |
| ------------------ | ------ | ------- | -------- |
| `api/register`   | POST   |         |          |
| `api/login`      | POST   |         |          |
| `api/verify-otp` | POST   |         |          |
| `api/logout`     | POST   |         |          |

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

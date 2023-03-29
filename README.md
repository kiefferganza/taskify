

## Taskify

An SPA application built with Laravel, Sanctum, Fortify, Vue, Vue Router, Vuex and Tailwindcss:

- [Laravel 9.x](https://github.com/laravel/laravel)
- [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)
- [Laravel Fortify](https://laravel.com/docs/9.x/fortify)
- [Vue 3](https://github.com/vuejs/vue)
- [Vue Router](https://router.vuejs.org/)
- [Vuex](https://vuex.vuejs.org/)
- [Tailwindcss 3.x](https://tailwindcss.com/)

## Features

The following Sanctum and Fortify features are implemented in this Application:

- ✅ Kanban Board
- ✅ Login
- ✅ Password Reset
- ✅ Registration
- ✅ Profile Management
- ✅ Password Confirmation
- ✅ E-Mail Verification

### Installation

Clone the repository and install the dependencies:

```bash
git clone https://github.com/kiefferganza/taskify.git
```

Install the dependencies:

```bash
composer install
```

Install the NPM dependencies:

```bash
npm install
```

Copy the example env file and make the required configuration changes in the .env file:

```bash
cp .env.example .env
```
Generate a new application key:

```bash
php artisan key:generate
```

Run the database migrations (Set the database connection in .env before migrating):

```bash
php artisan migrate
```

Start the app using the following command:

```bash
php artisan serve 
npm run watch
```


## Testing

PHPunit is ready setup to test the API side of this boilerplate. Tested are all Sanctum and Fortify features cause there are heavily based on there original tests. Thats a good starting point to add tests for your next project. To run the tests you can call phpunit like this:

```bash
php artisan test
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail via [kiefferganza23@gmail.com](mailto:kiefferganza23@gmail.com). All security vulnerabilities will be promptly addressed.

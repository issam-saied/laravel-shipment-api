# Laravel Shipment Options API

This project is a Laravel-based API that calculates available shipment options based on a set of business rules involving carriers, package types, destinations, and shipment dates.

The project was built as a personal exercise to experiment with API design, domain modeling, and backend architecture using Laravel.

It focuses on clean code structure, validation, service layer logic, containerized development, and automated testing.

---

## Features

- REST API endpoint for retrieving shipment options
- Business rules for carriers, package types, regions, and weekend availability
- Request validation using Laravel Form Requests
- API Resources for consistent JSON responses
- Service layer for business logic separation
- Eloquent models for domain entities
- Docker-based development environment
- Automated Feature and Unit tests

---

## Shipment Logic

Shipment options depend on the following parameters:

- Destination country
- Shipment date
- Package type

Based on these inputs, the system determines:

- Which carriers support the shipment
- Whether the carrier operates during weekends
- The correct shipping price

The API returns all available shipment options matching the request.

---

## Business Rules

The API applies a simplified set of shipment rules based on:

- carrier
- package type
- destination region
- shipment date
- weekend availability

Countries are mapped to shipping regions:

- **NL** – Netherlands
- **BE** – Belgium
- **EU** – Europe
- **ROW** – Rest of World

Key logic implemented in the system:

- Not every carrier supports every package type
- Not every carrier ships to every region
- Some shipment options are available on weekends
- Prices differ per carrier, package type, and destination region

The service layer evaluates these rules and returns the valid shipment options for the requested input parameters.

---

## Tech Stack

- PHP
- Laravel
- MySQL
- Docker
- Nginx
- PHPUnit

---

## Project Structure

```
project-root
├── docker/
│   ├── nginx/
│   └── php/
├── src/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers
│   │   │   ├── Requests
│   │   │   └── Resources
│   │   ├── Models
│   │   └── Services
│   ├── routes/
│   └── tests/
├── docker-compose.yml
└── README.md
```

---

## Running the Project

Start the Docker environment:

```
docker compose up -d --build
```

Install dependencies:

```
docker compose exec php composer install
```

Generate application key:

```
docker compose exec php php artisan key:generate
```

Run database migrations:

```
docker compose exec php php artisan migrate
```

---

## Example API Endpoint

```
GET /api/shipment-options
```

Example query parameters:

```
country=NL
package_type=Standard
shipment_date=2026-03-25
```

---

## Testing

Run the full test suite:

```
docker compose exec php php artisan test
```

Run only feature tests:

```
docker compose exec php php artisan test tests/Feature
```

Run only unit tests:

```
docker compose exec php php artisan test tests/Unit
```

The project includes automated tests for:

- API endpoint behavior
- Request validation
- Shipment availability rules
- Pricing logic
- Service layer business logic

---

## Purpose

This repository is shared as an example project to demonstrate Laravel backend development, API design, business rule implementation, containerized development, and automated testing.
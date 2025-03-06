# Redberry Homework III Back-end API - Epic Movie Quotes 

[Visit My Website](https://epic-movie-quotes.gigi-kakauridze.redberryinternship.ge)

[API](https://api.epic-movie-quotes.gigi-kakauridze.redberryinternship.ge)

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Resources](#resources)

## Introduction
This project is a social website for movie quotes, where users can log in, register, restore their password, or change their password. It also includes Google authentication. Once logged in, users can add movies to their personal movie list and create quotes about those movies. These quotes will appear on the news feed page, where any verified user can like or comment on them. The quote owner receives real-time notifications for likes and comments.

Additionally, users can search for both quotes and movies. They can also update their profile picture, username, and password while logged in. The website supports two languages: Georgian and English.

## Prerequisites
Before you begin, ensure you have met the following requirements:
- HTML
- PHP
- Laravel
- MySQL
- Sanctum
- Filament
- Broadcasting (Pusher)

## Tech Stack
This project uses the following technologies:
- HTML
- PHP
- Laravel
- MySQL
- Sanctum
- Socialite
- Laravel Query Builder
- Spatie Media Library
- CD pipeline
- Testing: Pest

## Getting Started
To get started with the project, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/RedberryInternship/gigi-kakauridze-epic-movie-quotes-back.git
2. **Enter the folder directory**:
   ```bash
   cd gigi-kakauridze-epic-movie-quotes-back
3. **Install node modules**:
   ```bash
   npm install
4. **Run Vite**:
   ```bash
   npm run dev
5. **Install composer**:
   ```bash
   composer install
6. **Run Laravel in another terminal**:
   ```bash
   php artisan serve
7. **Run Queue for events**:
   ```bash
   php artisan queue:work
8. **Connect your MySQL database to the project.**

9. **Run the migrations to create your tables**
   ```bash
   php artisan migrate

11. **Configure .env**
   
12. **Visit localhost in any browser at http://127.0.0.1:8000/api**


## Resources
Here are some useful resources:
- **Database Visualization**: [DrawSQL Link](https://drawsql.app/teams/redberry-42/diagrams/movie-quotes)




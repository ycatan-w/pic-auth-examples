# PicAuthBundle Demo

This is a **demo application** showing how to integrate the [CrayonPicAuthBundle](https://github.com/ycatan-w/pic-auth-bundle) into a Symfony 7.3 project.
It provides **image-based authentication** using the `pic-auth` library, including login, registration, and a simple home page that reflects the user’s authentication status.

> ⚠️ **Note:** This bundle and demo are experimental. Do **not** use for production or security-critical projects.

---

## Features

-   User registration using an **encoded image**.
-   Login using the **stamped image** generated at registration.
-   Symfony **FormLoginPicAuthenticator** integration.
-   Bootstrap-styled UI for login, registration, and post-registration pages.
-   Download button for stamped image with hover effect.
-   Home page displays username if logged in, or links to login/register otherwise.

---

## Installation

Clone the repository and install dependencies:

```bash
git clone git@github.com:ycatan-w/pic-auth-demo.git
cd pic-auth-demo
composer install
```

Make sure the bundles are enabled in `config/bundles.php`:

```php
return [
    Crayon\PicAuthBundle\CrayonPicAuthBundle::class => ['all' => true],
];
```

---

## Running the Demo

#### 1. Using Symfony local server

Start the Symfony server:

```bash
symfony server:start
```

Open your browser at [http://localhost:8000](http://localhost:8000).

---

#### 2. Using Docker

Build the Docker image:

```bash
docker build -t pic-auth-demo .
```

Run the container:

```bash
docker run -it -p 8000:8000 pic-auth-demo
```

Open your browser at [http://localhost:8000](http://localhost:8000).

> ✅ The Docker container installs all PHP dependencies via Composer and starts the Symfony built-in server automatically.

### Pages included

1. **Home** – shows the username if logged in, or links to login/register.
2. **Register** – create a user by uploading an image.

    - After registration, a **stamped image** is displayed.
    - You must download and save this image to log in.

3. **Login** – authenticate using username + image.

---

## Usage

### 1. Register a new user

1. Go to `/register`.
2. Enter a username and upload a **PNG/JPG image**.
3. Download the **stamped image** from the post-registration page.
4. Keep this image safe! It will be required to log in.

### 2. Login

1. Go to `/login`.
2. Enter your username.
3. Upload your **stamped image**.
4. After successful authentication, you'll be redirected to the home page, which now displays your username.

---

## Notes

-   The stamped image **must be kept by the user**. It is **not stored** in the database or on the server.
-   This demo uses **Bootstrap 5** for UI styling.
-   The demo showcases the **PicAuthBundle integration** and is intended for experimentation and learning.
-   **Commits in this repository** illustrate the different steps of setting up the bundle, from initial installation to registration, login, and UI enhancements.

---

## Resources

-   [PicAuthBundle GitHub](https://github.com/ycatan-w/pic-auth-bundle)
-   [pic-auth GitHub](https://github.com/ycatan-w/pic-auth)

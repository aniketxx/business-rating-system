# Business Rating System

This is a small web application created as an assignment to manage businesses and allow users to give ratings.

The main idea was to build a simple CRUD application and implement a rating system where a user can rate a business only once using their email or phone number.

---

## What this project does

* Add new businesses
* Edit business details
* Delete businesses
* Give star ratings to businesses
* Update rating if the same user rates again
* Show average rating for each business
* Load data without refreshing the page (AJAX)

---

## Technologies Used

**Frontend**

* HTML
* Bootstrap 5
* jQuery
* AJAX
* jQuery Raty plugin (for star rating)

**Backend**

* PHP (PDO)

**Database**

* MySQL

---

## Project Structure

```
varun-dangre-assignment/

ajax/
  add_business.php
  update_business.php
  delete_business.php
  fetch_business.php
  get_business.php
  save_rating.php

conn.php
index.php
README.md
```

---

## Database Setup

Create a database named:

```
business_rating
```

### businesses table

```sql
CREATE TABLE businesses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  address TEXT,
  phone VARCHAR(50),
  email VARCHAR(150)
);
```

### ratings table

```sql
CREATE TABLE ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT,
  name VARCHAR(255),
  email VARCHAR(150),
  phone VARCHAR(50),
  rating DECIMAL(2,1)
);
```

---

## How to Run

1. Copy project into WAMP/XAMPP `www` or `htdocs` folder.
2. Start Apache and MySQL.
3. Create database and tables.
4. Update database credentials in:

```
conn.php
```

5. Open browser:

```
http://localhost/varun-assignment/
```

---

## Rating Logic

When a rating is submitted:

* System checks if a rating already exists using email or phone.
* If found → rating is updated.
* Otherwise → new rating is inserted.

Average rating is calculated dynamically while fetching businesses.

---

## Things I Focused On

* Keeping backend simple and readable
* Using prepared statements (PDO)
* Avoiding page reload using AJAX
* Separating AJAX files for clarity

---

## Possible Improvements

* Form validation improvements
* User authentication
* Pagination
* Search and filters
* API-based structure

---

## Author

Varun Dangre

(Assignment Project)

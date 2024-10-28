# Test Assignment for PHP Developer

## Task 1:
Create an authentication system. It should contain a login page (username and password) and profile.

### Functional requirements:
- Login form should contain two text inputs, for username and password
- If login was successful, user should be redirected to profile page
- Profile page should contain text “Welcome {username}” and logout button 
- When user click “logout” button, they should be redirected to login page 
- In case of unsuccessful login, the login page should be shown with the error message: "Wrong credentials".
- After successful login, the login page should not be available, the user should be redirected to the user page.
- The user page should not be available if the login is not completed. The user should be redirected to the login page.
- In case of 3 unsuccessful login attempts in a row, the system should be blocked for 5 minutes, and when trying to log in, the message should be displayed: "Try again in seconds"

### Requirements:
- Store data in a text file, do not use a database.
- It is advisable to use the MVC architecture when developing.
- It is allowed to use a framework. It is advisable to use Yii2.

---

## Task 2
Products on the online store website are grouped into categories. Categories are organized into a tree structure with a nesting level of up to 4 inclusive. Significant attributes of a category: name. Significant attributes of a product: name, price, quantity in stock. One product can belong to several categories. In addition to categories, a product is also characterized by a set of tags (maximum 20 tags for all products)

### Design a MySQL database structure:
- To store a tree of categories, tags, products, and relationships between entities.
- Fill the tables with test data. Create at least 100 products.
- Write SQL queries to retrieve the following data:
  - For a given list of products, get the names of all categories that contain this products;
  - For a given category, get a list of offers for all products in this category and its child categories.
  - For a given list of categories, get the number of product offers in each category;
  - For a given list of categories, get the total number of unique product offers;
  - For a given category, get its full path in the tree (breadcrumb).
- Check and justify the optimality of the queries.

---

## Task 3
Create CRUD API for products, categories and tags from Task 2. 

### Requirements:
- Any operations shouldn’t break the category tree
- Read operations are public, Create, Update, Delete should be protected by auth (you can use the one you’ve created in Task 1)
- It should be possible to add/remove product to category
- It should be possible to add/remove tag to product

---

## Task 4
Create javascript function that accept 1 parameter date in unixtime and return string time past since provided date

### Date display rules:
- up to 5 minutes - just now
- from 5 minutes to 1 hour - x minutes ago
- from an hour to 8 hours - x hours y minutes ago with minutes rounded to 5
- from 8 hours to a day - x hours ago with minutes rounded to hours according to the rules of arithmetic
- from a day to a month - x days ago
- more than a month - dd.mm.yyyy

---

The main goals are to see the way you work with data, how you can solve problems and pay attention to details. I know it's not a small assignment, and if there is something you don't know how to do, it's okay. Just show your best)

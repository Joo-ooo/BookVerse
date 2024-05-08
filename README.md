# Inf2003 Database System Project
## Team 9 Members

- Sia Hong Liang
- Yip Jun Hao
- Chia Rui Feng
- Bryan Koh Kai Xuan
- Meng Lun Alan
- Tan Heng Joo

## Project Objectives
In today's digital age, the online bookstore industry represents a vast and dynamic landscape. As readers increasingly turn to the internet to discover and purchase books, the demand for online bookstore platforms that offer personalised experiences and efficient data management has never been greater. To meet this demand, we embark on a project to create an innovative and robust online bookstore that leverages both relational and non-relational databases to deliver exceptional value to book enthusiasts, casual readers, and the broader literary community.

Relational databases will mainly be used to store confidential and private information of customers such as transactions, preferences, and authentication details. The relational database will mainly be used for authentication or logging purchases. 

The non-relational database will store book details such as titles, ISBNs, and author names and reviews. By storing this data entry-intensive information in non-relational databases, we can lighten the load on the relational database by saving storage as well as increase performance whenever queries on the catalogue of books need to be performed. In addition to saving storage, using a non-relational database to store book information ensures rapid loading of the catalogue of books. The combination of relational and non-relational databases will reduce the number of queries performed and the total number of entries saved on relational databases, leading to an efficient and fast bookstore able to recommend books based on user preferences.

## Database Architecture
- Multi-tier model to include more layers
- Presentation layer (UI)
- Application Layer (Web Server)
- Data Storage Layer (Relational & NoSQL Database)
- Caching Layer
- Business Logic Layer (Order Processing, Product Recommendations, Shopping Cart Management etc)
## Proposed Database Design
### Relational Database
1. Customers Table
   - Columns: customer_id (Primary Key), first_name, last_name, email, password_hash
   - Foreign Keys: None
   - Constraints: Email
2. Orders Table
   - Columns: order_id (Primary Key), customer_id(Foreign key),books, total, ship_address
   - Foreign Keys: customer_id
   - Constraints: 
3. Relationships
   - Many-to-Many: Customers to Orders
4. Indexes
   - Applied to columns with frequent search operations such as book titles
5. CRUD Operations
   - Customers can register an account, add books to their shopping cart and place orders
   - Customers can view order history
   - Customers can update their shopping carts
   - Customers can delete items from their shopping cart
### Non-relational database
1. Books Table
   - Columns: item_ID(Primary Key), title, author, publisher, main_topic, subtopics, price, short_description   
   - Foreign Keys: None
   - Constraints: None
2. CRUD Operations
   - Store owner can create new entries for books
   - Store owner can edit book data
   - Store owner can delete book
   - Customer can read book entries for book data
### Software Packages
- Relational Database: MySQL
- NoSQL Database: MongoDB
### Datasets from Kaggle
1. https://www.kaggle.com/datasets/oscarm524/book-recommendation?select=evaluation.csv (Book Recommendation)
2. https://www.kaggle.com/datasets/mehmetemintastaban/ecommerce-bookstore-dataset (E-Commerce Bookstore Dataset)

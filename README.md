# NewsListing
PHP/MYSQL based news listing similar to Hacker News

##Features
* Login/Signup/Logout support along with validation
* upvoting and disabling upvote option
* User who submitted the post cannot upvote
* Vote count by default is 1 point
* posting URLs of articles
* URL appears as title of the actual post
* Favicon of each article is fetched and displayed
* User can delete his/her post
* View posts by a particular user
* Option to move forward (next) and backward (back) to iterate through posts.
* Maximum of 20 posts are displayed on one page.

##About files
###config.php
This file contains the details about database login details. Replace them with your database details appropriately.

###index.php
This is the main landing file where the posts are listed. It also contains the sign up/login front end. It also manages the submission of posts.

###header.php
This contains the header of landing page with login and sign up dropdowns and logo.

###signup.php
This handles the submission of a new user.

###upvote_count.php
This handles the upvoting of a post. This is connected to index.php using AJAX.

###functions.php
This contains all the functions to calculate time of the post, fetch title of URL etc.

###logout.php
This is used to destroy the session and logout the user.

###script.js
This contains all the javascript functions for form validation and manipulating upvotes.

###style.css
This contains the CSS which is added on to the bootstrap based front page.

###news.sql
This is the MYSQL based databases which contains the 3 tables used, which needs to be imported before running the scripts.

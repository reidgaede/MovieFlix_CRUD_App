# MovieFlix_CRUD_App
MovieFlix CRUD: a CRUD application built with PHP, JavaScript (jQuery), HTML, and CSS that allows visitors to create, read, update, and delete records in a database of films.

## Background
"MovieFlix CRUD" was the capstone project for "The Full Stack Web Development Bootcamp 2023" (https://www.udemy.com/course/the-full-stack-web-development-bootcamp-2020/). As the name implies, MovieFlix CRUD is a CRUD application that allows users to create, read, update, and delete records detailing user-specified films through a convenient, browser-accessible front-end interface.

To improve upon MovieFlix CRUD's original design and otherwise gain experience using different tools to complete familiar tasks, I have executed the following changes to MovieFlix CRUD after completing the Bootcamp:
- Implementated button functionalities for `index.php` via jQuery as opposed to via DOM manipulation;
- Reorganized and built-out JavaScript to prevent more than one CRUD form (i.e., “Create Record” form, “Update Record” form, or “Delete Record” form) from displaying at once in `index.php`;
- Integrated SQL `CREATE DATABASE IF NOT EXISTS` and `CREATE TABLE IF NOT EXISTS` queries into `index.php` such that `movieFlix_userCreatedDB` database and `movieFlix_userCreatedTable` table are initialized upon first opening of “index.php” in web browser, thus creating user experience requiring no interaction whatsoever with phpMyAdmin to create/maintain MovieFlix CRUD database/table;
- All HTML `<input>` fields (except for those passed `type` value of “submit”) designated `required` to prevent users from submitting partially-/completely-empty queries;
- Added “Delete All Records” button that drops entire `movieFlix_userCreatedTable` MySQL table and instantiates new, empty `movieFlix_userCreatedTable` table;
- Implemented JavaScript `confirm()` method that executes when user click of “Delete All Records” button detected;
- Reset auto-incrementation of “Record ID”/`movie_id` values for new records in `movieFlix_userCreatedTable` table if user completely empties `movieFlix_userCreatedTable` table of records one-by-one using “Delete Record” button;
- Implemented JavaScript `alert()` method that executes when user inputs invalid “Record ID”/`movie_id` value in “Update Record” form or “Delete Record” form;
- Replaced “Movie Genre” `<input>` tags with `<label>` and `<select>` elements to better ensure uniformity of values in “Movie Genre”/`movie_genre` column of `movieFlix_userCreatedTable` table;
- Implemented PHP `$_SESSION` superglobal and supporting infrastructure to facilitate variable sharing between relevant files; and
- Redesigned “Update Record”, “Delete Record”, and “Delete All Records” to dynamically hide/render based on number of records in `movieFlix_userCreatedTable` table;

## System Requirements and Recommendations
Download and set-up of XAMPP is required prior to enjoyment/utilization of MovieFlix CRUD. XAMPP can be downloaded for free from https://www.apachefriends.org/.

Following download and set-up of XAMPP, prospective MovieFlix CRUD users should store files from the "MovieFlix_CRUD_App" repository in a new directory within the `htdocs` directory in the XAMPP application directory (MacOS users, for instance, would likely find `htdocs` in "Macintosh HD" at `/Applications/XAMPP/xamppfiles/htdocs`).

Once a new directory has been created in `htdocs` to store files from the "MovieFlix_CRUD_App" repository, the following general steps are recommended in order to access MovieFlix CRUD:
- Open the XAMPP Control Panel (for MacOS users, this may be found by clicking "manager-osx" within Launchpad);
- Within the XAMPP Control Panel, click the "Manage Servers" tab;
- Highlight "MySQL Database" and click "Start";
- Highlight "Apache Web Server" and click "Start";
- Once both servers have "Status" values of "Running", input `http://localhost/`[name of folder in which "MovieFlix_CRUD_App" files are stored]`/` into a browser's URL bar and press "Enter"; and
- `index.php` should load automatically, allowing the user to freely interact with MovieFlix CRUD.

## Database Schema
The following MySQL table, which is itself created within the `movieFlix_userCreatedDB` database, will be created upon loading `index.php` in a browser window following activation (read: "starting") of the "MySQL Database" and "Apache Web Server" servers in the XAMPP Control Panel:

### `movieFlix_userCreatedTable` Table
This table stores the movies and films added - via user interaction with the MovieFlix CRUD's front-end - to the app.
| Field | Description |
| ----------- | ----------- |
| `movie_id` | Integer; correlates to "Record ID" column header on front-end; auto-increments by 1 with each record added |
| `movie_title` | Varchar (100 character limit); correlates to "Movie Title" column header in `index.php` |
| `movie_genre` | Varchar (100 character limit); correlates to "Movie Genre" column header in `index.php` |
| `movie_director` | Varchar (100 character limit); correlates to "Movie Director" column header in `index.php` |

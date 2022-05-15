# ReVa
ReVa (Request Vacation) is the go-to project to manage employee requests for vacations!

## How ReVa will help you
ReVa streamlines the vacation request and approval proccess through simplicity and automation.
It exposes a dashboard for the users to submit their requests and you only have to click on the "approve" or "reject" link
that will automatically be sent to you after the user's submission. The user will be notified immediately of your decision.

## Installation
Installation is really easy with ReVa and you're only required to perform the least amount of steps possible.
You should be good to go in a few minutes following these steps:
1. Clone the repo: `git clone https://{username}:{password}@github.com/spiroszermalias/reva.git`.
Replace {username} and {password} with your credentials.

2. Create an empty MySQL or MariaDB and a user with full privileges on the database.
Place the credentials in prod-config.php and/or dev-config.php under the config dir*.

3. Run `composer update` to install dependencies.

4. After you make sure that you have set `/public` dir as your webserver's document root,
visit (if for your domain would be example.com) `example.com/setup`. This will allow you to first
add the first admin user. Voila!

*These two files are identical and are meant to be used in case you need to seperate
development from production specific configuration constants. The config that gets loaded
is controlled by the master config.php located in the same dir, by setting `APP_MODE`.

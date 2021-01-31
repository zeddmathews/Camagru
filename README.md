# Camagru
Introduction to Web

# Requirements
A MySQL instance, eg. Xampp or Mamp
PHP (pre-installed with Xampp or Mamp)
HTML
CSS
JavaScript
A modern web browser (e.g. Google Chrome, Firefox)

# Installation
A server is required to host the web app. Xampp or mamp can be used. A Xampp installation guide can be found at: https://www.youtube.com/watch?v=xdvVKywGlc0&t=607s.

During the installation process the following credentials should be set for database access:

username: 'root'

password: 'root'

Once a localhost server is installed, navigate to the htdocs directory and clear out the directory. Clone (or download & unzip) the camagru repo into htdocs

e.g.
cd (xampp/mamp)/htdocs/
git clone https://github.com/zeddmathews/Camagru.git

Start both the Apache & MySql servers through the Xampp/Mamp Control Panel. Search '(localhost/127.0.0.1):portnumber/Camagru/config/setup.php' (portnumber could be one of multiple possible ports depending on the availability on the local machine. port 8080 is the default on windows and macos) in your web browser to ensure everything has been installed correctly.
If so, this should take you to the Xampp landing page.
Ensure your php.ini file is setup to send mail.

If everything was done correctly up until this point, it will automatically route you to the login / signup page of the web application and you may begin traversing my first voyage into the world of web development.
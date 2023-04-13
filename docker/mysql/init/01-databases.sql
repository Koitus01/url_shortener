# create databases
CREATE DATABASE IF NOT EXISTS `url_shortener_db_test`;

# create root user and grant rights
GRANT ALL PRIVILEGES ON url_shortener_db_test.* TO 'url_shortener_user'@'%';
FLUSH PRIVILEGES;
# start
  docker-compose up --build
  
  cat backup.sql | docker exec -i yii_mysql_1 /usr/bin/mysql -u root --password=password yii2
  

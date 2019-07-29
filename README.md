Steps to setup application:

1) Clone repository:

git clone https://github.com/mrfant0m/medicore_test_assignment.git

2) Loading composer repositories:
 
composer update

3) Setup database with docker:

docker-compose up -d

4) Run recalculating of compensation:

bin/console app:calculation

5) Run symfony local web server:

bin/console server:start

 [OK] Server listening on http://127.0.0.1:8000                                                                         

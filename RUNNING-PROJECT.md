### Initiating the project using Docker
To setup the project for the first time run:
```bash
docker build -f docker/Dockerfile -t hackathon .
docker run -it -v $(pwd):/app hackathon
composer install
```
To run the project on the next occasion you can run:
```bash
docker run -it -v $(pwd):/app hackathon
```

### Running tests
To run the tests for the project:
```bash
./vendor/bin/phpunit tests
```
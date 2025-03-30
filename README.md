
---

# Project Setup for PHP API and Web Service with Docker Compose

This project uses Docker Compose to set up two services: a **PHP API** and a **PHP Web** service, both using the `php:8.3-apache` image. These services communicate over a Docker bridge network, and you can access the API and Web services on ports **81** and **82** respectively.

![ChatGPT Image 29 de mar  de 2025, 19_55_49](https://github.com/user-attachments/assets/32ccbab2-039d-47c1-8d97-04dcca7d782f)


---

## Prerequisites

Before running this project, ensure you have the following installed on your system:

- **Docker** 
- **Docker Compose** 

You can verify that Docker and Docker Compose are installed by running:

```bash
docker --version
docker-compose --version
```

---

## Project Structure

Here is an overview of the project structure:

```
/project-root
├── api/
│   └── index.php       # Your PHP API code
├── web/
│   └── index.php       # Your PHP Web code
└── docker-compose.yml  # Docker Compose configuration
```

- The `api/` folder contains the PHP API service files.
- The `web/` folder contains the PHP Web service files.
- The `docker-compose.yml` file contains the configuration for both services and networks.

---

## Docker Compose Configuration

### 1. **`docker-compose.yml`**

```yaml
version: '3.8'

services:
  api:
    image: php:8.3-apache
    container_name: dev_api
    volumes:
      - ./api:/var/www/html
    ports:
      - "81:80"
    networks:
      - public_dev_network
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html
    restart: always

  web:
    image: php:8.3-apache
    container_name: dev_web
    volumes:
      - ./web:/var/www/html
    ports:
      - "82:80"
    depends_on:
      - api
    networks:
      - public_dev_network
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html
    restart: always

networks:
  public_dev_network:
    driver: bridge
```

### 2. **Service Breakdown**

- **`api` Service**:
    - Runs a PHP-based API using the `php:8.3-apache` image.
    - Mounts the local `./api` folder to `/var/www/html` inside the container.
    - Exposes port **81** on the host machine to access the API.
    - Restarts automatically if the container crashes.
    - Runs in the `public_dev_network` network, which allows communication with the `web` service.

- **`web` Service**:
    - Runs a PHP Web server also using the `php:8.3-apache` image.
    - Mounts the local `./web` folder to `/var/www/html` inside the container.
    - Exposes port **82** on the host machine to access the web page.
    - Depends on the `api` service, which means it will only start after the `api` service is up.
    - Waits for the API service to be fully accessible before starting the Apache server.

### 3. **Networking**

- Both services are connected to the same custom Docker network `public_dev_network` using the `bridge` driver. This ensures they can communicate using service names, like `api`, to address each other within the network.

---

## How to Set Up and Run the Project

### 1. **Clone the Project**

Clone or download this repository to your local machine:

```bash
git clone https://github.com/WataNegreirosMonteiro/how-to-use-docker-compose.git
cd how-to-use-docker-compose
```

### 2. **Create the API and Web Code**

Ensure you have PHP code in the `api/` and `web/` directories.

- **`api/index.php`**: This file will serve as your API endpoint.
- **`web/index.php`**: This file will serve as your Web application.

For example:

- **API (`api/index.php`)**:
  ```php
  <?php

  echo json_encode([
  'data' => [
  'linkedin' => 'https://www.linkedin.com/in/wata-negreiros-monteiro-2a94ab1a7/',
  'dev' => 'Wata Negreiros Monteiro',
    ]
  ]);
  ```

- **Web (`web/index.php`)**:
  ```php
  <?php
  $url = 'http://api';

  try {
      $response = file_get_contents($url);
      echo $response;
  } catch (Exception $e) {
      die('Error: ' . $e->getMessage());
  }
  ```

### 3. **Start the Containers**

Run the following command to build and start the containers:

```bash
docker-compose up -d
```
- `-d` runs the containers in detached mode (in the background).

### 4. **Access the Services**

- The **API** will be available at: [http://localhost:81](http://localhost:81)
- The **Web** service will be available at: [http://localhost:82](http://localhost:82)

---

## Conclusion

With this setup, you can easily run both a PHP API and a Web service in isolated Docker containers. Both services communicate over a shared Docker network, and the Web service can directly access the API using the service name (`http://api`).

If you encounter any issues or need further assistance, feel free to reach out!

---

Made with ♥ by Wata Negreiros Monteiro :wave: [Get in touch!](https://www.linkedin.com/in/wata-negreiros-monteiro-2a94ab1a7/)

| [<img src="https://avatars.githubusercontent.com/u/90472705?v=4" width=115><br><sub>Wata Negreiros Monteiro</sub>](https://github.com/WataNegreirosMonteiro) |  
| :---: | 

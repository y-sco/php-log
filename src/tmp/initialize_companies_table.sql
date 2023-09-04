CREATE TABLE companies (
  id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255),
  establishment DATE,
  founder VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;

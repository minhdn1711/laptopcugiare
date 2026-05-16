-- SQL Schema for Product Staging
CREATE TABLE IF NOT EXISTS `l88_product_staging` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sku` VARCHAR(100) UNIQUE,
    `title` VARCHAR(255),
    `slug` VARCHAR(255),
    `price` BIGINT DEFAULT 0,
    `cat_root` VARCHAR(100), -- Laptop, Apple, PC... (parent_id = 0)
    `brand` VARCHAR(100),
    `series` VARCHAR(100),
    `specs_json` JSON,
    `content_html` LONGTEXT,
    `media_urls` JSON,
    `status` VARCHAR(20) DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

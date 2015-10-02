
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- affiliate_transaction
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `affiliate_transaction`;

CREATE TABLE `affiliate_transaction`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `transaction_id` VARCHAR(255) NOT NULL,
    `user_id` INTEGER(20) NOT NULL,
    `ref_user_id` INTEGER(20) NOT NULL,
    `ref_user_amount` INTEGER(20) NOT NULL,
    `item_id` INTEGER(20) NOT NULL,
    `date` DATE NOT NULL,
    `status` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- affiliates
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `affiliates`;

CREATE TABLE `affiliates`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NOT NULL,
    `item_id` bigint(20) unsigned NOT NULL,
    `referral_user_id` bigint(20) unsigned NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `affiliates_FI_1` (`user_id`),
    INDEX `affiliates_FI_2` (`item_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author_email_settings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author_email_settings`;

CREATE TABLE `author_email_settings`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `rating_reminder` INTEGER(2) NOT NULL,
    `item_update_notification` INTEGER(2) NOT NULL,
    `item_comment_notification` INTEGER(2) NOT NULL,
    `item_review_notification` INTEGER(2) NOT NULL,
    `daily_summary_email` INTEGER(2) NOT NULL,
    `status` INTEGER(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author_item_licenses
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author_item_licenses`;

CREATE TABLE `author_item_licenses`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `licenses` VARCHAR(255) NOT NULL,
    `status` INTEGER(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author_item_support
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author_item_support`;

CREATE TABLE `author_item_support`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `support_type` VARCHAR(200) NOT NULL,
    `support_value` VARCHAR(255) NOT NULL,
    `status` INTEGER(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author_settings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author_settings`;

CREATE TABLE `author_settings`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `item_comment_notifications` VARCHAR(100) NOT NULL,
    `item_review_notifications` VARCHAR(100) NOT NULL,
    `buyer_review_notifications` VARCHAR(100) NOT NULL,
    `daily_summary_email` VARCHAR(100) NOT NULL,
    `licensing` VARCHAR(100) NOT NULL,
    `status` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author_social_networks
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author_social_networks`;

CREATE TABLE `author_social_networks`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `digg` VARCHAR(100) NOT NULL,
    `facebook` VARCHAR(100) NOT NULL,
    `flickr` VARCHAR(100) NOT NULL,
    `github` VARCHAR(100) NOT NULL,
    `googleplus` VARCHAR(100) NOT NULL,
    `linkedin` VARCHAR(100) NOT NULL,
    `myspace` VARCHAR(100) NOT NULL,
    `tumblr` VARCHAR(100) NOT NULL,
    `twitter` VARCHAR(100) NOT NULL,
    `vimeo` VARCHAR(100) NOT NULL,
    `youtube` VARCHAR(100) NOT NULL,
    `status` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- categories
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `category_name` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `parent_id` INTEGER,
    `status` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- categories_field
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `categories_field`;

CREATE TABLE `categories_field`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `category_id` BIGINT NOT NULL,
    `field` VARCHAR(255) NOT NULL,
    `field_type` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `categories_field_FI_1` (`category_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- collection_items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `collection_items`;

CREATE TABLE `collection_items`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `collection_id` BIGINT NOT NULL,
    `item_id` BIGINT NOT NULL,
    `status` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- collections
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `collections`;

CREATE TABLE `collections`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `visibility` VARCHAR(255) NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- comment_spam
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comment_spam`;

CREATE TABLE `comment_spam`
(
    `id` INTEGER(20) NOT NULL AUTO_INCREMENT,
    `reporter_id` INTEGER(20) NOT NULL,
    `comment_id` INTEGER(20) NOT NULL,
    `report_content` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    `status` INTEGER(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- comments_report
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comments_report`;

CREATE TABLE `comments_report`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `comment_id` BIGINT NOT NULL,
    `user_id` BIGINT NOT NULL,
    `report` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    `status` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- contact_us
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `contact_us`;

CREATE TABLE `contact_us`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- earning
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `earning`;

CREATE TABLE `earning`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned NOT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    `earning_type_id` bigint(20) unsigned NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `earning_FI_1` (`item_id`),
    INDEX `earning_FI_2` (`user_id`),
    INDEX `earning_FI_3` (`earning_type_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- earning_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `earning_type`;

CREATE TABLE `earning_type`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `type_name` VARCHAR(255) NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- favorites
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `favorites`;

CREATE TABLE `favorites`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `item_id` BIGINT NOT NULL,
    `status` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- followers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `followers`;

CREATE TABLE `followers`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `follower_id` BIGINT NOT NULL,
    `following` VARCHAR(255) NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- footer_settings_copyright
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `footer_settings_copyright`;

CREATE TABLE `footer_settings_copyright`
(
    `id` INTEGER(20) NOT NULL AUTO_INCREMENT,
    `copy_right_text` VARCHAR(255) NOT NULL,
    `copy_right_tagline` VARCHAR(255) NOT NULL,
    `status` INTEGER(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- footer_settings_menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `footer_settings_menu`;

CREATE TABLE `footer_settings_menu`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `footer_name` VARCHAR(255) NOT NULL,
    `footer_title` VARCHAR(255) NOT NULL,
    `footer_label` VARCHAR(255) NOT NULL,
    `footer_link` VARCHAR(255) NOT NULL,
    `status` INTEGER(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- footer_settings_social
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `footer_settings_social`;

CREATE TABLE `footer_settings_social`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `facebook` VARCHAR(255) NOT NULL,
    `twitter` VARCHAR(255) NOT NULL,
    `youtube` VARCHAR(255) NOT NULL,
    `status` INTEGER(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- item_comments
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_comments`;

CREATE TABLE `item_comments`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned NOT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    `comment` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `item_comments_FI_1` (`item_id`),
    INDEX `item_comments_FI_2` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- item_likers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_likers`;

CREATE TABLE `item_likers`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `item_id` BIGINT NOT NULL,
    `user_id` BIGINT NOT NULL,
    `type` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `item_likers_FI_1` (`item_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- item_rating
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_rating`;

CREATE TABLE `item_rating`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` BIGINT NOT NULL,
    `user_id` BIGINT NOT NULL,
    `rating_value` int(2) unsigned NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `item_rating_FI_1` (`item_id`),
    INDEX `item_rating_FI_2` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- item_viewers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_viewers`;

CREATE TABLE `item_viewers`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned NOT NULL,
    `view_count` bigint(20) unsigned NOT NULL,
    `ip` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `item_viewers_FI_1` (`item_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_name` TEXT NOT NULL,
    `category_id` bigint(20) unsigned NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` LONGTEXT NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `items_FI_1` (`category_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- items_fields
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `items_fields`;

CREATE TABLE `items_fields`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `field_id` BIGINT NOT NULL,
    `field_value` VARCHAR(255) NOT NULL,
    `item_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `items_fields_FI_1` (`field_id`),
    INDEX `items_fields_FI_2` (`item_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) DEFAULT '' NOT NULL,
    `target` VARCHAR(255),
    `parent_id` INTEGER DEFAULT 0 NOT NULL,
    `commonname` VARCHAR(60) NOT NULL,
    `order` SMALLINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- package
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `package`;

CREATE TABLE `package`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned NOT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    `package_name` VARCHAR(255) NOT NULL,
    `description` LONGTEXT NOT NULL,
    `valid_upto` DATETIME NOT NULL,
    `date` DATETIME NOT NULL,
    `package_price` FLOAT NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `package_FI_1` (`item_id`),
    INDEX `package_FI_2` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- pages
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `title` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    `status` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- payment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NOT NULL,
    `transanction_id` bigint(20) unsigned NOT NULL,
    `detail` TEXT NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `payment_FI_1` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- sales
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sales`;

CREATE TABLE `sales`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned,
    `user_id` bigint(20) unsigned NOT NULL,
    `package_id` bigint(20) unsigned,
    `transaction_id` VARCHAR(100) NOT NULL,
    `token` VARCHAR(100) NOT NULL,
    `payer_id` VARCHAR(100) NOT NULL,
    `amount` FLOAT NOT NULL,
    `date` DATETIME NOT NULL,
    `status` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sales_FI_1` (`item_id`),
    INDEX `sales_FI_2` (`user_id`),
    INDEX `sales_FI_3` (`package_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- total_earning
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `total_earning`;

CREATE TABLE `total_earning`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NOT NULL,
    `total_amount` FLOAT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `total_earning_FI_1` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_items`;

CREATE TABLE `user_items`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `item_id` bigint(20) unsigned NOT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_items_FI_1` (`item_id`),
    INDEX `user_items_FI_2` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile`
(
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(30) NOT NULL,
    `last_name` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `dob` DATE NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `user_id` BIGINT NOT NULL,
    `register_on` DATETIME NOT NULL,
    `last_login` DATETIME NOT NULL,
    `last_ip` VARCHAR(50) NOT NULL,
    `user_avatar` VARCHAR(255) NOT NULL,
    `company_name` VARCHAR(255) NOT NULL,
    `lives_in` VARCHAR(255) NOT NULL,
    `country` VARCHAR(255) NOT NULL,
    `homepage_image` VARCHAR(255) NOT NULL,
    `profile_heading` VARCHAR(255) NOT NULL,
    `profile_text` VARCHAR(255) NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_profile_FI_1` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(50) NOT NULL,
    `user_type` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `auth_token` VARCHAR(255) NOT NULL,
    `status` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

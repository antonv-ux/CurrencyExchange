--запрос на создание всех таблиц в вашей бд 
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `name` varchar(128) NOT NULL COMMENT 'Имя пользователя',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата обновления записи',
  PRIMARY KEY (`id`)
);

CREATE TABLE `user_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_from` int(10) unsigned NOT NULL COMMENT 'Идентификатор пользователя который одолжил деньги',
  `user_to` int(10) unsigned NOT NULL COMMENT 'Идентификатор пользователя которому одолжили деньги',
  `sum_value` int(11) NOT NULL COMMENT 'Сумма которые одалживали',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи',
  PRIMARY KEY (`id`),
  CONSTRAINT `user_payment_ibfk_1` FOREIGN KEY (`user_to`) REFERENCES `users` (`id`),
  CONSTRAINT `user_payment_ibfk_2` FOREIGN KEY (`user_from`) REFERENCES `users` (`id`)
);

CREATE TABLE `user_balance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `balance` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  CONSTRAINT `user_balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

--запрос на добавление записи о факте займа 
SELECT @fromUser:= 1, @toUser := 2, @payValue := 50;

INSERT INTO user_payment(user_from, user_to, sum_value)
VALUES (@fromUser, @toUser, @payValue); 

UPDATE `user_balance` SET balance = balance - @payValue WHERE user_id = @fromUser;
UPDATE `user_balance` SET balance = balance + @payValue WHERE user_id = @toUser;


--узнать, сколько Человек 1 должен Человеку 2 
SELECT 
  t1.user_name_from AS 'who debtor', t1.user_name_to AS 'whom debtor', (IFNULL(t2.quantity, 0)-IFNULL(t1.quantity, 0)) AS 'amount' 
FROM
  (SELECT 
    SUM(p.sum_value) AS 'quantity',
    p.user_from AS 'user_from',
    p.user_to AS 'user_to',
    u1.name AS 'user_name_from',
    u2.name AS  'user_name_to' 
  FROM
    `user_payment` p
  INNER JOIN `users` u1 ON u1.id = p.user_from
  INNER JOIN `users` u2 ON u2.id = p.user_to
  WHERE p.user_from = 1 AND p.user_to = 2
  GROUP BY p.user_from,
    p.user_to) AS t1
 LEFT JOIN  
 (SELECT 
    SUM(sum_value) AS 'quantity',
    user_from,
    user_to 
  FROM
    `user_payment` 
  WHERE user_from = 2 AND user_to = 1
  GROUP BY user_from,
    user_to) AS t2 ON t1.user_from = t2.user_to AND t1.user_to = t2.user_from;
 
 
--узнать баланс Человека 1 с учетом всех займов 
SELECT u.`name`, b.`balance`
FROM user_balance AS b
INNER JOIN users AS u ON u.`id` = b.`user_id` AND b.`user_id` = 1;


-- узнать кто и сколько должен Человеку 1
SELECT 
  t1.user_name_to AS 'who debtor', t1.user_name_from AS 'whom debtor', (IFNULL(t1.quantity, 0)-IFNULL(t2.quantity, 0)) AS 'amount' 
FROM
  (SELECT 
    SUM(p.sum_value) AS 'quantity',
    p.user_from AS 'user_from',
    p.user_to AS 'user_to',
    u1.name AS 'user_name_from',
    u2.name AS  'user_name_to' 
  FROM
    `user_payment` p
  INNER JOIN `users` u1 ON u1.id = p.user_from
  INNER JOIN `users` u2 ON u2.id = p.user_to
  WHERE p.user_from = 1
  GROUP BY p.user_from,
    p.user_to) AS t1
 LEFT JOIN  
 (SELECT 
    SUM(sum_value) AS 'quantity',
    user_from,
    user_to 
  FROM
    `user_payment` 
  WHERE user_to = 1
  GROUP BY user_from,
   user_to) AS t2 ON t1.user_from = t2.user_to AND t1.user_to = t2.user_from
  HAVING amount > 0;




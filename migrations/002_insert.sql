INSERT INTO `roles` (`id`, `name`) VALUES (1, 'user');
INSERT INTO `roles` (`id`, `name`) VALUES (2, 'admin');
INSERT INTO `user_roles` (`user_id`, `role_id`) select id,1 from users;
INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES (1, 2);
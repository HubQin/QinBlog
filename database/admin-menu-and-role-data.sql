INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
	(1, 0, 15, 'Dashboard', 'fa-tachometer', '/', NULL, NULL, '2020-05-20 22:26:18'),
	(2, 0, 9, 'Admin', 'fa-star', NULL, NULL, NULL, '2020-05-20 22:25:25'),
	(3, 2, 10, 'Users', 'fa-users', 'auth/users', NULL, NULL, '2020-05-20 22:25:25'),
	(4, 2, 11, 'Roles', 'fa-odnoklassniki', 'auth/roles', NULL, NULL, '2020-05-20 22:25:25'),
	(5, 2, 12, 'Permission', 'fa-expeditedssl', 'auth/permissions', NULL, NULL, '2020-05-20 22:25:25'),
	(6, 2, 13, 'Menu', 'fa-list-alt', 'auth/menu', NULL, NULL, '2020-05-20 22:25:25'),
	(7, 2, 14, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, '2020-05-20 22:25:25'),
	(8, 0, 7, 'Users', 'fa-users', 'users', NULL, NULL, '2020-05-20 22:12:33'),
	(9, 0, 3, 'Categories', 'fa-list', 'categories', NULL, NULL, '2020-05-20 22:12:33'),
	(10, 0, 4, 'Tags', 'fa-tag', 'tags', NULL, NULL, '2020-05-20 22:12:33'),
	(11, 0, 1, 'Posts', 'fa-book', 'posts', NULL, NULL, '2020-05-20 22:15:35'),
	(12, 0, 2, 'Comments', 'fa-comment', 'comments', NULL, NULL, '2020-05-20 22:12:57'),
	(13, 0, 5, 'Columns', 'fa-columns', 'columns', NULL, NULL, '2020-05-20 22:16:25'),
	(14, 0, 6, 'Settings', 'fa-gear', 'settings', NULL, NULL, '2020-05-20 22:15:23'),
	(15, 0, 8, 'Links', 'fa-link', 'links', NULL, NULL, '2020-05-20 22:25:25');

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin', NULL, NULL);


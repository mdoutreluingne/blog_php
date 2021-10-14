-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 12 oct. 2021 à 22:06
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `validated`, `user_id`, `post_id`) VALUES
(9, 'Cool', '2021-10-07 18:45:38', 0, 7, 4),
(11, 'gghb', '2021-10-07 18:45:38', 1, 7, 4),
(13, 'ok', '2021-10-10 17:50:46', 0, 7, 4);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `title` varchar(200) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `chapo`, `content`, `picture`, `created_at`, `updated_at`) VALUES
(3, 6, 'Symfony Flex devient sans serveur', 'Symfony Flex a été introduit en 2017 comme l\'un des éléments clés de l\'expérience Symfony repensée pour le lancement de Symfony 4 . Symfony Flex est un outil qui simplifie l\'installation/suppression de packages dans les applications Symfony.', 'Cette simplification est rendue possible grâce aux « recettes Flex », qui sont un ensemble d\'instructions automatisées qui indiquent à Symfony comment installer, activer et configurer des packages dans des applications. Ces recettes sont actuellement stockées dans deux référentiels publics GitHub : le référentiel de recettes principal et le référentiel de recettes contrib .\r\n\r\nLa dernière pièce qui rend Flex possible est le serveur Flex à https://flex.symfony.com. En plus d\'afficher les recettes/packages disponibles dans une interface Web, ce serveur communique avec le plug-in Flex Composer pour servir les recettes.\r\n\r\nPasser au sans serveur\r\nDans le cadre de nos efforts continus pour simplifier les opérations, nous nous sommes récemment demandé : comment pourrions-nous simplifier l\'infrastructure du serveur Flex ? Ensuite, nous avons pensé : et si nous supprimions entièrement le serveur Flex ? Et c\'est exactement ce que nous allons faire.\r\n\r\nDans la pull request #803 du package Symfony Flex, vous pouvez voir que nous allons remplacer le flex.symfony.compoint de terminaison propriétaire par un nouveau point de terminaison composé de fichiers JSON statiques hébergés sur GitHub.\r\n\r\nLes fichiers JSON sont stockés dans ce référentiel et sont générés par GitHub Actions à l\' aide de ce script grâce à un outil de vérification de recette personnalisé . Le point de terminaison du serveur Flex existant continuera à fonctionner pendant un certain temps en tant que service hérité pour les applications qui n\'ont pas encore été mises à jour.\r\n\r\nUtilisation des nouveaux points de terminaison\r\nLa version 1.16 de symfony/flexa été publiée avec la prise en charge des nouveaux points de terminaison, mais ils sont pour l\'instant derrière un indicateur de fonctionnalité : vous devez définir l\' FLEX_SERVERLESSenv var sur 1pour activer les nouveaux points de terminaison.\r\n\r\nVeuillez nous aider à confirmer que tout fonctionne comme prévu en activant cet indicateur de fonctionnalité.\r\n\r\nDans quelques semaines, la version 1.17 supprimera l\'indicateur de fonctionnalité et les nouveaux points de terminaison seront utilisés par défaut. Tous les utilisateurs de versions héritées de symfony/flexverront alors un avertissement les invitant à effectuer une mise à niveau.\r\n\r\nRecettes personnalisées\r\nUn effet secondaire très intéressant de ce changement est que vous pouvez facilement héberger des recettes personnalisées dans vos propres référentiels . Si vous le faites, ajoutez l\'URL de votre référentiel de recettes dans l\' extra.symfony.endpointoption de configuration de composer.json ou dans la SYMFONY_ENDPOINTvar env.\r\n\r\nDe plus, maintenant que le serveur propriétaire a disparu, vous pouvez ajouter vos propres fonctionnalités en plus de l\'API Symfony Flex. Nous sommes impatients de connaître vos idées. Certains d\'entre eux pourraient même être reversés à l\'API Flex officielle.', '', '2021-09-19 18:01:04', '2021-10-09 17:49:14'),
(4, 6, 'La fin de Swiftmailer', 'Depuis lors, nous avons travaillé à l\'améliorer en ajoutant plus de fournisseurs tiers et en ajoutant certaines fonctionnalités manquantes qui étaient déjà disponibles dans Swiftmailer, comme le support DKIM et signature d\'e-mails.', 'Depuis Symfony 5.3, toutes les fonctionnalités de Swiftmailer et bien plus sont disponibles dans Symfony Mailer.\r\n\r\nIl est maintenant temps de mettre fin officiellement à la maintenance de Swiftmailer au profit de Symfony Mailer. J\'ai fixé la date de fin de maintenance à fin novembre 2021 , en même temps que la version Symfony 5.4 LTS et 6.0.\r\n\r\nSymfony Mailer aurait pu s\'appeler Swiftmailer version 7 et le travail a commencé exactement comme la prochaine version majeure de Swiftmailer.\r\n\r\nExaminons un peu comment j\'ai décidé de créer Symfony Mailer au lieu de publier Swiftmailer 7. L\'infrastructure de code actuelle de Swiftmailer a été conçue pour la version 4.0, qui a été publiée à peu près en même temps que symfony 1.2 !\r\n\r\nPendant de nombreuses années, j\'ai essayé de moderniser la base de code de Swiftmailer une étape à la fois en essayant d\'introduire des espaces de noms, de passer au chargeur automatique de Composer, en essayant de supprimer la &amp;amp;amp;quot;séquence de démarrage&amp;amp;amp;quot; spéciale (et lourde), en essayant de basculer aux composants d\'injection de dépendances et de répartiteur d\'événements Symfony. Mais tous mes efforts se sont toujours soldés par des impasses, probablement parce que la tâche était trop importante pour peu d\'avantages, car Swiftmailer souffre de beaucoup plus de problèmes conceptuels : il a un héritage de classe étrange et complexe et les instances de message ne sont pas des objets de données, ce qui le rend pénible à sérialiser eux. Il manque également certaines fonctionnalités modernes telles que la prise en charge de Twig pour la composition d\'e-mails et la prise en charge de fournisseurs tiers. Les deux fonctionnalités auraient pu être ajoutées à la base de code actuelle, mais cela n\'aurait pas été idéal. Un autre problème est la façon dont Swiftmailer utilise un mécanisme de « spool » pour prendre en charge les e-mails asynchrones ; ça marche à peine et ce n\'est pas très flexible. Je peux continuer encore et encore, mais vous comprenez le point.\r\n\r\nAlors, à un moment donné, j\'ai décidé de recommencer, mais avec une approche très différente et radicale. Au lieu d\'essayer de moderniser le code étape par étape, j\'ai copié le code et commencé à travailler d\'abord sur l\'isolement d\'un composant Symfony Mime. Ensuite, j\'ai refactorisé le reste de la base de code autant que possible pour créer Symfony Mailer. Le résultat est Symfony Mailer. Symfony Mailer a beaucoup de code en commun avec Swiftmailer mais aucune de ses particularités.\r\n\r\nLa migration de Swiftmailer vers Symfony Mailer est une tâche relativement facile car les concepts sont les mêmes entre les deux projets.', '', '2021-09-12 18:01:04', '2021-10-10 15:59:40'),
(5, 6, 'Utiliser les discussions GitHub pour le support Symfony', 'Le support Open Source Symfony est fourni par la communauté via StackOverflow et Slack. Les deux nous ont bien servi pendant quelques années, mais il leur manque certaines fonctionnalités.', 'StackOverflow est bien pour le support asynchrone et ses discussions restent pour toujours et peuvent être trouvées via Google, mais il manque d\'outils de mise en forme avancés, d\'une meilleure modération et d\'une intégration GitHub (pour envoyer un ping aux utilisateurs, mentionner des problèmes, etc.)\r\n\r\nSlack est idéal pour la prise en charge de la synchronisation, où vous avez besoin d\'une réponse rapide et en direct à vos questions. Malheureusement, il souffre des mêmes problèmes que StackOverflow et de certains de ses propres problèmes. La version gratuite de Slack utilisée par Symfony a une limite d\'historique de 10 000 messages et ses messages ne peuvent pas être trouvés via Google.\r\n\r\nC\'est pourquoi nous activons les discussions GitHub pour Symfony comme une nouvelle façon pour la communauté de fournir un support Symfony gratuit. À notre avis, les principaux avantages des discussions GitHub par rapport à StackOverflow/Slack sont :\r\n\r\nIl n\'y a pas de limite de messages d\'historique et toutes les discussions sont facilement trouvées via Google ;\r\nLes discussions peuvent utiliser tous les excellents outils de mise en forme fournis par GitHub, y compris le téléchargement d\'images transparent ;\r\nL\'ensemble de la communauté Symfony est sur GitHub, les discussions peuvent donc tirer parti des fonctionnalités pour envoyer un ping aux utilisateurs et mentionner les problèmes et les demandes d\'extraction ;\r\nBien que les discussions ne soient pas aussi synchronisées que le chat Slack, la taille de la communauté Symfony pourrait garantir des réponses rapides à la plupart des discussions ;\r\nAu lieu de fermer certains problèmes parce qu\'il s\'agit de questions d\'assistance, nous pouvons maintenant les convertir en discussions, améliorant ainsi l\'expérience des nouveaux arrivants ;\r\nNous aurons plus d\'outils de modération pour nous assurer que les discussions GitHub sont un endroit formidable et sûr pour tout le monde.', '', '2021-09-20 11:01:04', '2021-10-09 17:50:32'),
(42, 7, 'PHP conserve la première place en tant que langage de programmation côté serveur sur le Web avec près de 79% d\'utilisation', 'Bien que PHP ne se rapproche généralement pas du podium dans les listes plus générales de popularité des langages, il jouit d\'une très grande popularité dans sa zone cible, le Web.', 'En témoigne une nouvelle enquête de W3Techs sur les serveurs Web, qui a indiqué que le langage était utilisé sur près de 79 % des 10 millions de sites les plus populaires selon le baromètre Alexa.\r\n\r\nL\'organisme a publié un rapport qui comprend un graphique d\'une année sur l\'autre à partir de janvier 2010, jusqu\'en 2021. Il en ressort que PHP est utilisé par 78,9 % des sites Web et se positionne loin devant ASP.NET (8,3 %) et Ruby (5,2 %). Java quant à lui est passé en quatrième position et tourne désormais sur 3,6 % de ces sites. Le langage est passé en quatrième position depuis janvier 2021 ; il était alors utilisé par 3,2 % de sites contre 4,3 % pour Ruby.', '0a09e62b2ed95773c8f2f06917c1cf57.jpg', '2021-10-10 12:04:57', '2021-10-10 12:07:27'),
(43, 7, 'L\'administration Biden choisit de rester sur le CMS WordPress pour lancer le site de la Maison Blanche', 'Avec le changement d\'administration vient un nouveau site Web et après que Joe Biden ait prêté serment mercredi 20 janvier, le tout nouveau site de la Maison Blanche Whitehouse.gov a fait ses débuts.', 'L\'administration précédente est passée de Drupal à WordPress en 2017, et les technologues travaillant avec l\'administration Biden ont décidé de s\'en tenir au même CMS.\r\n\r\nConformément aux fonctionnalités multilingues et d\'accessibilité mises en œuvre sur le site Web de l\'équipe de transition Biden-Harris, whitehouse.gov a été lancé avec des boutons pour le contraste et la taille de la police, ainsi qu\'un sélecteur de langue espagnole. Le site relancé comprend également une déclaration d\'accessibilité avec un engagement de l\'administration à travailler pour se conformer aux critères d\'accessibilité du contenu Web (WCAG) version 2.1, niveau AA.\r\n\r\nUne grande partie du contenu et de la conception du site Web de transition a été préservée. Le site de transition est maintenant redirigé vers whitehouse.gov, tandis que les liens vers les pages de l’ancienne administration aboutissent sur une page 404 avec un lien vers des sites Web présidentiels archivés.', '96122563030112fe6b16193955837e38.jpg', '2021-10-10 12:28:49', '2021-10-10 12:28:49'),
(44, 7, 'esesfs', 'tqsqqqq', 'test', '', '2021-10-10 16:47:11', '2021-10-10 17:27:56');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` smallint(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `password`, `email`, `avatar`, `role`) VALUES
(6, 'Doutreluingne', 'Maxime', '$2y$10$4JPepQS1.yqAsQgYt5swF./MEh.VTIyv1nlpDjRXgbP9k4F4FRFWS', 'maxime.doutreluingne@sfr.fr', '5328370a3e780f2508456d4780939f2c.jpg', 'USER'),
(7, 'admin', 'admin', '$2y$10$iMEgDW1STcmSZGRpz5fhf.IweNwG17VJNQxVRPE7x3tr5llPKskp6', 'admin.admin@gmail.com', NULL, 'ADMIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

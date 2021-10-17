SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE blog_php CHARACTER SET 'utf8';
USE blog_php;

--
-- Structure de la table comment
--

CREATE TABLE comment (
  id int(11) NOT NULL,
  content text NOT NULL,
  created_at datetime NOT NULL,
  validated tinyint(1) NOT NULL,
  user_id smallint(6) NOT NULL,
  post_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table post
--

CREATE TABLE post (
  id int(11) NOT NULL,
  user_id smallint(6) NOT NULL,
  title varchar(200) NOT NULL,
  chapo varchar(255) NOT NULL,
  content text NOT NULL,
  picture varchar(255) NOT NULL,
  created_at datetime NOT NULL DEFAULT current_timestamp(),
  updated_at datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table user
--

CREATE TABLE user (
  id smallint(11) NOT NULL,
  last_name varchar(50) NOT NULL,
  first_name varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  avatar varchar(255) DEFAULT NULL,
  role varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table user
--

INSERT INTO user (id, last_name, first_name, password, email, avatar, role) VALUES
(6, 'Doutreluingne', 'Maxime', '$2y$10$4JPepQS1.yqAsQgYt5swF./MEh.VTIyv1nlpDjRXgbP9k4F4FRFWS', 'maxime.doutreluingne@sfr.fr', '5328370a3e780f2508456d4780939f2c.jpg', 'USER'),
(7, 'admin', 'admin', '$2y$10$iMEgDW1STcmSZGRpz5fhf.IweNwG17VJNQxVRPE7x3tr5llPKskp6', 'admin.admin@gmail.com', NULL, 'ADMIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table comment
--
ALTER TABLE comment
  ADD PRIMARY KEY (id),
  ADD KEY user_id (user_id),
  ADD KEY post_id (post_id);

--
-- Index pour la table post
--
ALTER TABLE post
  ADD PRIMARY KEY (id),
  ADD KEY user_id (user_id);

--
-- Index pour la table user
--
ALTER TABLE user
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table comment
--
ALTER TABLE comment
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table post
--
ALTER TABLE post
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table user
--
ALTER TABLE user
  MODIFY id smallint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table comment
--
ALTER TABLE comment
  ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT comment_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table post
--
ALTER TABLE post
  ADD CONSTRAINT post_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id);
COMMIT;

CREATE DATABASE DW1;

CREATE TABLE `utilisateur` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(100) ,
  `prenom` varchar(100) ,
  `email` varchar(155)UNIQUE,
  `pass` varchar(255) ,
  `tel` int(10) UNIQUE,
  `Role` varchar(255) DEFAULT 'member',
  `equipe_ID` int(11) DEFAULT NULL,
  `project_ID` int(11) DEFAULT NULL
);

CREATE TABLE `projet` (
  `id_pro` int(10) NOT NULL AUTO_INCREMENT,
  `nom_pro` varchar(100) ,
  `date_Debut` date DEFAULT NULL,
  `date_Fin` date DEFAULT NULL
);

CREATE TABLE `equipe` (
  `id_equipe` int(10) NOT NULL  AUTO_INCREMENT ,
  `nom_equipe` varchar(100) ,
  `date_creation` date
);





ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id_equipe`),
  ADD KEY `id_pro` (`id_pro`);


ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipe_ID` (`equipe_ID`),
  ADD KEY `project_ID` (`project_ID`);

ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipe_ID` (`equipe_ID`),
  ADD KEY `project_ID` (`project_ID`);



ALTER TABLE `equipe`
  ADD CONSTRAINT `equipes_ibfk_1` FOREIGN KEY (`project_ID`) REFERENCES `projects` (`id`);

  ALTER TABLE `utilisateur`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`equipe_ID`) REFERENCES `equipes` (`id`),
  ADD CONSTRAINT `persons_ibfk_2` FOREIGN KEY (`project_ID`) REFERENCES `projects` (`id`);
COMMIT;








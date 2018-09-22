-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: bibliotcc_new
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `board`
--

LOCK TABLES `board` WRITE;
/*!40000 ALTER TABLE `board` DISABLE KEYS */;
INSERT INTO `board` (`id`, `scheduledTime`, `advisorGrade`, `evaluatorOneGrade`, `evaluatorTwoGrade`, `observations`, `finalGrade`, `isFinalized`, `isCanceled`, `isPresented`, `evaluatorOneId`, `evaluatorTwoId`, `semesterId`, `projectId`) VALUES (14,'2018-07-04 20:15:00',10,10,10,'Rever considerações feitas pelos professores nos volumes;\r\nFazer verificação das referências;\r\nRevisar diagrama de classes e colocar versão final;',10,0,0,1,7,17,1,14),(15,'2018-07-04 19:08:00',9.5,9.5,9.5,'Rever considerações feitas pelos  professores nos volumes entregues;\r\nRever lista de referências e suas citações no texto;\r\nColocar trabalhos futuros;\r\nRevisar formatação (Itálicos );\r\nAnexar diagramas nas versões finais;\r\nExplicar detalhadamente a captura de som e cálculo das médias no Sprint 2;',9.5,0,0,1,17,7,1,15),(16,'2018-06-26 19:18:00',9,9,9,'Rever sugestões feitas pelos professores nos volumes;\r\nColocar imagens do aplicativo nos sprints;\r\nRever casos de uso;\r\nColocar relação do kanban com o scrum;\r\nAtualizar product backlog / sprints;\r\nRever formatação e escrita;\r\nColocar desenvolvimentos futuros',9,0,0,1,7,17,1,16),(17,'2018-07-04 13:30:00',8,8,8,'#Artigo#\r\n- ver nos volumes de cada artigo de cada professor, que considerações fizeram no texto e ajustar para a entrega final.\r\n- explicar melhor como funciona o buscar projetos, como será a pesquisa e a regra para o projeto aparecer na biblioteca.\r\n- dizer no artigo que foi projetado para o curso de computação da Ulbra. Para outros cursos teria que avaliar que tipo de mudanças fazer.\r\n- Revisar o ER pois na impressão dentro do artigo os relacionamentos ficaram confusos.\r\n\r\n#software#\r\n- na tela da banca mudar o título Finalizar Banca para Apresentação da Banca. \r\n- o botão apresentar  mudar para Finalizar Apresentação.\r\n- na tela da banca mudar os labels Nota do Orientador para Nota do Cássio, Nota da Adriana, Nota do Ramon. Pegar o nome do avaliador e concatenar.\r\n- enquanto a banca não for finalizada, o professor orientador pode alterar as considerações e notas.\r\n\r\n#sugestões\r\n- fazer parte de avaliações de propostas dos alunos.\r\n- gerar certificado de participação que participaram das bancas como ouvintes.\r\n- gerar certificado de participação da banca do aluno avaliado com o nota final.',8,0,0,1,11,19,1,17),(18,'2018-07-05 15:00:00',6.5,6.5,6.5,'Observar anotações nos volumes.',6.5,0,0,1,19,16,1,18),(19,'2018-07-05 14:00:00',10,10,10,'Observar anotações nos volumes \r\nExplorar mais sprints\r\nCorreção de português.',10,0,0,1,16,19,1,19),(20,'2018-06-28 15:00:00',8.5,8.5,8.5,'CONSIDERAÇÕES DA BANCA.\r\nVer considerações apontadas pela banca no volume.\r\nRever a nomenclatura do \"Profissional\"\r\nExplorar + a Stack de desenvolvimento na introdução\r\nRever as features do product backlog Versus tarefas do no sprint backlog',8.5,0,0,1,16,18,1,20),(21,'2018-07-04 15:30:00',8,8,8,'Rever as anotações nos volumes;\r\nAdicionar caso de uso da aplicação;\r\nDisponibilizar no ar o sistema;\r\nrevisão de portugues;',8,0,0,1,7,19,1,21),(22,'2018-06-28 14:00:00',9,9,9,'Rever considerações feitas nos volumes.\r\nRever product backlog versus sprint backlog.\r\nUsar o Diagrama do fluxo conversacional.\r\nReferencial bibliográfico.\r\nVer questão metodológica da pesquisa (SERA EXIBIDO UM QUADRO COMPARATIVO).',9,0,0,1,16,18,1,22),(23,'2018-07-04 14:30:00',10,10,10,'Fazer a apresentação para validação do sistema para o professor Alexandre Futherlli,  que foi o solicitante do projeto e  é especialista em estomatologia.  Solicitar um parecer do especialista para ser anexado no artigo.\r\nFazer as correções no artigo conforme volumes entregues pelos  componentes da banca.',10,0,0,1,11,7,1,23);
/*!40000 ALTER TABLE `board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `name`, `description`, `article`, `code`, `firstPost`, `firstPostDate`, `lastPost`, `lastPostDate`, `studentId`, `advisorId`, `boardId`) VALUES (14,'Easy Routes','Easy Routes é uma aplicação para facilitar o gerenciamento de rotas universitárias e excursões.\r\nFeita para gestores de empresas de transporte obterem qualidade e excelência em seus serviços.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',0,'2018-07-11 20:15:00',14,16,14),(15,'Juntos podemos mais','Aplicativo e Web Site para ampliar a cultura visual dos deficientes auditivos.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',1,'2018-07-11 19:08:00',15,16,15),(16,'Projeto do Pedro Bertucci','Todos arquivos estão no link.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',0,'2018-07-03 19:18:00',13,16,16),(17,'BiblioTCC - Biblioteca e Gerenciador de Bancas de TCC','Neste artigo será apresentado o BiblioTCC, software,  para auxiliar o professor responsável pela organização de bancas no gerenciamento das bancas de TCC  e também servir como uma biblioteca aberta de trabalhos de conclusão, para que alunos possam estudar os projetos postados. O sistema foi desenvolvido com a linguagem PHP, na versão 7.1, utilizando o Framework Symfony 3.4.4 como base do projeto. A metodologia utilizada foi o Scrum, uma metodologia ágil para gestão e planejamento de projeto altamente utilizada.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',1,'2018-07-11 13:30:00',1,7,17),(18,'SMM Tool','Ferramenta para auxiliar Parques Tecnológicos na tomada de decisão em relação a suas startups de acordo com a metodologia SMM.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',1,'2018-07-12 15:00:00',8,11,18),(19,'Projeto do Caciano Kroth','Insira uma descrição','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',0,'2018-07-12 14:00:00',9,11,19),(20,'Projeto do Vikthor Ferreira','Insira uma descrição','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-28 00:00:00',0,'2018-07-05 15:00:00',12,11,20),(21,'Projeto do José Renato de Farias da Silva','Insira uma descrição','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',0,'2018-07-11 15:30:00',10,11,21),(22,'DESENVOLVIMENTO DE CHATBOTS','Uma análise comparativa entre plataformas.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',1,'2018-07-05 14:00:00',20,11,22),(23,'OpenCMI - Sistema para comunicação e arquivamento de imagens médicas','Sistema colaborativo para profissionais da área da odontologia que permite a comunicação e o arquivamento de prontuários em estomatologia.','Artigo1.pdf','CodigoFonte1.zip',1,'2018-06-20 00:00:00',0,'2018-07-11 14:30:00',21,19,23);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` (`id`, `start`, `end`) VALUES (1,'2018-01-01 00:00:00','2018-07-31 00:00:00');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`) VALUES (1,'leosorgetz','leosorgetz','leosorgetz123@gmail.com','leosorgetz123@gmail.com',1,NULL,'$2y$13$sQM0SPPm.LPo5f6B/kfSgu0FOvT2hkx3T/AhEllwGGkrBYBPjuEA2','2018-08-14 23:41:32','nm0C8DCoNA0-Q_la4OafEShFGWmPF-W_Xeuk9hROIUc','2018-06-19 00:44:38','a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Leonardo Sorgetz'),(2,'admin','admin','admin@gmail.com','admin@gmail.com',1,NULL,'$2y$13$kjEOMCGeL2XrMtzKiFTGveMCYfbm5b19gJnJKQillRnTS.UV9oZ1O','2018-08-15 00:22:46',NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}','Admin'),(7,'cassiocosta','cassiocosta','cassio.hc@gmail.com','cassio.hc@gmail.com',1,NULL,'$2y$13$ARWbb5CF8Jztn/hQq3QZR.x.K0Wdm3.owYsLRdvh63fMOTvsl.w0u','2018-07-05 19:43:57',NULL,NULL,'a:2:{i:0;s:16:\"ROLE_SUPER_ADMIN\";i:1;s:14:\"ROLE_PROFESSOR\";}','Cassio H Costa'),(8,'djian','djian','djianlucca@outlook.com','djianlucca@outlook.com',1,NULL,'$2y$13$jh2ib/fH05H0J0xtSG1dcuTMIMZ1Y3HKz87LhvNF5XL0TczBNmTM.','2018-07-07 00:32:36',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Djian Stiegelmaier'),(9,'caciano','caciano','caciano.kroths@gmail.com','caciano.kroths@gmail.com',1,NULL,'$2y$13$rpMqalwJipY6gr.S0etsGOxWYOb1zYrDmNqzKQbTN3wMA3H3E7c.m','2018-07-07 18:36:41',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Caciano Kroth'),(10,'joseRenato28','joserenato28','juegregore28@gmail.com','juegregore28@gmail.com',1,NULL,'$2y$13$v7CA/rz8346o8KHKxhmVcuRbUIADVQBLeVVLh1efDhqaGPgClHaoS','2018-07-06 18:06:04',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','José Renato de Farias da Silva'),(11,'Ramonsl','ramonsl','ramonsl@gmail.com','ramonsl@gmail.com',1,NULL,'$2y$13$dGrd3jFtgPn.UCo0pUBjMeK420y7nIqU/LKa/Qxg/TBd1s4Pz7pia','2018-06-28 13:31:17',NULL,NULL,'a:1:{i:0;s:14:\"ROLE_PROFESSOR\";}','Ramon dos Santos Lummertz'),(12,'vikthornvf','vikthornvf','vikthorferreira@gmail.com','vikthorferreira@gmail.com',1,NULL,'$2y$13$rhvMSX9iQWMqYMzGFb/59uN11DreOlo9T1Nd9Kgi6X1J9Qq0U6UHm','2018-06-28 15:38:45',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Vikthor Ferreira'),(13,'bertucci','bertucci','bertucci.dev@gmail.com','bertucci.dev@gmail.com',1,NULL,'$2y$13$n7gA7dctLsTVgdmhh3lS2O8ji2Xt2MAdhouM8X4s3k44bBcIPHbw2','2018-07-05 18:35:08',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Pedro Bertucci'),(14,'guilhermegaspar','guilhermegaspar','guilherme.castro@ulbra.inf.br','guilherme.castro@ulbra.inf.br',1,NULL,'$2y$13$csx4Vjx6PAc0jMk1sZSyieeAOT4wBXIA1zsS5Y/wd4VrJLGjEVAaK','2018-07-07 09:26:34',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Guilherme de Castro Gaspar'),(15,'leonardoteixeira','leonardoteixeira','leonardozb3@gmail.com','leonardozb3@gmail.com',1,NULL,'$2y$13$./qB1PD0kWyucDsGN4Ppi.qIhPlDn1njWF2VM3VcjniCmAOqnoY8u','2018-07-06 20:49:22',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Leonardo Machado Teixeira'),(16,'vinimagnus','vinimagnus','vinimagnus@gmail.com','vinimagnus@gmail.com',1,NULL,'$2y$13$r2qgfamkitOxAx4c6muVYejrVNRooY0l8bEMp.Z2vm75/LX7zGFHu','2018-07-06 21:07:32','X2vawXJAFiHeiJcjktchrxbGgi9Dh4AKW6CDGt7kewo','2018-06-18 20:27:35','a:1:{i:0;s:14:\"ROLE_PROFESSOR\";}','Vinícius Magnus'),(17,'caroline_porto','caroline_porto','carol_porto@ulbra.br','carol_porto@ulbra.br',1,NULL,'$2y$13$cZGcV5OhSkSiDgauGz5XxOzbHhTy0e1SfagZ3GIgA/bH6a9.kHV.C',NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_PROFESSOR\";}','Caroline Porto'),(18,'alexandre_gatelli','alexandre_gatelli','alexandre_gatelli@ulbra.br','alexandre_gatelli@ulbra.br',1,NULL,'$2y$13$yyO9x1oUnTHegZ4QUJh1yuypvXoDbkD5gE/LUL.phiRsM4FueJ5IW',NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_PROFESSOR\";}','Alexandre Gatelli Bastos'),(19,'adriana_bueno','adriana_bueno','adriana_bueno@ulbra.br','adriana_bueno@ulbra.br',1,NULL,'$2y$13$vugFLfEkDcFg/vqgEmBlhORTL4iQ33lT86LbVt0oRe7sqax5WurCW','2018-07-04 14:26:18',NULL,NULL,'a:1:{i:0;s:14:\"ROLE_PROFESSOR\";}','Adriana Bueno'),(20,'lucasfogacadj','lucasfogacadj','lucasfgc00@gmail.com','lucasfgc00@gmail.com',1,NULL,'$2y$13$jGWzVO8jv3h7x0IHqQYN9O7kRoM/de0rrUUTKbaMchASAYd8p34wm','2018-07-07 19:44:34',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Lucas Rodrigues Fogaça'),(21,'gabrieldewes','gabrieldewes','gabriel.dewes@ulbra.inf.br','gabriel.dewes@ulbra.inf.br',1,NULL,'$2y$13$7YMCWvyyHbfF8eukXhW35urVleksHP/gRwb7iouwIx9iKbC5dDIB.','2018-07-11 01:11:07',NULL,NULL,'a:1:{i:0;s:12:\"ROLE_STUDENT\";}','Gabriel Dewes');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-15 21:25:56

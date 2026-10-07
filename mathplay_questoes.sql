-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: mathplay
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `questoes`
--

DROP TABLE IF EXISTS `questoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tema` enum('inteiros','equacoes') COLLATE utf8mb4_unicode_ci NOT NULL,
  `enunciado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resposta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explicacao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questoes`
--

LOCK TABLES `questoes` WRITE;
/*!40000 ALTER TABLE `questoes` DISABLE KEYS */;
INSERT INTO `questoes` VALUES (1,'inteiros','Quanto é 8 + (-3)?','5','Quando somamos 8 com -3, fazemos 8 - 3. Portanto, o resultado é 5.'),(2,'inteiros','Quanto é -7 + 12?','5','Os sinais são diferentes. Fazemos 12 - 7 = 5 e mantemos o sinal do número de maior valor absoluto.'),(3,'inteiros','Quanto é -4 - 6?','-10','Subtrair 6 de -4 é o mesmo que somar -6. Portanto: -4 + (-6) = -10.'),(4,'inteiros','Quanto é 15 - 20?','-5','Como 20 é maior que 15, fazemos 20 - 15 = 5 e colocamos o sinal negativo.'),(5,'inteiros','Quanto é -10 + 4?','-6','Os sinais são diferentes. Fazemos 10 - 4 = 6 e mantemos o sinal do número de maior valor absoluto.'),(6,'equacoes','Resolva: x + 5 = 12. Qual é o valor de x?','7','Subtraímos 5 dos dois lados: x = 12 - 5. Portanto, x = 7.'),(7,'equacoes','Resolva: x - 4 = 9. Qual é o valor de x?','13','Somamos 4 aos dois lados: x = 9 + 4. Portanto, x = 13.'),(8,'equacoes','Resolva: 2x = 18. Qual é o valor de x?','9','Dividimos os dois lados por 2: x = 18 ÷ 2. Portanto, x = 9.'),(9,'equacoes','Resolva: x + 10 = 25. Qual é o valor de x?','15','Subtraímos 10 dos dois lados: x = 25 - 10. Portanto, x = 15.'),(10,'equacoes','Resolva: 3x = 21. Qual é o valor de x?','7','Dividimos 21 por 3: x = 21 ÷ 3. Portanto, x = 7.');
/*!40000 ALTER TABLE `questoes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-07 16:26:47


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `assigned_driver_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `parking_lot_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `car` (
  `car_id` int(11) NOT NULL,
  `license_plate_number` varchar(20) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `registration_year` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `driver` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `driver` (`driver_id`, `name`, `email`, `phone_number`, `license_number`, `password`) VALUES
(6, 'Tazower Sowad ', 'tazower000sowad@gmail.com', '01580719790', 'GA2069', 'asdf');



CREATE TABLE `parkinglot` (
  `parking_lot_id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `space_availability` int(11) DEFAULT NULL,
  `parking_owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `parkingowner` (
  `parking_owner_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `parking_lot_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `date_submitted` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `assigned_driver_id` (`assigned_driver_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `parking_lot_id` (`parking_lot_id`);


ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `car_ibfk_1` (`driver_id`);


ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);


ALTER TABLE `parkinglot`
  ADD PRIMARY KEY (`parking_lot_id`),
  ADD KEY `parking_owner_id` (`parking_owner_id`);


ALTER TABLE `parkingowner`
  ADD PRIMARY KEY (`parking_owner_id`);


ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);


ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `parking_lot_id` (`parking_lot_id`);


ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `car`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `driver`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `parkinglot`
  MODIFY `parking_lot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `parkingowner`
  MODIFY `parking_owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`assigned_driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`parking_lot_id`) REFERENCES `parkinglot` (`parking_lot_id`) ON DELETE CASCADE;

ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE SET NULL;


ALTER TABLE `parkinglot`
  ADD CONSTRAINT `parkinglot_ibfk_1` FOREIGN KEY (`parking_owner_id`) REFERENCES `parkingowner` (`parking_owner_id`) ON DELETE CASCADE;


ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE;


ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`parking_lot_id`) REFERENCES `parkinglot` (`parking_lot_id`) ON DELETE CASCADE;
COMMIT;


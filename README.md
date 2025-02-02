# To-do-list 📝
The Task Manager is a simple PHP and MySQL-based application designed to help users efficiently manage their tasks. 
A simple PHP-based Task Manager that allows users to **add, complete, and delete tasks**. Tasks have a creation time, and when marked as complete, a completion time is recorded.

## Features 🚀
✅ Add new tasks  
✅ Mark tasks as **Complete/Incomplete**  
✅ Track **task creation and completion times**  
✅ Delete tasks  
✅ Responsive **scrollable task list**  
✅ Secure with **prepared statements** (prevents SQL injection)  

## Database Setup 🗄️
Run the following SQL query to create the `task` table:

```sql
CREATE TABLE `task` (
  `id_task` INT NOT NULL AUTO_INCREMENT,
  `task` VARCHAR(100) NOT NULL,
  `date_create` DATETIME NOT NULL,
  `check_status` TINYINT(1) NOT NULL,
  `date_complete` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_task`)
);

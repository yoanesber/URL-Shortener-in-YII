<H2>Yii 2 Simple Application - TODOList (Advanced Project Template)</H2>

<p>
This simple project aims to develop a <b>todo list management</b> application using PHP programming language and YII Advanced Template Framework. Data is stored using MySql database.
</p>

<p>
The application folder, consists of 3 main folders, they are frontend, backend, and console. This application is created inside the frontend folder as it is designed as if to be used by the user.
</p>

<p>

## Preparing application
You only need to do these once for all.
1. Copy or clone this repository using command prompt/console with command:

   ```
   >>git clone https://github.com/yoanesber/YII-Todolist.git
   >>cd YII-Todolist
   ```

2. Run script composer update as below:

   ```
   >>YII-Todolist > composer update --prefer-dist
   >>YII-Todolist > composer install
   ```

3. Change the php.exe path in yii.bat file based on the configuration on your computer

   ```
   if "%PHP_COMMAND%" == "" set PHP_COMMAND=E:\xampp\php\php.exe
   ```

4. Run script php init as below:

   ```
   >>YII-Todolist > php init
   ```

    Select '0' for Development Environment, and '1' for Production Environment


5. Create a new database `todolist` and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.

6. Apply migrations with command as below:

   ```
   >>YII-Todolist/yii migrate
   ```

7. That's all. You just need to wait for completion! Then you can run the YII Server with command as below:
  
   ```
   >>YII-Todolist/yii serve --docroot="frontend/web/"
   ```

8. Access the project locally by URLs: `http://localhost:8080/` on your browser.
<H2>URL Shortener Service</H2>

<p>
This simple project aims to develop a <b>URL shortener service</b> application using PHP programming language and YII Advanced Template Framework combining with Google URL Shortener API. Data is stored using MySql database.
</p>

<p>

## Preparing application
You only need to do these once for all.
1. Create a project in Google API Library using "URL Shortener API" and get the API KEY:

   ```
   https://console.developers.google.com/apis/library
   ```

2. Change the API KEY in file `<YOUR_PROJECT_PATH>\frontend\controllers\UrlconversionController.php` with your API KEY:

3. Copy or clone this repository using command prompt/console with command:

   ```
   >>git clone https://github.com/yoanesber/YII_URL_Shortener_Service.git
   >>cd YII_URL_Shortener_Service
   ```

4. Run script composer update as below:

   ```
   >>YII_URL_Shortener_Service > composer update --prefer-dist
   >>YII_URL_Shortener_Service > composer install
   ```

5. Change the php.exe path in yii.bat file based on the configuration on your computer

   ```
   if "%PHP_COMMAND%" == "" set PHP_COMMAND=C:\xampp\php\php.exe
   ```

6. Run script php init as below:

   ```
   >>YII_URL_Shortener_Service > php init
   ```

    Select '0' for Development Environment, and '1' for Production Environment


7. Create a new database `url_shortener` and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.

8. Apply migrations with command as below:

   ```
   >>YII_URL_Shortener_Service/yii migrate
   ```

9. That's all. You just need to wait for completion! Then you can run the YII Server with command as below:
  
   ```
   >>YII_URL_Shortener_Service/yii serve --docroot="frontend/web/"
   ```

10. Access the project locally by URLs: `http://localhost:8080/` on your browser.
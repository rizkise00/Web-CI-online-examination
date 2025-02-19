# Running CodeIgniter 4 Application Locally

This guide explains how to run an existing **CodeIgniter 4** application on your local environment.

## Prerequisites

Before starting, make sure you have **PHP** (version 7.4 or higher) installed on your system.

### 1. Clone or Download the Project

If you don't have the project, clone it from the GitHub repository:

```bash
https://github.com/rrtutors/AdvanceAlarmaManager.git
```

### 2. Install Dependencies
Navigate to your project folder and install dependencies using Composer:

```bash
composer install
```

### 3. If you get an error
```bash
'composer' is not recognized as an internal or external command,
operable program or batch file.
```
This error occurs because the system cannot find the composer command. This is usually caused by:

1. Composer is not installed.
2. The Composer path is not added to Environment Variables.

### 4. Ensure Composer is Installed

If Composer is not installed, follow these steps:

1. Download Composer from https://getcomposer.org
2. Install Composer by following the instructions in the installer
3. Find the Composer installation location.
    - It is usually located at: **C:\ProgramData\ComposerSetup\bin** or **C:\Users\USERNAME\AppData\Roaming\Composer\vendor\bin**
    - You can also search for the `composer.phar` file on your computer.
4. Add this location to Environment Variables:
    - Open Control Panel → System → Advanced system settings.
    - Click **Environment Variables**.
    - In the **System Variables** section, find `Path` and click Edit.
    - Click New, then add the path to the Composer location.
    - Click OK, then restart Command Prompt.

Once the installation is complete, try running the following command in Command Prompt:

``` bash
composer -V
```

If Composer is detected, the installed version will be displayed. Run `composer install` again to ensure all dependencies are properly set up

### 5. Import Database File

1. Open XAMPP Control Panel or Other
2. Make sure the Apache and MySQL modules are Running
3. Open your browser and navigate to http://localhost/phpmyadmin/, then press Enter
4. Create database `db_online_examination`
5. Select the Import tab
6. Click Choose File and select the `db_online_examination.sql` file from your computer

### 6. Run the Local Server

Open a terminal and navigate to your project folder, then run the following command to start the local server

```bash
php spark serve
```

This command will run the application on http://localhost:8080 by default.

### 7. Access the Application

Open your browser and go to http://localhost:8080 to view the CodeIgniter 4 application running locally.

### 8. If you get an error
```bash
'php' is not recognized as an internal or external command,
operable program or batch file.
```
This happens because Windows cannot find the PHP executable (php.exe) in its system PATH.

### 9. Add PHP to Environment Variables
1. Open System Properties:
   - Press `Win + R`, type `sysdm.cpl`, and hit `Enter`.
   - Go to the **Advanced** tab and click on **Environment Variables**.

2. Edit the PATH variable:
   - Under **System Variables**, scroll down and find `Path`.
   - Select it and click **Edit**.
   - Click **New**, then add your PHP installation path (e.g., `C:\xampp\php\`).
   - Click **OK** to save the changes.
3. Restart terminal and try again `php spark serve`
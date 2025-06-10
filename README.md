## About Application

This application was created for educational purposes and presents the most common security vulnerabilities found in applications based on the Laravel framework. It is based on the OWASP Top 10, a compilation of the most common threats to web applications.

With this application you will learn:

-   What are the most common vulnerabilities in Laravel.
-   How attacks that exploit these vulnerabilities work.
-   How to effectively secure your application against threats.

The project includes both examples of flawed implementations that lead to vulnerabilities and their corrected versions with security best practices applied.
The goal of the application is to raise awareness among developers and promote secure practices in software development.

## How to Run application

1. Clone repository `https://github.com/Aflarp/magisterka-app`
2. Run docker compose `docker compose up --build`
3. Import postman collection
4. Enjoy!

## How to test a specific vulnerability

A postman collection is added to the repository, which should be imported to test all vulnerabilities in the application. The most important step is to execute the request titled Rejestracja użytkowniika. This is needed to test the following vulnerabilities.

If you want to login to database use this credentials
root/root or appuser/apppass and port 3306
### A01:2021-Broken Access Control

1. Wrong ACL  
   There are 3 endpoints in this folder. There are 2 testing paths  
   First Path: Requests: Poprawny zakres dostępu tokena -> Weryfikacja tokena  
   Second Path: Requests: Niepoprawny zakres dostępu tokena -> Weryfikacja tokena

### A02:2021-Cryptographic Failures

1. Missing password hash  
   I am not able to present password saving without encryption, because this is defined in the User Model, it is currently set to encrypt passwords when saving for security and best practice reasons  
   In the postaman collection there is an added image showing the difference between encrypted and unencrypted passwords

### A03:2021-Injection

1. XSS  
   This vulnerability can also be tested in the browser by pasting 2 links  
   Secured:  
   http://localhost:8000/xss-zWalidacja?input=%3Cscript%3Ealert(%27XSS%27)%3C/script%3E
   Unsecored:  
   http://localhost:8000/xss-bezWalidacji?input=%3Cscript%3Ealert(%27XSS%27)%3C/script%3E
2. SQL Injection
   There are 2 endpoints in this folder.

### A04:2021-Insecure Design

1. Open Redirect  
   To test it use postman collection or To test the vulnerability, run a terminal on your computer and paste the following command:  
   curl -X POST “http://localhost:8000/api/IncorrectloginWithRedirect?redirect_to=https://anstar.edu.pl/” \ -H “Content-Type: application/x-www-form-urlencoded”. \ -d “email=testuser@test.pl&password=testowanehaslo123” \ -D - -o /dev/null
   
   and second command  
   curl -X POST "http://localhost:8000/api/CorrectloginWithRedirect?redirect_to=https://anstar.edu.pl/" \ -H "Content-Type: application/x-www-form-urlencoded" \ -d "email=testuser@test.pl&password=testowanehaslo123" \ -D - -o /dev null  
2. Login Rate Limiter  
   After sending first request you will get correct response, but if you send few more you will get response 429 too many requests

### A05:2021-Security Misconfiguration

1. Token no expire  
   To verify the vulnerability, log into the database and access the personal_access_tokens table after performing one of two requests in the folder.  
   For a token that expires, the expires_at column should contain the date, and for a token that does not expire it should be null

### A06:2021-Vulnerable and Outdated Components

1. No use of composer audit  
   In order to test the podanity, enter the PHP container through the Docker desktop application and then click on the EXEC tab and in the /app folder type the command composer audit

### A07:2021-Identification and Authentication Failures

1. Many access keys for one user  
   To verify the vulnerability, log into the database and access the personal_access_tokens table after executing one of the two requests in the folder

### A08:2021-Software and Data Integrity Failures

No vulnerability in the current version of Laravel (11.9)

### A09:2021-Security Logging and Monitoring Failrues

1. Sensitive data in Log  
   To verify the vulnerability, after executing one of the two requests, access the PHP container via the Docker desktop application and then click on the EXEC tab and in the /storage/logs folder type cat laravel.log

### A10:2021-Server-Side Request Forgery

No vulnerability in the current version of Laravel (11.9)

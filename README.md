Mini HRMS Module (Laravel API)
Overview
=================
This project is a mini Human Resource Management System (HRMS) built using Laravel 10. It demonstrates a SaaS-oriented architecture with multi-tenant support, ensuring each company's data is strictly isolated.

The system supports Employee Management, Attendance Tracking, and Leave Management, with secure API authentication using Laravel Sanctum.

Features
====================
Employee Management: Create, update, view, and delete employees.
Attendance Management: Clock-in/out functionality with single daily clock-in.
Leave Management: Apply for leave, update leave details, approve/reject leaves.
Multi-Tenant Support: All records are linked to a company_id for data isolation.
API Authentication: Secure endpoints with Bearer tokens via Laravel Sanctum.

Tech Stack
===================
PHP 8.2
Laravel 10
MySQL
Laravel Sanctum (API authentication)

Setup Instructions
=====================
Clone the repository
git clone git@github.com:ROODRO-PERSONAL/eve-saas-hrms.git
cd eve-saas-hrms


Install dependencies
======================
composer install

Copy .env.example to .env and configure database
================================================
cp .env.example .env
php artisan key:generate
Update .env with your database credentials.



Run migrations => php artisan migrate
Seed the database => php artisan db:seed


Seeders create sample companies, admin users, and employees. Tokens for users are generated and stored in the database.

Start the server => php artisan serve

Usage Workflow

Login a company admin
=======================
POST /api/login
Provides a Bearer token.
Token changes on every login.

Add a user for the company (optional)
=====================
POST /api/register

Login the user
===================
On login, login time is recorded, and a new token is generated.

Employee CRUD
====================
Create, view, update, or delete employees within the company.

Attendance
===============
Clock-in an employee: POST /api/attendance/clock-in/{employee_id}
Clock-out an employee: POST /api/attendance/clock-out/{employee_id}


Leave Management
=======================
Apply for leave: POST /api/leaves/apply
Update leave: PATCH /api/leaves/{id}
Approve/reject leave: PATCH /api/leaves/{id}/status


Logout user
=================
POST /api/logout
On logout, logout time is recorded, and token is revoked.



Notes :-
==============
All endpoints are multi-tenant aware (scoped by company_id).

Tokens must be sent in the header for authentication:

Authorization: Bearer <your_token>

Default seeded data is available for easy testing.

Ensure unique email addresses for employees and users.

API Endpoints Summary :-
============================
Authentication ==>

Endpoint	                                    Method	                Description
--------                                        ------                  ------------

/api/login	                                    POST	                Login user, returns token
/api/logout	                                    POST	                Logout user
/api/register	                                POST	                Register new user
/api/me	                                        GET	                    Get authenticated user

Employees
=========
Endpoint	                                    Method	                Description
/api/employees	                                GET	                    List all employees
/api/employees	                                POST	                Add employee
/api/employees/{id}	                            GET	                    View employee
/api/employees/{id}	                            PUT	                    Update employee
/api/employees/{id}	                            DELETE	                Delete employee


Attendance
============
Endpoint	                                    Method	                Description
/api/attendance/clock-in/{employee_id}	        POST	                Clock-in employee
/api/attendance/clock-out/{employee_id}	        POST	                Clock-out employee
/api/attendance	GET	List attendances

Leaves
==========
Endpoint	                                    Method	                Description
/api/leaves/apply	                            POST	                Apply leave
/api/leaves/{id}	                            PATCH	                Update leave details
/api/leaves/{id}/status                     	PATCH	                Approve/reject leave
/api/leaves	                                    GET	                    List leaves


Companies
==============
Endpoint	                                    Method	                Description
/api/companies	                                GET	                    List companies
/api/companies	                                POST	                Create company
/api/companies/{id}	                            GET	                    View company
/api/companies/{id}	                            PUT	                    Update company
/api/companies/{id}	                            DELETE	                Delete company
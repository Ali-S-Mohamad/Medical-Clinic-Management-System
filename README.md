# MediCore Clinic Management System

MediCore Clinic Management System is a comprehensive solution designed to manage the operations of a medical clinic. It includes role-based access control, appointment scheduling, secure medical file management, and more, offering a seamless experience for administrators, doctors, employees, and patients.

---

## Features

### 1. Role-Based Access Control (RBAC)
- **Roles:** Clinic Manager, Doctor, Employee, and Patient.
- Each role has specific permissions and access to different parts of the system.
  - Clinic Manager: Full control over the system.
  - Doctor: Manage appointments and medical files.
  - Employee: Assist with appointment scheduling and administrative tasks.
  - Patient: Book appointments and access their medical records.

### 2. Appointment Management
- Schedule, update, and cancel appointments.
- View upcoming appointments in the dashboard.
- Notifications for appointment confirmations and reminders.

### 3. Medical File Management
- Secure storage for medical files.
- Role-specific access to view or edit medical records.

### 4. Department Management
- Associate doctors and employees with specific departments.
- Display departments and their respective members.

### 5. Dashboard
- Customizable dashboard for each role.
- Real-time updates for critical information such as:
  - Upcoming appointments.
  - Doctor performance ratings.

### 6. Notifications
- Real-time notifications for:
  - New appointments.
  - Changes in appointment status.


### 7. Ratings
- Display average ratings for doctors.
- Ratings are calculated based on patient feedback.

---

## Tech Stack

### Backend:
- Laravel (PHP framework).

### Frontend:
- Blade Templating Engine.
- Bootstrap (for styling modals, buttons, and layout).

### Database:
- MySQL.

### APIs:
- Authentication via Laravel Sanctum.

### Other Tools:
- Storage for uploaded images and files (via `storage` directory).
- Role management using middleware.
- Roles and permissions using spatie.
- Send code verification using SomarKesen-Telegram-Gateway-laravel-Package.

---

## Installation

### Prerequisites
Ensure you have the following installed on your system:
- PHP >= 8.0
- Composer
- MySQL
- Node.js and npm (for frontend assets)

### Steps
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd medi-core-clinic
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install frontend dependencies:
   ```bash
   npm install && npm run dev
   ```

4. Set up environment variables:
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other settings.

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Start the server:
   ```bash
   php artisan serve
   ```
   Visit the application at `http://127.0.0.1:8000`.

---

## Directory Structure

### Key Directories:
- **`app/Models`**: Contains models for `Doctor`, `Employee`, `Patient`, `Department`, etc.
- **`app/Http/Controllers`**: Contains controllers such as `AppointmentController`, `DepartmentController`, etc.
- **`resources/views`**: Blade templates for the frontend.
- **`routes/web.php`**: Web routes for the application.

---

## Usage

### Roles and Permissions
- Each role is assigned specific permissions via middleware.

### Appointment Scheduling
- Navigate to the `Appointments` section.
- Fill out the form with patient and doctor details.
- Submit to create a new appointment.

### Viewing Doctors
- Doctors are displayed on the dashboard with their respective departments and ratings.

---

## Development Practices

### 1. Clean Code and SOLID Principles
- **Service Classes:** All business logic is handled in service classes to keep controllers lightweight and focused on request handling.

### 2. Soft Deletes
- Soft deletes are implemented for `Doctors`, `Appointments`, and `Medical Files`.
  - When a doctor or department is deleted, associated appointments are marked as `soft deleted` and can be restored.

### 3. Notification System
- Real-time notifications using Laravel's built-in notification system.

---

---

## Future Enhancements
- Implement advanced reporting features.
- Add support for multiple clinic branches.
- Enhance the notification system with email and SMS integration.

---

## Credits
This project was built as part of a training program in focal X Agency to enhance skills in:
- Laravel development.
- Role-based access control.
- Secure medical data management.

---

## License
This project is licensed under the MIT License. See the LICENSE file for more details.



 
#الاء 

   
??
قسم التقيمات صار جاهز مع عرض متوسط التقييمات لدكتور معين ببروفايلو، ومافينا نضيف تقييم الا ل دكتور حصرا
واجهة الداشبورد صار فيا شويه احصائيات والهوفر عالكاردات بغير شكل المؤشر والضغط بياخدنا عالصفحة للتفاصيل
صفحة ادخال + تعديل موظف صار قسم خبرة الموظف بيختفي وبيظهر حسب الرول
ادخال وحفظ سيفي وعرض اسمو ببروفايل الدكتور والاسم رابط بياخدنا ع تاب جديد ليفتح الملف
تابع الحفظ / التعديل موجودة ب helper



حاليا لما بحذف دكتور عم تنحذف تقييماتو


##ُ Employees CRUD
لما بحذف قسم، شو حيصير بالموظفين
 

Route::get('/testr', function() { 
         $rating = new Rating; 
         $rating->employee_id = 1;  
         $rating->patient_id  = 1;
         $rating->doctor_rate = 6.3;        
         $rating->save();             
        });


لعدل:
git add .
git commit -m "emplyees CRUD"
git pull origin main
حل التعارضاتت وبرجع لأول وتاني تعليمة بس
    
git push origin alaa
pull request from git website

لاسحب:

git pull origin main


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


 
#الاء 
## Ratings api
delete user /  

## pdf
حذف سيرة
   
??
قسم التقيمات صار جاهز مع عرض متوسط التقييمات لدكتور معين ببروفايلو، ومافينا نضيف تقييم الا ل دكتور حصرا
واجهة الداشبورد صار فيا شويه احصائيات والهوفر عالكاردات بغير شكل المؤشر والضغط بياخدنا عالصفحة للتفاصيل
صفحة ادخال + تعديل موظف صار قسم خبرة الموظف بيختفي وبيظهر حسب الرول
ادخال وحفظ سيفي وعرض اسمو ببروفايل الدكتور والاسم رابط بياخدنا ع تاب جديد ليفتح الملف
تابع الحفظ / التعديل موجودة ب helper



حاليا لما بحذف دكتور عم تنحذف تقييماتو


##ُ Employees CRUD
لما بحذف قسم، شو حيصير بالموظفين
 
بس ضمّن سباتي:
عرضت الموظفين بصفحة موجودين فيا كلن.. تعديل صفحة عرض الدكاترة بس
 

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


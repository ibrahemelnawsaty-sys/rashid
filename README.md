# رشيد — مستشارك المالي (Rashid)

منصة سعودية ذكية تساعد الأفراد على **تجنّب القروض غير الضرورية**: تحلّل الوضع المالي، تعترض قرار الاقتراض قبل اتخاذه، وتقترح بدائل عملية بصفر فوائد (الجمعيات الرقمية · التمويل الحكومي المدعوم · التراكم الاستثماري · التأمين الوقائي · التكافل المجتمعي «فُرجت»).

**التقنية:** Laravel 13 · PHP 8.2+ · MySQL · Blade + Alpine.js + Tailwind (RTL، موبايل-أولاً). مُحسّن للاستضافة المشتركة (Hostinger): لا Redis، الطابور/الكاش عبر قاعدة البيانات، الأصول مُصرّفة مسبقاً.

> الدستور الهندسي الكامل للمشروع في `RASHID_MASTER_BLUEPRINT.md` (بالمستودع الأصل).

---

## النشر على Hostinger (خطوات سريعة)

المستودع يتضمّن `vendor/` و `public/build/` جاهزَين، فلا حاجة لتشغيل `composer` أو `npm` على الخادم.

1. **ارفع الملفات** (git clone/pull أو رفع عبر hPanel) إلى مجلد التطبيق، مثلاً `~/rashid`.
2. **وجّه النطاق** إلى مجلد `public/` (Document Root = `.../rashid/public`). إن لم يمكن تغيير الجذر، انقل محتوى `public/` إلى `public_html` وعدّل المسارات في `index.php` لتشير إلى مجلد التطبيق.
3. **الإعدادات**: انسخ `.env.example` إلى `.env` واملأ قيم قاعدة MySQL من hPanel، ثم:
   ```bash
   php artisan key:generate
   php artisan migrate --force --seed
   php artisan storage:link
   php artisan optimize
   ```
4. **المجدول (cron)** — أضِف في hPanel مهمة كل دقيقة:
   ```
   * * * * * cd ~/rashid && php artisan schedule:run >> /dev/null 2>&1
   ```

### تحديث لاحق
```bash
git pull
php artisan migrate --force
php artisan optimize:clear && php artisan optimize
```

---

## التشغيل محلياً (للتطوير)

```bash
composer install
npm install && npm run build
cp .env.example .env   # واضبط DB_CONNECTION=sqlite للتجربة السريعة
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## الحالة الحالية
- ✅ واجهة العميل كاملة (20 شاشة RTL) تعمل: الهبوط، الإعداد، اللوحة المالية، تدفّق «هل أقترض؟» والصدمة الإيجابية، البدائل الخمسة، الادخار، المستشار، الإعدادات.
- ✅ نظام تصميم فاخر (رموز + مكوّنات + أيقونات SVG + خط IBM Plex Sans Arabic self-hosted) ووضع داكن.
- 🔄 قيد الإكمال: ربط كل الشاشات بالبيانات الحقيقية، لوحة الإدارة، المصادقة بالجوال (OTP)، وتكاملات المصرفية المفتوحة والذكاء الاصطناعي.

> ملاحظة: المصادقة قيد البناء؛ حالياً تُعرض الشاشات ببيانات تجريبية (مستخدم «محمد») لتشغيل الموقع وتجربته.

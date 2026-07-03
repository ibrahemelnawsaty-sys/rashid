import Alpine from 'alpinejs';

// رشيد — تفاعلية خفيفة فقط (لا SPA). §6.0/§10.4
window.Alpine = Alpine;

// وضع داكن: يحترم تفضيل النظام ويُحفظ محلياً
const root = document.documentElement;
const saved = localStorage.getItem('rashid-theme');
if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    root.classList.add('dark');
}
window.toggleTheme = () => {
    root.classList.toggle('dark');
    localStorage.setItem('rashid-theme', root.classList.contains('dark') ? 'dark' : 'light');
};

// تنسيق مبلغ بالريال من الهللات (عرض فقط؛ لا حساب مالي في الواجهة)
window.formatSar = (halalas) =>
    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        .format((Number(halalas) || 0) / 100);

Alpine.start();

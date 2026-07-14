document.addEventListener('alpine:init', () => {
    const storedTheme = localStorage.getItem('admin-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = storedTheme ? storedTheme === 'dark' : prefersDark;

    document.documentElement.classList.toggle('dark', isDark);

    Alpine.store('theme', {
        dark: isDark,
        toggle() {
            this.dark = !this.dark;
            document.documentElement.classList.toggle('dark', this.dark);
            localStorage.setItem('admin-theme', this.dark ? 'dark' : 'light');
        },
    });

    Alpine.store('toasts', {
        items: [],
        push(message, type = 'success', duration = 4500) {
            const id = Date.now() + Math.random();
            this.items.push({ id, message, type });
            setTimeout(() => this.remove(id), duration);
        },
        remove(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    });

    Alpine.store('confirm', {
        open: false,
        title: 'Are you sure?',
        message: 'This action cannot be undone.',
        confirmLabel: 'Confirm',
        cancelLabel: 'Cancel',
        form: null,
        show({ title, message, confirmLabel, cancelLabel, form }) {
            this.title = title ?? this.title;
            this.message = message ?? this.message;
            this.confirmLabel = confirmLabel ?? this.confirmLabel;
            this.cancelLabel = cancelLabel ?? this.cancelLabel;
            this.form = form ?? null;
            this.open = true;
        },
        cancel() {
            this.open = false;
            this.form = null;
        },
        submit() {
            if (this.form) {
                this.form.submit();
            }
            this.cancel();
        },
    });
});

window.adminConfirmDelete = (form, message = 'Delete this record?') => {
    Alpine.store('confirm').show({
        title: 'Confirm deletion',
        message,
        confirmLabel: 'Delete',
        form,
    });
};

window.adminToast = (message, type = 'success') => {
    Alpine.store('toasts').push(message, type);
};

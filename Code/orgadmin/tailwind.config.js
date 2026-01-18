import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import flowbite from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/*/.blade.php',
        './resources/*/.js',
        './vendor/flowbite/*/.js',
        './resources/components/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Flowbite semantic colors
                'brand-softer': '#EFF6FF',
                'brand-soft': '#DBEAFE',
                'brand': '#3B82F6',
                'brand-strong': '#1D4ED8',
                'brand-subtle': '#BFDBFE',
                'brand-medium': '#60A5FA',
                
                'neutral-primary-soft': '#F3F4F6',
                'neutral-secondary-medium': '#D1D5DB',
                'neutral-tertiary': '#9CA3AF',
                'neutral-quaternary': '#6B7280',
                
                'fg-brand': '#3B82F6',
                'fg-brand-strong': '#1D4ED8',
                
                'fg-danger-strong': '#991B1B',
                'fg-success-strong': '#166534',
                'fg-warning': '#92400E',
                
                'fg-success': '#059669',
                
                'heading': '#111827',
                
                'danger-soft': '#FEE2E2',
                'danger-subtle': '#FECACA',
                'danger-medium': '#F87171',
                'danger': '#DC2626',
                
                'success-soft': '#DCFCE7',
                'success-subtle': '#BBF7D0',
                'success-medium': '#86EFAC',
                'success': '#22C55E',
                
                'warning-soft': '#FEF3C7',
                'warning-subtle': '#FCD34D',
                'warning-medium': '#FCA5A5',
                'warning': '#FBBF24',
                
                'default': '#E5E7EB',
                'default-medium': '#D1D5DB',
                'buffer': '#FFFFFF',
            },
        },
    },

    plugins: [flowbite],
};